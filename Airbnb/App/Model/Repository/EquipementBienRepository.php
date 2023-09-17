<?php

namespace App\Model\Repository;

use PDO;
use Core\Repository\Repository;
use Core\Repository\AppRepoManager;

class EquipementBienRepository extends Repository
{
    public function getTableName(): string
    {
        return 'equipement_bien';
    }

    public function getEquipByBien(int $id, string $label)
    {
        $arr_result = [];

        $q = sprintf(
            'SELECT %1$s.id AS mix_id, %2$s.id AS bien_id, %3$s.id AS equipement_id, %3$s.label
           FROM %1$s
           INNER JOIN %2$s ON %2$s.id = bien_id,
           INNER JOIN %3$s ON %3$s.id = equipement_id AND %3$s.label = :label,
           WHERE %1$s.id = :mix_id',
            $this->getTableName(),
            AppRepoManager::getRm()->getBienRepo()->getTableName(),
            AppRepoManager::getRm()->getEquipementRepo()->getTableName()
        );

        $stmt = $this->pdo->prepare($q);
        if (!$stmt) return $arr_result;

        $stmt->bindParam(':mix_id', $id);
        $stmt->bindParam(':label', $label, PDO::PARAM_STR);

        $stmt->execute();


        return $arr_result;
    }
}
