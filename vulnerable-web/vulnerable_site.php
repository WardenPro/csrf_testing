<?php

//Without session token put it on cookie;
// function generateToken() {
//     return bin2hex(random_bytes(32));
// }

// // Générer un nouveau token CSRF si le cookie n'existe pas
// if (!isset($_COOKIE['csrf_token'])) {
//     $csrf_token = generateToken();
//     setcookie('csrf_token', $csrf_token, [
//         'expires' => time() + 3600,
//         'path' => '/',
//         'domain' => 'localhost',
//         'secure' => false, // true si vous utilisez HTTPS
//         'httponly' => true,
//         'samesite' => 'Strict', // Ou 'Lax'
//     ]);
// } else {
//     $csrf_token = $_COOKIE['csrf_token'];
// }
session_start();

// Générer un nouveau token CSRF pour chaque requête
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$csrf_token = $_SESSION['csrf_token'];

// Not Working
// setcookie('csrf_token', $csrf_token, [
//     'expires' => time() + 3600,
//     'path' => '/',
//     'domain' => 'localhost',
//     'secure' => false,
//     'httponly' => true,
//     'samesite' => 'Strict',
// ]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Vulnérable</title>
</head>
<body>
    <h1>Mettre à jour l'adresse email</h1>
    <form action="update_email.php" method="POST">
        <label for="email">Nouvelle adresse email:</label>
        <input type="email" id="email" name="email">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
