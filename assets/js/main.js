/* Diverse Pathwais PVT LTD. — site behaviour
   Vanilla JS, no dependencies. Every block guards on the element existing so
   the same file can be shared by every page. All motion is skipped when the
   visitor asks for reduced motion. */
(function () {
  'use strict';

  var mq = window.matchMedia('(max-width: 900px)');
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ------------------------------------------ award-level experience --- */
  function initAwardExperience() {
    var body = document.body;
    if (!body) return;

    /* A short branded curtain makes moving between the static pages feel like
       one continuous experience. It never blocks reduced-motion visitors. */
    var loader = document.createElement('div');
    loader.className = 'page-loader';
    loader.setAttribute('aria-hidden', 'true');
    loader.innerHTML = '<div class="page-loader__inner"><strong class="page-loader__mark"><span>Diverse Pathwais</span></strong><b class="page-loader__line"><i></i></b></div>';
    body.appendChild(loader);

    function revealPage() {
      window.requestAnimationFrame(function () {
        window.requestAnimationFrame(function () { body.classList.add('is-ready'); });
      });
    }
    if (document.readyState === 'complete') revealPage();
    else window.addEventListener('load', revealPage, { once: true });
    window.setTimeout(revealPage, 900);

    /* Add the small editorial details consistently across all twenty pages. */
    Array.prototype.slice.call(document.querySelectorAll('.nav > ul > .nav__item')).forEach(function (item, i) {
      item.style.setProperty('--nav-i', i);
    });
    Array.prototype.slice.call(document.querySelectorAll('main .section')).forEach(function (section, i) {
      section.setAttribute('data-section-index', ('0' + (i + 1)).slice(-2));
    });
    var pageHero = document.querySelector('.page-hero');
    if (pageHero) {
      var pageTitle = pageHero.querySelector('h1');
      var heroShell = pageHero.querySelector('.shell');
      if (pageTitle && heroShell) heroShell.setAttribute('data-page-label', 'Global mobility / ' + pageTitle.textContent.trim());
    }

    /* Automatically opt useful shared components into the reveal system so
       every page benefits, including older pages with sparse data attributes. */
    var revealTargets = document.querySelectorAll('.section-head, .contact-card, .email-card, .quote, .form-card, .story-panel');
    Array.prototype.slice.call(revealTargets).forEach(function (el) {
      if (!el.hasAttribute('data-anim')) el.setAttribute('data-anim', 'up');
    });

    initKineticType();

    if (reduced) return;

    /* Route transitions for local pages only. External, download, hash and
       modifier-key navigation retain the browser's normal behaviour. */
    document.addEventListener('click', function (e) {
      if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
      var link = e.target.closest('a[href]');
      if (!link || link.target || link.hasAttribute('download')) return;
      var rawHref = link.getAttribute('href');
      if (!rawHref || rawHref.charAt(0) === '#') return;
      var url;
      try { url = new URL(link.href, window.location.href); } catch (ignore) { return; }
      if (url.origin !== window.location.origin || url.protocol === 'mailto:' || url.protocol === 'tel:') return;
      if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) return;
      e.preventDefault();
      body.classList.remove('is-ready');
      body.classList.add('is-leaving');
      window.setTimeout(function () { window.location.href = url.href; }, 520);
    });

    initPointerExperience();
    initMagneticButtons();
    initTiltCards();
    initHeroParallax();
  }

  function initKineticType() {
    var headings = Array.prototype.slice.call(document.querySelectorAll('.page-hero h1, .section-head h2'));
    if (!headings.length) return;

    headings.forEach(function (heading) {
      if (heading.dataset.kinetic) return;
      heading.dataset.kinetic = '1';
      var walker = document.createTreeWalker(heading, NodeFilter.SHOW_TEXT, {
        acceptNode: function (node) {
          return node.nodeValue.trim() ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT;
        }
      });
      var nodes = [];
      var node;
      while ((node = walker.nextNode())) nodes.push(node);
      var wordIndex = 0;
      nodes.forEach(function (textNode) {
        var fragment = document.createDocumentFragment();
        textNode.nodeValue.split(/(\s+)/).forEach(function (part) {
          if (!part) return;
          if (/^\s+$/.test(part)) {
            fragment.appendChild(document.createTextNode(part));
            return;
          }
          var outer = document.createElement('span');
          var inner = document.createElement('span');
          outer.className = 'word';
          outer.style.setProperty('--word-index', wordIndex++);
          inner.textContent = part;
          outer.appendChild(inner);
          fragment.appendChild(outer);
        });
        textNode.parentNode.replaceChild(fragment, textNode);
      });
    });

    if (reduced || !('IntersectionObserver' in window)) {
      headings.forEach(function (heading) { heading.classList.add('kinetic-in'); });
      return;
    }
    var typeObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('kinetic-in');
        typeObserver.unobserve(entry.target);
      });
    }, { threshold: .22 });
    headings.forEach(function (heading) { typeObserver.observe(heading); });
  }

  function initPointerExperience() {
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    var body = document.body;
    var dot = document.createElement('span');
    var ring = document.createElement('span');
    var spotlight = document.createElement('span');
    dot.className = 'cursor-dot';
    ring.className = 'cursor-ring';
    spotlight.className = 'motion-spotlight';
    body.appendChild(spotlight);
    body.appendChild(dot);
    body.appendChild(ring);

    var mouseX = window.innerWidth / 2;
    var mouseY = window.innerHeight / 2;
    var ringX = mouseX;
    var ringY = mouseY;
    document.addEventListener('pointermove', function (e) {
      mouseX = e.clientX;
      mouseY = e.clientY;
      dot.style.transform = 'translate3d(' + mouseX + 'px,' + mouseY + 'px,0)';
      document.documentElement.style.setProperty('--mx', mouseX + 'px');
      document.documentElement.style.setProperty('--my', mouseY + 'px');
      body.classList.add('has-pointer');
    }, { passive: true });
    document.addEventListener('pointerover', function (e) {
      body.classList.toggle('cursor-active', Boolean(e.target.closest('a, button, input, select, textarea, .hgal__card, .media-card')));
      body.classList.toggle('cursor-form', Boolean(e.target.closest('input, select, textarea')));
    });
    function followRing() {
      ringX += (mouseX - ringX) * .16;
      ringY += (mouseY - ringY) * .16;
      ring.style.transform = 'translate3d(' + ringX.toFixed(1) + 'px,' + ringY.toFixed(1) + 'px,0)';
      window.requestAnimationFrame(followRing);
    }
    followRing();
  }

  function initMagneticButtons() {
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    Array.prototype.slice.call(document.querySelectorAll('.btn')).forEach(function (button) {
      button.addEventListener('pointermove', function (e) {
        var rect = button.getBoundingClientRect();
        button.style.setProperty('--mag-x', ((e.clientX - rect.left - rect.width / 2) * .16).toFixed(1) + 'px');
        button.style.setProperty('--mag-y', ((e.clientY - rect.top - rect.height / 2) * .2).toFixed(1) + 'px');
      });
      button.addEventListener('pointerleave', function () {
        button.style.setProperty('--mag-x', '0px');
        button.style.setProperty('--mag-y', '0px');
      });
    });
  }

  function initTiltCards() {
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    var cards = document.querySelectorAll('.feature, .contact-card, .email-card, .quote, .marquee__item');
    Array.prototype.slice.call(cards).forEach(function (card) {
      card.classList.add('tilt-card');
      card.addEventListener('pointermove', function (e) {
        var rect = card.getBoundingClientRect();
        var rx = ((e.clientY - rect.top) / rect.height - .5) * -5;
        var ry = ((e.clientX - rect.left) / rect.width - .5) * 6;
        card.style.setProperty('--tilt-x', rx.toFixed(2) + 'deg');
        card.style.setProperty('--tilt-y', ry.toFixed(2) + 'deg');
      });
      card.addEventListener('pointerleave', function () {
        card.style.setProperty('--tilt-x', '0deg');
        card.style.setProperty('--tilt-y', '0deg');
      });
    });
  }

  function initHeroParallax() {
    var hero = document.querySelector('.page-hero');
    if (!hero) return;
    var ticking = false;
    function updateHero() {
      var offset = Math.min(window.scrollY * .18, 90);
      hero.style.setProperty('--hero-y', offset.toFixed(1) + 'px');
      hero.style.setProperty('--hero-y-reverse', (-offset * .6).toFixed(1) + 'px');
      ticking = false;
    }
    window.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      window.requestAnimationFrame(updateHero);
    }, { passive: true });
    updateHero();
  }

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

  /* -------------------------------------- interactive marquee engine --- */
  function initMarquee() {
    var container = document.querySelector('[data-marquee-container]') || document.querySelector('.marquee');
    var track = document.querySelector('[data-marquee]');
    if (!track || !container || track.dataset.initialized) return;
    track.dataset.initialized = '1';

    // Disable CSS animation so the JavaScript engine maintains smooth 60fps interactive control
    track.style.animation = 'none';

    // Clone items to ensure seamless infinite looping on any viewport size
    var initialHTML = track.innerHTML;
    track.innerHTML = initialHTML + initialHTML;
    if (track.scrollWidth < (window.innerWidth || 1920) * 2.5) {
      track.innerHTML += initialHTML;
    }

    var allItems = Array.prototype.slice.call(track.children);
    var halfCount = Math.floor(allItems.length / 2);
    allItems.forEach(function (el, i) {
      if (i >= halfCount) el.setAttribute('aria-hidden', 'true');
    });

    var halfWidth = track.scrollWidth / 2;
    function updateDimensions() {
      halfWidth = track.scrollWidth / 2;
    }
    window.addEventListener('resize', updateDimensions, { passive: true });

    // Animation & control state
    var pos = 0;
    var baseSpeed = 0.95; // pixels per frame at 60fps (~57px/sec)
    var speedMultiplier = 1.0;
    var direction = -1; // -1 = Right to Left, 1 = Left to Right
    var isPaused = false;
    var isHovered = false;
    var isDragging = false;
    var dragStartX = 0;
    var dragStartPos = 0;
    var hasDragged = false;
    var lastX = 0;
    var lastTime = 0;
    var velocity = 0;

    // Main render loop
    function animate() {
      if (!isDragging) {
        if (Math.abs(velocity) > 0.05) {
          pos += velocity;
          velocity *= 0.93; // Inertial decay after swipe
        } else {
          velocity = 0;
          if (!isPaused && !isHovered) {
            pos += baseSpeed * speedMultiplier * direction;
          }
        }

        // Seamless wrap-around
        if (halfWidth > 0) {
          while (pos <= -halfWidth) {
            pos += halfWidth;
          }
          while (pos > 0) {
            pos -= halfWidth;
          }
        }

        track.style.transform = 'translate3d(' + pos.toFixed(2) + 'px, 0, 0)';
      }

      requestAnimationFrame(animate);
    }
    requestAnimationFrame(animate);

    // --- UI Controls ---
    var toggleBtn = document.querySelector('[data-marquee-toggle]');
    var toggleText = toggleBtn ? toggleBtn.querySelector('.marquee-btn__text') : null;
    var iconPause = toggleBtn ? toggleBtn.querySelector('.icon-pause') : null;
    var iconPlay = toggleBtn ? toggleBtn.querySelector('.icon-play') : null;

    function setPaused(paused) {
      isPaused = paused;
      if (!toggleBtn) return;
      if (isPaused) {
        toggleBtn.classList.remove('is-playing');
        toggleBtn.classList.add('is-paused');
        toggleBtn.setAttribute('title', 'Resume animation');
        toggleBtn.setAttribute('aria-label', 'Resume marquee animation');
        if (toggleText) toggleText.textContent = 'Play';
        if (iconPause) iconPause.style.display = 'none';
        if (iconPlay) iconPlay.style.display = 'inline-block';
      } else {
        toggleBtn.classList.remove('is-paused');
        toggleBtn.classList.add('is-playing');
        toggleBtn.setAttribute('title', 'Pause animation');
        toggleBtn.setAttribute('aria-label', 'Pause marquee animation');
        if (toggleText) toggleText.textContent = 'Pause';
        if (iconPause) iconPause.style.display = 'inline-block';
        if (iconPlay) iconPlay.style.display = 'none';
      }
    }

    if (toggleBtn) {
      toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        setPaused(!isPaused);
      });
    }

    // Direction buttons
    var dirBtns = document.querySelectorAll('[data-marquee-dir]');
    Array.prototype.slice.call(dirBtns).forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var dir = parseInt(btn.getAttribute('data-marquee-dir'), 10) || -1;
        direction = dir;
        velocity = dir * 16; // Smooth step kick
        if (isPaused) {
          setPaused(false);
        }
      });
    });

    // Speed selector pills
    var speedBtns = document.querySelectorAll('[data-marquee-speed]');
    Array.prototype.slice.call(speedBtns).forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var spd = parseFloat(btn.getAttribute('data-marquee-speed')) || 1.0;
        speedMultiplier = spd;
        Array.prototype.slice.call(speedBtns).forEach(function (b) {
          b.classList.remove('is-active');
        });
        btn.classList.add('is-active');
      });
    });

    // Pause on hover
    container.addEventListener('mouseenter', function () {
      isHovered = true;
    });
    container.addEventListener('mouseleave', function () {
      isHovered = false;
      if (isDragging) {
        isDragging = false;
        container.classList.remove('is-dragging');
      }
    });

    // Mouse & Touch drag handling
    function onStart(clientX) {
      isDragging = true;
      hasDragged = false;
      dragStartX = clientX;
      dragStartPos = pos;
      lastX = clientX;
      lastTime = performance.now();
      velocity = 0;
      container.classList.add('is-dragging');
    }

    function onMove(clientX) {
      if (!isDragging) return;
      var delta = clientX - dragStartX;
      if (Math.abs(delta) > 5) {
        hasDragged = true;
      }
      pos = dragStartPos + delta;

      var now = performance.now();
      var dt = now - lastTime;
      if (dt > 8) {
        velocity = ((clientX - lastX) / dt) * 16;
        lastX = clientX;
        lastTime = now;
      }

      if (halfWidth > 0) {
        while (pos <= -halfWidth) {
          pos += halfWidth;
          dragStartPos += halfWidth;
        }
        while (pos > 0) {
          pos -= halfWidth;
          dragStartPos -= halfWidth;
        }
      }

      track.style.transform = 'translate3d(' + pos.toFixed(2) + 'px, 0, 0)';
    }

    function onEnd() {
      if (!isDragging) return;
      isDragging = false;
      container.classList.remove('is-dragging');
      if (velocity > 28) velocity = 28;
      if (velocity < -28) velocity = -28;
    }

    // Pointer events on container
    container.addEventListener('mousedown', function (e) {
      if (e.target.closest('button, a')) return;
      onStart(e.clientX);
    });
    window.addEventListener('mousemove', function (e) {
      if (isDragging) onMove(e.clientX);
    });
    window.addEventListener('mouseup', function () {
      if (isDragging) onEnd();
    });

    // Touch events for mobile/tablet
    container.addEventListener('touchstart', function (e) {
      if (e.target.closest('button, a')) return;
      if (e.touches.length === 1) {
        onStart(e.touches[0].clientX);
      }
    }, { passive: true });
    window.addEventListener('touchmove', function (e) {
      if (isDragging && e.touches.length === 1) {
        onMove(e.touches[0].clientX);
      }
    }, { passive: true });
    window.addEventListener('touchend', function () {
      if (isDragging) onEnd();
    });

    // Prevent link click when dragged
    track.addEventListener('click', function (e) {
      if (hasDragged) {
        e.preventDefault();
        e.stopPropagation();
      }
    }, true);
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
    function start() { stop(); timer = setInterval(function () { show(i + 1); }, 2000); }
    function stop() { if (timer) { clearInterval(timer); timer = null; } }

    avatars.forEach(function (a, k) {
      a.addEventListener('click', function () { show(k); start(); });
    });

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

  /* --------------------------------------------- hero text rotator --- */
  function initHeroRotator() {
    var rotator = document.getElementById('hero-rotator');
    if (!rotator) return;
    var words = Array.prototype.slice.call(rotator.querySelectorAll('.rotator-word'));
    if (words.length < 2) return;

    var currentIndex = 0;
    var interval = 2800;

    setInterval(function () {
      var currentWord = words[currentIndex];
      var nextIndex = (currentIndex + 1) % words.length;
      var nextWord = words[nextIndex];

      currentWord.classList.remove('is-active');
      currentWord.classList.add('is-exiting');

      nextWord.classList.add('is-active');
      nextWord.classList.remove('is-exiting');

      setTimeout(function () {
        currentWord.classList.remove('is-exiting');
      }, 500);

      currentIndex = nextIndex;
    }, interval);
  }

  /* -------------------------------------------------------------- init --- */
  function init() {
    initAwardExperience();
    initHeader();
    initNav();
    initHeroRotator();
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
