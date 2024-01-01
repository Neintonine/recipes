<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

final readonly class Tag
{
    public function __construct(
        private int $id,
        private string $tag
    )
    {
    }
}