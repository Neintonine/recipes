<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

final readonly class RecipeIngredient
{
    public function __construct(
        public int $id,
        public Recipe $recipe,
        public Ingredient $ingredient,
        public int $amount
    )
    {
    }
}