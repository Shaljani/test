<?php
session_start();
$isConnected = isset($_SESSION['user']);

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Aucun voyage sélectionné.";
    exit;
}

$trips = json_decode(file_get_contents('data/trips.json'), true);
$trip = null;
foreach ($trips as $t) {
    if ($t['id'] == $id) {
        $trip = $t;
        break;
    }
}
if (!$trip) {
    echo "Voyage non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($trip['title']) ?> - Détail</title>
    <link rel="stylesheet" href="css/stylevoyage.css">
    <script src="js/personnalisation.js" defer></script>
    <link id="theme-style" rel="stylesheet" href="css/stylevoyage.css">
    <script src="js/theme.js" defer></script>
</head>
<body>
<section class="header">
    <a href="index.php" class="logo">XPlore</a>
    <nav class="navbar">
        <?php if ($isConnected && $_SESSION['user']['role'] === 'administrator') : ?>
            <a href="admin.php">Admin</a>
        <?php endif; ?>
        <a href="index.php">Accueil</a>
        <a href="destination.php">Destination</a>
        <?php if ($isConnected): ?>
            <a href="profil.php">Mon Profil</a>
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="connexion.php">Se connecter</a>
        <?php endif; ?>
    </nav>
</section>

<header><h1><?= htmlspecialchars($trip['title']) ?></h1></header>
<section class="voyage-detail">
    <img src="<?= htmlspecialchars($trip['image']) ?>" alt="<?= $trip['title'] ?>" style="width: 100%; max-width: 600px;">
    <p><strong>Dates :</strong> <?= $trip['start_date'] ?> → <?= $trip['end_date'] ?> (<?= $trip['duration'] ?> jours)</p>
    <p><strong>Prix de base :</strong> <?= $trip['price'] ?> €</p>
    <p><strong>Difficulté :</strong> <?= ucfirst($trip['difficulty']) ?></p>
    <p><strong>Saison :</strong> <?= ucfirst($trip['season']) ?></p>
    <p><?= nl2br($trip['long_description']) ?></p>

    <h2>Étapes :</h2>
    <?php if ($isConnected): ?>
    <form method="post" action="recapitulatif.php">
    <?php endif; ?>
    <ol>
        <?php foreach ($trip['steps'] as $index => $step): ?>
            <li class="bloc-personnalisation">
                <h3><?= htmlspecialchars($step['title']) ?></h3>
                <p><strong>Dates :</strong> <?= htmlspecialchars($step['arrival_date']) ?> → <?= htmlspecialchars($step['departure_date']) ?></p>
                <p><strong>Lieu :</strong> <?= htmlspecialchars($step['location']['city']) ?></p>

                <?php if ($isConnected): ?>
                    <h4>Personnalisez cette étape :</h4>
                    <input type="hidden" name="trip_id" value="<?= $trip['id'] ?>">
                    <input type="hidden" name="step_title[]" value="<?= htmlspecialchars($step['title']) ?>">

                    <?php foreach (['hebergement', 'restauration', 'activites', 'transport'] as $type): ?>
                        <label><?= ucfirst($type) ?> :</label>
                        <select name="<?= $type ?>[]" class="option-select" data-type="<?= $type ?>">
                            <?php foreach ($step['options'][$type] as $option): ?>
                                <option value="<?= htmlspecialchars($option['label']) ?>" data-prix="<?= $option['prix'] ?>">
                                    <?= htmlspecialchars($option['label']) ?> (+<?= $option['prix'] ?> €)
                                </option>
                            <?php endforeach; ?>
                        </select><br>
                    <?php endforeach; ?>

                    <label>Nombre de participants :</label>
                    <input type="number" name="participants[]" class="participants-input" min="1" value="1"><br><br>

                    <p><strong>Prix total pour cette étape :</strong> <span class="prix-etape">0</span> €</p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
    <?php if ($isConnected): ?>
        <p class="prix-final-global"><strong>Prix total estimé du voyage :</strong> <span id="prix-voyage-final">0</span> €</p>
        <div class="recap-button-container">
            <button type="submit" class="recap-btn">Réserver</button>
        </div>
        </form>
    <?php else: ?>
        <p style="color: red;">Veuillez vous connecter pour personnaliser ce voyage.</p>
    <?php endif; ?>

    <a href="destination.php" class="btn-retour">← Retour aux voyages</a>
</section>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h2>XPlore</h2>
            <p>Vivez une aventure</p>
        </div>
        <div class="footer-section">
            <h3>À propos</h3>
            <ul>
                <li><a href="#">Qui sommes-nous ?</a></li>
                <li><a href="#">Nos agences</a></li>
                <li><a href="#">Recrutement</a></li>
                <li><a href="#">Affiliation</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Conditions</h3>
            <ul>
                <li><a href="#">CGV</a></li>
                <li><a href="#">Politique de confidentialité</a></li>
                <li><a href="#">Mentions légales</a></li>
                <li><a href="#">Paiement sécurisé</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p>Tel: 01 34 25 10 10</p>
            <p>Email: contact@xplore.com</p>
            <p>Av. du Parc, 95000 Cergy</p>
        </div>
        <div class="footer-section">
            <h3>Suivez-nous</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 XPlore - Tous droits réservés</p>
    </div>
</footer>
</body>
</html>