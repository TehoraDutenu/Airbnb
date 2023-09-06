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
        // - Déclarer un tableau vide
        $arr_result = [];

        // - Créer la requête
        $q = sprintf("SELECT * FROM %s", $this->getTableName());

        // - Exécuter la requête
        $stmt = $this->pdo->query($q);

        // - Si la requête n'est pas valide, retourner tableau vide
        if (!$stmt) return $arr_result;

        // - Boucler sur les données de la requête
        while ($row_data = $stmt->fetch()) {

            // - Stocker dans $arr_result un nouvel objet de la classe $class_name
            $arr_result[] = new $class_name($row_data);
        }
        // - Retourner le tableau
        return $arr_result;
    }

    protected function readById(string $class_name, int $id): ?Model
    {
        // - Créer la requête
        $q = sprintf("SELECT * FROM %s WHERE id=:id", $this->getTableName());

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);

        // - Si la requête n'est pas valide, retourner tableau vide
        if (!$stmt) return null;

        // - Exécuter la requête
        $stmt->execute(['id' => $id]);

        // - Récupérer les résultats
        $row_data = $stmt->fetch();

        // - Retourner l'objet $class_name
        return !empty($row_data) ? new $class_name($row_data) : null;
    }

    protected function delete(int $id)
    {
        // - Créer la requête
        $q = sprintf('DELETE FROM %s WHERE id = :id', $this->getTableName());

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);

        // - Si la requête n'est pas valide
        if (!$stmt) return false;

        // - Exécuter la requête
        $stmt->execute((['id' => $id]));
        return true;
    }
}
