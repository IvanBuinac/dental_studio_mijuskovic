/* dr Filip Katanić: .edu-carousel — strelice prev/next, bez autoplay-a (brand.md 5). */
(function () {
  'use strict';
  var d = document;
  var $ = function (s, r) { return (r || d).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || d).querySelectorAll(s)); };
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  $$('.edu').forEach(function (edu) {
    var tr = $('.edu__track', edu);
    if (!tr) return;
    function step() { var c = $('.edu__card', tr); return c ? c.getBoundingClientRect().width + 16 : 300; }
    $$('[data-edu]', edu).forEach(function (b) {
      b.addEventListener('click', function () {
        tr.scrollBy({ left: (b.getAttribute('data-edu') === 'next' ? 1 : -1) * step(), behavior: reduce ? 'auto' : 'smooth' });
      });
    });
  });
})();
