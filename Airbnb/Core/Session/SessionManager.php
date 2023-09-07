<?php

namespace Core\Session;

abstract class SessionManager
{
    // - Alimenter la session
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    // - Récupérer la session
    public static function get(string $key)
    {
        if (!isset($_SESSION[$key])) return null;
        return $_SESSION[$key];
    }

    // - Supprimer la session
    public static function remove(string $key): void
    {
        // - Vérifier qu'il y a bien une session
        if (!self::get($key)) return;
        // - La supprimer si elle existe
        unset($_SESSION[$key]);
    }
}
