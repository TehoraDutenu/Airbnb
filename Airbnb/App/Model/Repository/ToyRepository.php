<?php

namespace App\Model\Repository;

use App\Model\Toys;
use App\Model\Brands;
use Core\Session\Session;
use Core\Repository\Repository;
use App\Controller\AuthController;
use Core\Repository\AppRepoManager;


class ToyRepository extends Repository
{
    public function getTableName(): string
    {
        return 'toys';
    }

    public function findAll(): array
    {
        return $this->readAll(Toys::class);
    }

    public function findById(int $id)
    {
        return $this->readById(Toys::class, $id);
    }

    public function findByIdWithBrand(int $id): ?Toys
    {
        // - Obtenir un tableau avec toutes les infos de toys et le nom de brand
        /* OU
        SELECT toys.*, brand.name AS brand_name
        FROM toys
        INNER JOIN brands
        ON toys.brand_id =brands.id
        WHERE toys.id = :id
        */
        $q = sprintf(
            'SELECT `%1$s`.*, `%2$s` .name AS brand_name
            FROM `%1$s`
            INNER JOIN `%2$s`
            ON `%1$s` .brand_id = `%2$s` .id
            WHERE `%1$s` .id = :id',

            // - Donner la valeur de %1$s qui correspond à toys
            $this->getTableName(),
            // - Donner la valeur de %2$s qui correspond à brands
            // - Elle est récupérée à travers notre AppRepoManager
            AppRepoManager::getRm()->getBrandRepo()->getTableName()
        );

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);
        if (!$stmt) return null;

        // - Exécuter la requête
        $stmt->execute(['id' => $id]);

        // - Récupérer le résultat
        $row_data = $stmt->fetch();

        // - Retourner null s'il n'y a pas de résultat
        if (empty($row_data)) return null;

        // - L'hydratant ne remplit que les données qu'il connait
        $toy = new Toys($row_data);

        // - Reconstituer un tableau pour hydrater Brands
        $brand_data = [
            'id' => $toy->brand_id,
            'name' => $row_data['brand_name']
        ];

        // - Créer un objet Brands qu'on hydrate
        $brand = new Brands($brand_data);

        // - Ajouter l'objet brand à toy
        $toy->brands = $brand;

        return $toy;
    }

    public function findToysByBrand(int $brand_id): ?array
    {
        // - Créer la requête
        $q = sprintf(
            'SELECT * FROM `%s` WHERE brand_id = :brand_id',
            $this->getTableName()
        );

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);

        // - Vérifier que la requête est bien préparée
        if (!$stmt) return null;

        // - Exécuter la requête
        $stmt->execute(['brand_id' => $brand_id]);

        // - Boucler sur les résultats
        while ($row_data = $stmt->fetch()) {
            $toys[] = new Toys($row_data);
        }
        // - Retourner le tableau des jouets
        return $toys;
    }

    // - Insérer un jouet en BDD
    public function insert(array $data): bool
    {
        // - Créer la requête
        $q = sprintf(
            'INSERT INTO `%s` (`name`, `description`, `brand_id`, `price`, `image`, `slug`)
        VALUES (:name, :description, :brand_id, :price, :image, :slug)',
            $this->getTableName()
        );

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);

        // - Vérifier que la requête est bien préparée
        if (!$stmt) return false;

        // - Exécuter la requête
        $stmt->execute($data);
        return true;
    }

    public function update(array $data)
    {
        // - Stocker l'id avant de l'unset
        $id = $data['id'];
        // - Enlever un élément du tableau avec unset
        unset($data['id']);

        // - Reconstruire une string dans le foreach avec clé = valeur séparés par des virgules
        // - Déclarer un tableau vide
        $keysArray = [];
        // - Remplir dans le foreach le tableau déclaré auparavant
        foreach ($data as $key => $value) {
            $keysArray[] = $key . "=:" . $key;
        }
        $keysString = implode(', ', $keysArray);

        // - Créer la requête
        $q = sprintf('UPDATE `%1$s` SET %2$s WHERE id = %3$s', $this->getTableName(), $keysString, $id);

        // - Préparer la requête
        $stmt = $this->pdo->prepare($q);

        // - Vérifier la préparation
        if (!$stmt) return false;

        // - Exécuter la requête
        $stmt->execute($data);
        return true;
    }

    public function deletetoy(int $id): bool
    {
        return $this->delete($id);
    }
}
