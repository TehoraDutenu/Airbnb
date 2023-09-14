<?php

namespace Core\Database;

use PDO;
//Design Pattern Singleton (ne peut etre instanciée qu'une seule fois)
class Database
{
    private static ?PDO $pdoInstance = null;

    private const PDO_OPTIONS = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    //on crée une méthode statique qui va nous permettre de récupérer une instance de PDO
    //on lui passe en paramètre une instance de DatabaseConfigInterface
    public static function getPDO(DatabaseConfigInterface $config): PDO
    {
        //si l'instance de PDO n'a jamais été instanciée, on la crée
        if (is_null(self::$pdoInstance)) {
            //$dsn = 'mysql:dbname=site_mvc;host=database';
            $dsn = sprintf('mysql:dbname=%s;host=%s', $config->getName(), $config->getHost());
            self::$pdoInstance = new PDO(
                $dsn,
                $config->getUser(), //ici les info de l'utilisateur
                $config->getPass(), //ici le mot de passe
                self::PDO_OPTIONS
            );
        }
        //on retourne l'instance de PDO
        return self::$pdoInstance;
    }
    //on declare le constructeur en private pour bloquer l'instanciation de la classe
    private function __construct()
    {
    }
    //on declare la methode clone en private pour bloquer le clonage de la classe
    private function __clone()
    {
    }
    //on declare la methode wakeup en private pour bloquer la deserialisation de la classe
    public function __wakeup()
    {
    }
}
