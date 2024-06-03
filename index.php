<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lotto-game</title>
    <script src="../assets/bundle.js" defer></script>
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<body>
    <?php 
    if (isset($_SESSION['username'])) {
        require_once('public/game-template.php');
    } else {
        require_once('public/login-template.php'); 
    }
    ?>
</body>
</html>
