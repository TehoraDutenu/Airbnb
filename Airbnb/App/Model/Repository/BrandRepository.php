<?php

namespace App\Model\Repository;

use App\Model\Brands;
use Core\Repository\AppRepoManager;
use Core\Repository\Repository;

class BrandRepository extends Repository
{
    public function getTableName(): string
    {
        return 'brands';
    }

    public function findAll()
    {
        return $this->readAll(Brands::class);
    }

    public function getBrandByName(): ?array
    {
        // - Requête pour récupérer la liste des marques avec le nombre de jeux qu'elles comprennent
        $q = sprintf(
            'SELECT `%1$s` .id, `%1$s` .name, COUNT(`%2$s` .id) AS nb_toys        
            FROM `%1$s`
            INNER JOIN `%2$s`
            ON `%1$s` .id = `%2$s` .brand_id
            GROUP BY `%1$s` .id',
            $this->getTableName(),

            // - Récupérer la table toys à travers AppRepoManager
            AppRepoManager::getRm()->getToyRepo()->getTableName()
        );

        // - Exécuter la requête
        $stmt_brand = $this->pdo->query($q);
        if (!$stmt_brand) return null;
        while ($row_data = $stmt_brand->fetch()) {
            $brands[] = new Brands($row_data);
        }
        return $brands;
    }
}
