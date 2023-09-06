<?php

namespace Core\Model;

abstract class Model
{
    public int $id;

    public function __construct(array $data_row = [])
    {
        // - Injecter les données dans l'objet s'il y en a
        foreach ($data_row as $column => $value) {
            // - Si la propriété n'existe pas on passe à la suivante
            if (!property_exists($this, $column)) continue;
            // - Injecter la valeur dans la propriété
            $this->$column = $value;
        }
    }
}
