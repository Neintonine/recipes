<?php

/**
 * @var \League\Plates\Template\Template $this
 * @var \Aura\Router\Map $routes
 * @var Recipe[] $recipes
 */

use RecipeManager\Database\Models\Recipe;

$this->layout("layout::main", [ "resourceId" => "default" ]);
$links = [
    'example',
    'example 2',
    'example 3',
    'example 4',
];

?>

<?php $this->start("sidebar");
$lastKey = array_key_last($links);
foreach ($links as $linkKey => $link) {
    $isLast = $linkKey === $lastKey;

    ?>
    <a class="py-3 w-auto d-block <?php if (!$isLast): ?>border-bottom border-dark-subtle<?php endif; ?> mx-3 text-reset text-decoration-none" href="#">
        <?= $link ?>
    </a>
<?php
}
$this->end(); ?>

<a href="<?= $routes->getRoute('recipe.create')->path ?>">
    <button class="position-absolute bottom-0 end-0 p-3 m-2 me-3 btn rounded-circle btn-outline-primary">
        <i class="fa-solid fa-plus d-block"></i>
    </button>
</a>