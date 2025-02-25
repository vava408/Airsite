<?php
session_start(); // Démarrer la session pour récupérer les données

// Vérification si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}


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

session_start(); // Démarrer la session pour récupérer les données

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Avis</title>
    <link rel="stylesheet" href="assets/css/bulma.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/avis/assets/css/style.css">
    <link rel="stylesheet" href="/avis/assets/css/index.css">
</head>
<body>
    <!-- Back To Top Start -->
    <a id="backtotop" data-tippy-content="Back To Top.">
        <i class="fa-solid fa-angle-up has-text-white fa-2xl mt-5"></i>
    </a>
    <!-- Back To Top End -->

    <!-- Navbar Start -->
    <nav
      class="navbar is-fixed-top"
      role="navigation"
      aria-label="main navigation"
    >
      <div class="navbar-brand mt-2 mb-2">
        <a class="navbar-item" href="#">
          <strong>AIRBOT</strong>

           <!-- <img
            src="./assets/img/airbotredimenssioner-removebg-preview.png"
            width="112"
            height="112"
          />  -->
        </a>

        <a
          role="button"
          class="navbar-burger has-text-white"
          data-target="navMenu"
          aria-label="menu"
          aria-expanded="false"
        >
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <a href="" class="navbar-item is-tab">
            Accueil
          </a>

          <a href="./avis/index.php" class="navbar-item is-tab">
            Avis
          </a>

          <a href="./mise-a-jour/index.php" class="navbar-item is-tab">
            Mise à jour
          </a>

          <a href="partenaires/index.php" class="navbar-item is-tab">
            Nos partenaires
          </a>
        </div>

        <div class="navbar-end">
          <a href="#" class="navbar-item is-tab" target="_blank">
            <i class="fa-brands fa-discord"></i>
          </a>

          <a href="#" class="navbar-item is-tab" target="_blank">
            <i class="fa-brands fa-github"></i>
          </a>

          <div class="navbar-item">
            <div class="buttons">
          <div class="navbar-item">
            <div class="buttons">
              <?php if ($isLoggedIn): ?>
                <a href="/profil.php" class="button is-success">
                  <strong><i class="fa-solid fa-user mr-2"></i> <?php echo htmlspecialchars($username); ?></strong>
                </a>
                <a href="/logout.php" class="button is-danger">
                  <strong><i class="fa-solid fa-sign-out-alt mr-2"></i> Déconnexion</strong>
                </a>
              <?php else: ?>
                <a href="/connexion/index.php" class="button is-blurple">
                  <strong><i class="fa-solid fa-right-to-bracket mr-2"></i> Connexion</strong>
                </a>
              <?php endif; ?>
            </div>
          </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar End -->

    <div class="main-content">
        <div class="avis-section">
            <h2>Vos Avis Comptent !</h2>
            <p>Partagez votre expérience avec AIRBOT et aidez-nous à nous améliorer.</p>

            <div class="avis-list">
                <div class="avis-card">
                    <h3>John Doe</h3>
                    <p>⭐⭐⭐⭐⭐</p>
                    <p>Amazing bot! Very helpful and easy to use.</p>
                </div>
                <div class="avis-card">
                    <h3>Jane Smith</h3>
                    <p>⭐⭐⭐⭐</p>
                    <p>Great features, but could use more customization options.</p>
                </div>
                <!-- Ajouter plus d'avis ici -->
            </div>
        </div>
    </div>

    <!-- Footer Section Start -->
    <footer class="footer bg-base">
        <div class="content has-text-centered has-text-white">
            <div class="mb-2">
                <a href="#" class="has-text-white" target="_blank"><i class="fa-brands fa-discord"></i></a>
                &nbsp; &nbsp;
                <a href="#" class="has-text-white" target="_blank"><i class="fa-brands fa-github"></i></a>
            </div>
            <p>
                <span class="has-text-weight-bold">AirBot</span>
                <br />
                &copy; <span id="cp-year"></span> Copyright vava4859. All Rights Reserved.
            </p>
        </div>
    </footer>
    <!-- Footer Section End -->

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
