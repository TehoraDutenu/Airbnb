<?php

namespace App\Model;

use App\Model\Bien;
use Core\Model\Model;

class Photo extends Model
{
    public string $image_path;
    public string $slug;
    public string $bien_id;

    public ?Bien $bien = null;
}
