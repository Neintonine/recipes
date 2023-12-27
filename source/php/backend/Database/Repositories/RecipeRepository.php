<?php
declare(strict_types=1);

namespace RecipeManager\Database\Repositories;

use RecipeManager\Database\Database;
use RecipeManager\Database\Models\Recipe;

final class RecipeRepository extends Repository
{
    public function __construct(
        Database $database,
        private SourceRepository $sourceRepository
    )
    {
        parent::__construct($database);
    }

    #[\Override] public function get(int $id): ?Recipe
    {
        $sql = "SELECT recipe.id,
       recipe.name,
       recipe.portions,
       recipe.calorine,
       recipe.prepration_time,
       recipe.source_argument,
       s.id as source_id,
       s.name as source_name,
       s.type as source_type
FROM recipe
    LEFT JOIN recipes.source s on recipe.fk_source = s.id
WHERE recipe.id = ?
LIMIT 1";

        $result = $this->database->query($sql, $id);
        if (!$result) {
            throw new \Exception("Couldn't query for recipe with id '$id'");
        }

        $valueArray = $result->fetch();
        if (!$valueArray) {
            return null;
        }

        return $this->createModel($valueArray);
    }

    /**
     * @return Recipe[]
     */
    #[\Override] public function getAll(): array
    {
        $sql = "SELECT recipe.id,
       recipe.name,
       recipe.portions,
       recipe.calorine,
       recipe.prepration_time,
       recipe.source_argument,
       s.id as source_id,
       s.name as source_name,
       s.type as source_type
FROM recipe
    LEFT JOIN recipes.source s on recipe.fk_source = s.id";

        $result = $this->database->query($sql);
        if (!$result) {
            throw new \Exception("Couldn't query for recipes");
        }

        $resultingData = [];
        while ($row = $result->fetch()) {
            $resultingData[] = $this->createModel($row);
        }

        return $resultingData;
    }

    /**
     * @param array{id: int, name: string, portions: int, calorine: int, prepration_time: string, source_argument: ?string, source_id: ?string, source_name: ?string, source_type: ?string} $values
     */
    #[\Override] public function createModel(array $values): Recipe
    {
        [
            'id' => $id,
            'name' => $name,
            'portions' => $portions,
            'calorine' => $calorine,
            'prepration_time' => $prepration_time,
            'source_argument' => $source_argument,
            'source_id' => $source_id,
            'source_name' => $source_name,
            'source_type' => $source_type
        ] = $values;

        $source = null;
        if ($source_id !== null){
            $source = $this->sourceRepository->createModel([
                'id' => $source_id,
                'name' => $source_name,
                'type' => $source_type
            ]);
        }

        return new Recipe(
            $id,
            $name,
            $portions,
            $calorine,
            new \DateInterval("PT{$prepration_time}M"),
            $source,
            $source_argument
        );
    }
}