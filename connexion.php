<?php
session_start();

// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $usersFile = 'data/users.json';

    if (!file_exists($usersFile)) {
        $error = "Fichier utilisateur introuvable.";
    } else {
        $jsonContent = file_get_contents($usersFile);
        $users = json_decode($jsonContent, true);

        if (!is_array($users)) {
            $error = "Erreur de lecture des utilisateurs.";
        } else {
            foreach ($users as $user) {
                $userTrouve = false;

foreach ($users as $user) {
    if ($user['email'] === $email) {
        $userTrouve = true;

        if ($user['role'] === 'banni') {
            $error = "Votre compte a été banni. Veuillez contacter un administrateur.";
            break;
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: profil.php");
            exit();
        } else {
            $error = "Mot de passe incorrect.";
            break;
        }
    }
}

if (!$userTrouve) {
    $error = "Aucun compte trouvé avec cet email.";
}
                }
            }
        }
    }

?>

<!-- Affichage du formulaire HTML avec message d'erreur -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/styleconnexion.css">
    <link id="theme-style" rel="stylesheet" href="css/styleconnexion.css">
    <script src="js/theme.js" defer></script>
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
        </nav>
        

        
        

    </section>

    
    <div class="form-container login-container">
    <form action="connexion.php" method="post" autocomplete="off">
        <h1>Connexion</h1>
        <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>

        <button type="submit">Se connecter</button>

        <div class="register-link">
            <p>Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></p>
        </div>
    </form>
</div>

    </div>

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

<script src="js/form_validation.js"></script>

</body>
</html>
