document.addEventListener("DOMContentLoaded", function () {
  const blocs = document.querySelectorAll(".bloc-personnalisation");

  function calculerPrixEtape(bloc) {
      const selects = bloc.querySelectorAll(".option-select");
      const participantsInput = bloc.querySelector(".participants-input");
      const prixEtapeEl = bloc.querySelector(".prix-etape");

      let total = 0;
      const participants = parseInt(participantsInput.value) || 1;

      selects.forEach(select => {
          const prix = parseFloat(select.selectedOptions[0].dataset.prix || 0);
          total += prix;
      });

      total *= participants;
      prixEtapeEl.textContent = total.toFixed(0);

      return total;
  }

  function mettreAJourPrixTotal() {
      let totalVoyage = 0;
      blocs.forEach(bloc => {
          totalVoyage += calculerPrixEtape(bloc);
      });

      const totalGlobal = document.getElementById("prix-voyage-final");
      if (totalGlobal) {
          totalGlobal.textContent = totalVoyage.toFixed(0) + " €";
      }
  }

  blocs.forEach(bloc => {
      const selects = bloc.querySelectorAll(".option-select");
      const input = bloc.querySelector(".participants-input");

      selects.forEach(select => {
          select.addEventListener("change", () => {
              calculerPrixEtape(bloc);
              mettreAJourPrixTotal();
          });
      });

      input.addEventListener("input", () => {
          calculerPrixEtape(bloc);
          mettreAJourPrixTotal();
      });

      // Init
      calculerPrixEtape(bloc);
  });

  mettreAJourPrixTotal();
});

