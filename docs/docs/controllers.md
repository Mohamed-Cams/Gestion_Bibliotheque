# Controllers Directory


###
The controllers directory contains the main business logic.


### AuthController
With method login() , the AuthController allows users to log into their account

```php
<?php
 public function login($email, $mdp)
    {
        // Log input values for debugging
        error_log("Inside login function - Email: $email, Password: $mdp");

        $user = $this->authModel->findUserByEmail($email);

        if ($user) {
            error_log("User found: " . print_r($user, true));
        } else {
            error_log("User not found with email: $email");
        }

        if ($user && $mdp == $user['mdp']) {
            echo "success";
            // Authentification réussie
            session_start();
            $_SESSION['user_id'] = $user['email'];

            $role = $this->authModel->findRoleById($user['role']);
            $_SESSION['role'] = $role['nom'];

            switch ($_SESSION['role']) {
                case 'admin':
                    header('Location: ./views/admin_page.php');
                    exit;
                case 'bibliothecaire':
                    header('Location: ./views/bibliothecaire_page.php');
                    exit;
                case 'utilisateur':
                    header('Location: ./views/utilisateur_page.php');
                    exit;
                default:
                    // Rediriger vers une page par défaut en cas de rôle inconnu
                    header('Location: ./acceuil.php');
                    exit;
            }
        } else {
            $error = 'Email ou mot de passe incorrect';
            error_log("Login failed: $error");
            return $error;
        }
    }
```


### BibliothecaireController
The BibliothecaireController hold many methods that operate with books management.

#### Example :
```php
<?php
  public function ajoutEmprunt()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_POST['User_id'];
            $livre_id = $_POST['Livre_id'];
            $date_emprunt = date('Y-m-d H:i:s');

            $errorMessage = "";
            $successMessage = "";

            $user = $this->bibliothecaire->getUserById($user_id);
            $livre = $this->bibliothecaire->getLivreById($livre_id);

            if ($user['Nb_emprunt'] >= 5) {
                $errorMessage = "Utilisateur a dépassé la limite des emprunts";
            } elseif ($livre['Nb_des_exemplaires'] <= 0) {
                $errorMessage = "Pas d'exemplaires disponibles pour ce livre pour le moment";
            } else {
                $empruntExist = $this->bibliothecaire->checkEmpruntExist($user_id, $livre_id);
                if ($empruntExist) {
                    $errorMessage = "Emprunt déjà existant";
                } else {
                    $this->bibliothecaire->ajouterEmprunt($user_id, $livre_id, $date_emprunt);
                    $this->bibliothecaire->decrementerExemplaires($livre_id);
                    $this->bibliothecaire->incrementerEmprunts($user_id);
                    $successMessage = "Vous avez ajouté un emprunt avec succès";
                }
            }

            include '../views/bibliothecaire/ajouterEmprunt.php';
        } else {
            include '../views/bibliothecaire/ajouterEmprunt.php';
        }
    }

```
### EmpruntController
The BibliothecaireController hold many methods that operate with books loan management.

#### Example :
```php

<?php
 public function rendreEmprunt($user_email, $livre_id, $date_retour)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                $_SESSION['ErrorMessage'] = "Vous devez être connecté en tant qu'bibliothecaire pour rendre un emprunt.";
                exit;
            }


            try {
                $message = $this->empruntModel->rendreEmprunt($user_email, $livre_id, $date_retour);
                $_SESSION['SuccessMessage'] = $message;
            } catch (Exception $e) {
                $_SESSION['ErrorMessage'] = $e->getMessage();
            }


            echo "changer";
            //header("Location: ../../views/bibliothecaire/supprimerLivre.php");
            //exit;
        }
    }

```
