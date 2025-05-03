<?php
session_start();

// Vérifie si les infos de paiement et de réservation sont présentes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valider_paiement']) && isset($_SESSION['recap'])) {
    $recap = $_SESSION['recap'];
    $email = $_SESSION['user']['email'];

    // Lire les utilisateurs existants
    $usersFile = 'data/users.json';
    $users = json_decode(file_get_contents($usersFile), true);

    // Ajouter le voyage à l'utilisateur
    foreach ($users as &$user) {
        if ($user['email'] === $email) {
            $user['trips_history'][] = $recap;
            $_SESSION['user'] = $user; // met à jour la session
            break;
        }
    }

    // Sauvegarde
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    unset($_SESSION['recap']); // Nettoyage après paiement

    // Redirection différée vers le profil
    $redirect = true;
} else {
    $redirect = false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation du paiement</title>
    <link rel="stylesheet" href="css/stylevoyage.css">
    <meta http-equiv="refresh" content="4;url=profil.php">
</head>
<body>
    <div class="payment-box">
        <?php if ($redirect): ?>
            <h2>Paiement validé ✅</h2>
            <p>Merci pour votre réservation !</p>
            <p>Redirection vers votre profil en cours...</p>
        <?php else: ?>
            <h2>Erreur ❌</h2>
            <p>Une erreur est survenue lors du paiement.</p>
            <a href="recapitulatif.php">↩ Retour au récapitulatif</a>
        <?php endif; ?>
    </div>
</body>
</html>
