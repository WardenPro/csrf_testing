<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Token valide - traiter la mise à jour de l'email
        $new_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        // Code pour mettre à jour l'email dans la base de données
        
        echo "L'adresse email a été mise à jour à : " . htmlspecialchars($new_email);
    } else {
        // Token invalide - afficher une erreur
        echo "Erreur : token CSRF invalide.";
    }
} else {
    // Rediriger ou afficher une erreur si la requête n'est pas POST
    echo "Erreur : méthode de requête invalide.";
}
?>
