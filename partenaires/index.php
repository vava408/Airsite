<?php
// Vérifier si l'utilisateur est connecté
session_start();

if (isset($_SESSION['username'])) {

} 
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Airbot</title>
    <link rel="stylesheet" href="assets/css/bulma.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://unpkg.com/tippy.js@6/animations/scale.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <script src="assets/js/jquery-3.6.0.js"></script>
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
            Accueille
          </a>

          <a href="./repport-de-bug/index.html" class="navbar-item is-tab">
            Avis
          </a>

          <a href="./mise-a-jour/index.html" class="navbar-item is-tab">
            Mise a jour
          </a>

          <a href="./partenaires/index.html" class="navbar-item is-tab">
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
              <a href="/connexion/index.php" class="button is-blurple">
              <strong>
              <i class="fa-solid fa-right-to-bracket mr-2"></i><?php echo isset($_SESSION['username']) ? 'Déconnexion' : 'Connexion'; ?>
              </strong>
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar End -->
  </body>
</html>