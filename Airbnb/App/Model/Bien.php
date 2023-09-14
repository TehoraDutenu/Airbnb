<?php

namespace App\Model;

use App\Model\Typebien;
use App\Model\Utilisateur;
use Core\Model\Model;

class Bien extends Model
{
    public const ANIMALS_NO = 0;
    public const ANIMALS_YES = 1;


    public int $utilisateur_id;
    public string $label;
    public string $description;
    public string $adresse;
    public int $typebien_id;
    public int $taille;
    public int $nbre_pieces;
    public int $nbre_couchages;
    public bool $are_animals;
    public int $prix_nuitee;

    public ?Utilisateur $utilisateur = null;
    public ?Typebien $typebien = null;
}
