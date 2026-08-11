/* Diverse Pathwais PVT LTD. — site behaviour
   Vanilla JS, no dependencies. Every block guards on the element existing so
   the same file can be shared by every page. All motion is skipped when the
   visitor asks for reduced motion. */
(function () {
  'use strict';

  var mq = window.matchMedia('(max-width: 900px)');
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ------------------------------------------------------------ header --- */
  function initHeader() {
    var header = document.querySelector('[data-header]');
    var bar = document.querySelector('[data-progress]');
    if (!header && !bar) return;

    /* The scrollable distance is cached so the scroll handler never forces a
       layout; it is refreshed on resize and whenever the document grows. */
    var maxScroll = 0;
    function measure() {
      var doc = document.documentElement;
      maxScroll = doc.scrollHeight - doc.clientHeight;
    }

    function update() {
      var y = window.scrollY || document.documentElement.scrollTop || 0;
      if (header) header.classList.toggle('is-stuck', y > 60);
      if (bar) {
        var ratio = maxScroll > 0 ? Math.min(Math.max(y / maxScroll, 0), 1) : 0;
        bar.style.transform = 'scaleX(' + ratio + ')';
      }
    }

    /* Deliberately synchronous: the work is two class toggles and one transform
       write, and a rAF-gated version silently stops updating if a frame is
       never delivered (throttled/background tabs). */
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', function () { measure(); update(); }, { passive: true });
    window.addEventListener('load', function () { measure(); update(); });

    measure();
    update();
  }

  /* ------------------------------------------------------ mobile menu --- */
  function initNav() {
    var toggle = document.querySelector('.nav-toggle');
    var nav = document.getElementById('primary-nav');
    if (!toggle || !nav) return;

    function closeNav() {
      nav.classList.remove('is-open');
      toggle.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }

    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.classList.toggle('is-open', open);
      toggle.setAttribute('aria-expanded', String(open));
      document.body.style.overflow = open ? 'hidden' : '';
    });

    /* Dropdowns: hover on desktop, click on touch/mobile. */
    var parents = Array.prototype.slice.call(nav.querySelectorAll('.nav__item--has-sub'));

    parents.forEach(function (item) {
      var trigger = item.querySelector('.nav__link');

      trigger.addEventListener('click', function (e) {
        if (!mq.matches) return; // desktop uses hover
        e.preventDefault();
        var wasOpen = item.classList.contains('is-open');
        parents.forEach(function (p) { p.classList.remove('is-open'); });
        item.classList.toggle('is-open', !wasOpen);
        trigger.setAttribute('aria-expanded', String(!wasOpen));
      });

      item.addEventListener('mouseenter', function () {
        if (mq.matches) return;
        item.classList.add('is-open');
        trigger.setAttribute('aria-expanded', 'true');
      });
      item.addEventListener('mouseleave', function () {
        if (mq.matches) return;
        item.classList.remove('is-open');
        trigger.setAttribute('aria-expanded', 'false');
      });

      trigger.addEventListener('keydown', function (e) {
        if (mq.matches) return;
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          var open = item.classList.toggle('is-open');
          trigger.setAttribute('aria-expanded', String(open));
        }
      });
    });

    document.addEventListener('keydown', function (e) {
      if (e.key !== 'Escape') return;
      parents.forEach(function (p) {
        p.classList.remove('is-open');
        p.querySelector('.nav__link').setAttribute('aria-expanded', 'false');
      });
      closeNav();
    });

    document.addEventListener('click', function (e) {
      if (nav.contains(e.target) || toggle.contains(e.target)) return;
      parents.forEach(function (p) { p.classList.remove('is-open'); });
      if (mq.matches) closeNav();
    });

    var onChange = function () {
      closeNav();
      parents.forEach(function (p) { p.classList.remove('is-open'); });
    };
    if (mq.addEventListener) mq.addEventListener('change', onChange);
    else if (mq.addListener) mq.addListener(onChange);
  }

  /* --------------------------------------------------- scroll reveals --- */
  function initReveals() {
    var items = Array.prototype.slice.call(document.querySelectorAll('[data-anim]'));
    if (!items.length) return;

    /* Stagger siblings inside any [data-anim-group]. */
    document.querySelectorAll('[data-anim-group]').forEach(function (group) {
      var step = parseInt(group.getAttribute('data-anim-group'), 10) || 90;
      Array.prototype.slice.call(group.querySelectorAll('[data-anim]')).forEach(function (el, i) {
        if (!el.style.getPropertyValue('--d')) el.style.setProperty('--d', (i * step) + 'ms');
      });
    });

    if (reduced || !('IntersectionObserver' in window)) {
      items.forEach(function (el) { el.classList.add('is-in'); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-in');
        io.unobserve(entry.target);
      });
    }, { rootMargin: '0px 0px -80px 0px', threshold: 0.05 });

    items.forEach(function (el) { io.observe(el); });
  }

  /* ========================================================== cinematic ===
     Scroll is the timeline. Each [data-cine] section owns a tall track and a
     sticky stage; we turn the track's position into a 0 -> 1 progress number
     and drive everything from it: the video play-head, the image chapters and
     every overlay cue.

     Cues are declarative:
       data-cue="a,b,c,d"  hidden < a, fades in a..b, holds b..c, out c..d
                           (c and d optional -> stays visible to the end)
       data-cue-y="60"     px travelled on the way in/out
       data-cue-scale=".9" scale at rest, easing to 1 while held
  --------------------------------------------------------------------- */
  function clamp01(v) { return v < 0 ? 0 : v > 1 ? 1 : v; }

  function cueOpacity(p, w) {
    var a = w[0], b = w[1], c = w[2], d = w[3];
    if (p < a) return 0;
    if (p < b) return clamp01((p - a) / (b - a || 1));
    if (c == null) return 1;
    if (p < c) return 1;
    if (d == null) return 1;
    return clamp01(1 - (p - c) / (d - c || 1));
  }

  function initCinematic() {
    var sections = Array.prototype.slice.call(document.querySelectorAll('[data-cine]'));
    if (!sections.length) return;

    sections.forEach(function (section) {
      var track = section.querySelector('.cine__track');
      var video = section.querySelector('[data-cine-video]');
      var layers = Array.prototype.slice.call(section.querySelectorAll('.cine__layer'));
      var chapters = Array.prototype.slice.call(section.querySelectorAll('.cine__chapter'));
      if (!track) return;

      /* Reduced motion: show the first chapter, skip the whole engine. */
      if (reduced) {
        if (layers[0]) { layers[0].style.opacity = 1; layers[0].style.transform = 'none'; }
        if (video) video.remove();
        return;
      }

      var cues = Array.prototype.slice.call(section.querySelectorAll('[data-cue]')).map(function (el) {
        return {
          el: el,
          win: el.getAttribute('data-cue').split(',').map(parseFloat),
          y: parseFloat(el.getAttribute('data-cue-y') || 0),
          scale: parseFloat(el.getAttribute('data-cue-scale') || 1)
        };
      });

      /* Pick the right clip for the viewport, then remount so it reloads. */
      if (video) {
        var wide = video.getAttribute('data-src-desktop');
        var tall = video.getAttribute('data-src-mobile');
        var pick = (window.matchMedia('(max-width: 767px)').matches && tall) ? tall : wide;
        if (pick) {
          video.src = pick;
          video.load();
          section.classList.add('has-video');
        } else {
          video.remove();
          video = null;
        }
      }

      var progress = 0;
      var targetTime = 0;

      function render() {
        var rect = track.getBoundingClientRect();
        var scrollable = rect.height - window.innerHeight;
        var scrolled = Math.min(Math.max(-rect.top, 0), Math.max(scrollable, 0));
        progress = scrollable > 0 ? scrolled / scrollable : 0;

        /* Image chapters crossfade, with the first fully opaque at p=0 and the
           last fully opaque at p=1 (centres spread across the whole track), so
           the stage never starts or ends on a half-faded frame. A single
           continuous scale gives the slow scroll-driven push-in. */
        if (layers.length) {
          var last = layers.length - 1;
          var reach = last > 0 ? 1 / last : 1;
          var scale = (1.04 + progress * 0.12).toFixed(4);
          layers.forEach(function (layer, i) {
            var centre = last > 0 ? i / last : 0;
            var o = last > 0 ? 1 - Math.min(Math.abs(progress - centre) / reach, 1) : 1;
            layer.style.opacity = o.toFixed(3);
            layer.style.transform = 'scale(' + scale + ')';
          });
        }

        /* Overlay choreography. */
        cues.forEach(function (cue) {
          var o = cueOpacity(progress, cue.win);
          var t = '';
          if (cue.y) t += ' translate3d(0,' + ((1 - o) * cue.y).toFixed(1) + 'px,0)';
          if (cue.scale !== 1) t += ' scale(' + (cue.scale + (1 - cue.scale) * o).toFixed(4) + ')';
          cue.el.style.opacity = o.toFixed(3);
          cue.el.style.transform = t || 'none';
          cue.el.style.pointerEvents = o > 0.55 ? 'auto' : 'none';
        });

        /* Chapter rail fills as you move through each chapter. */
        if (chapters.length) {
          var cspan = 1 / chapters.length;
          chapters.forEach(function (ch, i) {
            var fill = clamp01((progress - i * cspan) / cspan);
            ch.firstElementChild.style.transform = 'scaleX(' + fill.toFixed(3) + ')';
          });
        }

        if (video && video.duration) {
          targetTime = progress * (video.duration - 0.05);
        }
      }

      /* The video play-head chases its target every frame, so scrubbing eases
         instead of snapping. Only runs while a clip is actually present. */
      var rafId = 0;
      function chase() {
        if (video && video.readyState >= 2) {
          var diff = targetTime - video.currentTime;
          if (Math.abs(diff) > 0.008) video.currentTime += diff * 0.28;
        }
        rafId = window.requestAnimationFrame(chase);
      }

      /* Clicking a chapter seeks the page to that point in the track. */
      chapters.forEach(function (ch, i) {
        ch.addEventListener('click', function () {
          var rect = track.getBoundingClientRect();
          var top = rect.top + window.scrollY;
          var scrollable = rect.height - window.innerHeight;
          var mid = (i + 0.5) / chapters.length;
          window.scrollTo({ top: top + scrollable * mid, behavior: 'smooth' });
        });
      });

      window.addEventListener('scroll', render, { passive: true });
      window.addEventListener('resize', render, { passive: true });
      if (video) {
        video.addEventListener('loadedmetadata', render);
        rafId = window.requestAnimationFrame(chase);
        document.addEventListener('visibilitychange', function () {
          if (document.hidden) { window.cancelAnimationFrame(rafId); rafId = 0; }
          else if (!rafId) { rafId = window.requestAnimationFrame(chase); }
        });
      }
      render();
    });
  }

  /* ------------------------------------------- pinned horizontal rail --- */
  function initPinnedRail() {
    var section = document.querySelector('[data-hgal]');
    if (!section) return;

    var track = section.querySelector('.hgal__track');
    var stage = section.querySelector('.hgal__stage');
    var rail = section.querySelector('.hgal__rail');
    var bar = section.querySelector('.hgal__bar i');
    if (!track || !rail) return;

    var distance = 0;

    function measure() {
      /* Below the pin breakpoint the CSS turns the rail into a swipe
         carousel, so the track must not reserve any extra height. */
      if (mq.matches || reduced) {
        track.style.height = '';
        rail.style.transform = '';
        return;
      }
      distance = Math.max(rail.scrollWidth - window.innerWidth + 48, 0);
      track.style.height = (stage.offsetHeight + distance) + 'px';
    }

    function render() {
      if (mq.matches || reduced || !distance) return;
      var rect = track.getBoundingClientRect();
      var scrollable = rect.height - window.innerHeight;
      var scrolled = Math.min(Math.max(-rect.top, 0), Math.max(scrollable, 0));
      var p = scrollable > 0 ? scrolled / scrollable : 0;
      rail.style.transform = 'translate3d(' + (-p * distance).toFixed(1) + 'px,0,0)';
      if (bar) bar.style.transform = 'scaleX(' + p.toFixed(3) + ')';
    }

    window.addEventListener('scroll', render, { passive: true });
    window.addEventListener('resize', function () { measure(); render(); }, { passive: true });
    window.addEventListener('load', function () { measure(); render(); });
    measure();
    render();
  }

  /* --------------------------------------------- duplicate the marquee --- */
  function initMarquee() {
    var track = document.querySelector('[data-marquee]');
    if (!track || track.dataset.cloned) return;
    // The CSS animation translates by -50%, so the content must appear twice.
    track.innerHTML += track.innerHTML;
    Array.prototype.slice.call(track.children).forEach(function (el, i, all) {
      if (i >= all.length / 2) el.setAttribute('aria-hidden', 'true');
    });
    track.dataset.cloned = '1';
  }

  /* ------------------------------------------------ group media slider --- */
  function initMediaSlider() {
    var track = document.querySelector('[data-media-track]');
    if (!track) return;

    function step() {
      var card = track.querySelector('.media-card');
      if (!card) return track.clientWidth;
      return card.getBoundingClientRect().width + 24; /* card + gap */
    }

    var prev = document.querySelector('[data-media-prev]');
    var next = document.querySelector('[data-media-next]');
    var nav = track.parentNode.querySelector('.media-nav');

    /* On wide screens every card already fits, so the arrows would be inert —
       hide them rather than offering controls that do nothing. */
    function syncNav() {
      if (!nav) return;
      nav.hidden = track.scrollWidth <= track.clientWidth + 4;
    }
    window.addEventListener('resize', syncNav, { passive: true });
    window.addEventListener('load', syncNav);
    syncNav();

    if (prev) prev.addEventListener('click', function () {
      if (track.scrollLeft <= 4) track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
      else track.scrollBy({ left: -step(), behavior: 'smooth' });
    });
    if (next) next.addEventListener('click', function () {
      var atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
      if (atEnd) track.scrollTo({ left: 0, behavior: 'smooth' });
      else track.scrollBy({ left: step(), behavior: 'smooth' });
    });
  }

  /* -------------------------------------------------- testimonial rail --- */
  function initTestimonials() {
    var root = document.querySelector('[data-tstack]');
    if (!root) return;

    var slides = Array.prototype.slice.call(root.querySelectorAll('.tstack__slide'));
    var avatars = Array.prototype.slice.call(root.querySelectorAll('.tstack__avatar'));
    if (slides.length < 2) return;

    var i = 0;
    var timer = null;

    function show(n) {
      i = (n + slides.length) % slides.length;
      slides.forEach(function (s, k) { s.classList.toggle('is-active', k === i); });
      avatars.forEach(function (a, k) {
        a.classList.toggle('is-active', k === i);
        a.setAttribute('aria-selected', String(k === i));
      });
    }
    function start() { stop(); if (!reduced) timer = setInterval(function () { show(i + 1); }, 7000); }
    function stop() { if (timer) { clearInterval(timer); timer = null; } }

    avatars.forEach(function (a, k) {
      a.addEventListener('click', function () { show(k); start(); });
    });
    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);

    show(0);
    start();
  }

  /* -------------------------------------------------------- scroll UI --- */
  function initScrollUI() {
    var toTop = document.querySelector('[data-to-top]');
    if (!toTop) return;
    window.addEventListener('scroll', function () {
      toTop.classList.toggle('is-visible', window.scrollY > 700);
    }, { passive: true });
    toTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: reduced ? 'auto' : 'smooth' });
    });
  }

  /* ------------------------------------------------- enquiry form(s) --- */
  function initForms() {
    var forms = Array.prototype.slice.call(document.querySelectorAll('[data-enquiry-form]'));
    if (!forms.length) return;

    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
    var phoneRe = /^[0-9+\-()\s]{7,20}$/;

    forms.forEach(function (form) {
      var status = form.querySelector('.form-status');

      function setError(input, message) {
        var field = input.closest('.field');
        if (!field) return;
        var slot = field.querySelector('.error');
        field.classList.toggle('has-error', Boolean(message));
        if (slot) slot.textContent = message || '';
      }

      function validate(input) {
        var value = input.value.trim();
        if (input.hasAttribute('required') && !value) {
          setError(input, 'This field is required.');
          return false;
        }
        if (input.type === 'email' && value && !emailRe.test(value)) {
          setError(input, 'Enter a valid email address.');
          return false;
        }
        if (input.type === 'tel' && value && !phoneRe.test(value)) {
          setError(input, 'Enter a valid phone number.');
          return false;
        }
        setError(input, '');
        return true;
      }

      var inputs = Array.prototype.slice.call(form.querySelectorAll('input, select, textarea'));
      inputs.forEach(function (input) {
        input.addEventListener('blur', function () { validate(input); });
        input.addEventListener('input', function () {
          var f = input.closest('.field');
          if (f && f.classList.contains('has-error')) validate(input);
        });
      });

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var ok = inputs.map(validate).every(Boolean);
        if (!ok) {
          var firstBad = form.querySelector('.field.has-error input, .field.has-error select, .field.has-error textarea');
          if (firstBad) firstBad.focus();
          return;
        }
        if (status) {
          status.textContent = 'Thank you. Your enquiry has been recorded — our team will contact you shortly.';
          status.classList.add('is-visible', 'is-success');
        }
        form.reset();
      });
    });
  }

  /* -------------------------------------------------------------- init --- */
  function init() {
    initHeader();
    initNav();
    initMarquee();
    initReveals();
    initCinematic();
    initPinnedRail();
    initMediaSlider();
    initTestimonials();
    initScrollUI();
    initForms();
    var year = document.querySelector('[data-year]');
    if (year) year.textContent = new Date().getFullYear();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
