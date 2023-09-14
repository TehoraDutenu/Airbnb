<?php

namespace App\Model;

use App\Model\Bien;
use Core\Model\Model;
use DateTime;

class Disponibilite extends Model
{
    public string $bien_id;
    public DateTime $dispo_debut;
    public DateTime $dispo_fin;

    public ?Bien $bien = null;
}
