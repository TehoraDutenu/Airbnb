<?php

namespace Core\Session;

class SessionManager
{
    //pour pouvoir alimenter notre session
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    //pour pouvoir récupérer notre session
    public static function get(string $key)
    {
        if(!isset($_SESSION[$key])) return null;
        return $_SESSION[$key];
    }

    //pour pouvoir vider la session
    public static function remove(string $key): void
    {
        //si j'essaye de supprimer une session qui n'existe pas, je ne fais rien
        if (!self::get($key)) return;
        //sinon je supprime la session
        unset($_SESSION[$key]);
    }
}
