/* Dental Studio Mijušković — main.js (vanilla, bez biblioteka) */
(function () {
  'use strict';
  var doc = document;
  var root = doc.documentElement;
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Placeholder slike ----------
     Ako fajl iz assets/img/ ne postoji, sliku sakrivamo i ostaje vidljiv
     placeholder sa imenom fajla. Kada se fajl doda, slika se prikaže sama. */
  function markMissing(img) {
    var ph = img.closest('.ph');
    if (ph) ph.classList.add('is-missing');
  }
  function markLoaded(img) {
    var ph = img.closest('.ph');
    if (ph) { ph.classList.remove('is-missing'); ph.classList.add('is-loaded'); }
  }
  doc.querySelectorAll('.ph > img').forEach(function (img) {
    if (img.complete) {
      if (img.naturalWidth === 0) markMissing(img); else markLoaded(img);
    }
    img.addEventListener('error', function () { markMissing(img); });
    img.addEventListener('load', function () { markLoaded(img); });
  });

  /* ---------- Logo: wordmark ostaje ako logo.webp ne postoji ---------- */
  doc.querySelectorAll('.brand').forEach(function (brand) {
    var img = brand.querySelector('.brand__logo');
    var word = brand.querySelector('.brand__word');
    if (!img || !word || !img.decode) return;
    img.decode().then(function () {
      if (img.naturalWidth > 0) { img.hidden = false; word.hidden = true; }
    }).catch(function () { /* nema logotipa: ostaje wordmark */ });
  });

  /* ---------- Header pri skrolu ---------- */
  var header = doc.querySelector('.site-header');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ---------- Desktop dropdown "Usluge" (klik + Esc) ---------- */
  doc.querySelectorAll('.has-dd').forEach(function (item) {
    var btn = item.querySelector('.nav__dd-toggle');
    if (!btn) return;
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = !item.classList.contains('is-open');
      item.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', String(open));
    });
    item.addEventListener('mouseenter', function () { btn.setAttribute('aria-expanded', 'true'); });
    item.addEventListener('mouseleave', function () {
      if (!item.classList.contains('is-open')) btn.setAttribute('aria-expanded', 'false');
    });
    doc.addEventListener('click', function (e) {
      if (!item.contains(e.target)) { item.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }
    });
    item.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { item.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); btn.focus(); }
    });
  });

  /* ---------- Mobilni meni ---------- */
  var toggle = doc.querySelector('.nav-toggle');
  var panel = doc.getElementById('mnav');
  if (toggle && panel) {
    var setMenu = function (open) {
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Zatvorite meni' : 'Otvorite meni');
      panel.hidden = !open;
      root.classList.toggle('menu-open', open);
      doc.body.classList.toggle('menu-open', open);
    };
    toggle.addEventListener('click', function () { setMenu(toggle.getAttribute('aria-expanded') !== 'true'); });
    panel.addEventListener('click', function (e) { if (e.target.closest('a')) setMenu(false); });
    doc.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') { setMenu(false); toggle.focus(); }
    });
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 900 && toggle.getAttribute('aria-expanded') === 'true') setMenu(false);
    });
  }

  /* ---------- Pre/posle klizač ---------- */
  function setPos(ba, v) { ba.style.setProperty('--pos', v + '%'); }
  var sliders = doc.querySelectorAll('.ba');
  sliders.forEach(function (ba) {
    var range = ba.querySelector('.ba__range');
    if (!range) return;
    setPos(ba, range.value);
    range.addEventListener('input', function () { setPos(ba, range.value); ba.dataset.touched = '1'; });
  });

  function hint(ba) {
    var range = ba.querySelector('.ba__range');
    if (!range || reduceMotion || ba.dataset.touched) return;
    var start = null, dur = 900;
    function frame(t) {
      if (ba.dataset.touched) return;
      if (start === null) start = t;
      var p = Math.min((t - start) / dur, 1);
      var v = 50 + 10 * Math.sin(p * Math.PI);
      setPos(ba, v.toFixed(2));
      if (p < 1) requestAnimationFrame(frame); else { setPos(ba, range.value); }
    }
    requestAnimationFrame(frame);
  }

  /* ---------- Reveal + hint pri ulasku u viewport ---------- */
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target;
        if (el.classList.contains('ba')) { hint(el); } else { el.classList.add('is-in'); }
        io.unobserve(el);
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.15 });
    doc.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
    sliders.forEach(function (el) { io.observe(el); });
  } else {
    doc.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('is-in'); });
  }

  /* ---------- Tabovi slučajeva na početnoj ---------- */
  doc.querySelectorAll('[data-ba-tabs]').forEach(function (group) {
    var btns = group.querySelectorAll('[data-target]');
    btns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        btns.forEach(function (b) {
          var on = b === btn;
          b.setAttribute('aria-pressed', String(on));
          var panelEl = doc.getElementById(b.dataset.target);
          if (panelEl) panelEl.hidden = !on;
        });
      });
    });
  });

  /* ---------- Filter rezultata (ključ boja + hash) ---------- */
  var filter = doc.querySelector('[data-filter]');
  if (filter) {
    var fbtns = filter.querySelectorAll('[data-cat]');
    var cases = doc.querySelectorAll('.case[data-cat]');
    var count = doc.querySelector('[data-count]');
    var valid = Array.prototype.map.call(fbtns, function (b) { return b.dataset.cat; });
    var apply = function (cat, updateHash) {
      if (valid.indexOf(cat) === -1) cat = 'sve';
      var n = 0;
      fbtns.forEach(function (b) { b.setAttribute('aria-pressed', String(b.dataset.cat === cat)); });
      cases.forEach(function (c) {
        var show = cat === 'sve' || c.dataset.cat === cat;
        c.hidden = !show;
        if (show) n++;
      });
      if (count) count.textContent = 'Prikazano slučajeva: ' + n;
      if (updateHash && window.history && history.replaceState) {
        history.replaceState(null, '', cat === 'sve' ? location.pathname + location.search : '#' + cat);
      }
    };
    fbtns.forEach(function (b) {
      b.addEventListener('click', function () { apply(b.dataset.cat, true); });
    });
    var fromHash = function () { apply((location.hash || '').replace('#', '') || 'sve', false); };
    window.addEventListener('hashchange', fromHash);
    fromHash();
  }

  /* ---------- Godina u footeru ---------- */
  doc.querySelectorAll('[data-year]').forEach(function (el) { el.textContent = new Date().getFullYear(); });
})();
