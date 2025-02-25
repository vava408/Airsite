<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    die("⛔ Vous devez être connecté pour effectuer cette action.");
}

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

// Suppression des informations Discord de l'utilisateur dans la base de données
$stmt = $pdo->prepare("UPDATE inscription SET discord_id = NULL, linked_with_discord = 0, dashboard_token = NULL, token_expires_at = NULL WHERE user = ?");
$stmt->execute([$_SESSION['username']]);

// Suppression des données Discord de la session
unset($_SESSION['discord_id']);
unset($_SESSION['discord_username']);
unset($_SESSION['discord_avatar']);

// Redirection vers la page de profil avec un message de confirmation
header("Location: profil.php?unlink=success");
exit();
?>
