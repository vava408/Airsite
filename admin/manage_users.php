<?php

// Inclure la connexion à la base de données
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

// Traitement du formulaire de suppression
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $userIdToDelete = mysqli_real_escape_string($conn, $_POST['user_id_to_delete']);

    // Vérifier si l'identifiant n'est pas vide
    if (!empty($userIdToDelete)) {
        echo "<h2>Confirmer la suppression</h2>";
        echo "<p>Êtes-vous sûr de vouloir supprimer cet utilisateur avec l'ID $userIdToDelete?</p>";
        echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
        echo "<input type='hidden' name='user_id_to_delete' value='" . $userIdToDelete . "'>";
        echo "<button type='submit' name='confirm_delete'>Oui</button>";
        echo "<button type='submit' name='cancel_delete'>Non</button>";
        echo "</form>";
    } else {
        echo "L'identifiant de l'utilisateur à supprimer est vide.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    // Si l'utilisateur a confirmé la suppression
    $userIdToDelete = mysqli_real_escape_string($conn, $_POST['user_id_to_delete']);

    // Code pour supprimer l'utilisateur de la base de données
    $deleteQuery = "DELETE FROM inscription WHERE id = $userIdToDelete";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "L'utilisateur avec l'ID $userIdToDelete a été supprimé.";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur : " . $conn->error;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_delete'])) {
    // Si l'utilisateur a annulé la suppression
    echo "La suppression a été annulée.";
}

// Récupération et affichage des données utilisateur depuis la base de données
$query = "SELECT * FROM inscription";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    echo "<h2>Gestion des utilisateurs</h2>";
    echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
    echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Mot de passe</th>
            <th>Rôle</th>
            <th>Action</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . $row['id'] . "</td>
            <td>" . $row['user'] . "</td>
            <td>" . $row['mail'] . "</td>
            <td>" . $row['password'] . "</td>
            <td>" . $row['role'] . "</td>
            <td>
                <input type='hidden' name='user_id_to_delete' value='" . $row['id'] . "'>
                <button type='submit' name='delete_user'>Supprimer</button>
            </td>
        </tr>";
    }

    echo "</table>";
    echo "</form>";
} else {
    echo "Aucun utilisateur trouvé.";
}

$conn->close();
?>
