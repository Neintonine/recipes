<?php
declare(strict_types=1);

namespace RecipeManager\Routing;

use Aura\Router\Map;
use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;

final class Router
{
    private readonly Map $map;

    public function __construct(
        private readonly RouterContainer $routerContainer
    ) {
        $this->map = $this->getMap();
    }

    public function route() {
        $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );

        $matcher = $this->routerContainer->getMatcher();

        $route = $matcher->match($request);
        if (! $route) {
            // get the first of the best-available non-matched routes
            $failedRoute = $matcher->getFailedRoute();

            if (!$failedRoute) {
                // 404 NOT FOUND
                return;
            }

            // which matching rule failed?
            switch ($failedRoute->failedRule) {
                case 'Aura\Router\Rule\Allows':
                    // 405 METHOD NOT ALLOWED
                    // Send the $failedRoute->allows as 'Allow:'
                    break;
                case 'Aura\Router\Rule\Accepts':
                    // 406 NOT ACCEPTABLE
                    break;
                default:
                    // 404 NOT FOUND
                    break;
            }
            return;
        }

        foreach ($route->attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        $callable = $route->handler;
        $response = $callable($request);

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }

    private function getMap(): Map {
        $map = $this->routerContainer->getMap();



        return $map;
    }
}