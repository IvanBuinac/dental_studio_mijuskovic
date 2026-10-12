/* dr Filip Katanić — main.js (v2), vanilla, bez biblioteka.
   reveal (progresivno) · header · dropdown · mobilni meni · sticky bar · FAQ · footer akordeoni · scroller tačke */
(function () {
  'use strict';
  var d = document, w = window, root = d.documentElement;
  var reduce = w.matchMedia && w.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $ = function (s, r) { return (r || d).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || d).querySelectorAll(s)); };
  var hasIO = 'IntersectionObserver' in w;

  /* ---------- reveal: skriva se SAMO ono što je ispod pregiba, i tek kad je IO spreman ---------- */
  (function () {
    var els = $$('.reveal');
    if (!els.length || !hasIO || reduce) return;
    var vh = w.innerHeight || root.clientHeight;
    var pending = [];
    els.forEach(function (el) {
      if (el.getBoundingClientRect().top < vh * 0.98) return;      // već vidljivo → ne dira se
      var sib = el.parentElement ? $$(':scope > .reveal', el.parentElement) : [el];
      var i = Math.max(0, sib.indexOf(el));
      if (i > 0 && i < 5) el.style.setProperty('--rd', (i * 60) + 'ms');
      el.classList.add('reveal-pending');
      pending.push(el);
    });
    if (!pending.length) return;
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-in');
        io.unobserve(e.target);
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -4% 0px' });
    pending.forEach(function (el) { io.observe(el); });
    root.classList.add('reveal-ready');
    function showAll() { pending.forEach(function (el) { el.classList.add('is-in'); }); }
    w.setTimeout(showAll, 2500);                  // failsafe (headless/screenshot/spori uređaji)
    w.addEventListener('beforeprint', showAll);
  })();

  /* ---------- header + sticky bar ---------- */
  var header = $('#site-header'), bar = $('#sticky-bar');
  var heroVisible = true, endVisible = false;
  function update() {
    if (header) header.classList.toggle('is-scrolled', w.scrollY > 24);
    if (bar) bar.classList.toggle('is-on', !heroVisible && !endVisible);
  }
  if (bar && hasIO) {
    var hero = $('.hero, .page-hero');
    if (hero) new IntersectionObserver(function (es) { heroVisible = es[0].isIntersecting; update(); }).observe(hero);
    else heroVisible = false;
    var ends = $$('#cta-band, .site-footer'), vis = {};
    var io2 = new IntersectionObserver(function (es) {
      es.forEach(function (e) { vis[e.target.className] = e.isIntersecting; });
      endVisible = Object.keys(vis).some(function (k) { return vis[k]; });
      update();
    });
    ends.forEach(function (e) { io2.observe(e); });
  } else if (bar) { bar.classList.add('is-on'); }
  w.addEventListener('scroll', update, { passive: true });
  update();

  /* ---------- dropdown "Oblasti rada" ---------- */
  $$('.has-sub').forEach(function (li) {
    var btn = $('button', li);
    function set(open) { li.classList.toggle('is-open', open); btn.setAttribute('aria-expanded', open ? 'true' : 'false'); }
    btn.addEventListener('click', function (e) { e.stopPropagation(); set(!li.classList.contains('is-open')); });
    li.addEventListener('focusout', function (e) { if (!li.contains(e.relatedTarget)) set(false); });
    li.addEventListener('keydown', function (e) { if (e.key === 'Escape') { set(false); btn.focus(); } });
    d.addEventListener('click', function (e) { if (!li.contains(e.target)) set(false); });
  });

  /* ---------- mobilni meni (dialog, fokus trap, Esc, scroll lock) ---------- */
  (function () {
    var burger = $('.burger'), menu = $('#menu');
    if (!burger || !menu) return;
    var closeBtn = $('.menu__close', menu), lastFocus = null, timer;
    function focusables() { return $$('a[href], button', menu).filter(function (x) { return x.offsetParent !== null; }); }
    function open(o) {
      w.clearTimeout(timer);
      burger.setAttribute('aria-expanded', o ? 'true' : 'false');
      d.body.classList.toggle('menu-open', o);
      if (o) {
        lastFocus = d.activeElement;
        menu.hidden = false;
        w.requestAnimationFrame(function () { w.requestAnimationFrame(function () { menu.classList.add('is-open'); }); });
        if (closeBtn) closeBtn.focus();
      } else {
        menu.classList.remove('is-open');
        timer = w.setTimeout(function () { menu.hidden = true; }, reduce ? 0 : 260);
        if (lastFocus && lastFocus.focus) lastFocus.focus();
      }
    }
    burger.addEventListener('click', function () { open(true); });
    if (closeBtn) closeBtn.addEventListener('click', function () { open(false); });
    d.addEventListener('keydown', function (e) {
      if (menu.hidden) return;
      if (e.key === 'Escape') { open(false); return; }
      if (e.key === 'Tab') {
        var f = focusables(); if (!f.length) return;
        var first = f[0], last = f[f.length - 1];
        if (e.shiftKey && d.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && d.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    });
    $$('a', menu).forEach(function (a) { a.addEventListener('click', function () { open(false); }); });
    var acc = $('.menu__acc', menu);
    if (acc) acc.addEventListener('click', function () { acc.setAttribute('aria-expanded', acc.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); });
    w.addEventListener('resize', function () { if (w.innerWidth >= 1120 && !menu.hidden) open(false); });
  })();

  /* ---------- FAQ akordeon ---------- */
  $$('.faq__item').forEach(function (it) {
    var b = $('.faq__q button', it);
    if (!b) return;
    b.addEventListener('click', function () {
      var o = !it.classList.contains('is-open');
      it.classList.toggle('is-open', o);
      b.setAttribute('aria-expanded', o ? 'true' : 'false');
    });
  });

  /* ---------- footer kolone: akordeoni na telefonu (bez JS-a su otvoreni) ---------- */
  if (w.matchMedia('(max-width: 767px)').matches) {
    $$('.site-footer details.fcol').forEach(function (x) { x.open = false; });
  }

  /* ---------- scroller (scroll-snap) — dekorativne tačke ---------- */
  $$('[data-scroller]').forEach(function (sc) {
    var track = $('.scroller__track', sc), dots = $('.dots', sc);
    if (!track || !dots) return;
    var items = $$(':scope > li', track);
    items.forEach(function () { dots.appendChild(d.createElement('span')); });
    var ds = $$('span', dots);
    function mark() {
      var best = 0, bd = Infinity;
      var left = track.getBoundingClientRect().left + (parseFloat(getComputedStyle(track).paddingLeft) || 0);
      items.forEach(function (it, i) { var dd = Math.abs(it.getBoundingClientRect().left - left); if (dd < bd) { bd = dd; best = i; } });
      if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 4) best = items.length - 1;
      ds.forEach(function (s, i) { s.classList.toggle('is-on', i === best); });
    }
    track.addEventListener('scroll', function () { w.requestAnimationFrame(mark); }, { passive: true });
    mark();
  });
})();
