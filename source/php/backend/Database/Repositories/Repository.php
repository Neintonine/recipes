<?php
declare(strict_types=1);

namespace RecipeManager\Database\Repositories;

use RecipeManager\Database\Database;

abstract class Repository
{
    public function __construct(
        protected Database $database
    )
    {
    }

    public abstract function get(int $id);
    public abstract function createModel(array $values);
}