<?php

namespace RecipeManager\Routing;

use Aura\Router\Route;
use Aura\Router\Rule\RuleInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ResourceRule implements RuleInterface
{
    private const ALLOWED_EXTENSIONS = [
        "js", "css",
        "ttf", "woff", "woff2",
        "gif", "svg", "png", "jpg"
    ];

    /**
     * @inheritDoc
     */
    public function __invoke(ServerRequestInterface $request, Route $route): bool
    {
        if (!str_ends_with($route->name, "resources")) {
            return true;
        }

        $path = $request->getUri()->getPath();
        foreach (self::ALLOWED_EXTENSIONS as $extension) {
            if (!str_ends_with($path, $extension)) {
                continue;
            }

            return true;
        }

        return false;
    }
}