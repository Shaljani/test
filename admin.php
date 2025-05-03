<?php session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: index.php');
    exit();
}

$usersFile = 'data/users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$usersPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startIndex = ($page - 1) * $usersPerPage;
$usersToShow = array_slice($users, $startIndex, $usersPerPage);
$totalPages = ceil(count($users) / $usersPerPage);


// Bannir
if (isset($_POST['emailToBan'])) {
    foreach ($users as &$user) {
        if ($user['email'] === $_POST['emailToBan']) {
            $user['role'] = 'banni';
            break;
        }
    }
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    header("Location: admin.php?page=$page"); exit();
}

// Débannir
if (isset($_POST['emailToUnban'])) {
    foreach ($users as &$user) {
        if ($user['email'] === $_POST['emailToUnban']) {
            $user['role'] = 'normal';
            break;
        }
    }
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    header("Location: admin.php?page=$page"); exit();
}




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="css/styleadmin.css"> <!-- Lien vers le CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link id="theme-style" rel="stylesheet" href="css/styleadmin.css">
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
    
        <div class="admin-table-container">
  <h2>Gestion des utilisateurs</h2>
  <div class="admin-table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Rôle</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($usersToShow as $index => $user): ?>
    <?php if (!$user || !isset($user['email'])) continue; ?>
    <tr>
        <td><?= htmlspecialchars($user['personal_info']['name'] ?? 'Non défini') ?></td>
        <td><?= htmlspecialchars($user['email'] ?? 'Non défini') ?></td>
        <td><?= ucfirst($user['role'] ?? 'inconnu') ?></td>
        <td>
            <?php if (($user['role'] ?? '') === 'normal'): ?>
                <form method="post" style="display:inline;">
                <input type="hidden" name="emailToBan" value="<?= htmlspecialchars($user['email']) ?>">
                <button type="submit" class="ban-btn">Bannir</button>
                </form>
            <?php elseif (($user['role'] ?? '') === 'banni'): ?>
                <form method="post" style="display:inline;">
                <input type="hidden" name="emailToUnban" value="<?= htmlspecialchars($user['email']) ?>">
                <button type="submit" class="unban-btn">Débannir</button>
                </form>
            <?php endif; ?>
            <form method="get" action="consulter.php" style="display:inline;">
            <input type="hidden" name="email" value="<?= htmlspecialchars($user['email']) ?>">
            <button type="submit" class="edit-btn">Consulter</button>
</form>

        </td>
    </tr>
<?php endforeach; ?>
      </tbody>
    </table>
    <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="admin.php?page=<?= $page - 1 ?>" class="prev-btn">Précédent</a>
    <?php endif; ?>

    <?php if ($page < $totalPages): ?>
        <a href="admin.php?page=<?= $page + 1 ?>" class="next-btn">Suivant</a>
    <?php endif; ?>
    </div>
    </div>
  </div>
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
