<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

final readonly class Recipe
{
    public function __construct(
        public int $id,
        public string $name,
        public ?int $portions = null,
        public ?int $calorine = null,
        public ?\DateInterval $prepration_time = null,
        public ?Source $source = null,
        public ?string $source_argument = null
    )
    {
    }
}