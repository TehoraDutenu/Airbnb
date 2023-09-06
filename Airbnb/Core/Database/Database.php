<?php

namespace Core\Database;

use PDO;

// - Design Pattern Singletoon (ne peut être instanciée qu'une seule fois)
class Database
{
    private static ?PDO $pdoInstance = null;

    private const PDO_OPTIONS = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // - Créer méthode statique pour récupérer une instance de PDO avec en paramètre une instance de DatabaseConfigInterface
    public static function getPDO(DatabaseConfigInterface $config): PDO
    {
        if (is_null(self::$pdoInstance)) {

            // - $dsn = 'mysql:dbname=site_mvc;host=database';
            $dsn = sprintf('mysql:dbname=%s;host=%s', $config->getName(), $config->getHost());

            self::$pdoInstance = new PDO($dsn, $config->getUser(), $config->getPass(), self::PDO_OPTIONS);
        }
        return self::$pdoInstance;
    }

    // - Déclarer le contructeur en private pour bloquer l'instanciation de la classe 
    private function __construct()
    {
    }

    // - Bloquer le clonage de la classe
    private function __clone()
    {
    }

    // - Métode wakeup pour bloquer la déserialisation de la classe
    public function __wakeup()
    {
    }
}
