<?php

namespace App\Model;

use App\Model\Brands;
use Core\Model\Model;


class Toys extends Model
{
    // - Déclarer propriétés, colonnes de la table
    public string $name;
    public string $description;
    public int $brand_id;
    public float $price;
    public string $image;
    public string $slug;

    // - Propriété de modélisation
    public ?Brands $brands = null;
}
