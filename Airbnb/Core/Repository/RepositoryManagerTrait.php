<?php

namespace Core\Repository;
/* 
Un trait permet de gérer une portion de code qui peut être réutilisée dans plusieurs classes.
sans notion de hiérarchie.
self: ici représente la classe qui appel le trait
lien de la doc qui parle du trait: https://www.php.net/manual/fr/language.oop5.traits.php
*/
trait RepositoryManagerTrait
{
    private static ?self $rm_instance = null;
    //design pattern singleton
    public static function getRm(): self
    {
        if (is_null(self::$rm_instance)) {
            self::$rm_instance = new self();
        }
        return self::$rm_instance;
    }

    protected function __construct()
    {
    }
    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
