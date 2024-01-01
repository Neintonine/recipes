<?php
declare(strict_types=1);

namespace RecipeManager\Database\Repositories;

use Exception;
use RecipeManager\Database\Models\Recipe;
use RecipeManager\Database\Models\Tag;

final class TagRepository extends Repository
{

    #[\Override] public function get(int $id): ?Tag
    {
        $sql = "SELECT id,
       tag
FROM recipes.tags
WHERE recipes.tags.id = ?
LIMIT 1";
        $result = $this->database->query($sql, $id);
        if (!$result) {
            throw new Exception("Couldn't query for tag with id '$id'");
        }

        $valueArray = $result->fetch();
        if (!$valueArray) {
            return null;
        }

        return $this->createModel($valueArray);
    }

    /**
     * @return Tag[]
     */
    public function getAll()
    {
        $sql = "SELECT 
    id, tag
FROM recipes.tags";

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
     * @return Tag[]
     */
    public function fromRecipe(Recipe $recipe): array
    {
        $sql = "SELECT 
    t.id, t.tag
FROM recipes.recipe_tags
    INNER JOIN recipes.tags t on t.id = recipe_tags.tag_id = t.id
WHERE recipe_id = ?";

        $result = $this->database->query($sql, $recipe->id);
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
     * @param array{ id: int, tag: string } $values
     */
    #[\Override] public function createModel(array $values): Tag
    {
        return new Tag(
            $values['id'],
            $values['tag'],
        );
    }
}