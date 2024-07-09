<?php

use EmpruntController;
use BibliothecaireController;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../controllers/BibliothecaireController.php';
require_once '../controllers/EmpruntController.php';

$controller = new BibliothecaireController();
$empcontroller = new EmpruntController($pdo);

/* $view =  __DIR__ . '/../views/bibliothecaire/listeLivres.php'; */ // Vue par défaut

if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'ajouterLivre':
      $view = __DIR__ . '/../views/admin_page.php';
      $controller->ajouterLivre();
      break;
    case 'modifierLivre':
      /*  $view = __DIR__ . '/../views/bibliothecaire/modifierLivre.php'; */
      $controller->modifierLivre($_GET['id']);
      break;
    case 'supprimerLivre':
      /* $view = __DIR__ . '/../views/bibliothecaire/supprimerLivre.php'; */
      $controller->supprimerLivre($_GET['id']);
      break;
    case 'listeLivres':
      //$view = __DIR__ . '/../views/bibliothecaire/listeLivres.php';
      $controller->listeLivres();
      break;
    case 'historiqueEmprunt':
      /*    $view = __DIR__ . '/../views/bibliothecaire/historiqueEmprunt.php'; */
      $controller->historiqueEmprunt();
      break;
    case 'listerUtilisateurs':
      // $view = __DIR__ . '/../views/bibliothecaire/listerUtilisateurs.php';
      $controller->listerUtilisateurs();
      break;
    case 'empruntsEnCours':
      /*   $view =  __DIR__ . '/../views/bibliothecaire/empruntsEnCours.php'; */
      $controller->empruntsEnCours();
      break;

      /*case 'ajouterEmprunt':
            $view = __DIR__ . '/../views/bibliothecaire/ajoutEmprunt.php';
            $empcontroller->ajouterEmprunt();
            break;*/
    case 'logout':
      echo "logout";
      //$view =  __DIR__ . '../views/auth/login.php';
      $controller->logout();
      break;
    default:
      break;
  }
}

include '../views/navbar.php';
include '../views/includes/menu.php';
//include $view;