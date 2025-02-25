<?php
session_start(); // Démarrer la session pour récupérer les données

// Vérification si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
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

    <!--- ?php require_once(__DIR__ . '/header.php'); ?>-->

      
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

    <!-- Hero Section Start -->
    <section class="hero bg-base is-fullheight">
      <div class="hero-body">
        <div class="">
          <div class="columns">
            <div class="column mr-6 mt-12" data-aos="fade-up">
              <p class="title has-text-white has-text-weight-bold">
                Il est temps d'ajouter AIRBOT à votre serveur.
              </p>
              <p class="subtitle has-text-grey-light is-size-6 mt-3">
                Un bot spécialisé dans l'écoute des administrateurs des serveurs, 
                avec des ajouts des commandes réalisées dans les plus brefs délais.
              </p>
              <div class="buttons">
                <a href="#" class="button is-info">
                  <strong>Ajoutez à votre Discord</strong>
                </a>

                <a href="#" class="button is-primary is-outlined">
                  <strong><i class="fa-solid fa-crown"></i> </strong>
                </a>
              </div>
            </div>
            <div class="column mt-6" data-aos="fade-left">
              <img
                class="image has-image-centered vert-move mt-4"
                src="assets/img/airbotredimenssioner-removebg-preview.png"
                alt="image du bot"
                style="width: 20rem;"
              />
            </div>
          </div>
        </div>
      </div>  
      <div class="has-text-centered" data-tippy-content="Scroll Down">
        <a href="#features"
          ><i
            class="fa-solid fa-circle-chevron-down fa-lg vert-move2 has-text-white"
          ></i
        ></a>
      </div>
    </section>
    <!-- Hero Section End -->

    <!-- Hero Waves Start -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path
        fill="#1a2634"
        fill-opacity="1"
        d="M0,288L24,261.3C48,235,96,181,144,154.7C192,128,240,128,288,149.3C336,171,384,213,432,202.7C480,192,528,128,576,133.3C624,139,672,213,720,213.3C768,213,816,139,864,101.3C912,64,960,64,1008,106.7C1056,149,1104,235,1152,240C1200,245,1248,171,1296,144C1344,117,1392,139,1416,149.3L1440,160L1440,0L1416,0C1392,0,1344,0,1296,0C1248,0,1200,0,1152,0C1104,0,1056,0,1008,0C960,0,912,0,864,0C816,0,768,0,720,0C672,0,624,0,576,0C528,0,480,0,432,0C384,0,336,0,288,0C240,0,192,0,144,0C96,0,48,0,24,0L0,0Z"
      ></path>
    </svg>
    <!-- Hero Waves End -->

    <!-- Features Section Start -->
    <section id="features" class="section mt-6">
      <div class="has-text-centered">
        <h1 class="title lined">Caractéristique</h1>
        <div class="line line-center blurple"></div>
      </div>

      <!-- single feature start (Left) -->
      
        <div class="shape-right" data-aos="fade-up-left">
          <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path
              fill="#9AAAE3"
              d="M42.7,-62.9C50.9,-52.8,50.1,-34.4,51.7,-19.2C53.4,-4,57.4,8,56.6,20.8C55.8,33.7,50.1,47.4,39.9,53.8C29.6,60.1,14.8,59.1,0.4,58.5C-14,58,-28,57.9,-38,51.5C-48.1,45,-54.3,32.3,-61.3,18.1C-68.4,4,-76.4,-11.7,-71.9,-22.7C-67.4,-33.6,-50.4,-39.8,-36.3,-47.9C-22.2,-56.1,-11.1,-66.3,3.1,-70.5C17.2,-74.7,34.5,-72.9,42.7,-62.9Z"
              transform="translate(100 100)"
            />
          </svg>
        </div>

        <div class="columns mt-6">
          <div class="column mr-6">
            <h4 class="title">Niveau<span class="blurple">#1</span></h4>
            <p class="subtitle mt-3">
            Airbot possède un système de niveau personnalisable; par exemple : les messages des passages de niveau. Vous pouvez lui attribuer des rôles et bien plus encore!
            </p>
          </div>
          <div class="column" data-aos="fade-left">
            <img
              class="image has-image-centered"
              src="assets/img/bdd.png"
              alt="feature1 img"
              style="width: 20rem;"
            />
          </div>
        </div>
      
      <!-- single feature end (Left) -->

      <!-- single feature start (Right) -->
    
        <div class="shape-left" data-aos="fade-up-right">
          <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path
              fill="#9AAAE3"
              d="M54.2,-67.2C69.4,-63.5,80.4,-46.6,84.6,-28.7C88.7,-10.8,86,8.1,76.8,21.4C67.6,34.7,51.9,42.3,38.1,50.3C24.2,58.3,12.1,66.7,-2.8,70.5C-17.7,74.3,-35.3,73.6,-45.6,64.5C-55.9,55.3,-58.8,37.7,-63.3,21.2C-67.7,4.7,-73.7,-10.6,-71.8,-25.4C-69.8,-40.2,-59.9,-54.5,-46.6,-58.9C-33.3,-63.2,-16.7,-57.6,1.4,-59.6C19.5,-61.5,39,-71,54.2,-67.2Z"
              transform="translate(100 100)"
            />
          </svg>
        </div>

        <div class="columns mt-6">
          <div class="column" data-aos="fade-right">
			  <!----Source : Toptal  https://bs-uploads.toptal.io/blackfish-uploads/blog/post/seo/og_image_file/og_image/15493/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png --->
            <img
              class="image has-image-centered"
              src="assets/img/discord.png"
              alt="feature1 img"
              style="width: 20rem;"
            />
          </div>
          <div class="column">
            <h4 class="title">Des jeux <span class="has-text-primary">#2</span>
            </h4>
            <p class="subtitle mt-3">
              Airbot est équipé de commande de jeux. Cela vous permettra de vous 
              amuser entre ami(e)s ou seul. Plein de commandes seront ajoutées prochainement
              pour encore plus de fun.
            </p>
          </div>
        </div>

      <!-- single feature end (Right) -->

      <!-- single feature start (Left) -->

        <div class="shape-right" data-aos="fade-up-left">
          <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path
              fill="#9AAAE3"
              d="M42.7,-62.9C50.9,-52.8,50.1,-34.4,51.7,-19.2C53.4,-4,57.4,8,56.6,20.8C55.8,33.7,50.1,47.4,39.9,53.8C29.6,60.1,14.8,59.1,0.4,58.5C-14,58,-28,57.9,-38,51.5C-48.1,45,-54.3,32.3,-61.3,18.1C-68.4,4,-76.4,-11.7,-71.9,-22.7C-67.4,-33.6,-50.4,-39.8,-36.3,-47.9C-22.2,-56.1,-11.1,-66.3,3.1,-70.5C17.2,-74.7,34.5,-72.9,42.7,-62.9Z"
              transform="translate(100 100)"
            />
          </svg>
        </div>

        <div class="columns mt-6">
          <div class="column mr-6">
            <h4 class="title">Une écoute active <span class="has-text-warning">#3</span>
            </h4>
            <p class="subtitle mt-3">
              Nous avons une équipe de développement à l'écoute
              de vos besoins. Nous faisons de notre mieux 
              pour faire les mises à jour le plus vite possible.

            </p>
          </div>
          <div class="column" data-aos="fade-left">
            <img
              class="image has-image-centered"
              src="assets/img/ecoute.jpg"
              alt="feature1 img"
              style="width: 20rem;"
            />
          </div>
        </div>

      <!-- single feature end (Left) -->

      <!-- single feature start (Right) -->
     <!--
        <div class="shape-left" data-aos="fade-up-right">
          <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path
              fill="#9AAAE3"
              d="M54.2,-67.2C69.4,-63.5,80.4,-46.6,84.6,-28.7C88.7,-10.8,86,8.1,76.8,21.4C67.6,34.7,51.9,42.3,38.1,50.3C24.2,58.3,12.1,66.7,-2.8,70.5C-17.7,74.3,-35.3,73.6,-45.6,64.5C-55.9,55.3,-58.8,37.7,-63.3,21.2C-67.7,4.7,-73.7,-10.6,-71.8,-25.4C-69.8,-40.2,-59.9,-54.5,-46.6,-58.9C-33.3,-63.2,-16.7,-57.6,1.4,-59.6C19.5,-61.5,39,-71,54.2,-67.2Z"
              transform="translate(100 100)"
            />
          </svg>
        </div>

        <div class="columns mt-6">
          <div class="column" data-aos="fade-right">
            <img
              class="image has-image-centered"
              src="assets/img/music.svg"
              alt="feature1 img"
              style="width: 20rem;"
            />
          </div>
          <div class="column">
            <h4 class="title">Feature <span class="has-text-info">#4</span></h4>
            <p class="subtitle mt-3">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
              enim ad minim veniam, quis nostrud exercitation ullamco laboris
              nisi ut aliquip ex ea commodo consequat.
            </p>
          </div>
      </div>-->
      <!-- single feature end (Right) -->
    </section>
    <!-- Features Section End -->

    <!-- Stats Section Start -->
    <?php
