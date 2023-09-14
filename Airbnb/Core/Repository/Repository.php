<?php 
namespace Core\Repository;

use PDO;
use Core\Model\Model;
use Core\Database\Database;
use Core\Database\DatabaseConfigInterface;

abstract class Repository 
{
    protected PDO $pdo;

    abstract public function getTableName(): string;

    public function __construct(DatabaseConfigInterface $config)
    {
        $this->pdo = Database::getPDO($config);
    }

    protected function readAll(string $class_name): array
    {
        //on déclare un tableau vide
        $arr_result = [];
        //on crée la requete
        $q = sprintf("SELECT * FROM %s", $this->getTableName());
        //on execute la requete
        $stmt = $this->pdo->query($q);
        //si la requete n'est pas valide on retourne le tableau vide
        if(!$stmt) return $arr_result;
        //on boucle sur les données de la requete
        while($row_data = $stmt->fetch()){
            //on stock dans $arr_result un nouvel objet de la classe $class_name
            $arr_result[] = new $class_name($row_data);
        }
        //on retourne le tableau
        return $arr_result;
    }

    protected function readById(string $class_name, int $id): ?Model
    {
        
        //on crée la requete
        $q = sprintf("SELECT * FROM %s WHERE id=:id", $this->getTableName());
        //on prepare la requete
        $stmt = $this->pdo->prepare($q);
        //si la requete n'est pas valide on retourne le tableau vide
        if(!$stmt) return null;
        
        //on execute la requete
        $stmt->execute(['id' => $id]);
        //on recupère les résultats
        $row_data = $stmt->fetch();
        //on retourne un objet de la classe $class_name
        return !empty($row_data) ? new $class_name($row_data) : null;
    }

    protected function delete(int $id): bool
    {
        //on crée la requete
        $q = sprintf("DELETE FROM %s WHERE id=:id", $this->getTableName());
        //on prepare la requete
        $stmt = $this->pdo->prepare($q);
        //si la requete n'est pas valide on retourne le tableau false
        if(!$stmt) return false;
        
        //on execute la requete
        $stmt->execute(['id' => $id]);
        return true;
    }

}