<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf_token'];
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
