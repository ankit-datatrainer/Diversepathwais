/* Diverse Pathwais — Super Admin panel behaviour (no build step) */
(function () {
  'use strict';

  var $ = function (sel, root) { return (root || document).querySelector(sel); };
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

  /* mobile sidebar */
  var shell = $('.adm');
  $$('[data-toggle-side]').forEach(function (b) {
    b.addEventListener('click', function () { shell.classList.toggle('is-open'); });
  });

  /* confirm destructive actions */
  $$('form[data-confirm]').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      if (!window.confirm(f.getAttribute('data-confirm'))) e.preventDefault();
    });
  });

  /* tabs — remembers the open tab across validation reloads via the hash */
  $$('[data-tabs]').forEach(function (wrap) {
    var buttons = $$('[data-tab]', wrap);
    function open(name) {
      buttons.forEach(function (b) { b.classList.toggle('is-active', b.getAttribute('data-tab') === name); });
      $$('[data-panel]').forEach(function (p) { p.classList.toggle('is-active', p.getAttribute('data-panel') === name); });
    }
    buttons.forEach(function (b) {
      b.addEventListener('click', function () {
        open(b.getAttribute('data-tab'));
        history.replaceState(null, '', '#' + b.getAttribute('data-tab'));
      });
    });
    var fromHash = location.hash.replace('#', '');
    var firstError = $('.field.has-error');
    var errPanel = firstError && firstError.closest('[data-panel]');
    if (errPanel) open(errPanel.getAttribute('data-panel'));
    else if (fromHash && buttons.some(function (b) { return b.getAttribute('data-tab') === fromHash; })) open(fromHash);
  });

  /* character counters: data-count="min,max" */
  $$('[data-count]').forEach(function (input) {
    var range = input.getAttribute('data-count').split(',').map(Number);
    var out = $('[data-counter-for="' + input.id + '"]');
    if (!out) return;
    function update() {
      var n = input.value.length;
      var src = input.value ? '' : (input.getAttribute('data-fallback') || '');
      if (!n && src) n = src.length;
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
    var fields = {
      title: get('meta_title'), desc: get('meta_description'),
      ogTitle: get('og_title'), ogDesc: get('og_description'),
      slug: get('slug'), postTitle: get('title'), excerpt: get('excerpt')
    };
    var base = serp.getAttribute('data-base');
    var suffix = serp.getAttribute('data-suffix') || '';
    function txt(el) { return el ? el.value.trim() : ''; }
    function render() {
      var title = txt(fields.title) || (txt(fields.postTitle) ? txt(fields.postTitle) + suffix : serp.getAttribute('data-fallback-title'));
      var desc = txt(fields.desc) || txt(fields.excerpt) || serp.getAttribute('data-fallback-desc') || 'Add a meta description so Google shows the right summary.';
      var path = fields.slug ? '/blog/' + (txt(fields.slug) || 'your-post-url') : serp.getAttribute('data-path');
      $('[data-serp-title]').textContent = title;
      $('[data-serp-desc]').textContent = desc;
      $('[data-serp-url]').textContent = base + (path === '/' ? '' : path.replace(/\//g, ' › ').replace(/^ › /, ' › '));
      var st = $('[data-social-title]'); if (st) st.textContent = txt(fields.ogTitle) || title;
      var sd = $('[data-social-desc]'); if (sd) sd.textContent = txt(fields.ogDesc) || desc;
    }
    Object.keys(fields).forEach(function (k) { if (fields[k]) fields[k].addEventListener('input', render); });
    render();
  }

  /* slug: auto-fill from title until edited by hand */
  var slug = document.getElementById('slug');
  var title = document.getElementById('title');
  if (slug && title) {
    var touched = slug.value.trim() !== '';
    var slugify = function (s) {
      return s.toLowerCase().normalize('NFKD').replace(/[̀-ͯ]/g, '')
        .replace(/&/g, ' and ').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 120);
    };
    slug.addEventListener('input', function (e) {
      if (e.isTrusted) touched = slug.value.trim() !== '';
    });
    slug.addEventListener('blur', function () { slug.value = slugify(slug.value); slug.dispatchEvent(new Event('input')); });
    title.addEventListener('input', function () {
      if (touched) return;
      slug.value = slugify(title.value);
      slug.dispatchEvent(new Event('input'));
    });
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
          container: [
            [{ header: [2, 3, 4, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['blockquote', 'link', 'image'],
            [{ align: [] }],
            ['clean']
          ],
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
    quill.on('text-change', sync);
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
