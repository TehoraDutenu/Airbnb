<?php

namespace App\Model;

use Core\Model\Model;

class Users extends Model
{
    public const ROLE_SUBSCRIBER = 1;
    public const ROLE_ADMINISTRATOR = 2;

    public string $email;
    public string $password;
    public int $role;
}
