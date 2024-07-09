<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../controllers/BibliothecaireController.php';
require_once '../controllers/EmpruntController.php';
require_once '../controllers/RendreEmpruntController.php';

$controller = new BibliothecaireController();
$empcontroller = new EmpruntController($pdo);
//$rencontroller =new RendreEmpruntController($pdo);

$view =  __DIR__ . '/../views/bibliothecaire/listeLivres.php'; // Vue par défaut

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'ajouterLivre':
            $view = __DIR__ . '/../views/bibliothecaire/ajouterLivre.php';
            $controller->ajouterLivre();
            break;
        case 'modifierLivre':
            $view = __DIR__ . '/../views/bibliothecaire/modifierLivre.php';
            $controller->modifierLivre($_GET['id']);
            break;
        case 'supprimerLivre':
            $view = __DIR__ . '/../views/bibliothecaire/supprimerLivre.php';
            $controller->supprimerLivre($_GET['id']);
            break;
        case 'listeLivres':
            //$view = __DIR__ . '/../views/bibliothecaire/listeLivres.php';
            $controller->listeLivres();
            break;
        case 'historiqueEmprunt':
            $view = __DIR__ . '/../views/bibliothecaire/historiqueEmprunt.php';
            $controller->historiqueEmprunt();
            break;
        case 'listerUtilisateurs':
            $view = __DIR__ . '/../views/bibliothecaire/listerUtilisateurs.php';
            $controller->listerUtilisateurs();
            break;
        case 'empruntsEnCours':
            $view =  __DIR__ . '../views/bibliothecaire/empruntsEnCours.php';
            $controller->empruntsEnCours();
            break;
        case 'ajouterEmprunt':
            $view = __DIR__ . '/../views/bibliothecaire/ajoutEmprunt.php';
            $empcontroller->ajouterEmprunt();
            break;

        case 'rendreEmprunt':
            $view = __DIR__ . '/../views/bibliothecaire/rendreEmprunt.php';
            $rencontroller->rendreEmprunt();
            break;
        case 'logout':
            $controller->logout();
            break;
        default:
            break;
    }
}

include '../views/navbar.php';
include '../views/includes/menu.php';
include $view;
