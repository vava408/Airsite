<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mise à jour</title>
    <link rel="stylesheet" href="assets/css/bulma.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/mise-a-jour//assets/css/index.css">
</head>
<body>
    <!-- Back To Top Start -->
    <a id="backtotop" data-tippy-content="Back To Top.">
        <i class="fa-solid fa-angle-up has-text-white fa-2xl mt-5"></i>
    </a>
    <!-- Back To Top End -->
  
    <!-- Navbar Start -->
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand mt-2 mb-2">
            <a class="navbar-item" href="#">
                <strong>AIRBOT</strong>
            </a>
            <a role="button" class="navbar-burger has-text-white" data-target="navMenu" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a href="" class="navbar-item is-tab">Accueille</a>
                <a href="./repport-de-bug/index.html" class="navbar-item is-tab">Repport de bug</a>
                <a href="./mise-a-jour/index.html" class="navbar-item is-tab">Mise à jour</a>
                <a href="./partenaires/index.html" class="navbar-item is-tab">Nos partenaires</a>
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

    <div class="container">
        <h1>Dernières mises à jour</h1>
        <div class="updates-container">
            <?php
            // Code PHP pour la connexion à la base de données et la récupération des mises à jour
            $host = '';
            $user = '';
            $password = '';
            $database = '';

            try {
                $connection = new PDO("mysql:host=$host;dbname=$database", $user, $password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = 'SELECT * FROM `update` ORDER BY STR_TO_DATE(`date`, "%d/%m/%Y") DESC LIMIT 5';
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $updates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo '<p class="error-message">Erreur de connexion à la base de données: ' . $e->getMessage() . '</p>';
            }

            // Générer les cartes pour chaque mise à jour
            foreach ($updates as $update) {
                echo '<div class="update-card">';
                echo '<div class="update-title">' . $update['nom'] . '</div>';
                echo '<div class="update-description">' . $update['description'] . '</div>';
                echo '<div class="update-version">Version: ' . $update['version'] . '</div>';
                echo '<div class="update-date">Date: ' . $update['date'] . '</div>';

                // Formulaire pour les réactions
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="update_id" value="' . $update['id'] . '">';
                echo '<textarea name="reaction" placeholder="Votre réaction" required></textarea>';
                echo '<button type="submit">Envoyer</button>';
                echo '</form>';

                // Afficher les réactions pour cette mise à jour
                try {
                    $query = 'SELECT * FROM `reactions` WHERE update_id = :update_id ORDER BY created_at DESC';
                    $stmt = $connection->prepare($query);
                    $stmt->bindParam(':update_id', $update['id']);
                    $stmt->execute();

                    $reactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($reactions) {
                        echo '<div class="reactions">';
                        foreach ($reactions as $reaction) {
                            echo '<div class="reaction">';
                            echo '<p>' . htmlspecialchars($reaction['reaction']) . '</p>';
                            echo '<small>' . $reaction['created_at'] . '</small>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo '<p class="error-message">Erreur lors de la récupération des réactions: ' . $e->getMessage() . '</p>';
                }

                echo '</div>';
            }

            // Enregistrer la réaction dans la base de données
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['reaction']) && !empty($_POST['update_id'])) {
                try {
                    $query = 'INSERT INTO reactions (update_id, reaction, created_at) VALUES (:update_id, :reaction, NOW())';
                    $stmt = $connection->prepare($query);
                    $stmt->bindParam(':update_id', $_POST['update_id']);
                    $stmt->bindParam(':reaction', $_POST['reaction']);
                    $stmt->execute();

                    // Rediriger pour éviter le re-posting du formulaire
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    exit;
                } catch (PDOException $e) {
                    echo '<p class="error-message">Erreur lors de l\'enregistrement de la réaction: ' . $e->getMessage() . '</p>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
