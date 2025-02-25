<?php
// Définir les informations de connexion à la base de données
$servername = "";
$username = "";
$password = "";
$database = "";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier si la connexion a échoué
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      // Récupérer les données du formulaire
      $mail = $_POST["mail"];
      $username = $_POST["username"];
      $password = $_POST["password"];
      $password2 = $_POST["password_confirm"];
  
      if($password === $password2 ){
          // Échapper les valeurs pour éviter les attaques par injection SQL
          $mail = $conn->real_escape_string($mail);
          $username = $conn->real_escape_string($username);
          $password = $conn->real_escape_string($password);
  
          // Préparer l'instruction SQL
          $sql = "INSERT INTO `inscription`(`mail`, `user`, `password`, `role`) VALUES ('$mail', '$username', '$password', 'membres')";
          
          // Exécuter l'instruction SQL
          if ($conn->query($sql) === TRUE) {
              echo "Nouvel enregistrement créé avec succès.";
          } else {
              echo "Erreur lors de la création de l'enregistrement : " . $conn->error;
          }
      } else {
          echo "Mots de passe différents.";
      }
  }
  

}


// Fermer la connexion à la base de données
$conn->close();
?>  

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/connexion/assets/css/style.css" />
    <title>connexion</title>
</head>
<body>
  <div class="login-box">
    <h2>inscription</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="user-box">
        <input type="email" name="mail" required="">
        <label>Mail</label>
      </div>
      <div class="user-box">
        <input type="text" name="username" required="">
        <label>Nom d'utilisateur</label>
      </div>
      <div class="user-box">
        <input type="password" name="password" required="">
        <label>Mots de passe</label>
      </div>
      <div class="user-box">
        <input type="password" name="password_confirm" required="">
        <label>Confirmer le mot de passe</label>
      </div>
      <a class="forget" href="#">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <input type="submit" value="Envoyer">
      </a>
      <a class="forget" href="/connexion/index.php">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        Connexion
      </a>
      </form>
  </div>
</body>
</html>