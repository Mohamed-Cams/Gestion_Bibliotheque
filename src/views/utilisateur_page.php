<?php
session_start();
if ($_SESSION['role'] !== 'utilisateur') {
    header('Location: ../public/index.php');
    exit;
}
include('../../config/config.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Page Utilisateur</title>
    <link href="../../css/stylea.css" rel="stylesheet" type="" />
</head>

<body>
    <header>
        <img src="../../images/open-book-svgrepo-com.svg" class="logo" alt="">
        <img src="../../Images/user-icon.svg" height="30px" alt="">
        <h3 class="logophrase">Utilisateur Booky</h3>
        <nav class="navigation">
            <a href="../acceuil.php">
                <button class="btnLogout">Deconnexion</button>
            </a>
        </nav>
    </header>
</body>

</html>