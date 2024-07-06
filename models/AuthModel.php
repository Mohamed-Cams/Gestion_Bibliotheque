<?php
// AuthModel.php

require_once __DIR__ . '/../config/config.php';

class AuthModel
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function findUserByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM personnes WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findRoleById($roleId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM roles WHERE id = ?');
        $stmt->execute([$roleId]);
        return $stmt->fetch();
    }
}
