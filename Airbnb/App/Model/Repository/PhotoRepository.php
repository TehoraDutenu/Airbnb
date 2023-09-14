<?php


namespace App\Model\Repository;

use Core\Repository\Repository;

class PhotoRepository extends Repository
{
    public function getTableName(): string
    {
        return 'photo';
    }

    public function insertPhoto(string $image_path, string $slug)
    {
        $q_insert = sprintf(
            'INSERT INTO `%s` (`image_path`, `slug`)
            VALUES (:image_path, :slug)',
            $this->getTableName()
        );

        $q_select = sprintf(
            'SELECT * FROM `%s` WHERE `image_path` = :image_path',
            $this->getTableName()
        );

        // - Préparer select
        $stmt_select = $this->pdo->prepare($q_select);
        if (!$stmt_select) return false;

        // - Exécuter
        $stmt_select->execute([
            'image_path' => $image_path,
            'slug' => $slug
        ]);

        // - Récupérer les données
        $photo_data = $stmt_select->fetch();
        if (!empty($photo_data)) return false;

        // - Préparer l'insertion
        $stmt_insert = $this->pdo->prepare($q_insert);
        if (!$stmt_insert) return false;

        // - Exécuter
        $stmt_insert->execute([
            'image_path' => $image_path,
            'slug' => $slug
        ]);
    }
}
