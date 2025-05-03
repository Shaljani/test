<?php
$motDePasseClair = "azerty";
$motDePasseHash = '$2y$10$uSlW63.YcFcBGd/r0UOJw.lcZ3Qcy9PzmjRr4H3a.W5vA.XzK1Wmi';

if (password_verify($motDePasseClair, $motDePasseHash)) {
    echo "✅ Mot de passe correct";
} else {
    echo "❌ Mot de passe incorrect";
}
