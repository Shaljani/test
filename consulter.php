<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['email'])) {
    echo "Email manquant.";
    exit();
}

$targetEmail = $_GET['email'];
$users = json_decode(file_get_contents('data/users.json'), true);
$targetUser = null;

foreach ($users as $user) {
    if ($user['email'] === $targetEmail) {
        $targetUser = $user;
        break;
    }
}

if (!$targetUser) {
    echo "Utilisateur introuvable.";
    exit();
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voyages de <?= htmlspecialchars($foundUser['personal_info']['name'] ?? 'Utilisateur') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/styleconsulter.css"> <!-- ou un CSS spécifique -->
    <link id="theme-style" rel="stylesheet" href="css/styleconsulter.css">
    <script src="js/theme.js" defer></script>
</head>
<body>
<header>
    <section class="header">
         
            <a href="index.php" class="logo">XPlore</a>
    
            <nav class="navbar">
                <a href="admin.php">Admin</a>
                <a href="index.php">Accueil</a>
                <a href="destination.php">Destination</a>

                <?php if (isset($_SESSION['user'])): ?>
                    <a href="profil.php">Mon Profil</a>
                    <a href="logout.php">Déconnexion</a>
                <?php else: ?>
                    <a href="connexion.php">Se connecter</a>
                <?php endif; ?>
            </nav>

        </nav>
        <div class="menu-reduit" id="menu-reduit"><i class="fas fa-bars"></i></div>


    </section>

 <div class="menu-redu">
     <a href="admin.php">Admin</a>
     <a href="index.php">Accueil</a>
     <a href="destination.php">Destination</a>
     <a href="profil.php">Mon Profil</a>
     <a href="inscription.php">Se connecter</a>
 </nav>
 </div>
        
        <script>
            const MenuButton = document.querySelector('.menu-reduit')
            const MenuButtonICON = document.querySelector('.menu-reduit i')
            const Menu = document.querySelector('.menu-redu')

            MenuButton.onclick = function(){
                Menu.classList.toggle('open')
                const isOpen = Menu.classList.contains('open')
                MenuButtonICON.classList= isOpen ? 'fas fa-xmark':'fas fa-bars'
            }

        </script>
   
    </header>

    <main>
    <div class="user-details-card">
    <h2>Détails de l'utilisateur</h2>
    <div class="user-grid">
        <div><strong>Nom complet :</strong></div>
        <div><?= htmlspecialchars($user['personal_info']['name'] ?? 'Non défini') ?></div>

        <div><strong>Email :</strong></div>
        <div><?= htmlspecialchars($user['email'] ?? 'Non défini') ?></div>

        <div><strong>Rôle :</strong></div>
        <div><?= ucfirst($user['role'] ?? 'Non défini') ?></div>

        <div><strong>Adresse :</strong></div>
        <div><?= htmlspecialchars($user['personal_info']['address'] ?? 'Non défini') ?></div>

        <div><strong>Date de naissance :</strong></div>
        <div><?= htmlspecialchars($user['personal_info']['birthdate'] ?? 'Non défini') ?></div>

        <div><strong>Date d'inscription :</strong></div>
        <div><?= htmlspecialchars($user['registration_date'] ?? 'Non défini') ?></div>

        <div><strong>Dernière connexion :</strong></div>
        <div><?= htmlspecialchars($user['last_login_date'] ?? 'Non défini') ?></div>
    </div>

    <h3>Voyages réservés</h3>
    <?php if (!empty($user['trips_history'])): ?>
        <p><?= count($user['trips_history']) ?> voyage(s) réservé(s)</p>
        <a href="recapprofil.php?admin=1&email=<?= urlencode($targetUser['email']) ?>&index=0" class="trip-details-btn">Consulter les voyages réservés</a>
    <?php else: ?>
        <p>Aucun voyage réservé.</p>
    <?php endif; ?>


<div class="back-admin-container">
    <a href="admin.php" class="back-admin-btn">← Retour à la gestion des utilisateurs</a>
</div>
    </main>



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
