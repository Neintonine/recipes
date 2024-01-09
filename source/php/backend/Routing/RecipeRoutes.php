<?php
declare(strict_types=1);

namespace RecipeManager\Routing;

use Aura\Router\Map;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use RecipeManager\ContainerHandler;
use RecipeManager\Database\Repositories\IngredientRepository;
use RecipeManager\Database\Repositories\IngredientUnitRepository;
use RecipeManager\Database\Repositories\SourceRepository;
use RecipeManager\Database\Repositories\TagRepository;
use RecipeManager\Template\TemplateEngine;

final class RecipeRoutes
{
    public function attach(Map $map) {
        $map->get('create', '/create', $this->createRoute(...));
    }

    private function createRoute(ServerRequest $request): Response {
        $totalTags = ContainerHandler::Get(TagRepository::class)->getAll();
        $sources = ContainerHandler::Get(SourceRepository::class)->getAll();
        $ingredients = ContainerHandler::Get(IngredientRepository::class)->getAll();
        $units = ContainerHandler::Get(IngredientUnitRepository::class)->getAll();

        $templateEngine = ContainerHandler::Get(TemplateEngine::class);
        $renderedTemplate = $templateEngine->render("pages::recipes/create", [
            "tags" => $totalTags,
            "sources" => $sources,
            'ingredients' => $ingredients,
            "ingredientUnits" => $units
        ]);

        $response = new Response();
        $response->getBody()->write($renderedTemplate);

        return $response;
    }
}