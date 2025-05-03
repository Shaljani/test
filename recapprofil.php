<?php
session_start();

// Récupération des paramètres
$index = isset($_GET['index']) ? (int)$_GET['index'] : 0;
$isAdmin = isset($_GET['admin']) && $_GET['admin'] == 1;
$email = $isAdmin ? ($_GET['email'] ?? '') : ($_SESSION['user']['email'] ?? '');

// Redirection si l'email est manquant
if (!$email) {
    header('Location: profil.php');
    exit();
}

// Lecture du fichier users
$usersFile = 'data/users.json';
$users = json_decode(file_get_contents($usersFile), true);
$targetUser = null;

foreach ($users as $user) {
    if ($user['email'] === $email) {
        $targetUser = $user;
        break;
    }
}

// Si utilisateur ou voyage non trouvé
if (!$targetUser || empty($targetUser['trips_history'][$index])) {
    echo "<p>Voyage introuvable.</p>";
    exit();
}

$recap = $targetUser['trips_history'][$index];

// Gestion de l'annulation (autorisé uniquement en mode utilisateur, pas admin)
if (!$isAdmin && isset($_POST['cancel_trip']) && isset($_POST['index'])) {
    $indexToDelete = intval($_POST['index']);

    foreach ($users as &$user) {
        if ($user['email'] === $_SESSION['user']['email'] && isset($user['trips_history'][$indexToDelete])) {
            array_splice($user['trips_history'], $indexToDelete, 1);
            $_SESSION['user'] = $user; // mise à jour de la session
            break;
        }
    }

    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    header('Location: profil.php');
    exit();
}

// Pour gérer les boutons suivant/précédent
$totalTrips = count($targetUser['trips_history']);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du voyage</title>
    <link rel="stylesheet" href="css/stylevoyage.css">
</head>
<body>

<h1>Détail de votre voyage réservé</h1>

<p><strong>Date de réservation :</strong> <?= htmlspecialchars($recap['date']) ?></p>

<h2>Étapes personnalisées :</h2>
<ol>
<?php foreach ($recap['custom_options'] as $step): ?>
    <table class="recap-table">
        <thead>
        <tr><th colspan="2"><?= htmlspecialchars($step['step'] ?? 'Étape non définie') ?></th></tr>
        </thead>
        <tbody>
        <tr><td><strong>Hébergement</strong></td><td><?= htmlspecialchars($step['hebergement'] ?? 'Non défini') ?></td></tr>
        <tr><td><strong>Restauration</strong></td><td><?= htmlspecialchars($step['restauration'] ?? 'Non défini') ?></td></tr>
        <tr><td><strong>Activité</strong></td><td><?= htmlspecialchars($step['activite'] ?? 'Non défini') ?></td></tr>
        <tr><td><strong>Transport</strong></td><td><?= htmlspecialchars($step['transport'] ?? 'Non défini') ?></td></tr>
        <tr><td><strong>Participants</strong></td><td><?= htmlspecialchars($step['participants'] ?? 'Non défini') ?></td></tr>
        </tbody>
    </table>
<?php endforeach; ?>
</ol>

<!-- Navigation entre voyages -->
<div style="text-align:center; margin-top: 20px;">
    <?php if ($index > 0): ?>
        <a href="recapprofil.php?index=<?= $index - 1 ?>&<?= $isAdmin ? "admin=1&email=" . urlencode($email) : '' ?>" class="btn-retour">← Voyage précédent</a>
    <?php endif; ?>

    <?php if ($index < $totalTrips - 1): ?>
        <a href="recapprofil.php?index=<?= $index + 1 ?>&<?= $isAdmin ? "admin=1&email=" . urlencode($email) : '' ?>" class="btn-retour">Voyage suivant →</a>
    <?php endif; ?>
</div>

<!-- Bouton annuler (visible que si ce n'est pas l'admin) -->
<?php if (!$isAdmin): ?>
<div style="text-align: center; margin-top: 15px;">
    <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce voyage ?');" style="display: inline-block;">
        <input type="hidden" name="cancel_trip" value="1">
        <input type="hidden" name="index" value="<?= $index ?>">
        <button type="submit" class="btn-annuler">❌ Annuler ce voyage</button>
    </form>
</div>
<?php endif; ?>

<!-- Retour selon le contexte -->
<div style="text-align:center; margin-top: 15px;">
    <?php if ($isAdmin): ?>
        <a href="consulter.php?email=<?= urlencode($email) ?>" class="btn-retour">↩ Retour à la fiche utilisateur</a>
    <?php else: ?>
        <a href="profil.php" class="btn-retour">↩ Retour à mon profil</a>
    <?php endif; ?>
</div>

</body>
</html>
