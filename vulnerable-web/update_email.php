<?php

session_start();
//WORKING
// $valid_origin = 'http://localhost:8080';
// if (!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN'] !== $valid_origin) {
//     die('Invalid origin');
// }

//WORKING
// $valid_referer = 'http://localhost:8080/';
// if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $valid_referer) !== 0) {
//     // Referrer invalide
//     die('Invalid referer');
// }

//Without session token put it on cookie
// function generateToken() {
//     return bin2hex(random_bytes(32));
// }
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['csrf_token']) && isset($_COOKIE['csrf_token']) && hash_equals($_COOKIE['csrf_token'], $_POST['csrf_token'])) {
//         $new_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
//
//         $new_csrf_token = generateToken();
//         setcookie('csrf_token', $new_csrf_token, [
//             'expires' => time() + 3600,
//             'path' => '/',
//             'domain' => 'localhost',
//             'secure' => false, // true si vous utilisez HTTPS
//             'httponly' => true,
//             'samesite' => 'Strict', // Ou 'Lax'
//         ]);
//
//         echo "L'adresse email a été mise à jour à : " . htmlspecialchars($new_email);
//     } else {
//         echo "Erreur : token CSRF invalide.";
//     }
// } else {
//     echo "Erreur : méthode de requête invalide.";
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $new_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        echo "L'adresse email a été mise à jour à : " . htmlspecialchars($new_email);
    } else {
        echo "Erreur : token CSRF invalide.";
    }
} else {
    echo "Erreur : méthode de requête invalide.";
}
?>
