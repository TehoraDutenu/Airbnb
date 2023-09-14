<?php

namespace App\Model;

use App\Model\Bien;
use Core\Model\Model;
use App\Model\Utilisateur;
use DateTime;

class Reservation extends Model
{
    public int $utilisateur_id;
    public string $bien_id;
    public DateTime $arrivee;
    public DateTime $depart;

    public ?Utilisateur $utilisateur = null;
    public ?Bien $bien = null;
}
