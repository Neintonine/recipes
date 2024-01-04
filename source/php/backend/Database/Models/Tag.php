<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

final readonly class Tag
{
    public function __construct(
        public int     $id,
        public string $tag
    )
    {
    }
}