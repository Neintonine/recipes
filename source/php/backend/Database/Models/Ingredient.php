<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

enum IngredientType: int
{
    case NONE = 0;
    case GRAMS = 1;
    case PIECE = 2;
    case EL = 3;
    case TL = 4;
    case LITRE = 5;
}

final readonly class Ingredient
{
    public function __construct(
        public int $id,
        public string $name,
        public IngredientType $type,
        public ?string $type_argument
    )
    {
    }
}