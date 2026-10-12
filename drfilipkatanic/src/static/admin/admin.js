/* Admin — minimalan JS (bez biblioteka): potvrda opasnih akcija, auto-submit sortiranja, zaštita od duplog slanja. */
(function () {
  "use strict";

  document.addEventListener("submit", function (e) {
    var form = e.target;
    var msg = form.getAttribute("data-confirm");
    if (msg && !window.confirm(msg)) {
      e.preventDefault();
      return;
    }
    if (form.method.toLowerCase() === "post") {
      if (form.dataset.sending === "1") { e.preventDefault(); return; }
      form.dataset.sending = "1";
      var btn = form.querySelector("button[type=submit]");
      if (btn) { btn.setAttribute("aria-busy", "true"); btn.classList.add("is-busy"); }
    }
  });

  var sort = document.querySelector("[data-autosubmit]");
  if (sort) {
    sort.addEventListener("change", function () { sort.form.submit(); });
  }

  /* Na detalju: otvaranje jedne akcije zatvara ostale. */
  var actions = document.querySelectorAll("details.action");
  actions.forEach(function (d) {
    d.addEventListener("toggle", function () {
      if (!d.open) return;
      actions.forEach(function (o) { if (o !== d) o.open = false; });
    });
  });
})();
