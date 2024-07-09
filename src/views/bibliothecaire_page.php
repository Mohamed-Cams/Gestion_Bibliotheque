<?php
session_start();
if ($_SESSION['role'] !== 'bibliothecaire') {
    header('Location: ../public/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Page Bibliothécaire</title>
</head>

<body>
    <header>
        <img src="../../images/open-book-svgrepo-com.svg" class="logo" alt="">
        <img src="../../Images/admin_13087915.svg" height="30px" alt="">
        <h3 class="logophrase">Admin Booky</h3>
        <nav class="navigation">
            <button class="btnLogin-popup">Ajouter</button>
            <a href="../acceuil.php">
                <button class="btnLogout">Deconnexion</button>
            </a>
        </nav>
    </header>

    <h1>Bienvenue, Bibliothécaire</h1>
</body>

</html>