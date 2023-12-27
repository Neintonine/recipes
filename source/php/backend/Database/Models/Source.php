<?php
declare(strict_types=1);

namespace RecipeManager\Database\Models;

enum SourceType: string
{
    case BOOK = "BOOK";
    case WEB = "WEB";
    case TOLD = "TOLD";
}

final readonly class Source
{
    public function __construct(
        public int $id,
        public string $name,
        public SourceType $type,
    ) { }
}