/* Diverse Pathwais — Super Admin behaviour (no build step) */
(function () {
  'use strict';

  var $ = function (sel, root) { return (root || document).querySelector(sel); };
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };
  var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var root = document.documentElement;
  function store(key, val) { try { if (val === undefined) return localStorage.getItem(key); localStorage.setItem(key, val); } catch (e) { return null; } }

  /* ------------------------------------------------ top loading bar */
  var bar = $('[data-nprogress]');
  function startBar() {
    if (!bar) return;
    bar.classList.add('is-on');
    bar.style.width = '0';
    requestAnimationFrame(function () { bar.style.width = '72%'; });
  }
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a[href]');
    if (!a || e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey || a.target === '_blank') return;
    var href = a.getAttribute('href');
    if (!href || href.charAt(0) === '#' || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) return;
    if (a.origin !== location.origin) return;
    startBar();
  });
  window.addEventListener('pageshow', function () { if (bar) { bar.style.width = '100%'; setTimeout(function () { bar.classList.remove('is-on'); bar.style.width = '0'; }, 250); } });

  /* ------------------------------------------------------ sidebar */
  var shell = $('[data-shell]');
  $$('[data-toggle-side]').forEach(function (b) { b.addEventListener('click', function () { shell.classList.toggle('is-open'); }); });
  var collapse = $('[data-collapse]');
  if (collapse) collapse.addEventListener('click', function () {
    var on = root.classList.toggle('side-collapsed');
    store('dp-admin-collapsed', on ? '1' : '0');
    setTimeout(placeInd, 460);
  });

  var nav = $('[data-nav]'), ind = $('[data-nav-ind]');
  function placeInd(target) {
    if (!nav || !ind) return;
    var a = target || $('a.is-active', nav);
    if (!a) { ind.style.opacity = 0; return; }
    ind.style.opacity = 1;
    ind.style.height = a.offsetHeight + 'px';
    ind.style.transform = 'translateY(' + a.offsetTop + 'px)';
  }
  if (nav) {
    placeInd();
    $$('a', nav).forEach(function (a) {
      a.addEventListener('mouseenter', function () { placeInd(a); });
    });
    nav.addEventListener('mouseleave', function () { placeInd(); });
    window.addEventListener('resize', function () { placeInd(); });
  }

  /* --------------------------------------------- sticky top shadow */
  var top = $('[data-top]');
  if (top) {
    var onScroll = function () { top.classList.toggle('is-scrolled', window.scrollY > 8); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ---------------------------------------------------- dropdowns */
  $$('[data-drop]').forEach(function (d) {
    var btn = $('[data-drop-toggle]', d);
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = !d.classList.contains('is-open');
      $$('[data-drop].is-open').forEach(function (o) { o.classList.remove('is-open'); });
      d.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', open);
    });
  });
  document.addEventListener('click', function (e) {
    if (!e.target.closest('[data-drop]')) $$('[data-drop].is-open').forEach(function (o) { o.classList.remove('is-open'); });
  });

  /* -------------------------------------------- staggered reveals */
  var content = $('[data-content]');
  if (content && !reduced) {
    var i = 0;
    Array.prototype.forEach.call(content.children, function (el) {
      if (el.matches('.stats, .kpis, .grid')) {
        Array.prototype.forEach.call(el.children, function (c) {
          if (c.matches('.grid')) {
            Array.prototype.forEach.call(c.children, function (cc) { cc.classList.add('rv'); cc.style.setProperty('--i', i++); });
          } else { c.classList.add('rv'); c.style.setProperty('--i', i++); }
        });
      } else if (el.tagName === 'FORM' && el.firstElementChild && el.firstElementChild.matches('.grid')) {
        $$(':scope > .grid > *, :scope > .grid > .grid > *', el).forEach(function (c) { if (!c.matches('.grid')) { c.classList.add('rv'); c.style.setProperty('--i', i++); } });
      } else { el.classList.add('rv'); el.style.setProperty('--i', i++); }
    });
  }
  $$('.table tbody').forEach(function (tb) { $$('tr', tb).forEach(function (tr, n) { tr.style.setProperty('--r', Math.min(n, 18)); }); });
  $$('.checks').forEach(function (ul) { $$('li', ul).forEach(function (li, n) { li.style.setProperty('--r', n); }); });
  $$('.hbars').forEach(function (h) { $$('.hbar__fill', h).forEach(function (f, n) { f.style.setProperty('--r', n); }); });

  /* ---------------------------------------- cursor spotlight cards */
  $$('.card, .stat').forEach(function (c) {
    c.classList.add('spot');
    c.addEventListener('pointermove', function (e) {
      var r = c.getBoundingClientRect();
      c.style.setProperty('--mx', (e.clientX - r.left) + 'px');
      c.style.setProperty('--my', (e.clientY - r.top) + 'px');
    });
  });
  $$('.stat').forEach(function (c) { c.classList.add('card--hover'); });

  /* -------------------------------------------------- ripple */
  document.addEventListener('pointerdown', function (e) {
    var b = e.target.closest && e.target.closest('.btn');
    if (!b || reduced) return;
    var r = b.getBoundingClientRect(), s = Math.max(r.width, r.height);
    var span = document.createElement('span');
    span.className = 'ripple';
    span.style.cssText = 'width:' + s + 'px;height:' + s + 'px;left:' + (e.clientX - r.left - s / 2) + 'px;top:' + (e.clientY - r.top - s / 2) + 'px';
    b.appendChild(span);
    setTimeout(function () { span.remove(); }, 650);
  });

  /* ------------------------------------------------ count-up */
  $$('[data-count-to]').forEach(function (el) {
    var to = parseFloat(el.getAttribute('data-count-to')) || 0;
    if (reduced || to === 0) { el.textContent = to.toLocaleString(); return; }
    var start = null, dur = 1300;
    el.textContent = '0';
    function step(t) {
      if (!start) start = t;
      var p = Math.min(1, (t - start) / dur), eased = 1 - Math.pow(1 - p, 4);
      el.textContent = Math.round(to * eased).toLocaleString();
      if (p < 1) requestAnimationFrame(step);
    }
    setTimeout(function () { requestAnimationFrame(step); }, 250);
  });

  /* ------------------------------------------------- toasts */
  $$('.toast').forEach(function (t, n) {
    setTimeout(function () { t.classList.add('is-out'); setTimeout(function () { t.remove(); }, 400); }, 4600 + n * 300);
    t.addEventListener('click', function () { t.classList.add('is-out'); setTimeout(function () { t.remove(); }, 400); });
  });

  /* ------------------------------------------- confirm + loading */
  $$('form[data-confirm]').forEach(function (f) {
    f.addEventListener('submit', function (e) { if (!window.confirm(f.getAttribute('data-confirm'))) e.preventDefault(); });
  });
  document.addEventListener('submit', function (e) {
    if (e.defaultPrevented) return;
    var f = e.target;
    var btn = e.submitter || $('[type=submit]', f);
    if (btn && btn.classList.contains('btn')) { btn.classList.add('is-loading'); }
    dirty = false;
    if (f.method && f.method.toLowerCase() === 'post') startBar();
  });
  window.addEventListener('pageshow', function () { $$('.btn.is-loading').forEach(function (b) { b.classList.remove('is-loading'); }); });

  /* ---------------------------------------- unsaved-changes bar */
  var dirty = false;
  $$('form[data-track]').forEach(function (f) {
    var sb = $('.savebar', f);
    var mark = function () { dirty = true; if (sb) sb.classList.add('is-dirty'); };
    f.addEventListener('input', mark);
    f.addEventListener('change', mark);
  });
  window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });
  document.addEventListener('keydown', function (e) {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
      var f = $('form[data-track]');
      if (f) { e.preventDefault(); if (f.requestSubmit) f.requestSubmit(); else f.submit(); }
    }
  });

  /* ------------------------------------------------ command palette */
  var cmdk = $('[data-cmdk]');
  if (cmdk) {
    var data = [], icons = {};
    try { data = JSON.parse($('#cmdk-data').textContent); icons = JSON.parse($('#cmdk-icons').textContent); } catch (e) {}
    var input = $('[data-cmdk-input]'), list = $('[data-cmdk-list]'), active = 0, shown = [];
    var esc = function (s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); };
    var score = function (item, q) {
      if (!q) return 1;
      var hay = (item.t + ' ' + (item.s || '') + ' ' + item.g).toLowerCase();
      var parts = q.toLowerCase().split(/\s+/).filter(Boolean);
      for (var k = 0; k < parts.length; k++) if (hay.indexOf(parts[k]) === -1) return 0;
      return item.t.toLowerCase().indexOf(parts[0]) === 0 ? 3 : 2;
    };
    var render = function () {
      var q = input.value.trim();
      shown = data.map(function (it) { return { it: it, s: score(it, q) }; }).filter(function (x) { return x.s > 0; })
        .sort(function (a, b) { return b.s - a.s; }).map(function (x) { return x.it; }).slice(0, q ? 40 : 14);
      if (!shown.length) { list.innerHTML = '<div class="cmdk__empty">No results for “' + esc(q) + '”</div>'; return; }
      active = Math.min(active, shown.length - 1);
      var html = '', last = '';
      shown.forEach(function (it, n) {
        if (it.g !== last) { html += '<div class="cmdk__group">' + esc(it.g) + '</div>'; last = it.g; }
        html += '<a class="cmdk__item' + (n === active ? ' is-active' : '') + '" data-n="' + n + '" href="' + esc(it.u) + '"' + (it.n ? ' target="_blank" rel="noopener"' : '') + '>' +
          '<span class="ico-circle"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + (icons[it.i] || '') + '</svg></span>' +
          '<strong>' + esc(it.t) + '</strong>' + (it.s ? '<small>' + esc(it.s) + '</small>' : '') + '</a>';
      });
      list.innerHTML = html;
    };
    var openCmd = function () { cmdk.classList.add('is-open'); cmdk.setAttribute('aria-hidden', 'false'); input.value = ''; active = 0; render(); setTimeout(function () { input.focus(); }, 30); };
    var closeCmd = function () { cmdk.classList.remove('is-open'); cmdk.setAttribute('aria-hidden', 'true'); };
    var move = function (d) {
      active = (active + d + shown.length) % shown.length;
      $$('.cmdk__item', list).forEach(function (el) { el.classList.toggle('is-active', +el.getAttribute('data-n') === active); });
      var cur = $('.cmdk__item.is-active', list); if (cur) cur.scrollIntoView({ block: 'nearest' });
    };
    $$('[data-cmdk-open]').forEach(function (b) { b.addEventListener('click', openCmd); });
    cmdk.addEventListener('click', function (e) { if (e.target === cmdk) closeCmd(); });
    list.addEventListener('mousemove', function (e) {
      var it = e.target.closest('.cmdk__item'); if (!it) return;
      var n = +it.getAttribute('data-n'); if (n !== active) { active = n; move(0); }
    });
    input.addEventListener('input', function () { active = 0; render(); });
    document.addEventListener('keydown', function (e) {
      var typing = /INPUT|TEXTAREA|SELECT/.test(document.activeElement.tagName) || document.activeElement.isContentEditable;
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); cmdk.classList.contains('is-open') ? closeCmd() : openCmd(); return; }
      if (e.key === '/' && !typing && !cmdk.classList.contains('is-open')) { e.preventDefault(); openCmd(); return; }
      if (!cmdk.classList.contains('is-open')) { if (e.key === 'Escape') shell && shell.classList.remove('is-open'); return; }
      if (e.key === 'Escape') closeCmd();
      else if (e.key === 'ArrowDown') { e.preventDefault(); move(1); }
      else if (e.key === 'ArrowUp') { e.preventDefault(); move(-1); }
      else if (e.key === 'Enter') { e.preventDefault(); var cur = $('.cmdk__item.is-active', list); if (cur) { if (cur.target === '_blank') window.open(cur.href); else { startBar(); location.href = cur.href; } closeCmd(); } }
    });
  }

  /* ---------------------------------------------- chart tooltips */
  $$('[data-chart]').forEach(function (chart) {
    var tip = $('.chart-tip', chart);
    $$('.hit', chart).forEach(function (h) {
      var barEl = h.nextElementSibling;
      h.addEventListener('pointerenter', function () {
        barEl.classList.add('is-hover');
        tip.innerHTML = '<strong>' + h.getAttribute('data-v') + ' ' + (h.getAttribute('data-v') === '1' ? 'enquiry' : 'enquiries') + '</strong><span>' + h.getAttribute('data-l') + '</span>';
        var cr = chart.getBoundingClientRect(), br = barEl.getBoundingClientRect();
        tip.style.left = (br.left - cr.left + br.width / 2) + 'px';
        tip.style.top = (br.top - cr.top) + 'px';
        tip.classList.add('is-on');
      });
      h.addEventListener('pointerleave', function () { barEl.classList.remove('is-hover'); tip.classList.remove('is-on'); });
    });
  });

  /* ======================================================= login page */
  var login = $('[data-login]');
  if (login) {
    var pw = $('#password'), eye = $('[data-eye]'), caps = $('[data-caps]');
    eye.addEventListener('click', function () {
      var show = pw.type === 'password';
      pw.type = show ? 'text' : 'password';
      eye.setAttribute('aria-pressed', show);
      eye.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
      eye.innerHTML = show
        ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M17.9 17.9A10.4 10.4 0 0 1 12 19c-6.4 0-10-7-10-7a18.5 18.5 0 0 1 5.1-5.9M9.9 5.2A9.1 9.1 0 0 1 12 5c6.4 0 10 7 10 7a18.6 18.6 0 0 1-2.2 3.2M14.1 14.1a3 3 0 1 1-4.2-4.2M2 2l20 20"/></svg>'
        : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>';
      pw.focus();
    });
    var capsCheck = function (e) { if (e.getModifierState) caps.classList.toggle('is-on', e.getModifierState('CapsLock')); };
    pw.addEventListener('keydown', capsCheck);
    pw.addEventListener('keyup', capsCheck);
    pw.addEventListener('blur', function () { caps.classList.remove('is-on'); });
    if (login.classList.contains('is-shake')) {
      setTimeout(function () { login.classList.remove('is-shake'); }, 600);
      var bad = $('.ff.has-error input', login); if (bad) bad.focus();
    }
    login.addEventListener('submit', function (e) {
      var email = $('#email');
      if (!email.value.trim() || !pw.value) {
        e.preventDefault();
        login.classList.remove('is-shake'); void login.offsetWidth; login.classList.add('is-shake');
        (email.value.trim() ? pw : email).focus();
      }
    });
  }

  var art = $('[data-parallax]');
  if (art && !reduced) {
    var glow = $('.auth__glow', art), layers = $$('[data-depth]', art);
    art.addEventListener('pointermove', function (e) {
      var r = art.getBoundingClientRect();
      var x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
      glow.style.setProperty('--gx', (x * 100) + '%');
      glow.style.setProperty('--gy', (y * 100) + '%');
      layers.forEach(function (l) {
        var d = +l.getAttribute('data-depth');
        l.style.transform = 'translate(' + ((x - .5) * -d) + 'px,' + ((y - .5) * -d) + 'px)';
      });
    });
  }
  var rot = $('[data-rotator]');
  if (rot && !reduced) {
    var words = $$('span', rot), w = 0;
    setInterval(function () {
      var cur = words[w]; w = (w + 1) % words.length;
      cur.classList.remove('is-on'); cur.classList.add('is-out');
      words[w].classList.remove('is-out'); words[w].classList.add('is-on');
      setTimeout(function () { cur.classList.remove('is-out'); }, 700);
    }, 2600);
  }

  /* ================================================= editor screens */
  /* tabs with sliding indicator; remembers the open tab via the hash */
  $$('[data-tabs]').forEach(function (wrap) {
    var buttons = $$('[data-tab]', wrap);
    var bar2 = document.createElement('span'); bar2.className = 'tabs__ind'; wrap.appendChild(bar2);
    function slide(b) { bar2.style.width = b.offsetWidth + 'px'; bar2.style.transform = 'translateX(' + b.offsetLeft + 'px)'; }
    function open(name) {
      buttons.forEach(function (b) { var on = b.getAttribute('data-tab') === name; b.classList.toggle('is-active', on); if (on) slide(b); });
      $$('[data-panel]').forEach(function (p) { p.classList.toggle('is-active', p.getAttribute('data-panel') === name); });
    }
    buttons.forEach(function (b) {
      b.addEventListener('click', function () { open(b.getAttribute('data-tab')); history.replaceState(null, '', '#' + b.getAttribute('data-tab')); });
    });
    var fromHash = location.hash.replace('#', '');
    var firstError = $('.field.has-error');
    var errPanel = firstError && firstError.closest('[data-panel]');
    if (errPanel) open(errPanel.getAttribute('data-panel'));
    else if (fromHash && buttons.some(function (b) { return b.getAttribute('data-tab') === fromHash; })) open(fromHash);
    else { var a = $('[data-tab].is-active', wrap) || buttons[0]; requestAnimationFrame(function () { slide(a); }); }
    window.addEventListener('resize', function () { var a = $('[data-tab].is-active', wrap); if (a) slide(a); });
  });

  /* character counters: data-count="min,max" */
  $$('[data-count]').forEach(function (input) {
    var range = input.getAttribute('data-count').split(',').map(Number);
    var out = $('[data-counter-for="' + input.id + '"]');
    if (!out) return;
    function update() {
      var n = input.value.length;
      if (!n && input.getAttribute('data-fallback')) n = input.getAttribute('data-fallback').length;
      out.textContent = n + ' / ' + range[1];
      out.classList.remove('is-good', 'is-warn', 'is-bad');
      out.classList.add(n === 0 ? 'is-bad' : (n >= range[0] && n <= range[1]) ? 'is-good' : 'is-warn');
    }
    input.addEventListener('input', update);
    update();
  });

  /* live Google / social preview */
  var serp = $('[data-serp]');
  if (serp) {
    var get = function (id) { return document.getElementById(id); };
    var fields = { title: get('meta_title'), desc: get('meta_description'), ogTitle: get('og_title'), ogDesc: get('og_description'), slug: get('slug'), postTitle: get('title'), excerpt: get('excerpt') };
    var base = serp.getAttribute('data-base'), suffix = serp.getAttribute('data-suffix') || '';
    var txt = function (el) { return el ? el.value.trim() : ''; };
    var renderSerp = function () {
      var title = txt(fields.title) || (txt(fields.postTitle) ? txt(fields.postTitle) + suffix : serp.getAttribute('data-fallback-title'));
      var desc = txt(fields.desc) || txt(fields.excerpt) || serp.getAttribute('data-fallback-desc') || 'Add a meta description so Google shows the right summary.';
      var path = fields.slug ? '/blog/' + (txt(fields.slug) || 'your-post-url') : serp.getAttribute('data-path');
      $('[data-serp-title]').textContent = title;
      $('[data-serp-desc]').textContent = desc;
      $('[data-serp-url]').textContent = base + (path === '/' ? '' : path.replace(/\//g, ' › '));
      var st = $('[data-social-title]'); if (st) st.textContent = txt(fields.ogTitle) || title;
      var sd = $('[data-social-desc]'); if (sd) sd.textContent = txt(fields.ogDesc) || desc;
    };
    Object.keys(fields).forEach(function (k) { if (fields[k]) fields[k].addEventListener('input', renderSerp); });
    renderSerp();
  }

  /* slug auto-fills from the title until edited by hand */
  var slug = document.getElementById('slug'), title = document.getElementById('title');
  if (slug && title) {
    var touched = slug.value.trim() !== '';
    var slugify = function (s) {
      return s.toLowerCase().normalize('NFKD').replace(/[̀-ͯ]/g, '').replace(/&/g, ' and ')
        .replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 120);
    };
    slug.addEventListener('input', function (e) { if (e.isTrusted) touched = slug.value.trim() !== ''; });
    slug.addEventListener('blur', function () { slug.value = slugify(slug.value); slug.dispatchEvent(new Event('input')); });
    title.addEventListener('input', function () { if (touched) return; slug.value = slugify(title.value); slug.dispatchEvent(new Event('input')); });
  }

  /* image file inputs: instant preview */
  $$('input[type=file][data-preview]').forEach(function (input) {
    input.addEventListener('change', function () {
      var img = document.getElementById(input.getAttribute('data-preview'));
      if (img && input.files && input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
        img.hidden = false;
        var social = $('[data-social-img]');
        if (social && input.hasAttribute('data-social')) social.src = img.src;
      }
    });
  });

  /* rich text editor (Quill) */
  var editorEl = document.getElementById('editor');
  if (editorEl && window.Quill) {
    var hidden = document.getElementById('content');
    var quill = new window.Quill(editorEl, {
      theme: 'snow',
      placeholder: 'Write your article…',
      modules: {
        toolbar: {
          container: [[{ header: [2, 3, 4, false] }], ['bold', 'italic', 'underline', 'strike'], [{ list: 'ordered' }, { list: 'bullet' }], ['blockquote', 'link', 'image'], [{ align: [] }], ['clean']],
          handlers: {
            image: function () {
              var picker = document.createElement('input');
              picker.type = 'file';
              picker.accept = 'image/png,image/jpeg,image/webp,image/gif';
              picker.onchange = function () {
                var file = picker.files[0];
                if (!file) return;
                var data = new FormData();
                data.append('image', file);
                data.append('_token', document.querySelector('meta[name=csrf-token]').content);
                fetch(editorEl.getAttribute('data-upload'), { method: 'POST', body: data, headers: { Accept: 'application/json' }, credentials: 'same-origin' })
                  .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, d: d }; }); })
                  .then(function (res) {
                    if (!res.ok) { alert((res.d.errors && res.d.errors.image && res.d.errors.image[0]) || 'Upload failed.'); return; }
                    var range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'image', res.d.url, 'user');
                    quill.setSelection(range.index + 1);
                  })
                  .catch(function () { alert('Upload failed.'); });
              };
              picker.click();
            }
          }
        }
      }
    });
    quill.root.innerHTML = hidden.value;
    var sync = function () { hidden.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML; };
    quill.on('text-change', function (d, o, source) { sync(); if (source === 'user') hidden.dispatchEvent(new Event('input', { bubbles: true })); });
    editorEl.closest('form').addEventListener('submit', sync);
  }

  /* pretty-print JSON-LD on blur */
  $$('textarea[data-json]').forEach(function (ta) {
    ta.addEventListener('blur', function () {
      if (!ta.value.trim()) return;
      try { ta.value = JSON.stringify(JSON.parse(ta.value), null, 2); ta.closest('.field').classList.remove('has-error'); }
      catch (e) { ta.closest('.field').classList.add('has-error'); }
    });
  });
})();
