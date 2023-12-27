<?php
declare(strict_types=1);

namespace RecipeManager\Database\Repositories;

use Exception;
use Override;
use RecipeManager\Database\Database;
use RecipeManager\Database\Models\Recipe;
use RecipeManager\Database\Models\RecipeStep;

final class RecipeStepRepository extends Repository
{

    public function __construct(
        Database $database,
        private readonly RecipeRepository $recipeRepository
    )
    {
        parent::__construct($database);
    }

    /**
     * @throws Exception
     */
    #[Override] public function get(int $id): ?RecipeStep
    {
        $sql = "SELECT 
    recipe_step.id, recipe_step.fk_recipe, recipe_step.`order`, recipe_step.step_text
FROM recipe_step
WHERE recipe_step.id = ?
LIMIT 1";

        $result = $this->database->query($sql, $id);
        if (!$result) {
            throw new Exception("Couldn't query for recipe with id '$id'");
        }

        $valueArray = $result->fetch();
        if (!$valueArray) {
            return null;
        }

        $valueArray['recipe'] = $this->recipeRepository->get($valueArray['fk_recipe']);

        return $this->createModel($valueArray);
    }

    /**
     * @param Recipe $recipe
     * @return RecipeStep[]
     * @throws Exception
     */
    public function getByRecipe(Recipe $recipe): array {
        $sql = "SELECT 
    recipe_step.id, recipe_step.`order`, recipe_step.step_text
FROM recipe_step
WHERE fk_recipe = ?";

        $result = $this->database->query($sql, $recipe->id);
        if (!$result) {
            throw new Exception("Couldn't query for recipes");
        }

        $resultingData = [];
        while ($row = $result->fetch()) {
            $row['recipe'] = $recipe;
            $resultingData[] = $this->createModel($row);
        }

        return $resultingData;
    }

    /**
     * @param array{
     *     id: int,
     *     recipe: Recipe,
     *     order: int,
     *     step_text: string
     * } $values
     */
    #[Override] public function createModel(array $values): RecipeStep
    {
        return new RecipeStep(
            $values['id'],
            $values['recipe'],
            $values['order'],
            $values['step_text']
        );
    }
}