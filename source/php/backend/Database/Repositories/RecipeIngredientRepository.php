<?php
declare(strict_types=1);

namespace RecipeManager\Database\Repositories;

use Exception;
use Override;
use RecipeManager\Database\Database;
use RecipeManager\Database\Models\Recipe;
use RecipeManager\Database\Models\RecipeIngredient;

final class RecipeIngredientRepository extends Repository
{

    public function __construct(Database $database, private readonly RecipeRepository $recipeRepository, private readonly IngredientRepository $ingredientRepository)
    {
        parent::__construct($database);
    }

    /**
     * @throws Exception
     */
    #[Override] public function get(int $id): ?RecipeIngredient
    {
        $sql = "SELECT 
    recipe_ingrediant.id, fk_recipe, amount, i.id as ingredient_id, name as ingredient_name, type as ingredient_type, type_argument as ingredient_type_argument
FROM recipe_ingrediant
    LEFT JOIN recipes.ingrediant i on i.id = recipe_ingrediant.fk_ingrediant
WHERE recipe_ingrediant.id = ?
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
     * @param Recipe $recipe
     * @return RecipeIngredient[]
     * @throws Exception
     */
    public function getFromRecipe(Recipe $recipe): array {
        $sql = "SELECT 
    recipe_ingrediant.id, amount, i.id as ingredient_id, name as ingredient_name, type as ingredient_type, type_argument as ingredient_type_argument
FROM recipe_ingrediant
    LEFT JOIN recipes.ingrediant i on i.id = recipe_ingrediant.fk_ingrediant
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
     *     fk_recipe?: int,
     *     recipe?: Recipe,
     *     amount: int,
     *     ingredient_id: int,
     *     ingredient_name: string,
     *     ingredient_type: string,
     *     ingredient_type_argument: string
     * } $values
     * @throws Exception
     */
    #[Override] public function createModel(array $values): RecipeIngredient
    {
        $recipe = array_key_exists('recipe', $values) ? $values['recipe'] : $this->recipeRepository->get($values['fk_recipe']);

        $ingredient = $this->ingredientRepository->createModel([
            'id' => $values['ingredient_id'],
            'name' => $values['ingredient_name'],
            'type' => $values['ingredient_type'],
            'type_argument' => $values['ingredient_type_argument'],
        ]);

        return new RecipeIngredient(
            $values['id'],
            $recipe,
            $ingredient,
            $values['amount']
        );
    }
}