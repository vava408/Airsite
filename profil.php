<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    die("⛔ Vous devez être connecté pour accéder à cette page.");
}

// Connexion à la base de données avec PDO
$host = "mysql-airbot.alwaysdata.net";
$dbname = "airbot_connexion";
$username = "airbot";
$password = "vava11ba";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Infos de l'application Discord
$client_id = "1077950946367254561";
$client_secret = "A3dipmSsfXqOabaJUbpD3lBUvw6yw0oC";
$redirect_uri = "https://www.airbot.adkynet.eu/profil.php";

// Récupérer les infos de l'utilisateur
$stmt = $pdo->prepare("SELECT discord_id, linked_with_discord, dashboard_token, refresh_token, token_expires_at 
                       FROM inscription WHERE user = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$linked = !empty($user['discord_id']);
$access_token = $user['dashboard_token'] ?? null;
$refresh_token = $user['refresh_token'] ?? null;
$token_expires_at = $user['token_expires_at'] ?? null;

// Vérification si le token est expiré
if ($linked && $access_token && strtotime($token_expires_at) <= time()) {
    if ($refresh_token) {
        echo "🔄 Rafraîchissement du token en cours...<br>";

        // Demande un nouveau token avec le refresh_token
        $token_url = "https://discord.com/api/oauth2/token";
        $data = [
            "client_id" => $client_id,
            "client_secret" => $client_secret,
            "grant_type" => "refresh_token",
            "refresh_token" => $refresh_token
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);

        $response = curl_exec($ch);
        curl_close($ch);

        $token_info = json_decode($response, true);

        if (isset($token_info['access_token'])) {
            $access_token = $token_info['access_token'];
            $new_refresh_token = $token_info['refresh_token'] ?? $refresh_token;
            $expires_at = date("Y-m-d H:i:s", time() + $token_info['expires_in']);

            // Mise à jour dans la base de données
            $stmt = $pdo->prepare("UPDATE inscription 
                SET dashboard_token = :access_token, refresh_token = :refresh_token, token_expires_at = :expires_at 
                WHERE user = :username");

            $stmt->execute([
                ':access_token' => $access_token,
                ':refresh_token' => $new_refresh_token,
                ':expires_at' => $expires_at,
                ':username' => $_SESSION['username']
            ]);

            // Mise à jour de la session
            $_SESSION['access_token'] = $access_token;
            $_SESSION['refresh_token'] = $new_refresh_token;
        } else {
            die("❌ Erreur lors du rafraîchissement du token.");
        }
    } else {
        die("❌ Aucun refresh token disponible. Veuillez vous reconnecter.");
    }
}

// Récupération des infos Discord
if ($linked && $access_token) {
    $ch = curl_init("https://discord.com/api/users/@me");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
    $user_info = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (isset($user_info['id'])) {
        $_SESSION['discord_id'] = $user_info['id'];
        $_SESSION['discord_username'] = $user_info['username'] . "#" . $user_info['discriminator'];
        $_SESSION['discord_avatar'] = "https://cdn.discordapp.com/avatars/{$user_info['id']}/{$user_info['avatar']}.png";
    } else {
        die("❌ Impossible de récupérer les infos Discord.");
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
    <h1>Mon Profil</h1>

    <?php if ($linked): ?>
        <p>✅ Votre compte est lié à Discord !</p>
        <p><strong>Discord :</strong> <?= htmlspecialchars($_SESSION['discord_username'] ?? "Inconnu") ?></p>
        <img src="<?= htmlspecialchars($_SESSION['discord_avatar'] ?? "https://via.placeholder.com/80") ?>" alt="Avatar Discord" width="80">
        <br><br>
        <a href="unlink_discord.php">❌ Délier mon compte</a>
    <?php else: ?>
        <p>⚠️ Votre compte n'est pas encore lié à Discord.</p>
        <a href="https://discord.com/oauth2/authorize?client_id=<?= $client_id ?>&response_type=code&redirect_uri=<?= urlencode($redirect_uri) ?>&scope=identify+guilds">
            🔗 Lier mon compte Discord
        </a>
    <?php endif; ?>
</body>
</html>
