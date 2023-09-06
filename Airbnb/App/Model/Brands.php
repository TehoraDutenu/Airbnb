<?php

namespace App\Model;

use Core\Model\Model;


class Brands extends Model
{
    // - Déclarer propriétés/colonnes de la table
    public string $name;
    public int $nb_toys;
}
