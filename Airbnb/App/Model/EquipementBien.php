<?php

namespace App\Model;

use App\Model\Bien;
use Core\Model\Model;
use App\Model\Equipement;

class EquipementBien extends Model
{
    public string $bien_id;
    public int $equipement_id;

    public ?Bien $bien = null;
    public ?Equipement $equipement = null;
}
