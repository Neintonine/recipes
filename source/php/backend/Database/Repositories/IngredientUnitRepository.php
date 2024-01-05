<?php
declare(strict_types=1);

namespace RecipeManager\Database\Repositories;

use RecipeManager\Database\Models\IngredientUnit;

final class IngredientUnitRepository
{
    public const UNIT_NONE = 'NONE';
    public const UNIT_GRAMS = 'GRAMS';
    public const UNIT_PIECE = 'PIECE';
    public const UNIT_EL = 'EL';
    public const UNIT_TL = 'TL';
    public const UNIT_LITRE = 'LITRE';

    private ?array $units = null;

    public function get(string $tag): IngredientUnit {
        $units = $this->getUnits();
        return $units[$tag];
    }

    private function getUnits(): array {
        if ($this->units !== null) {
            return $this->units;
        }

        $this->units = [
            self::UNIT_NONE => new IngredientUnit(
                self::UNIT_NONE,
                'None',
                ''
            ),
            self::UNIT_GRAMS => new IngredientUnit(
                self::UNIT_GRAMS,
                'Grams',
                [ 0 => 'g', 1000 => 'kg' ]
            ),
            self::UNIT_EL => new IngredientUnit(
                self::UNIT_EL,
                'EL',
                'EL'
            ),
            self::UNIT_TL => new IngredientUnit(
                self::UNIT_TL,
                'TL',
                'TL'
            ),
            self::UNIT_LITRE => new IngredientUnit(
                self::UNIT_LITRE,
                'Litre',
                'l'
            ),
            self::UNIT_PIECE => new IngredientUnit(
                self::UNIT_PIECE,
                'Pieces',
                'pc'
            )
        ];
        return $this->units;
    }
}