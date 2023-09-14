<?php

namespace Core\Session;

class Session extends SessionManager
{
    public const FORM_RESULT = 'FORM_RESULT';
    public const USER = 'USER';
    public const SUCCESS_MESSAGE = 'SUCCESS_MESSAGE';
    public const LOGOUT_SUCCESS_MESSAGE = 'LOGOUT_SUCCESS_MESSAGE';

    /**
     * Vérifie si une clé existe dans la session.
     *
     * @param string $key La clé à vérifier.
     *
     * @return bool True si la clé existe, sinon False.
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
}
