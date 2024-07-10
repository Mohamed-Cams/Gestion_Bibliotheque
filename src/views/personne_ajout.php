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

if (isset($_POST['ajouterPersonne'])) {

    //header('location: ../acceuil.php');

    require_once '../controllers/BibliothecaireController.php';

    $controller = new BibliothecaireController();
    $controller->ajouterPersonne();
}

if (isset($_POST['supprimer'])) {

    require_once '../controllers/BibliothecaireController.php';

    $id = $_POST["supprimer"];

    $controller = new BibliothecaireController();
    $controller->supprimerLivre($id);

    header('Location: ./admin_page.php');
}
if (isset($_POST['supprimerp'])) {

    require_once '../controllers/BibliothecaireController.php';

    $email = $_POST["supprimerp"];

    $controller = new BibliothecaireController();
    $controller->supprimerPersonne($email);

    header('Location: ./admin_page.php');
}
if (isset($_POST['deconnection'])) {
    $bibliothequeController->logout();
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
            <a href="./gestion_emp.php">
                <button class="btnLogout">Emprunt</button>
            </a>
            <a href="./recherche.php">
                <button class="btnLogout">Rechercher</button>
            </a>
        </nav>
    </header>

    <div class="wrapper active-popup">
        <span class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </span>
        <div class="form-box login">
            <h2>Ajout Personne</h2>
            <form action="personne_ajout.php" method="POST">
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
                <button type="submit" class="btn" name="ajouterPersonne">Enregistrer</button>
                <br>
                <a href="./admin_page.php">Livre</a>
            </form>
        </div>
    </div>

    <main>
        <br><br><br><br><br>


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
                        <th colspan="2">Option</th>
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
                        <th colspan="2">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM personnes";
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
                        <td>
                            <a href="modifierPersonne.php?email=<?= $row['email']; ?>"
                                class="btn btn-warning">Modifier</a>
                        </td>
                        <td>
                            <form action="" method="POST">
                                <button value="<?= $row['email']; ?>" class=" btn btn-danger"
                                    name="supprimerp">Supprimer</button>
                            </form>
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