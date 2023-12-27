<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

final readonly class RecipeStep
{
    public function __construct(
        public int $id,
        public Recipe $recipe,
        public int $order,
        public string $stepText
    )
    {
    }
}