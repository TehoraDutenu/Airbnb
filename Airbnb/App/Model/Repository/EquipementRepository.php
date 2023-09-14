<?php

namespace App\Model\Repository;

use App\Model\Equipement;
use Core\Repository\Repository;

class EquipementRepository extends Repository
{
    public function getTableName(): string
    {
        return 'equipement';
    }

    public function findAll()
    {
        return $this->readAll(Equipement::class);
    }
}
