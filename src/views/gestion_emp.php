<!-- <!DOCTYPE html>
<html>

<head>
    <title>Page Gestion</title>
    <link href="../css/stylea.css" rel="stylesheet" type="" />
</head>

<body>
    <header>
        <img src="../../images/open-book-svgrepo-com.svg" class="logo" alt="">
        <img src="../../Images/admin_13087915.svg" height="30px" alt="">
        <h3 class="logophrase">Admin Booky</h3>
        <nav class="navigation">
            <a href="./admin_page.php">
                <button class="btnLogout">Retour</button>
            </a>
            <a href="../acceuil.php">
                <button class="btnLogout">Deconnexion</button>
            </a>
        </nav>
    </header>


</body>

</html> -->

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../controllers/EmpruntController.php';
require_once '../controllers/BibliothecaireController.php';

session_start();

$empruntController = new EmpruntController($pdo);
$biblioController = new BibliothecaireController();

$utilisateurs = $empruntController->getUtilisateursAvecEmprunts();
// $biblioController->historiqueEmprunt();

//var_dump($utilisateurs);

// Traitement du formulaire pour sélectionner l'utilisateur
if (!empty($_POST['fk_utilisateur'])) {
    $user_email = $_POST['fk_utilisateur'];
    $livresEmpruntes = $empruntController->getLivresEnCoursPourUtilisateur($user_email);
    var_dump($livresEmpruntes);
}

if (isset($_POST['livre_id'])) {
    $user_email = $_POST['fk_utilisateur'];
    $livre_id = $_POST['id'];
    $date_retour = $_POST['date_retour'];

    $empruntController->rendreEmprunt($user_email, $livre_id, $date_retour);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Librio : Rendre Emprunt</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand" href="admin_page.php">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="empreuntCours.php">Emprunt En cours</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historiqueEmprunt.php">historique emprunt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <h1>Rendre Emprunt</h1>
        <hr>

        <!-- Formulaire pour sélectionner l'utilisateur -->
        <form method="POST">
            <div class="mb-3">
                <label for="fk_utilisateur" class="form-label">Sélectionner l'utilisateur :</label>
                <select class="form-select" id="fk_utilisateur" name="fk_utilisateur" onchange="this.form.submit()"
                    required>
                    <option selected disabled value="">Choisir...</option>
                    <?php foreach ($utilisateurs as $utilisateur) : ?>

                    <option value="<?= htmlspecialchars($utilisateur['fk_utilisateur']) ?>">
                        <?= htmlspecialchars($utilisateur['fk_utilisateur']) ?>

                    </option>

                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <!-- Formulaire pour rendre l'emprunt -->
        <?php if (!empty($_POST['fk_utilisateur'])) : ?>
        <form action="gestion_emp.php" method="POST">
            <input type="hidden" name="fk_utilisateur" value="<?= htmlspecialchars($_POST['fk_utilisateur']) ?>">
            <div class="mb-3">
                <label for="id" class="form-label">Sélectionner le livre à rendre :</label>
                <select class="form-select" id="id" name="id" required>
                    <option selected disabled value="">Choisir...</option>
                    <?php foreach ($livresEmpruntes as $livre) : ?>
                    <option value="<?= htmlspecialchars($livre['id']) ?>">
                        <?= htmlspecialchars($livre['titre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="date_retour" class="form-label">Date de retour :</label>
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
    </div>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>Historique des Emprunts</title>
    </head>

    <body>
        <h1>Historique des Emprunts</h1>
        <table border="2">
            <tr>
                <th>ID Emprunt</th>
                <th>ID Livre</th>
                <th>Email Emprunteur</th>
                <th>Date d'emprunt</th>
                <th>Date de retour prévue</th>
                <th>Date de retour</th>
                <th>État</th>
            </tr>
            <?php
            $sql = "SELECT *,
            DATE_ADD(date_emprunt, INTERVAL 30 DAY) AS date_retour_max,
            CASE
            WHEN date_retour > DATE_ADD(date_emprunt, INTERVAL 30 DAY) THEN 'Rendu après délai'
            ELSE 'Rendu avant délai'
            END AS etat
            FROM emprunts
            ORDER BY date_emprunt DESC";

            $stmt = $GLOBALS['pdo']->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll();

            if ($result) {
            foreach ($result as $emprunt){?>
            <tr>
                <td><?php echo $emprunt['id']; ?></td>
                <td><?php echo $emprunt['fk_livre']; ?></td>
                <td><?php echo $emprunt['fk_utilisateur']; ?></td>
                <td><?php echo $emprunt['date_emprunt']; ?></td>
                <td><?php echo $emprunt['date_retour_prevue']; ?></td>
                <td><?php echo $emprunt['date_retour']; ?></td>
                <td>
                    <?php
                        $date_retour = $emprunt['date_retour'];
                        $date_retour_prevue = $emprunt['date_retour_prevue'];
                        $etat = ($date_retour <= $date_retour_prevue) ? "Rendu avant délai" : "Rendu après délai";
                        echo $etat;
                        ?>
                </td>
            </tr>
            <?php
                        }
                    }?>
        </table>

        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <title>Liste des Emprunts en Cours</title>
        </head>

        <body>
            <h1>Liste des Emprunts en Cours</h1>
            <div class="table-responsive py-3 px-3">
                <table class="table table-bordered border-dark" border="2">
                    <thead>
                        <tr>
                            <th>ID Emprunt</th>
                            <th>ID Livre</th>
                            <th>Email Emprunteur</th>
                            <th>Date d'emprunt</th>
                            <th>Date de retour prévue</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </body>

        </html>
    </body>

    </html>
</body>

</html>