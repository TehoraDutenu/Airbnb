<?php

namespace App\Model\Repository;

use Core\Form\FormError;
use App\Model\Utilisateur;
use Core\Repository\Repository;
use Core\Form\FormResult;

class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return 'utilisateur';
    }

    public function checkAuth(string $email, string $password): ?Utilisateur
    {
        // - Créer la requête
        $q = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email AND `password` = :password',
            $this->getTableName()
        );

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);

        // - Vérifier que la requête est bien préparée
        if (!$stmt) return null;

        // - Exécuter la requête
        $stmt->execute([
            'email' => $email,
            'password' => $password
        ]);

        // - Récupérer les données
        $user_data = $stmt->fetch();

        //on instancie un objet User
        return empty($user_data) ? null : new Utilisateur($user_data);
    }

    public function findUserById(int $id)
    {
        return $this->readById(Utilisateur::class, $id);
    }


    // - Inscription d'un nouvel utilisateur
    public function subscribe(string $prenom, string $nom, string $email, string $telephone, string $adresse, string $password)
    {
        // - Créer la requête d'insertion
        $q_insert = sprintf(
            'INSERT INTO `%s` (`prenom`,`nom`, `email`, `telephone`, `adresse`, `password`) 
                VALUES (:prenom, :nom, :email, :telephone, :adresse, :password)',
            $this->getTableName()
        );
        // - Créer une requête pour savoir si un utilisateur existe déjà
        $q_select = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email',
            $this->getTableName()
        );

        //- Préparer la requête select
        $stmt_select = $this->pdo->prepare($q_select);
        // - Vérifier que la requête est bien préparée
        if (!$stmt_select) return false;

        // - Exécuter la requête
        $stmt_select->execute([
            'email' => $email
        ]);

        // - Récupérer les données
        $user_data = $stmt_select->fetch();

        // - En cas de résultat
        if (!empty($user_data)) return false;

        // - Sinon préparer l'insertion
        $stmt_insert = $this->pdo->prepare($q_insert);
        // - Vérifier que la requête est bien préparée
        if (!$stmt_insert) return false;

        // - Exécuter la requête
        $stmt_insert->execute([
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'telephone' => $telephone,
            'adresse' => $adresse,
            'password' => $password
        ]);

        return true;
    }
}
