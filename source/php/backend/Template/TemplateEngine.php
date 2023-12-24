<?php

namespace RecipeManager\Template;

use League\Plates\Engine;
use RecipeManager\Path;

class TemplateEngine
{
    private Engine $engine;

    public function __construct() {
        $this->engine = new Engine(Path::PHP_TEMPLATES_PATH);

        $this->engine->addFolder("layout", Path::PHP_TEMPLATES_PATH . "/layout");
        $this->engine->addFolder("pages", Path::PHP_TEMPLATES_PATH . "/pages");

        $this->engine->addData([
            "resourceMap" => json_decode(file_get_contents(Path::PUBLIC_PATH . "/file-index.json"), true)
        ]);
    }
}