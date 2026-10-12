/* Zakazivanje konsultacije — slanje forme na /api/zakazi.php */
(function () {
  "use strict";

  var form = document.getElementById("appointment-form");
  if (!form) return;

  var alertBox = document.getElementById("booking-alert");
  var submitBtn = document.getElementById("btn-submit-booking");

  /* Datum ne sme biti u proslosti. */
  var dateInput = document.getElementById("zeljeni_datum");
  if (dateInput) {
    var today = new Date();
    var iso = today.toISOString().slice(0, 10);
    dateInput.setAttribute("min", iso);
  }

  function showAlert(kind, message) {
    alertBox.className = "form-alert form-alert--" + kind;
    alertBox.textContent = message;
    alertBox.style.display = "block";
    alertBox.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    var data = new FormData(form);
    submitBtn.disabled = true;
    submitBtn.textContent = "Slanje u toku…";

    fetch("api/zakazi.php", { method: "POST", body: data })
      .then(function (res) {
        return res.json().then(function (body) {
          return { ok: res.ok, body: body };
        });
      })
      .then(function (result) {
        if (result.ok && result.body && result.body.ok) {
          showAlert("success", "Vaš zahtev je primljen. Potvrdu termina dobićete putem izabranog kanala u najkraćem roku.");
          form.reset();
        } else {
          var msg = (result.body && result.body.error) || "Zahtev trenutno nije moguće poslati. Pokušajte ponovo ili nas kontaktirajte direktno.";
          showAlert("error", msg);
        }
      })
      .catch(function () {
        showAlert("error", "Došlo je do greške pri slanju. Proverite internet vezu ili nas kontaktirajte direktno.");
      })
      .finally(function () {
        submitBtn.disabled = false;
        submitBtn.textContent = "Pošaljite zahtev za konsultaciju";
      });
  });
})();