// Définir les informations de connexion à la base de données
$servername = "mysql-airbot.alwaysdata.net";
$username = "airbot";
$password = "vava11ba";
$database = "airbot_stats";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier si la connexion a échoué
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les informations de la table "stats"
$query = "SELECT serveur, membre FROM stat";
$result = $conn->query($query);

// Vérifier si des résultats ont été obtenus
if ($result->num_rows > 0) {
    // Parcourir les résultats
    while ($row = $result->fetch_assoc()) {
        $serveurs = $row["serveur"];
        $membres = $row["membre"];
    }
} else {
    $serveurs = "N/A";
    $membres = "N/A";
}

// Fermer la connexion à la base de données
$conn->close();
?>


<section id="stats" class="section mt-6">
  <div class="has-text-centered">
    <h1 class="title lined">Stats</h1>
    <div class="line line-center blurple"></div>
  </div>

  <div class="columns mt-6">
    <div class="column has-text-centered">
      <p class="title has-text-weight-bold lined"><?php echo $serveurs; ?></p>
      <span class="subtitle has-text-weight-bold blurple"><i class="fa-solid fa-server"></i> Servers</span>
    </div>

    <div class="column has-text-centered">
      <p class="title has-text-weight-bold lined">000</p>
      <span class="subtitle has-text-weight-bold blurple"><i class="fa-solid fa-terminal"></i> Commands</span>
    </div>

    <div class="column has-text-centered">
      <p class="title has-text-weight-bold lined"><?php echo $membres; ?></p>
      <span class="subtitle has-text-weight-bold blurple"><i class="fa-solid fa-users"></i> Users</span>
    </div>
  </div>
