<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

final readonly class IngredientUnit
{
    public function __construct(
        public string $tag,
        public string $name,
        public string|array $unit,
    )
    {
    }
}