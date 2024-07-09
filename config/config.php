<?php
#Fichier de configuration 
# Pour le username et le password mettez vos identifiants respectifs


$host = "mysql:host=127.0.0.1;dbname=bibliotheque";
$username = "root";
$password = "";

try {
    $pdo = new PDO($host, $username, $password);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
