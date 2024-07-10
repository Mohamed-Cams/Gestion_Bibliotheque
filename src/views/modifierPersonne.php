<?php
ini_set('memory_limit', '262144M');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include('../../config/config.php');

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../public/index.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "bibliotheque";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception
    // echo "Connected Successfully";

} catch (PDOException $e) {

    echo "Connection Failed" . $e->getMessage();
}

if (isset($_POST['modifierp'])) {

    require_once '../controllers/BibliothecaireController.php';

    $email = $_GET["email"];
    $role = $_POST["role"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mdp = $_POST["mdp"];
    $nb_emp = $_POST["nb_emp"];


    $controller = new BibliothecaireController();
    $controller->modifierPersonne($email, $role, $nom, $prenom, $nb_emp, $mdp);

    header('Location: ./admin_page.php');
}

?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <link href="../css/stylea.css" rel="stylesheet" type="" />
</head>
<header>
    <img src="../../images/modele-logo-librairie-design-plat-dessine-main.png" class="logo" alt="">
    <img src="../../Images/admin_13087915.svg" height="30px" alt="">
    <h6 class="logophrase">Bonjour, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?>,</h6>
    <nav class="navigation">

        <a href="./admin_page.php">
            <button class="btnLogout">Retour</button>
        </a>

    </nav>
</header>

<body>
    <main>
        <br>
        <br>
        <br>
        <br>
        <div class="wrapper active-popup">
            <span class="icon-close">
                <ion-icon name="close-outline"></ion-icon>
            </span>
            <div class="form-box login">
                <h2>Modifier Personne</h2>
                <form action="" method="POST">
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <input type="number" id="role" name="role" min="1" max="3" />
                        <label for="">Role</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <input type="text" name="nom" required>
                        <label for="">Nom</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <input type="Text" name="prenom" required>
                        <label for="">Prenom</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="book"></ion-icon>
                        </span>
                        <input type="email" name="email" required>
                        <label for="">Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="images"></ion-icon>
                        </span>
                        <input type="password" name="mdp" required>
                        <label for="">Mot de passe</label>
                    </div>
                    <button type="submit" class="btn" name="modifierp">Modifier</button>
                    <br>
                </form>
            </div>
        </div>
    </main>


    <script src="../../js/scriptadmin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>