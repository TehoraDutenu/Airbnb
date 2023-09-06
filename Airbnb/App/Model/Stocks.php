<?php

namespace App\Model;

use App\Model\Toys;
use App\Model\Stores;
use Core\Model\Model;


class Stocks extends Model
{
    // - Déclarer propriétés, colonnes de la table
    public int $toy_id;
    public int $store_id;
    public int $quantity;

    // - Propriété de modélisation
    public ?Toys $toy = null;
    public ?Stores $stores = null;
}
