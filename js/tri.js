const menuButton = document.querySelector('.menu-reduit');
const menuIcon = document.querySelector('.menu-reduit i');
const menu = document.querySelector('.menu-redu');
menuButton.onclick = () => {
  menu.classList.toggle('open');
  menuIcon.className = menu.classList.contains('open') ? 'fas fa-xmark' : 'fas fa-bars';
}

function filterDestinations() {
  const keyword = document.getElementById("searchKeyword").value.toLowerCase();
  const difficulty = document.getElementById("difficulty").value;
  const season = document.getElementById("season").value;

  const cards = document.querySelectorAll('.destination-card');
  cards.forEach(card => {
    const searchText = card.getAttribute('data-search');
    const matchKeyword = searchText.includes(keyword) || keyword === "";
    const matchDifficulty = card.classList.contains(difficulty) || difficulty === "";
    const matchSeason = card.classList.contains(season) || season === "";
    card.style.display = (matchKeyword && matchDifficulty && matchSeason) ? "block" : "none";
  });
}

const triSelect = document.getElementById("triSelect");
const container = document.querySelector(".destination-cards");
const voyages = Array.from(container.querySelectorAll(".destination-card"));

triSelect.addEventListener("change", () => {
  const valeur = triSelect.value;
  if (!valeur) return;

  const prop = valeur.replace("-desc", "");
  const inverse = valeur.includes("desc");

  const visibles = voyages.filter(card => card.style.display !== "none");

  visibles.sort((a, b) => {
    let valA = a.dataset[prop];
    let valB = b.dataset[prop];
    if (prop === "date") {
      valA = new Date(valA);
      valB = new Date(valB);
    } else {
      valA = parseFloat(valA);
      valB = parseFloat(valB);
    }
    return inverse ? valB - valA : valA - valB;
  });

  visibles.forEach(card => container.appendChild(card));
});

function resetFiltresEtTri() {
  document.getElementById("searchKeyword").value = "";
  document.getElementById("difficulty").value = "";
  document.getElementById("season").value = "";
  document.getElementById("triSelect").value = "";

  const cards = document.querySelectorAll('.destination-card');
  cards.forEach(card => {
    card.style.display = "block";
  });

  voyages.forEach(card => container.appendChild(card));
}

  
