/* dr Filip Katanić: lightbox — [data-lightbox="grupa"] (a href = puna slika, data-caption = naslov).
   NAPOMENA (structure.md 0.2): hero.webp i konferencija-02.webp se NIKAD ne otvaraju u punoj/nekropovanoj
   rezoluciji kroz lightbox — trigeri za te fajlove moraju linkovati na vec kropovanu/bezbednu verziju slike,
   ne na sirovi fajl. build.py --lint proverava da se ta dva fajla ne pojavljuju kao data-lightbox href. */
(function () {
  'use strict';
  var d = document;
  var $ = function (s, r) { return (r || d).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || d).querySelectorAll(s)); };
  var triggers = $$('[data-lightbox]');
  if (!triggers.length) return;
  var lb, img, cap, count, group = [], idx = 0, lastFocus = null, sx = 0;
  var svg = function (p) { return '<svg viewBox="0 0 28 28" aria-hidden="true"><path d="' + p + '"/></svg>'; };

  function build() {
    lb = d.createElement('div');
    lb.className = 'lb'; lb.setAttribute('role', 'dialog'); lb.setAttribute('aria-modal', 'true'); lb.setAttribute('aria-label', 'Pregled slike');
    lb.innerHTML =
      '<button class="lb__btn lb__close" type="button" aria-label="Zatvori"><span></span><span></span></button>' +
      '<button class="lb__btn lb__prev" type="button" aria-label="Prethodna">' + svg('M17 4 L7 14 L17 24') + '</button>' +
      '<button class="lb__btn lb__next" type="button" aria-label="Sledeća">' + svg('M11 4 L21 14 L11 24') + '</button>' +
      '<div class="lb__stage"><img class="lb__img" alt=""></div>' +
      '<div class="lb__bar"><p class="lb__cap"></p><p class="lb__count"></p></div>';
    d.body.appendChild(lb);
    img = $('.lb__img', lb); cap = $('.lb__cap', lb); count = $('.lb__count', lb);
    $('.lb__close', lb).addEventListener('click', close);
    $('.lb__prev', lb).addEventListener('click', function () { go(-1); });
    $('.lb__next', lb).addEventListener('click', function () { go(1); });
    lb.addEventListener('click', function (e) { if (e.target === lb || e.target.classList.contains('lb__stage')) close(); });
    lb.addEventListener('touchstart', function (e) { sx = e.changedTouches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) { var dx = e.changedTouches[0].clientX - sx; if (Math.abs(dx) > 50) go(dx < 0 ? 1 : -1); }, { passive: true });
    d.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('is-open')) return;
      if (e.key === 'Escape') close();
      else if (e.key === 'ArrowLeft') go(-1);
      else if (e.key === 'ArrowRight') go(1);
      else if (e.key === 'Tab') {
        var f = $$('button', lb).filter(function (b) { return b.offsetParent !== null; });
        if (!f.length) return;
        var first = f[0], last = f[f.length - 1];
        if (e.shiftKey && d.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && d.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    });
  }
  function show(i) {
    idx = (i + group.length) % group.length;
    var t = group[idx];
    img.src = t.getAttribute('href');
    img.alt = t.getAttribute('data-caption') || '';
    cap.textContent = t.getAttribute('data-caption') || '';
    count.textContent = (idx + 1) + ' / ' + group.length;
    lb.classList.toggle('is-single', group.length < 2);
  }
  function go(o) { if (group.length > 1) show(idx + o); }
  function open(t) {
    if (!lb) build();
    var g = t.getAttribute('data-lightbox');
    group = triggers.filter(function (x) { return x.getAttribute('data-lightbox') === g; });
    lastFocus = d.activeElement;
    show(group.indexOf(t));
    lb.classList.add('is-open'); d.body.classList.add('lb-open');
    $('.lb__close', lb).focus();
  }
  function close() {
    lb.classList.remove('is-open'); d.body.classList.remove('lb-open');
    if (lastFocus) lastFocus.focus();
  }
  triggers.forEach(function (t) {
    t.addEventListener('click', function (e) { if (e.metaKey || e.ctrlKey || e.shiftKey) return; e.preventDefault(); open(t); });
  });
})();