</section>


    <!-- Invite Section Start -->
    <section class="section mt-6">
      <div class="columns">
        <div class="column has-text-left">
          <p class="title has-text-weight-bold">
            Pret à essayer <span class="blurple">AirBot</span>?
          </p>
          <p class="subtitle mt-3 has-text-gray">
            Venez vous amuser avec AirBot ! et faites grandir notre
            communauté. Venez aider au developpemment du bot.
          
          </p>
          <a href="https://discord.com/api/oauth2/authorize?client_id=1077950946367254561&permissions=8&scope=bot" class="button is-blurple is-medium"
            ><strong><i class="fa-solid fa-book"></i> Inviter AirBot</strong></a
          >
        </div>

        <div class="column"></div>
      </div>
    </section>
    <!-- Invite Section End -->

    <!-- Footer Section Start -->
    <footer class="footer bg-base">
      <div class="content has-text-centered has-text-white">
        <div class="mb-2">
          <a href="#" class="has-text-white" target="_blank">
            <i class="fa-brands fa-discord"></i>
          </a>
          &nbsp; &nbsp;
          <a href="#" class="has-text-white" target="_blank">
            <i class="fa-brands fa-github"></i>
          </a>
        </div>

        <p>
          <span class="has-text-weight-bold">AirBot</span>
          <br />
          &copy; <span id="cp-year"></span> Copyright vava4859. All Rights
          Reserved.
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
