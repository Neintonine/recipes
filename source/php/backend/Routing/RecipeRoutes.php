<?php
declare(strict_types=1);

namespace RecipeManager\Routing;

use Aura\Router\Map;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use RecipeManager\ContainerHandler;
use RecipeManager\Template\TemplateEngine;

final class RecipeRoutes
{
    public function attach(Map $map) {
        $map->get('create', '/create', $this->createRoute(...));
    }

    private function createRoute(ServerRequest $request): Response {
        $templateEngine = ContainerHandler::Get(TemplateEngine::class);
        $renderedTemplate = $templateEngine->render("pages::recipes/create");

        $response = new Response();
        $response->getBody()->write($renderedTemplate);

        return $response;
    }
}