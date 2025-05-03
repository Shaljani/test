<?php
session_start();
$tripsFile = 'data/trips.json';
$trips = json_decode(file_get_contents($tripsFile), true);
if ($trips === null) {
    echo "<p>Erreur de lecture du fichier trips.json</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Xplore - Destinations Trekking</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="css/styledestination.css">
  <link id="theme-style" rel="stylesheet" href="css/styledestination.css">
  <script src="js/theme.js" defer></script>
  <script src="js/tri.js" defer></script>
</head>
<body>

<section class="header">
  <a href="index.php" class="logo">XPlore</a>
  <nav class="navbar">
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'administrator') : ?>
        <a href="admin.php">Admin</a>
    <?php endif; ?>
    <a href="index.php">Accueil</a>
    <a href="destination.php">Destination</a>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="profil.php">Mon Profil</a>
        <a href="logout.php">Déconnexion</a>
    <?php else: ?>
        <a href="connexion.php">Se connecter</a>
    <?php endif; ?>
  </nav>
  <div class="menu-reduit" id="menu-reduit"><i class="fas fa-bars"></i></div>
</section>

<div class="menu-redu">
  <a href="admin.php">Admin</a>
  <a href="index.php">Accueil</a>
  <a href="destination.php">Destination</a>
  <a href="profil.php">Mon Profil</a>
  <a href="inscription.php">Se connecter</a>
</div>

<section id="filters">
  <form id="searchForm" onsubmit="event.preventDefault(); filterDestinations();">
    <div class="filter-group">
      <label for="searchKeyword">Mots-clés :</label>
      <input type="text" id="searchKeyword" placeholder="Ex: Alpes, Zanzibar, glacier..." />
    </div>
    <div class="filter-group">
      <label for="difficulty">Difficulté :</label>
      <select id="difficulty">
        <option value="">-- Choisissez --</option>
        <option value="facile">Facile</option>
        <option value="moyenne">Moyenne</option>
        <option value="difficile">Difficile</option>
      </select>
    </div>
    <div class="filter-group">
      <label for="season">Saison idéale :</label>
      <select id="season">
        <option value="">-- Choisissez --</option>
        <option value="été">Été</option>
        <option value="hiver">Hiver</option>
        <option value="automne">Automne</option>
        <option value="printemps">Printemps</option>
      </select>
    </div>
    <button type="submit" class="btn-search">Rechercher</button>
    <button type="button" class="btn-reset" onclick="resetFiltresEtTri()">Réinitialiser</button>
  </form>
</section>

<div class="tri-container">
  <label for="triSelect">Trier par :</label>
  <select id="triSelect">
    <option value="">-- Choisissez --</option>
    <option value="prix">Prix croissant</option>
    <option value="prix-desc">Prix décroissant</option>
    <option value="date">Date de départ (proche → lointaine)</option>
    <option value="date-desc">Date de départ (lointaine → proche)</option>
    <option value="duree">Durée (croissante)</option>
    <option value="duree-desc">Durée (décroissante)</option>
    <option value="etapes">Nombre d’étapes (croissant)</option>
    <option value="etapes-desc">Nombre d’étapes (décroissant)</option>
  </select>
</div>

<div class="destination-cards">
  <?php foreach ($trips as $trip): ?>
    <?php 
      $searchData = strtolower($trip['title'] . ' ' . $trip['description'] . ' ' . $trip['long_description']); 
    ?>
    <div class="destination-card <?= $trip['slug'] ?> <?= $trip['difficulty'] ?> <?= $trip['season'] ?>"
         data-search="<?= htmlspecialchars($searchData) ?>"
         data-prix="<?= $trip['price'] ?>"
         data-date="<?= $trip['start_date'] ?>"
         data-duree="<?= $trip['duration'] ?>"
         data-etapes="<?= count($trip['steps']) ?>">
      <img src="<?= htmlspecialchars($trip['image']) ?>" alt="<?= htmlspecialchars($trip['title']) ?>">
      <h3><?= htmlspecialchars($trip['title']) ?></h3>
      <p><?= htmlspecialchars($trip['description']) ?></p>
      <p><strong>Prix :</strong> <?= $trip['price'] ?> €</p>
      <p><strong>Départ :</strong> <?= date('d/m/Y', strtotime($trip['start_date'])) ?></p>
      <a href="voyage.php?id=<?= $trip['id'] ?>" class="btn-consulter">Réserver</a>
    </div>
  <?php endforeach; ?>
</div>

<footer>
  <div class="footer-container">
    <div class="footer-section">
      <h2>XPlore</h2>
      <p>Vivez une aventure</p>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 XPlore - Tous droits réservés</p>
    </div>
  </div>
</footer>

</body>
</html>
