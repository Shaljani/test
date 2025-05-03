<?php
session_start();
if (!isset($_SESSION['recap'])) {
    header('Location: recapitulatif.php');
    exit();
}

// Charger les infos du voyage
$recap = $_SESSION['recap'];

// On va récupérer le prix à partir du fichier JSON
$trips = json_decode(file_get_contents('data/trips.json'), true);
$montant = 0;
$titreVoyage = 'Voyage personnalisé';
foreach ($trips as $trip) {
    if ($trip['id'] == $recap['trip_id']) {
        $montant = $trip['price'];
        $titreVoyage = $trip['title'];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
    <link rel="stylesheet" href="css/stylepayment.css">
</head>
<body>
<body>
    <div class="payment-wrapper">
        <h1>💳 Paiement</h1>
        <div class="payment-box">
            <p><strong>Voyage :</strong> <?= htmlspecialchars($titreVoyage) ?></p>
            <p><strong>Montant à payer :</strong> <?= $montant ?> €</p>

            <form method="post" action="validation_paiement.php">
                <div class="form-group">
                    <label>Numéro de carte :</label>
                    <input type="text" name="card_number" id="card_number" maxlength="19" placeholder="1234 5678 9012 3456" required>
                </div>
                <div class="form-group">
                    <label>Nom du titulaire :</label>
                    <input type="text" name="card_name" placeholder="Jean Dupont" required>
                </div>
                <div class="form-group">
                    <label>Date d'expiration :</label>
                    <input type="month" name="card_expiry" required>
                </div>
                <div class="form-group">
                    <label>CVV :</label>
                    <input type="text" name="card_cvv" placeholder="123" maxlength="3" required>
                </div>
                <button type="submit" name="valider_paiement" class="btn-valider">✅ Payer maintenant</button>
            </form>

            <a href="recapitulatif.php"><button type="button" class="btn-annuler">❌ Annuler</button></a>
        </div>
    </div>

</body>
</html>

<script>
    const cardInput = document.getElementById('card_number');

    cardInput.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, ''); // Supprimer tout sauf les chiffres
        value = value.substring(0, 16); // Limite à 16 chiffres
        const spaced = value.match(/.{1,4}/g); // Regroupe par 4
        this.value = spaced ? spaced.join(' ') : '';
    });
</script>
