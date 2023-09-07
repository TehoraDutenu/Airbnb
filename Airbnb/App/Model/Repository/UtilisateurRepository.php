<?php

namespace App\Model\Repository;

use App\Model\Utilisateur;
use Core\Repository\Repository;


class UtilisateurRepository extends Repository
{
    public function getTableName(): string
    {
        return 'utilisateur';
    }

    public function checkAuth(string $email, string $password): ?Utilisateur
    {
        // - Requête
        $q = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email AND `password` = :password',
            $this->getTableName()
        );
        var_dump($q);
        die();

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);
        if (!$stmt) return null;

        // - Exécuter la requête
        $stmt->execute([
            'email' => $email,
            'password' => $password
        ]);

        // - Récupérer les données, instancier Utilisateur
        $utilisateur_data = $stmt->fetch();
        return empty($utilisateur_data) ? null : new Utilisateur($utilisateur_data);
    }
}
