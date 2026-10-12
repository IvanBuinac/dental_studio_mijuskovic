/* Zakazivanja — admin. Minimalan JS bez biblioteka (sve radi i bez njega). */
(function () {
  "use strict";

  /* Zaštita od duplog klika + tekst "Šaljem…" */
  document.addEventListener("submit", function (e) {
    var form = e.target;
    if (form.dataset.sending === "1") { e.preventDefault(); return; }
    form.dataset.sending = "1";
    var btn = form.querySelector("button[type=submit]");
    if (btn) {
      btn.setAttribute("aria-busy", "true");
      btn.classList.add("is-busy");
      if (btn.dataset.busy) btn.textContent = btn.dataset.busy;
    }
  });

  /* U kartici je otvoren samo jedan panel (Potvrdi ili Odbij). */
  document.querySelectorAll(".decide").forEach(function (box) {
    var items = box.querySelectorAll("details");
    items.forEach(function (d) {
      d.addEventListener("toggle", function () {
        if (!d.open) return;
        items.forEach(function (o) { if (o !== d) o.open = false; });
        var first = d.querySelector("textarea, input:not([type=hidden])");
        if (first && window.matchMedia("(min-width: 760px)").matches) first.focus();
      });
    });
  });

  /* Prikaži / sakrij lozinku */
  document.querySelectorAll("[data-pw-toggle]").forEach(function (btn) {
    var input = document.getElementById(btn.getAttribute("data-pw-toggle"));
    if (!input) return;
    btn.addEventListener("click", function () {
      var show = input.type === "password";
      input.type = show ? "text" : "password";
      btn.textContent = show ? "Sakrij" : "Prikaži";
      btn.setAttribute("aria-pressed", show ? "true" : "false");
    });
  });
})();
