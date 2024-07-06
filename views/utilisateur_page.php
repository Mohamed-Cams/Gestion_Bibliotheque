<?php
session_start();
if ($_SESSION['role'] !== 'utilisateur') {
    header('Location: ../public/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Utilisateur</title>
</head>
<body>
    <h1>Bienvenue, Utilisateur</h1>
</body>
</html>
