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

  /* Split the hero headline into words so they can rise one after another. */
  function initHeadlines() {
    var titles = Array.prototype.slice.call(document.querySelectorAll('[data-split]'));
    if (!titles.length) return;

    titles.forEach(function (title) {
      if (title.dataset.splitDone) return;
      var html = '';
      // Preserve <em> highlights while splitting on whitespace.
      Array.prototype.slice.call(title.childNodes).forEach(function (node) {
        var isEm = node.nodeType === 1 && node.tagName === 'EM';
        var text = node.textContent;
        text.split(/(\s+)/).forEach(function (chunk) {
          if (!chunk.trim()) { html += chunk; return; }
          var inner = isEm ? '<em>' + chunk + '</em>' : chunk;
          html += '<span class="word"><span>' + inner + '</span></span>';
        });
      });
      title.innerHTML = html;
      title.dataset.splitDone = '1';
      Array.prototype.slice.call(title.querySelectorAll('.word > span')).forEach(function (w, i) {
        w.style.setProperty('--d', (i * 70) + 'ms');
      });
    });
  }

  function playHeadline(scope) {
    if (!scope) return;
    var t = scope.querySelector('[data-split]');
    if (!t) return;
    t.classList.remove('is-typed');
    // force reflow so the transition restarts on every slide change
    void t.offsetWidth;
    t.classList.add('is-typed');
  }

  /* ------------------------------------------------------- hero slider --- */
  function initHero() {
    var hero = document.querySelector('[data-hero]');
    if (!hero) return;

    var slides = Array.prototype.slice.call(hero.querySelectorAll('.hero__slide'));
    var dots = Array.prototype.slice.call(hero.querySelectorAll('.hero__dot'));
    if (!slides.length) return;

    var index = 0;
    var timer = null;
    var DELAY = 6000;

    function show(next) {
      index = (next + slides.length) % slides.length;
      slides.forEach(function (s, i) {
        s.classList.toggle('is-active', i === index);
        s.setAttribute('aria-hidden', String(i !== index));
      });
      dots.forEach(function (d, i) {
        d.classList.toggle('is-active', i === index);
        d.setAttribute('aria-selected', String(i === index));
      });
      playHeadline(slides[index]);
    }

    function start() { stop(); if (slides.length > 1 && !reduced) timer = setInterval(function () { show(index + 1); }, DELAY); }
    function stop() { if (timer) { clearInterval(timer); timer = null; } }

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { show(i); start(); });
    });

    var prev = hero.querySelector('.hero__arrow--prev');
    var next = hero.querySelector('.hero__arrow--next');
    if (prev) prev.addEventListener('click', function () { show(index - 1); start(); });
    if (next) next.addEventListener('click', function () { show(index + 1); start(); });

    hero.addEventListener('mouseenter', stop);
    hero.addEventListener('mouseleave', start);
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) stop(); else start();
    });

    /* Swipe on touch devices. */
    var x0 = null;
    hero.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
    hero.addEventListener('touchend', function (e) {
      if (x0 === null) return;
      var dx = e.changedTouches[0].clientX - x0;
      if (Math.abs(dx) > 50) { show(index + (dx < 0 ? 1 : -1)); start(); }
      x0 = null;
    }, { passive: true });

    show(0);
    start();
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
    initHeadlines();
    initMarquee();
    initReveals();
    initHero();
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
