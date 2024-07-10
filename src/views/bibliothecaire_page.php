<?php
session_start();
if ($_SESSION['role'] !== 'bibliothecaire') {
    header('Location: ../public/index.php');
    exit;
}
if (isset($_POST['deconnection'])) {
    $bibliothequeController->logout();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Page Bibliothécaire</title>
    <link href="../css/stylea.css" rel="stylesheet" type="" />
</head>

<body>
    <header>
        <img src="../../images/modele-logo-librairie-design-plat-dessine-main.png" class="logo" alt="">
        <img src="../../Images/admin_13087915.svg" height="30px" alt="">
        <h6 class="logophrase">Bonjour, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?>,</h6>
        <nav class="navigation">
            <button class="btnLogin-popup">Ajouter</button>
            <form action="" method="post">
                <button class="btnLogout" name="deconnection">Déconnexion</button></a>
            </form>
        </nav>
    </header>

    <h1>Bienvenue, Bibliothécaire</h1>
</body>

</html>