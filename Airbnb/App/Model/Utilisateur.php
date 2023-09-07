<?php

namespace App\Model;

use Core\Model\Model;

class Utilisateur extends Model
{
    public const ROLE_STANDARD = 0;
    public const ROLE_HOST = 1;

    public string $prenom;
    public string $nom;
    public string $email;
    public string $password;
    public string $telephone;
    public string $adresse;
    public bool $is_host;
}
