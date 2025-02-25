<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    die("⛔ Vous devez être connecté pour accéder à cette page.");
}
echo "<pre>Valeur de \$_SESSION['username'] : ";
var_dump($_SESSION['username']);
echo "</pre>";

// Connexion à la base de données avec PDO
$host = "";
$dbname = "";
$username = "";
$password = "";

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

// Vérifie si un code OAuth2 a été reçu après la connexion avec Discord
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    echo "Code OAuth reçu : " . htmlspecialchars($code) . "<br>";

    // Échange du code contre un token d'accès
    $token_url = "https://discord.com/api/oauth2/token";
    $data = [
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "grant_type" => "authorization_code",
        "code" => $code,
        "redirect_uri" => $redirect_uri
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    echo "<pre>Réponse de Discord : ";
    var_dump($response);
    echo "</pre>";

    $token_info = json_decode($response, true);
    
    if (isset($token_info['access_token'])) {
        $access_token = $token_info['access_token'];
        $expires_at = date("Y-m-d H:i:s", time() + $token_info['expires_in']);
        
        // Récupération des infos de l'utilisateur via l'API Discord
        $ch = curl_init("https://discord.com/api/users/@me");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
        $user_info = json_decode(curl_exec($ch), true);
        curl_close($ch);

        echo "<pre>Infos utilisateur Discord : ";
        var_dump($user_info);
        echo "</pre>";

        if (isset($user_info['id'])) {
            $discord_id = $user_info['id'];
            $discord_username = $user_info['username'] . "#" . $user_info['discriminator'];
            $discord_avatar = "https://cdn.discordapp.com/avatars/{$user_info['id']}/{$user_info['avatar']}.png";

            // Vérification si l'utilisateur existe bien dans la base
            $stmt = $pdo->prepare("SELECT * FROM inscription WHERE user = ?");
            $stmt->execute([$_SESSION['username']]);
            $user_check = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user_check) {
                die("❌ Erreur : l'utilisateur {$_SESSION['username']} n'existe pas dans la base !");
            } else {
                echo "<pre>✅ Utilisateur trouvé dans la base : ";
                var_dump($user_check);
                echo "</pre>";
            }

            // Mise à jour des informations Discord dans la base
            $stmt = $pdo->prepare("UPDATE inscription SET discord_id = :discord_id, linked_with_discord = 1, dashboard_token = :access_token, token_expires_at = :expires_at WHERE user = :username");

            $stmt->execute([
                ':discord_id' => $discord_id,
                ':access_token' => $access_token,
                ':expires_at' => $expires_at,
                ':username' => $_SESSION['username']
            ]);

            if ($stmt->rowCount() > 0) {
                echo "✅ Mise à jour de la base de données réussie !<br>";
            } else {
                echo "⚠️ Aucun changement effectué. Vérifie si l'utilisateur existe et que les données sont bien différentes.<br>";
            }
            
            // Sauvegarde des informations Discord dans la session
            $_SESSION['discord_id'] = $discord_id;
            $_SESSION['discord_username'] = $discord_username;
            $_SESSION['discord_avatar'] = $discord_avatar;
        }
    }
}

// Vérifie si l'utilisateur a déjà lié son compte Discord
$stmt = $pdo->prepare("SELECT discord_id, linked_with_discord FROM inscription WHERE user = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<pre>Utilisateur récupéré depuis la base : ";
var_dump($user);
echo "</pre>";

$linked = !empty($user['discord_id']);
$access_token = isset($access_token) ? $access_token : null; // Ajout de la vérification

// Ne tenter de récupérer les serveurs Discord que si l'utilisateur est lié
if ($linked && $access_token) {
    $ch = curl_init("https://discord.com/api/users/@me/guilds");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
    $guilds_response = curl_exec($ch);
    curl_close($ch);

    $guilds = json_decode($guilds_response, true);

    echo "<h2>🔹 Serveurs où vous avez des permissions</h2>";
    if (!empty($guilds)) {
        echo "<ul>";
        foreach ($guilds as $guild) {
            $icon_url = $guild['icon'] ? "https://cdn.discordapp.com/icons/{$guild['id']}/{$guild['icon']}.png" : "https://via.placeholder.com/80";
            $invite_link = "https://discord.com/oauth2/authorize?client_id=$client_id&scope=bot&permissions=8&guild_id={$guild['id']}";

           echo "<li>";
           echo "<img src='$icon_url' width='40' style='border-radius:50%;'> ";
           echo htmlspecialchars($guild['name']);
           echo " <a href='$invite_link' target='_blank'>➕ Ajouter le bot</a>";
           echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>❌ Aucun serveur trouvé.</p>";
    }
} else {
    echo "<p>⚠️ Vous n'êtes pas encore lié à Discord ou vous n'avez pas de token d'accès valide.</p>";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Mon Profil</h1>

    <?php if ($linked): ?>
        <p>✅ Votre compte est lié à Discord !</p>
        <p><strong>Discord :</strong> <?php echo htmlspecialchars($_SESSION['discord_username']); ?></p>
        <img src="<?php echo htmlspecialchars($_SESSION['discord_avatar']); ?>" alt="Avatar Discord" width="80">
        <br><br>
        <a href="unlink_discord.php">❌ Délier mon compte</a>
    <?php else: ?>
        <p>⚠️ Votre compte n'est pas encore lié à Discord.</p>
        <a href="https://discord.com/oauth2/authorize?client_id=<?php echo $client_id; ?>&response_type=code&redirect_uri=<?php echo urlencode($redirect_uri); ?>&scope=identify+guilds">
            🔗 Lier mon compte Discord
        </a>
    <?php endif; ?>

    <br><br>
    <a href="dashboard.php">Retour au dashboard</a>
</body>
</html>
