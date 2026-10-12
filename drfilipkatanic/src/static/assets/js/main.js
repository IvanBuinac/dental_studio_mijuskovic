/* dr Filip Katanić: vanilla JS, bez biblioteka.
   Sadrzaj: reveal (IO) · header (scroll) · dropdown "Oblasti rada" · mobilni meni · sticky bar · FAQ akordeon */
(function () {
  'use strict';
  var d = document, w = window;
  var reduce = w.matchMedia && w.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $ = function (s, r) { return (r || d).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || d).querySelectorAll(s)); };
  var hasIO = 'IntersectionObserver' in w;

  /* reveal: jednom pri ulasku u vidno polje */
  (function () {
    var els = $$('.reveal');
    if (!els.length) return;
    if (!hasIO || reduce) { els.forEach(function (e) { e.classList.add('is-in'); }); return; }
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-in');
        io.unobserve(e.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    els.forEach(function (e) { io.observe(e); });
  })();

  /* header: 1px linija posle skrola + sticky bar prikaz/sakrivanje */
  var header = $('#site-header');
  var ctaVisible = false;
  function onScroll() {
    if (header) header.classList.toggle('is-scrolled', w.scrollY > 8);
    var sb = $('#sticky-bar');
    if (sb) {
      var show = w.scrollY > 240 && !ctaVisible;
      sb.classList.toggle('is-on', show);
      d.body.classList.toggle('has-sticky', show);
    }
  }
  var cta = $('#cta-band');
  if (cta && hasIO) {
    new IntersectionObserver(function (es) { ctaVisible = es[0].isIntersecting; onScroll(); }).observe(cta);
  }
  w.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* dropdown "Oblasti rada" (desktop): klik/Enter/Esc + aria-expanded (CSS hover/focus-within radi i bez JS-a) */
  $$('.has-sub').forEach(function (li) {
    var btn = $('button', li);
    function set(open) { li.classList.toggle('is-open', open); btn.setAttribute('aria-expanded', open ? 'true' : 'false'); }
    btn.addEventListener('click', function () { set(!li.classList.contains('is-open')); });
    li.addEventListener('focusout', function (e) { if (!li.contains(e.relatedTarget)) set(false); });
    li.addEventListener('keydown', function (e) { if (e.key === 'Escape') { set(false); btn.focus(); } });
    d.addEventListener('click', function (e) { if (!li.contains(e.target)) set(false); });
  });

  /* mobilni meni: full-screen, fokus-trap, Esc, zakljucan scroll */
  (function () {
    var burger = $('.burger'), menu = $('#menu');
    if (!burger || !menu) return;
    var lastFocus = null;
    function focusables() { return $$('a[href], button', menu); }
    function open(o) {
      menu.classList.toggle('is-open', o);
      d.body.classList.toggle('menu-open', o);
      burger.setAttribute('aria-expanded', o ? 'true' : 'false');
      burger.setAttribute('aria-label', o ? 'Zatvori meni' : 'Otvori meni');
      if (o) { lastFocus = d.activeElement; var f = $('a, button', menu); if (f) f.focus(); }
      else if (lastFocus) lastFocus.focus();
    }
    burger.addEventListener('click', function () { open(!menu.classList.contains('is-open')); });
    d.addEventListener('keydown', function (e) {
      if (!menu.classList.contains('is-open')) return;
      if (e.key === 'Escape') { open(false); burger.focus(); return; }
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
    w.addEventListener('resize', function () { if (w.innerWidth >= 1024 && menu.classList.contains('is-open')) open(false); });
  })();

  /* FAQ akordeon */
  $$('.faq').forEach(function (faq) {
    $$('.faq__item', faq).forEach(function (it) {
      var b = $('.faq__q button', it);
      b.setAttribute('aria-expanded', it.classList.contains('is-open') ? 'true' : 'false');
      b.addEventListener('click', function () {
        var o = !it.classList.contains('is-open');
        it.classList.toggle('is-open', o);
        b.setAttribute('aria-expanded', o ? 'true' : 'false');
      });
    });
  });
})();
