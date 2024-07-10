<?php
session_start();
if ($_SESSION['role'] !== 'bibliothecaire') {
    header('Location: ../public/index.php');
    exit;
}

require_once '../../config/config.php';
require_once '../models/Bibliotheque.php';
require_once '../models/Bibliothecaire.php';
require_once '../controllers/BibliothecaireController.php';

$bibliothequeController = new BibliothecaireController();

if (isset($_POST["ajoutLivre"])) {

    require_once '../controllers/BibliothecaireController.php';

    $controller = new BibliothecaireController();
    $controller->ajouterLivre();
}

if (isset($_POST['supprimer'])) {

    require_once '../controllers/BibliothecaireController.php';

    $id = $_POST["supprimer"];

    $controller = new BibliothecaireController();
    $controller->supprimerLivre($id);

    header('Location: ./bibliothecaire_page.php');
}
if (isset($_POST['supprimerp'])) {

    require_once '../controllers/BibliothecaireController.php';

    $email = $_POST["supprimerp"];

    $controller = new BibliothecaireController();
    $controller->supprimerPersonne($email);

    header('Location: ./bibliothecaire_page.php');
}
if (isset($_POST['deconnection'])) {
    $bibliothequeController->logout();
}

if (isset($_POST['deconnection'])) {
    $bibliothequeController->logout();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Page Bibliothécaire</title>
    <link href="../css/styleb.css" rel="stylesheet" type="" />
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

    <div class="wrapper active-popup">
        <span class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </span>
        <div class="form-box login">
            <h2>Ajout Livre</h2>
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
                <br>

            </form>
        </div>
    </div>

    <main>
        <br><br><br><br><br>
        <br><br><br><br><br>
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
                                    <img class="novel-item" style="height: 136px" src="../../Images/Couverture/<?= $row['p_couverture']; ?>" alt="">
                                </td>
                                <td><?= $row['titre']; ?></td>
                                <td><?= $row['auteur']; ?></td>
                                <td><?= $row['anne_pub']; ?></td>
                                <td><?= $row['genre']; ?></td>
                                <td><?= $row['nb_exemp']; ?></td>
                                <td>
                                    <a href="modifierLivreb.php?id=<?= $row['id']; ?>" class="btn btn-warning">Modifier</a>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <button value="<?= $row['id']; ?>" class=" btn btn-danger" name="supprimer">Supprimer</button>
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