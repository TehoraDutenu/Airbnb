<?php

namespace App\Model;

use DateTime;
use App\Model\Toys;
use Core\Model\Model;

class Sales extends Model
{
    // - Déclarer propriétés, colonnes de la table
    public int $toy_id;
    public DateTime $date_sold;
    public int $quantity;

    // - Propriété de modélisation
    public ?Toys $toys = null;
}
