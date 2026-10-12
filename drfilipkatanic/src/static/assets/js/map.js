/* dr Filip Katanić: mapa-facade na /kontakt/ — iframe se ucitava tek na klik (performanse, structure.md 3.12). */
(function () {
  'use strict';
  var d = document;
  var btn = d.querySelector('[data-map-load]');
  if (!btn) return;
  btn.addEventListener('click', function () {
    var wrap = btn.closest('.map-embed');
    if (!wrap) return;
    var ifr = d.createElement('iframe');
    ifr.src = btn.getAttribute('data-src');
    ifr.title = btn.getAttribute('data-title') || 'Mapa';
    ifr.loading = 'lazy';
    ifr.referrerPolicy = 'no-referrer-when-downgrade';
    ifr.setAttribute('allowfullscreen', '');
    wrap.innerHTML = '';
    wrap.appendChild(ifr);
  });
})();
