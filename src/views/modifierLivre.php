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

if (isset($_POST['modifier'])) {

    require_once '../controllers/BibliothecaireController.php';

    $id = $_GET["id"];
    $titre = $_POST["titre"];
    $auteur = $_POST["auteur"];
    $anne_pub = $_POST["anne_pub"];
    $genre = $_POST["genre"];
    $nb_exemp = $_POST["nb_exemp"];
    $p_couverture = $_POST["p_couverture"];

    $controller = new BibliothecaireController();
    $controller->modifierLivre($id, $titre, $auteur, $anne_pub, $genre, $nb_exemp, $p_couverture);

    header('Location: ./admin_page.php');
}


?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
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
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $query = "SELECT * FROM livres WHERE id=:id ";
                $statement = $conn->prepare($query);
                $data = [':id' => $id];
                $statement->execute($data);

                $result = $statement->fetch(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
            }
            ?>
            <div class="form-box login">
                <h2>Modifier Livre</h2>
                <form action="" method="POST">
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <input type="text" name="titre" required>
                        <label for="">Titre</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <input type="Text" name="auteur" required>
                        <label for="">Auteur</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="calendar-number-outline"></ion-icon>
                        </span>
                        <input id="date" type="date" name="anne_pub" />
                        <label for="">Date Publication</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="book"></ion-icon>
                        </span>
                        <input type="Text" name="genre" required>
                        <label for="">Genre</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="file-tray-stacked"></ion-icon>
                        </span>
                        <input type="number" id="exemplaire" name="nb_exemp" min="0" max="100" required />
                        <label for="">NB Exemplaire</label>
                    </div>
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="images"></ion-icon>
                        </span>
                        <input type="text" name="p_couverture" required>
                        <label for="">Couverture</label>
                    </div>
                    <button type="submit" class="btn" name="modifier">modifier</button>
                    <br>

                </form>
            </div>
        </div>
    </main>


    <script src="../../js/scriptadmin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>