<?php

session_start();

if (isset($_SESSION['username'])) {
    header("Location: https://administration.airbot.adkynet.eu");
    exit();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Welcome to Admin Panel</h1>

    <a href="manage_users.php">Manage Users</a>
    <!-- Add more admin features or links as needed -->

    <a href="logout.php">Logout</a>
</body>
</html>
