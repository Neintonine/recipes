<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

final readonly class Ingredient
{
    public function __construct(
        public int            $id,
        public string         $name,
        public IngredientUnit $type,
        public ?string        $type_argument
    )
    {
    }
}