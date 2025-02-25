<?php
session_start(); // Démarrer la session au début du script

// Informations de connexion à la base de données
$servername = "";
$username = "";
$password = "";
$database = "";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $email = $_POST["mail"];
    $password = $_POST["password"];

    // Échappement des valeurs pour éviter les attaques par injection SQL
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Vérification des informations de connexion dans la base de données
    $query = "SELECT * FROM inscription WHERE mail = '$email' AND password = '$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows == 1) {
        // Récupération des informations de l'utilisateur
        $row = $result->fetch_assoc();
        $role = $row["role"];
        $username = $row["user"]; // Assurez-vous que la colonne "username" existe dans votre BDD

        // Stocker le nom d'utilisateur dans la session
        $_SESSION['username'] = $username;

        // Redirection selon le rôle de l'utilisateur
        if ($role == "admin") {
            header("Location: https://administration.airbot.adkynet.eu");
            exit();
        } else {
            header("Location: https://www.airbot.adkynet.eu/");
            exit();
        }
    } else {
        // Authentification échouée
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="/connexion/assets/css/style.css"
    />
    <title>connexion</title>
</head>
<body>
  <div class="login-box">
    <h2>connexion</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <form>
    <div class="user-box">
    <input type="email" name="mail" required="">
    <label>mail</label>
</div>
<div class="user-box">
    <input type="password" name="password" required="">
    <label>Mots de passe</label>
</div>

      <a class="forget" >
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <input type="submit" value="Envoyer">
      </a>
      <a class="forget" href="/inscription/index.php">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        inscrire
      </a>
    </form>
     
  </div>
  
     
</body>
</html>