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

if (isset($_POST["ajoutLivre"])) {

    require_once '../controllers/BibliothecaireController.php';

    $controller = new BibliothecaireController();
    $controller->ajouterLivre();
}

if (isset($_POST['supprimer'])) {

    require_once '../controllers/BibliothecaireController.php';

    $controller = new BibliothecaireController();
    $controller->supprimerLivre($id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <link href="../../css/stylea.css" rel="stylesheet" type="" />
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

    <div class="wrapper active-popup">
        <span class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </span>
        <div class="form-box login">
            <h2>Ajout</h2>
            <form action="admin_page.php" method="POST">
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
                    <input id="date" type="date" name="anne_pub" value="1900-01-01" />
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
                <button type="submit" class="btn" name="ajoutLivre">Enregistrer</button>
            </form>
        </div>
    </div>

    <main>
        <br><br><br><br><br>
        <div class="container">
            <form action="search.php" method="get" style="width: 100%; max-width: 30rem">

                <div class="input-group my-5">
                    <input type="text" class="form-control" name="key" placeholder="Rechercher livre..."
                        aria-label="Rechercher livre..." aria-describedby="basic-addon2">

                    <button class="input-group-text
                btn btn-primary" id="basic-addon2">
                        <img src="../../Images/search-svgrepo-com.svg" width="20">

                    </button>
                </div>
            </form>
        </div>

        <div class="container">
            <table class="table table-bordered shadow">
                <h4>Liste de livre</h4>
                <br>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Couverture</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Anné_Pub</th>
                        <th>Genre</th>
                        <th>Exemplaire</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM livres";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();

                    $result = $stmt->fetchAll();
                    if ($result) {
                        # code...
                        foreach ($result as $row) {
                    ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td>
                            <img class="novel-item" style="height: 136px"
                                src="../../Images/Couverture/<?= $row['p_couverture']; ?>" alt="">
                        </td>
                        <td><?= $row['titre']; ?></td>
                        <td><?= $row['auteur']; ?></td>
                        <td><?= $row['anne_pub']; ?></td>
                        <td><?= $row['genre']; ?></td>
                        <td><?= $row['nb_exemp']; ?></td>
                        <td>
                            <a href="" class="btn btn-warning">Modifier</a>
                        </td>
                        <td>
                            <a href="" class="btn btn-danger">Supprimer</a>
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
        <br><br>
        <div class="container">
            <table class="table table-bordered shadow">
                <h4>Liste de Bibliothecaire</h4>
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Email</th>
                        <th>Mot de Pass</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM personnes WHERE role = '3'";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();

                    $result = $stmt->fetchAll();
                    if ($result) {
                        # code...
                        foreach ($result as $row) {
                    ?>
                    <tr>
                        <td><?= $row['role']; ?></td>
                        <td><?= $row['nom']; ?></td>
                        <td><?= $row['prenom']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['mdp']; ?></td>
                        <td>
                            <a href="" class="btn btn-warning">Modifier</a>
                        </td>
                        <td>
                            <a href="" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        ?>
                    <tr>
                        <td colspan="7">0 Biblio Enregistrer</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
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