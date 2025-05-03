<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

$recap = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step_title'])) {
    $tripId = $_POST['trip_id'];
    $steps = [];

    for ($i = 0; $i < count($_POST['step_title']); $i++) {
        $steps[] = [
            'step' => $_POST['step_title'][$i] ?? '',
            'hebergement' => $_POST['hebergement'][$i] ?? 'Non défini',
            'restauration' => $_POST['restauration'][$i] ?? 'Non défini',
            'activite' => $_POST['activite'][$i] ?? 'Non défini',
            'transport' => $_POST['transport'][$i] ?? 'Non défini',
            'participants' => $_POST['participants'][$i] ?? 1
        ];
    }

    $recap = [
        'trip_id' => $tripId,
        'title' => 'Voyage personnalisé',
        'date' => date('Y-m-d'),
        'custom_options' => $steps
    ];
    $_SESSION['recap'] = $recap;
}

if (isset($_POST['confirmer_reservation']) && isset($_SESSION['recap'])) {
    $userEmail = $_SESSION['user']['email'];
    $usersFile = 'data/users.json';
    $users = json_decode(file_get_contents($usersFile), true);

    foreach ($users as &$user) {
        if ($user['email'] === $userEmail) {
            $user['trips_history'][] = $_SESSION['recap'];
            $_SESSION['user'] = $user;
            break;
        }
    }

    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    unset($_SESSION['recap']);
    header('Location: profil.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Récapitulatif</title>
    <link rel="stylesheet" href="css/stylevoyage.css">
    <link id="theme-style" rel="stylesheet" href="css/stylerecapitulatif.css">
    <script src="js/theme.js" defer></script>
</head>
<body>
    <h1>Récapitulatif de votre voyage</h1>

    <?php if (isset($_SESSION['recap'])): ?>
        <?php $recap = $_SESSION['recap']; ?>
        <p><strong>Date de réservation :</strong> <?= $recap['date'] ?></p>
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
                    <tr><td><strong>Participants</strong></td><td><?= htmlspecialchars($step['participants'] ?? '1') ?></td></tr>
                </tbody>
            </table>
        <?php endforeach; ?>
        </ol>

        <form action="payment.php" method="post" style="margin-top: 30px;">
            <input type="hidden" name="recap_data" value='<?= htmlspecialchars(json_encode($_SESSION['recap']), ENT_QUOTES, "UTF-8") ?>'>
            <button type="submit" class="confirm-btn">Confirmer ma réservation</button>
        </form>

        <a href="javascript:history.back()">← Retour à la personnalisation</a>
    <?php else: ?>
        <p>Aucune donnée de personnalisation trouvée.</p>
    <?php endif; ?>
</body>
</html>

