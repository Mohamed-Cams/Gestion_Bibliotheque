<?php
// AuthController.php

require_once __DIR__ . '/../models/AuthModel.php';

class AuthController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

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
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];

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
}
