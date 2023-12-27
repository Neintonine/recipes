<?php

namespace RecipeManager\Template;

use League\Plates\Engine;
use RecipeManager\ContainerHandler;
use RecipeManager\Path;
use RecipeManager\Routing\Router;

class TemplateEngine
{
    private Engine $engine;

    public function __construct() {
        $this->engine = new Engine(Path::PHP_TEMPLATES_PATH);

        $this->engine->addFolder("layout", Path::PHP_TEMPLATES_PATH . "/layout");
        $this->engine->addFolder("pages", Path::PHP_TEMPLATES_PATH . "/pages");

        $this->engine->addData([
            "resourceMap" => $this->loadResourceMap()
        ]);
    }

    public function render(string $file, array $data = []): string {
        $routeMap = ContainerHandler::Get(Router::class)->map;
        $data['routes'] = $routeMap;

        return $this->engine->render($file, $data);
    }

    /**
     * @return array<array{js: array<string>, css: array<string>}>
     */
    public function loadResourceMap(): array {
        $resourceIndex = json_decode(file_get_contents(Path::PUBLIC_PATH . "/file-index.json"), true);
        $map = [];

        $ensureResourceCallback = (function (array $resources, string $key) {
            if (!array_key_exists($key, $resources)) {
                return [];
            }

            $val = $resources[$key];
            if (is_array($val)) {
                return $val;
            }

            return [$val];
        });

        foreach ($resourceIndex as $page => $resources) {
            $map[$page] = [
                "js" => $ensureResourceCallback($resources, "js"),
                "css" => $ensureResourceCallback($resources, "css"),
            ];
        }

        return $map;
    }
}