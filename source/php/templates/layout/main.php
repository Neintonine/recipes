<?php
/**
 * @var Template $this
 * @var array<array{js: array<string>, css: array<string>}> $resourceMap
 * @var ?string $pageId
 */

use League\Plates\Template\Template;

assert(is_array($resourceMap));

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Recipes</title>

        <?php
        if (array_key_exists($pageId, $resourceMap)):
            $resources = $resourceMap[$pageId];

            foreach ($resources["js"] as $resource):
            ?>
                <script src="<?= $resource ?>"></script>
            <?php endforeach;
            foreach ($resources["css"] as $resource): ?>
                <link rel="stylesheet" href="<?= $resource ?>">
            <?php endforeach;
        endif;?>
    </head>
    <body class="bg-light-subtle">

    </body>
</html>
