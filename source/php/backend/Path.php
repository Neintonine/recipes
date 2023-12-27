<?php

namespace RecipeManager;

final class Path
{
    public const BASE_PATH = __DIR__ . "/../../..";
    public const PUBLIC_PATH = self::BASE_PATH . "/public";
    public const SOURCE_PATH = self::BASE_PATH . "/source";
    public const PHP_SOURCE_PATH = self::SOURCE_PATH . "/php";
    public const PHP_TEMPLATES_PATH = self::PHP_SOURCE_PATH . "/templates";
    public const PHP_CONFIG_PATH = self::PHP_SOURCE_PATH . "/config";

}