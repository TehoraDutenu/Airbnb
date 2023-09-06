<?php

namespace App\Model\Repository;

use App\Model\Users;
use Core\Repository\Repository;

class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return 'users';
    }

    public function checkAuth(string $email, string $password): ?Users
    {
        // - Créer la requête
        $query = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email AND `password` = :password',
            $this->getTableName()
        );

        // - Préparer la requête
        $stmt = $this->pdo->prepare($query);

        // - Vérifier que la requête est bien préparée
        if (!$stmt) return null;

        // - Exécuter la requête
        $stmt->execute([
            'email' => $email,
            'password' => $password
        ]);

        $user_data = $stmt->fetch();
        return empty($user_data) ? null : new Users($user_data);
    }

    // - Récupérer la liste des utilisateurs
    public function findAll(): array
    {
        return $this->readAll(Users::class);
    }

    public function findById(int $id): ?Users
    {
        return $this->readById(Users::class, $id);
    }

    // - Updater l'utilisateur
    public function updateUserById(string $email, int $role, int $id): ?Users
    {
        // - Créer la requête
        $q = sprintf(
            'UPDATE `%s` SET `email` = :email, `role` = :role WHERE `id` = :id',
            $this->getTableName()
        );

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);

        // - Vérifier qu'elle est bien préparée
        if (!$stmt) return null;

        // - Exécuter
        $stmt->execute([
            'email' => $email,
            'role' => $role,
            'id' => $id
        ]);

        // - Récupérer les données
        $user_data = $stmt->fetch();

        // - Instancier Users
        return empty($user_data) ? null : new Users($user_data);
    }

    // - Supprimer un utilisateur
    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }

    // - Créer un nouvel utilisateur
    public function createUser(string $email, string $password, int $role)
    {
        // - Créer la requête
        $q_insert = sprintf(
            'INSERT INTO `%s` (`email`, `password`, `role`)
            VALUES (:email, :password, :role)',
            $this->getTableName()
        );

        // - Vérifier qu'un utilisateur n'a pas déjà été créé
        $q_select = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email',
            $this->getTableName()
        );

        // - Préparer la requête select
        $stmt_select = $this->pdo->prepare($q_select);

        // - Vérifier que select est bien préparée
        if (!$stmt_select) return null;

        // - Exécuter la requête
        $stmt_select->execute([
            'email' => $email
        ]);

        // - Récupérer les données
        $user_data = $stmt_select->fetch();

        // - Vérifier le résultat, s'il y en a un retourner false
        if (!empty($user_data)) return false;

        // - Sinon préparer la requête d'insertion
        $stmt_insert = $this->pdo->prepare($q_insert);

        // - Vérifier que q_insert est bien préparée
        if (!$stmt_insert) return null;

        // - Exécuter la requête
        $stmt_insert->execute([
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);
        return true;
    }
}
