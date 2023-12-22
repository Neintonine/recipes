<?php
declare(strict_types=1);

use RecipeManager\ContainerHandler;
use RecipeManager\Routing\Router;

require __DIR__ . "/../vendor/autoload.php";

$whoops = ContainerHandler::Get(\Whoops\Run::class);
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = ContainerHandler::Get(Router::class);
$router->route();