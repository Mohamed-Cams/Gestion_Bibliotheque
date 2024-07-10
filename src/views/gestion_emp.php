<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers nécessaires
require_once '../../config/config.php';
require_once '../models/Bibliotheque.php';
require_once '../models/Bibliothecaire.php';
require_once '../controllers/BibliothecaireController.php';
require_once '../controllers/EmpruntController.php';

// Initialisation des contrôleurs
$bibliothequeController = new BibliothecaireController();
$empruntController = new EmpruntController($pdo);

// Récupération des données nécessaires pour l'affichage
$utilisateurs = $bibliothequeController->getAllUtilisateurs();
$livresEmpruntes = $empruntController->getLivresEmpruntes();
$emprunts = $empruntController->getAllEmprunts();

// Logique pour gérer les différentes actions (POST et GET)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Actions pour la gestion des emprunts
        if ($action === 'rendre_emprunt') {
            $fk_utilisateur = isset($_POST['fk_utilisateur']) ? $_POST['fk_utilisateur'] : null;
            $id_livre = isset($_POST['id']) ? $_POST['id'] : null;
            $date_retour = isset($_POST['date_retour']) ? $_POST['date_retour'] : null;

            if ($fk_utilisateur !== null && $id_livre !== null && $date_retour !== null) {
                $empruntController->rendreEmprunt($fk_utilisateur, $id_livre, $date_retour);
            } else {
                // Gérer l'erreur ou le cas où une valeur requise est manquante
                $_SESSION['ErrorMessage'] = "Tous les champs doivent être remplis pour rendre l'emprunt.";
            }
        }
    }
}

