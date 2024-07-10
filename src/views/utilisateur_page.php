<?php
session_start();
if ($_SESSION['role'] !== 'utilisateur') {
    header('Location: ../public/index.php');
    exit;
}
include('../../config/config.php');

if (isset($_POST['livre_id'])) {

    $livre_id = $_POST['livre_id'];
    require_once '../controllers/EmpruntController.php';

    $controller = new EmpruntController($pdo);

    $controller->ajouterEmprunt($livre_id);
}

if (isset($_POST['livreR_id'])) {

    $livre_id = $_POST['livreR_id'];
    require_once '../controllers/EmpruntController.php';

    $controller = new EmpruntController($pdo);

    // $controller->rendreEmprunt($livre_id,);
}

if (isset($_POST['deconnection'])) {
    $bibliothequeController->logout();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Page Utilisateur</title>
    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <link href="../css/stylea.css" rel="stylesheet" type="" />
</head>

<body>
    <header>
        <img src="../../images/modele-logo-librairie-design-plat-dessine-main.png" class="logo" alt="">
        <img src="../../Images/user-icon.svg" height="30px" alt="">
        <h6 class="logophrase">Bonjour, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?>,</h6>
        <nav class="navigation">
            <form action="" method="post">
                <button class="btnLogout" name="deconnection">Déconnexion</button></a>
            </form>
        </nav>
    </header>
    <div class="container">
        <table class="table table-bordered shadow">
            <h4>Liste de livre</h4>
            <br>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT e.fk_utilisateur, p.prenom, l.titre, l.id, l.auteur FROM emprunts e JOIN personnes p JOIN livres l ON e.fk_utilisateur = p.email and l.id = e.fk_livre WHERE e.date_retour IS NULL";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                $result = $stmt->fetchAll();
                if ($result) {
                    # code...
                    foreach ($result as $row) {
                ?>
                <tr>
                    <td><?= $row['titre']; ?></td>
                    <td><?= $row['auteur']; ?></td>
                    <td>
                        <form action="utilisateur_page.php" method="post">
                            <button type="submit" class="btn btn-sm btn-outline-secondary" name="livreR_id"
                                value="<?= $row['id']; ?>">Rendre</button>
                        </form>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    ?>
                <tr>
                    <td colspan="7">0 Livre Enregistrer</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            $query = "SELECT * FROM livres";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll();
            if ($result) {
                # code...
                foreach ($result as $row) {
            ?>
            <div class="col">
                <div class="card shadow-sm">
                    <img class="bd-placeholder-img card-img-top" width="100px" height="225px"
                        src="../../Images/Couverture/<?= $row['p_couverture']; ?>" alt="">
                    <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef"
                        dy=".3em"><?= $row['titre']; ?></text>
                    <div class="card-body">
                        <p class="card-text"></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                <form action="utilisateur_page.php" method="post">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" name="livre_id"
                                        value="<?= $row['id']; ?>">Emprunter</button>
                                </form>

                            </div>
                            <small class="text-body-secondary"><?= $row['genre']; ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    </div>
    <!-- <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            $query = "SELECT e.fk_utilisateur, p.prenom, l.titre FROM emprunts e JOIN personnes p JOIN livres l ON e.fk_utilisateur = p.email and l.id = e.fk_livre WHERE e.date_retour IS NULL ";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll();
            if ($result) {
                # code...
                foreach ($result as $row) {
            ?>
                    <div class="col">
                        <div class="card shadow-sm">

                            <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em"><?= $row['titre']; ?></text>
                            <div class="card-body">
                                <p class="card-text"></p>
                                <div class="d-flex justify-content-between align-items-center">


                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    </div> -->
</body>

</html>