<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
    echo json_encode(["success" => false, "error" => "Non connecté"]);
    exit;
}

// Lire les données JSON brutes
$data = json_decode(file_get_contents("php://input"), true);

// Vérifie si les données sont valides
if (!$data || !is_array($data)) {
    echo json_encode(["success" => false, "error" => "Données invalides"]);
    exit;
}

// Charger les utilisateurs
$usersFile = 'data/users.json';
$users = json_decode(file_get_contents($usersFile), true);

$currentUserEmail = $_SESSION['user']['email'];
$found = false;

foreach ($users as &$user) {
    if ($user['email'] === $currentUserEmail) {
        // Mise à jour des champs
        foreach ($data as $key => $value) {
            if ($key === 'email') {
                $user['email'] = $value;
                $_SESSION['user']['email'] = $value;
            } elseif (isset($user['personal_info'][$key])) {
                $user['personal_info'][$key] = $value;
            }
        }
        $found = true;
        break;
    }
}

if ($found) {
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Utilisateur non trouvé"]);
}
