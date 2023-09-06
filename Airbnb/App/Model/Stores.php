<?php

namespace App\Model;

use Core\Model\Model;

class Stores extends Model
{
    public string $name;
    public int $postal_code;
    public string $city;
}
