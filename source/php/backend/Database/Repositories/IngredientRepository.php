<?php
declare(strict_types=1);

namespace RecipeManager\Database\Repositories;

use Exception;
use RecipeManager\Database\Models\Ingredient;
use RecipeManager\Database\Models\IngredientType;

final class IngredientRepository extends Repository
{
    #[\Override] public function get(int $id): ?Ingredient
    {
        $sql = "SELECT 
    id, name, type, type_argument
FROM ingrediant
WHERE ingrediant.id = ?
LIMIT 1";

        $result = $this->database->query($sql, $id);
        if (!$result) {
            throw new Exception("Couldn't query for recipe with id '$id'");
        }

        $valueArray = $result->fetch();
        if (!$valueArray) {
            return null;
        }

        return $this->createModel($valueArray);
    }

    /**
     * @return Ingredient[]
     * @throws Exception
     */
    public function getAll(): array {
        $sql = "SELECT 
    id, name, type, type_argument
FROM ingrediant";

        $result = $this->database->query($sql);
        if (!$result) {
            throw new Exception("Couldn't query for recipes");
        }

        $resultingData = [];
        while ($row = $result->fetch()) {
            $resultingData[] = $this->createModel($row);
        }

        return $resultingData;
    }

    /**
     * @param array{id: int, name: string, type: string, type_argument: string} $values
     * @return Ingredient
     */
    #[\Override] public function createModel(array $values): Ingredient
    {
        return new Ingredient(
            $values['id'],
            $values['name'],
            IngredientType::from($values['type']),
            $values['type_argument']
        );
    }
}