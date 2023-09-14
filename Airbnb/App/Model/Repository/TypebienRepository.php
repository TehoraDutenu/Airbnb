<?php

namespace App\Model\Repository;

use App\Model\Typebien;
use Core\Repository\Repository;
use Core\Repository\AppRepoManager;

class TypebienRepository extends Repository
{
    public function getTableName(): string
    {
        return 'type_bien';
    }

    public function findAll()
    {
        return $this->readAll(Typebien::class);
    }

    public function getTypeByLabel(): array
    {
        // - Créer la requête qui recupère la liste des types de biens
        $q = sprintf(
            'SELECT `%1$s`.label AS typebien
            FROM `%1$s`',
            $this->getTableName()
        );
        $typesDeBien = [];

        // - Exécuter la requête
        $stmt_typebien = $this->pdo->query($q);
        if (!$stmt_typebien) {
            echo "La requête SQL a échoué : " . $this->pdo->errorInfo()[2];
            return $typesDeBien;
        }
        while ($row_data = $stmt_typebien->fetch()) {
            $typesDeBien[] = $row_data['typebien'];
        }
        return $typesDeBien;
    }
}