if (isset($_POST['deconnection'])) {
    $bibliothequeController->logout();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page Gestion</title>
    <link href="../css/stylea.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <img src="../../images/open-book-svgrepo-com.svg" class="logo" alt="">
        <img src="../../Images/admin_13087915.svg" height="30px" alt="">
        <h6 class="logophrase">Bonjour, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?>,</h6>
        <nav class="navigation">
            <a href="./admin_page.php"><button class="btnLogout">Retour</button></a>
            <form action="" method="post">
                <button class="btnLogout" name="deconnection">Déconnexion</button></a>
            </form>

        </nav>
    </header>

    <main class="container">
        <h1 class="h1a">Rendre Emprunt</h1>
        <hr>

        <!-- Formulaire pour sélectionner l'utilisateur -->
        <form method="POST">
            <div class="mb-3">
                <label for="fk_utilisateur" class="form-label h1a">Sélectionner l'utilisateur :</label>
                <select class="form-select" id="fk_utilisateur" name="fk_utilisateur" onchange="this.form.submit()"
                    required>
                    <option selected disabled value="">Choisir...</option>
                    <?php foreach ($utilisateurs as $utilisateur) : ?>
                    <option
                        value="<?= isset($utilisateur['fk_utilisateur']) ? htmlspecialchars($utilisateur['fk_utilisateur']) : '' ?>">
                        <?= isset($utilisateur['prenom']) ? htmlspecialchars($utilisateur['prenom']) : '' ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <!-- Formulaire pour rendre l'emprunt -->
        <?php if (!empty($livresEmpruntes)) : ?>
        <form action="gestion_emp.php" method="POST">
            <input type="hidden" name="fk_utilisateur"
                value="<?= isset($_POST['fk_utilisateur']) ? htmlspecialchars($_POST['fk_utilisateur']) : '' ?>">
            <div class="mb-3">
                <label for="id" class="form-label ha1">Sélectionner le livre à rendre :</label>
                <select class="form-select" id="id" name="id" required>
                    <option selected disabled value="">Choisir...</option>
                    <?php foreach ($livresEmpruntes as $livre) : ?>
                    <option value="<?= isset($livre['id']) ? htmlspecialchars($livre['id']) : '' ?>">
                        <?= isset($livre['titre']) ? htmlspecialchars($livre['titre']) : '' ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="date_retour" class="form-label h1a">Date de retour :</label>
                <input type="datetime-local" class="form-control" id="date_retour" name="date_retour" required>
            </div>
            <button type="submit" class="btn btn-primary" name="livre_id">Rendre Emprunt</button>
        </form>
        <?php endif; ?>

        <!-- Affichage des messages d'erreur et de succès -->
        <?php if (isset($_SESSION['ErrorMessage'])) : ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= $_SESSION['ErrorMessage'] ?>
        </div>
        <?php unset($_SESSION['ErrorMessage']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['SuccessMessage'])) : ?>
        <div class="alert alert-success mt-3" role="alert">
            <?= $_SESSION['SuccessMessage'] ?>
        </div>
        <?php unset($_SESSION['SuccessMessage']); ?>
        <?php endif; ?>

        <h1 class="h1a">Historique des Emprunts</h1>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID Emprunt</th>
                    <th>ID Livre</th>
                    <th>Email Emprunteur</th>
                    <th>Date d'emprunt</th>
                    <th>Date de retour prévue</th>
                    <th>Date de retour</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprunts as $emprunt) : ?>
                <tr>
                    <td><?= isset($emprunt['id']) ? htmlspecialchars($emprunt['id']) : '' ?></td>
                    <td><?= isset($emprunt['fk_livre']) ? htmlspecialchars($emprunt['fk_livre']) : '' ?></td>
                    <td><?= isset($emprunt['fk_utilisateur']) ? htmlspecialchars($emprunt['fk_utilisateur']) : '' ?>
                    </td>
                    <td><?= isset($emprunt['date_emprunt']) ? htmlspecialchars($emprunt['date_emprunt']) : '' ?></td>
                    <td><?= isset($emprunt['date_retour_prevue']) ? htmlspecialchars($emprunt['date_retour_prevue']) : '' ?>
                    </td>
                    <td><?= isset($emprunt['date_retour']) ? htmlspecialchars($emprunt['date_retour']) : 'Non rendu' ?>
                    </td>
                    <td>
                        <?php
                            if ($emprunt['date_retour'] === null) {
                                echo 'Pas encore rendu';
                            } else {
                                $date_retour_max = date('Y-m-d H:i:s', strtotime($emprunt['date_emprunt'] . ' + 30 days'));
                                if ($emprunt['date_retour'] < $emprunt['date_retour_prevue']) {
                                    echo 'Rendu avant délai';
                                } elseif ($emprunt['date_retour'] > $emprunt['date_retour_prevue']) {
                                    echo 'Rendu après délai';
                                } else {
                                    echo 'Rendu à temps';
                                }
                            }
                            ?>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <h1 class="h1a">Liste des Emprunts en Cours</h1>
        <div class="table-responsive">
            <table class="table table-bordered border-dark">
                <thead>
                    <tr>
                        <th>ID Emprunt</th>
                        <th>ID Livre</th>
                        <th>Email Emprunteur</th>
                        <th>Date d'emprunt</th>
                        <th>Date de retour prévue</th>
                        <th>Date de retour</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emprunts as $emprunt) : ?>
                    <?php if ($emprunt['date_retour'] == null) { ?>
                    <tr>
                        <td><?= isset($emprunt['id']) ? htmlspecialchars($emprunt['id']) : '' ?></td>
                        <td><?= isset($emprunt['fk_livre']) ? htmlspecialchars($emprunt['fk_livre']) : '' ?></td>
                        <td><?= isset($emprunt['fk_utilisateur']) ? htmlspecialchars($emprunt['fk_utilisateur']) : '' ?>
                        </td>
                        <td><?= isset($emprunt['date_emprunt']) ? htmlspecialchars($emprunt['date_emprunt']) : '' ?>
                        </td>
                        <td><?= isset($emprunt['date_retour_prevue']) ? htmlspecialchars($emprunt['date_retour_prevue']) : '' ?>
                        </td>
                        <td><?= isset($emprunt['date_retour']) ? htmlspecialchars($emprunt['date_retour']) : 'Pas encore rendu' ?>
                        </td>
                        <td>
                            <?php
                                    if ($emprunt['date_retour'] === null) {
                                        echo 'En cours';
                                    } else {
                                        $date_retour_max = date('Y-m-d H:i:s', strtotime($emprunt['date_emprunt'] . ' + 30 days'));
                                        if (new DateTime() > new DateTime($date_retour_max)) {
                                            echo 'Dépassé';
                                        } else {
                                            echo 'En cours';
                                        }
                                    }
                                    ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>