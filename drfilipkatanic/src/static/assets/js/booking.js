/* dr Filip Katanić — /zakazivanje/ (v2)
   Ugovor (brief-v2 §4, uprošćena forma): GET {api}csrf.php → {"token"} ; POST {api}zakazi.php (multipart)
   polja: csrf_token, ime_prezime*, email*, telefon*, tip_usluge*, zeljeni_datum*, doba_dana, napomena, saglasnost*=1, website (honeypot), ts
   odgovori: 200 {ok:true,id} | 4xx {ok:false,error,fields{}} | 429 rate limit. Putanje relativne kroz data-api (={{root}}api/). */
(function () {
  'use strict';
  var d = document, w = window;
  var form = d.getElementById('booking-form');
  if (!form) return;

  var API = form.getAttribute('data-api') || 'api/';
  var submit = d.getElementById('booking-submit');
  var btnLabel = submit.querySelector('.booking__btn-l');
  var summary = d.getElementById('booking-summary');
  var success = d.getElementById('booking-success');
  var tokenInput = d.getElementById('csrf_token');
  var tsInput = d.getElementById('booking-ts');
  var dateInput = d.getElementById('zeljeni_datum');
  var select = d.getElementById('tip_usluge');
  var tokenAt = 0;
  var MAX_MONTHS = 6; // backend: booking.max_months_ahead

  var MSG = {
    ime_prezime: { req: 'Unesite ime i prezime.', min: 'Ime mora imati bar 2 znaka.', max: 'Ime može imati najviše 100 znakova.' },
    email: { req: 'Unesite e-mail adresu.', fmt: 'E-mail adresa nije ispravna — proverite da li sadrži @ i domen.' },
    telefon: { req: 'Unesite broj telefona.', fmt: 'Broj telefona nije ispravan — unesite 6 do 20 cifara.' },
    tip_usluge: { req: 'Izaberite razlog konsultacije.' },
    zeljeni_datum: { req: 'Izaberite željeni datum.', past: 'Datum ne može biti u prošlosti.', far: 'Izaberite datum u narednih 6 meseci.' },
    doba_dana: { req: 'Izaberite jednu od ponuđenih opcija.' },
    napomena: { max: 'Napomena može imati najviše 2000 znakova.' },
    saglasnost: { req: 'Za slanje zahteva potrebna je Vaša saglasnost.' }
  };
  var LABELS = { ime_prezime: 'Ime i prezime', email: 'E-mail', telefon: 'Telefon', tip_usluge: 'Usluga', zeljeni_datum: 'Željeni datum', doba_dana: 'Doba dana', napomena: 'Napomena', saglasnost: 'Saglasnost' };
  var ORDER = ['ime_prezime', 'email', 'telefon', 'tip_usluge', 'zeljeni_datum', 'doba_dana', 'napomena', 'saglasnost'];
  var ERR_GENERIC = 'Zahtev trenutno nije moguće poslati. Pokušajte ponovo za nekoliko minuta ili nam pišite na Instagramu @drfilipkatanic.';
  var ERR_NET = 'Zahtev nije poslat — proverite internet vezu i pokušajte ponovo. Podaci koje ste uneli su sačuvani u formi.';
  var ERR_429 = 'Previše pokušaja u kratkom roku. Pokušajte ponovo za nekoliko minuta ili nam pišite na Instagramu.';
  var ERR_CSRF = 'Sesija je istekla. Osvežili smo formu — kliknite ponovo na „Pošalji zahtev“.';

  /* ---------- datum: lokalno vreme (ne UTC) ---------- */
  function ymd(dt) {
    var m = dt.getMonth() + 1, dd = dt.getDate();
    return dt.getFullYear() + '-' + (m < 10 ? '0' : '') + m + '-' + (dd < 10 ? '0' : '') + dd;
  }
  function today() { var t = new Date(); return new Date(t.getFullYear(), t.getMonth(), t.getDate()); }
  var maxDate = today(); maxDate.setMonth(maxDate.getMonth() + MAX_MONTHS);
  dateInput.min = ymd(today());
  dateInput.max = ymd(maxDate);

  /* ---------- predizbor usluge iz ?usluga= ---------- */
  var params = new URLSearchParams(w.location.search);
  var u = params.get('usluga');
  var picked = d.getElementById('booking-picked');
  if (u && select.querySelector('option[value="' + u.replace(/[^a-z-]/g, '') + '"]')) {
    select.value = u;
    d.getElementById('booking-picked-l').textContent = select.options[select.selectedIndex].text;
    picked.hidden = false;
    d.getElementById('booking-change').addEventListener('click', function () { select.focus(); });
  }

  /* ---------- CSRF token ---------- */
  function fetchToken() {
    return fetch(API + 'csrf.php', { credentials: 'same-origin', headers: { 'Accept': 'application/json' }, cache: 'no-store' })
      .then(function (r) { return r.json(); })
      .then(function (j) { if (j && j.token) { tokenInput.value = j.token; tokenAt = Date.now(); } return j && j.token; })
      .catch(function () { return null; });
  }
  fetchToken();
  tsInput.value = String(Date.now());

  /* ---------- brojač napomene ---------- */
  var nap = d.getElementById('napomena'), napN = d.getElementById('napomena-n'), napC = d.getElementById('napomena-count'), napLive = d.getElementById('napomena-live');
  function count() {
    var n = nap.value.length;
    napN.textContent = n;
    napC.classList.toggle('is-warn', n > 1800);
    napLive.textContent = n > 1800 ? 'Preostalo je još ' + Math.max(0, 2000 - n) + ' znakova.' : '';
    nap.style.height = 'auto';
    nap.style.height = Math.min(Math.max(nap.scrollHeight + 2, 132), 420) + 'px';
  }
  nap.addEventListener('input', count);

  /* ---------- validacija ---------- */
  function field(name) { return form.elements[name]; }
  function firstControl(name) {
    var el = field(name);
    return el && el.length && !el.tagName ? el[0] : el;
  }
  function validate(name) {
    var el = field(name), v = el && typeof el.value === 'string' ? el.value.trim() : '';
    var m = MSG[name];
    switch (name) {
      case 'ime_prezime':
        if (!v) return m.req; if (v.length < 2) return m.min; if (v.length > 100) return m.max; return '';
      case 'email':
        if (!v) return m.req; if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v)) return m.fmt; return '';
      case 'telefon':
        if (!v) return m.req;
        var digits = v.replace(/[\s+\/\-().]/g, '');
        if (!/^\d{6,20}$/.test(digits)) return m.fmt; return '';
      case 'tip_usluge':
        return v ? '' : m.req;
      case 'zeljeni_datum':
        if (!v) return m.req;
        if (v < ymd(today())) return m.past;
        if (v > ymd(maxDate)) return m.far;
        return '';
      case 'napomena':
        return nap.value.length > 2000 ? m.max : '';
      case 'saglasnost':
        return field('saglasnost').checked ? '' : m.req;
    }
    return '';
  }
  function setError(name, msg) {
    var box = d.getElementById('err-' + name);
    var ctl = firstControl(name);
    if (box) box.innerHTML = msg ? '<svg class="i" aria-hidden="true"><use href="#i-alert"/></svg><span></span>' : '';
    if (box && msg) box.querySelector('span').textContent = msg;
    if (ctl && ctl.setAttribute) {
      if (msg) ctl.setAttribute('aria-invalid', 'true'); else ctl.removeAttribute('aria-invalid');
    }
  }
  var touched = {};
  ORDER.forEach(function (name) {
    var ctl = firstControl(name);
    if (!ctl || name === 'doba_dana') return;
    ctl.addEventListener('blur', function () { touched[name] = true; setError(name, validate(name)); });
    ctl.addEventListener(ctl.type === 'checkbox' || ctl.tagName === 'SELECT' ? 'change' : 'input', function () {
      if (touched[name] || ctl.getAttribute('aria-invalid')) setError(name, validate(name));
    });
  });

  function showSummary(errs, general) {
    var names = Object.keys(errs);
    summary.innerHTML = '';
    var h = d.createElement('p');
    h.className = 'summary__h';
    h.innerHTML = '<svg class="i" aria-hidden="true"><use href="#i-alert"/></svg><span></span>';
    h.querySelector('span').textContent = names.length
      ? (names.length === 1 ? 'Proverite jedno polje:' : 'Proverite ' + names.length + ' polja:')
      : (general || ERR_GENERIC);
    summary.appendChild(h);
    if (names.length) {
      var ul = d.createElement('ul');
      names.forEach(function (n) {
        var li = d.createElement('li'), a = d.createElement('a');
        var ctl = firstControl(n);
        a.href = '#' + (ctl && ctl.id ? ctl.id : '');
        a.textContent = (LABELS[n] || n) + ' — ' + errs[n];
        a.addEventListener('click', function (e) { e.preventDefault(); if (ctl && ctl.focus) ctl.focus(); });
        li.appendChild(a); ul.appendChild(li);
      });
      summary.appendChild(ul);
      if (general && names.length > 1 && general !== 'Proverite označena polja.') {
        var p = d.createElement('p'); p.textContent = general; summary.appendChild(p);
      }
    }
    summary.hidden = false;
    summary.focus({ preventScroll: true });
    summary.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
  function clearSummary() { summary.hidden = true; summary.innerHTML = ''; }

  /* ---------- stanja ---------- */
  function busy(on) {
    form.setAttribute('aria-busy', on ? 'true' : 'false');
    submit.disabled = on;
    Array.prototype.forEach.call(form.querySelectorAll('input:not([type=hidden]):not([type=radio]):not([type=checkbox]), textarea'), function (el) { el.readOnly = on; });
    btnLabel.textContent = on ? 'Šaljem…' : 'Pošalji zahtev';
    var sp = submit.querySelector('.spinner');
    if (on && !sp) { sp = d.createElement('span'); sp.className = 'spinner'; sp.setAttribute('aria-hidden', 'true'); submit.insertBefore(sp, submit.firstChild); }
    if (!on && sp) sp.remove();
  }
  function showSuccess(id, email) {
    form.hidden = true;
    var t = d.getElementById('success-txt');
    if (email) {
      t.textContent = 'Ovo još nije potvrđen termin. Potvrdu termina — ili predlog drugog, ako željeni nije slobodan — dobijate mejlom na ';
      var b = d.createElement('strong'); b.textContent = email; t.appendChild(b); t.appendChild(d.createTextNode('.'));
    }
    if (id) {
      d.getElementById('success-id').textContent = '#' + ('000' + id).slice(-Math.max(4, String(id).length)); // isto kao u mejlu (#0001)
      d.getElementById('success-id-wrap').hidden = false;
    }
    success.hidden = false;
    var card = d.getElementById('booking-card');
    if (card) card.scrollIntoView({ behavior: 'smooth', block: 'start' });
    d.getElementById('success-h').focus({ preventScroll: true });
    try {
      var url = new URL(w.location.href); url.searchParams.set('poslato', '1');
      w.history.replaceState(null, '', url.toString());
    } catch (e) { /* stari pregledači */ }
  }
  if (params.get('poslato') === '1') { showSuccess(null, null); }

  /* ---------- slanje ---------- */
  var retried = false;
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    clearSummary();
    var errs = {};
    ORDER.forEach(function (n) { var m = validate(n); setError(n, m); if (m) errs[n] = m; });
    if (Object.keys(errs).length) { showSummary(errs); return; }
    send();
  });

  function send() {
    busy(true);
    var stale = !tokenInput.value || (Date.now() - tokenAt > 20 * 60 * 1000);
    (stale ? fetchToken() : Promise.resolve(tokenInput.value)).then(function () {
      var fd = new FormData(form);
      return fetch(API + 'zakazi.php', { method: 'POST', body: fd, credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
    }).then(function (res) {
      return res.text().then(function (txt) {
        var body = null; try { body = JSON.parse(txt); } catch (x) { body = null; }
        return { status: res.status, body: body };
      });
    }).then(function (r) {
      busy(false);
      var b = r.body || {};
      if (r.status >= 200 && r.status < 300 && b.ok) { showSuccess(b.id, field('email').value.trim()); return; }
      if (r.status === 429) { showSummary({}, ERR_429); return; }
      if (r.status === 403 && !retried) {
        retried = true;
        fetchToken().then(function () { showSummary({}, ERR_CSRF); });
        return;
      }
      var fields = b.fields && typeof b.fields === 'object' ? b.fields : {};
      var errs = {};
      Object.keys(fields).forEach(function (n) {
        var msg = fields[n] || (MSG[n] && (MSG[n].req || MSG[n].fmt)) || '';
        if (d.getElementById('err-' + n)) { setError(n, msg); errs[n] = msg; }
      });
      if (Object.keys(errs).length) showSummary(errs, b.error);
      else showSummary({}, (r.status >= 500 || !b.error) ? ERR_GENERIC : b.error);
    }).catch(function () {
      busy(false);
      showSummary({}, ERR_NET);
    });
  }
})();
