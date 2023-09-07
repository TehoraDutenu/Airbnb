<?php

namespace App\Model;

use Core\Model\Model;

class Utilisateur extends Model
{
    public int $utilisateur_id;
    public string $label;
    public string $description;
    public string $adresse;
    public int $type_bien;
    public int $taille;
    public int $nbr_pieces;
    public int $nbr_couchages;
    public bool $are_animals;
}
