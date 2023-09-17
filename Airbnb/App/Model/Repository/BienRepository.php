<?php

namespace App\Model\Repository;

use App\Model\Bien;
use App\Model\Equipement;
use App\Model\EquipementBien;
use Core\Repository\Repository;
use Core\Repository\AppRepoManager;

class BienRepository extends Repository
{
    public function getTableName(): string
    {
        return 'bien';
    }

    public function findAll(): array
    {
        return $this->readAll(Bien::class);
    }

    public function findById(int $id)
    {
        return $this->readById(Bien::class, $id);
    }

    public function insertBien(int $utilisateur_id, string $label, string $description, string $adresse, int $typebien_id, int $taille, int $nbre_pieces, int $nbre_couchages, bool $are_animals, int $prix_nuitee, array $photo)
    {
        // - Créer la requête d'insertion
        $q_insert = sprintf(
            'INSERT INTO `%s` (`utilisateur_id`,`label`, `description`, `adresse`, `typebien_id`, `taille`, `nbre_pieces`, `nbre_couchages`, `are_animals`, `prix_nuitée`) 
                VALUES (:utilisateur_id, :label, :description, :adresse, :typebien_id, :taille, :nbre_pieces, :nbre_couchages, :are_animals, :prix_nuitee)',
            $this->getTableName(),
        );
        // - Créer une requête pour savoir si ce bien est déjà enregistré
        $q_select = sprintf(
            'SELECT * FROM `%s` WHERE `label` = :label AND `adresse` = :adresse',
            $this->getTableName()
        );

        //- Préparer la requête select
        $stmt_select = $this->pdo->prepare($q_select);
        // - Vérifier que la requête est bien préparée
        if (!$stmt_select) return false;

        // - Exécuter la requête
        $stmt_select->execute([
            'label' => $label,
            'adresse' => $adresse
        ]);

        // - Récupérer les données
        $bien_data = $stmt_select->fetch();

        // - En cas de résultat
        if (!empty($bien_data)) return false;

        // - Sinon préparer l'insertion
        $stmt_insert = $this->pdo->prepare($q_insert);
        // - Vérifier que la requête est bien préparée
        if (!$stmt_insert) return false;

        // - Exécuter la requête
        $stmt_insert->execute([
            'utilisateur_id' => $utilisateur_id,
            'label' => $label,
            'description' => $description,
            'adresse' => $adresse,
            'typebien_id' => $typebien_id,
            'taille' => $taille,
            'nbre_pieces' => $nbre_pieces,
            'nbre_couchages' => $nbre_couchages,
            'are_animals' => $are_animals,
            'prix_nuitee' => $prix_nuitee
        ]);

        // - Récupérer l'ID du bien crée
        $bien_id = $this->pdo->lastInsertId();

        // - Gérer les images
        if (!empty($photos)) {
            foreach ($photos as $photo) {
                $q_insert_photo = 'INSERT INTO `photo` (`bien_id`, `image_path`) VALUES (:bien_id, :image_path)';
                $stmt_insert_photo = $this->pdo->prepare($q_insert_photo);

                if ($stmt_insert_photo) {
                    $image_path = 'img/photos_bien' . $photo['image_path'];

                    $stmt_insert_photo->execute([
                        'bien_id' => $bien_id,
                        'image_path' => $image_path
                    ]);
                }
            }
        }
        return true;
    }
}
