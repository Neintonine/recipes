<?php

namespace RecipeManager\Routing;

use Aura\Router\Map;
use Laminas\Diactoros\{CallbackStream, Request, Response, ServerRequest};
use Mimey\MimeTypes;
use RecipeManager\ContainerHandler;
use RecipeManager\Path;
use RecipeManager\Template\TemplateEngine;

final class Routes
{
    public function fillMap(Map $map) {
        $map->get("index", "/", $this->handleIndexRoute(...));

        $map->attach('recipe.', '/recipe', ContainerHandler::Get(RecipeRoutes::class)->attach(...));

        $map->get("resources", "/", $this->handleResource(...))
            ->wildcard("_blank")
            ->attributes([
                "resource-route" => true
            ]);
    }

    private function handleIndexRoute(ServerRequest $request): Response {
        $templateEngine = ContainerHandler::Get(TemplateEngine::class);
        $renderedTemplate = $templateEngine->render("pages::start");

        $response = new Response();
        $response->getBody()->write($renderedTemplate);

        return $response;
    }

    private function handleResource(ServerRequest $request): Response {
        $path = $request->getUri()->getPath();

        $fullPath = Path::PUBLIC_PATH . $path;
        if (!file_exists($fullPath)) {
            return new Response(status: 404);
        }

        $file = file_get_contents($fullPath);

        $response = new Response();
        $response->getBody()->write($file);
        $response = $response->withHeader("Content-Type", ContainerHandler::Get(MimeTypes::class)->getMimeType(pathinfo($path, PATHINFO_EXTENSION)));
        return $response;
    }
}