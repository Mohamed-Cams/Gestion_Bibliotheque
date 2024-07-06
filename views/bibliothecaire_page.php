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
    <h1>Bienvenue, Bibliothécaire</h1>
</body>
</html>
