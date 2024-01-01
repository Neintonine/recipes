<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

enum IngredientType: string
{
    case NONE = "NONE";
    case GRAMS = "GRAMS";
    case PIECE = "PIECE";
    case EL = "EL";
    case TL = "TL";
    case LITRE = "LITRE";
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