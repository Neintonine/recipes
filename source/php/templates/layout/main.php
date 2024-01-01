<?php
/**
 * @var Template $this
 * @var array<array{js: array<string>, css: array<string>}> $resourceMap
 * @var ?string $resourceId
 */

use League\Plates\Template\Template;

assert(is_array($resourceMap));

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Recipes</title>

        <?php
        if (array_key_exists($resourceId, $resourceMap)):
            $resources = $resourceMap[$resourceId];

            foreach ($resources["js"] as $resource):
            ?>
                <script src="/<?= $resource ?>"></script>
            <?php endforeach;
            foreach ($resources["css"] as $resource): ?>
                <link rel="stylesheet" href="/<?= $resource ?>">
            <?php endforeach;
        endif;?>

        <?= $this->section("head") ?>
    </head>
    <body>
        <div class="content">
            <div class="row h-100">
                <div class="sidebar h-100 col-3 border-end pe-1">
                    <?= $this->section("sidebar") ?>
                </div>
                <div class="col-9 ps-1 position-relative">
                    <?= $this->section("content") ?>
                </div>
            </div>
        </div>
    </body>
</html>
