<?php
ini_set('memory_limit', '262144M');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include('../../config/config.php');

if ($_SESSION['role'] !== 'utilisateur') {
    header('Location: ../public/index.php');
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/stylea.css" rel="stylesheet" type="" />
    <title>Rechercher</title>
</head>

<body>

    <header>
        <img src="../../images/modele-logo-librairie-design-plat-dessine-main.png" class="logo" alt="">
        <img src="../../Images/admin_13087915.svg" height="30px" alt="">
        <h6 class="logophrase">Bonjour, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?>,</h6>
        <nav class="navigation">
            <a href="./utilisateur_page.php">
                <button class="btnLogout">Retour</button>
            </a>
        </nav>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 style="color:black;">Recherche</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">

                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" required value="<?php if (isset($_GET['search'])) {
                                                                                                echo $_GET['search'];
                                                                                            } ?>" class="form-control" placeholder="Search data">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Couverture</th>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Anné_Pub</th>
                                    <th>Genre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $con = mysqli_connect("localhost", "root", "", "bibliotheque");

                                if (isset($_GET['search'])) {
                                    $filtervalues = $_GET['search'];
                                    $query = "SELECT * FROM livres WHERE CONCAT(titre,auteur,genre) LIKE '%$filtervalues%' ";
                                    $query_run = mysqli_query($con, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $items) {
                                ?>
                                            <tr>
                                                <td><?= $items['id']; ?></td>
                                                <td><img class="novel-item" style="height: 136px" src="../../Images/Couverture/<?= $items['p_couverture']; ?>" alt=""></td>
                                                <td><?= $items['titre']; ?></td>
                                                <td><?= $items['auteur']; ?></td>
                                                <td><?= $items['anne_pub']; ?></td>
                                                <td><?= $items['genre']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4">pas de livre trouver</td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>