<?php
declare(strict_types=1);

/**
 * @var Tag[] $tags
 * @var \RecipeManager\Database\Models\Source[] $sources
 */

use RecipeManager\Database\Models\Tag;

$this->layout("layout::main", [ "resourceId" => "recipes/create" ]);
?>

<?php $this->start("sidebar"); ?>

<button class="btn btn-primary btn-lg w-100 mt-2">
    Save
</button>

<div class="mt-4">
    <div class="form-floating">
        <input type="number" class="form-control" id="portions-input" placeholder="">
        <label for="portions-input">Portions</label>
    </div>
    <div class="form-floating mt-2">
        <input type="number" class="form-control" id="calorine-input" placeholder="">
        <label for="calorine-input">Calorine</label>
    </div>
    <div class="form-floating mt-2"
         data-td-target-input="nearest"
         data-td-target-toggle="nearest"
         id="prepration-time-input"
    >
        <input type="text" class="form-control"
               data-td-target="#prepration-time-input"
               data-td-toggle="datetimepicker"
               placeholder=""
        >
        <label>Preparation Time</label>
    </div>
</div>
<hr>
<div class="mt-3">
    <label for="source-input">Source</label>
    <select class="selectpicker w-100" id="source-input" name="source"
            data-style="btn-dark" data-live-search="true" data-size="10"
            data-dropup-auto="false" title="Choose a source..."
    >
        <option data-content='<i class="fa-solid fa-plus me-1"></i> Create new source'>Create new source</option>
        <option data-divider="true"></option>
        <?php foreach ($sources as $source): ?>
            <option value="<?= $source->id ?>">
                <?= $source->name ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div class="form-floating mt-2">
        <input type="text" class="form-control" id="source-argument-input" placeholder="">
        <label>Source Argument</label>
    </div>
</div>
<hr>
<div class="mt-3">
    <label for="tag-input" class="form-label">Tags</label>
    <select class="form-select" id="tag-input" name="tags[]" multiple>
        <option disabled hidden value="">Choose a tag...</option>
        <?php foreach ($tags as $tag): ?>
            <option value="<?= $tag->id ?>">
                <?= $tag->tag ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<?php $this->end(); ?>

<div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-lg" id="name" placeholder autocomplete="off">
        <label for="name">Name</label>
    </div>
</div>
<hr>
<div>
    <label for="" class="form-label ms-2">
        Ingredients
        <a class="text-reset text-decoration-none js-add-ingredient"
           style="cursor:pointer;"
        >
            <i class="fa-solid fa-plus me-1"></i>
        </a>
    </label>

    <table class="table table-striped js-ingredient-table">
        <colgroup>
            <col style="width:2rem">
            <col>
            <col>
            <col style="width: 2rem">
        </colgroup>
        <thead>
            <tr>
                <th></th>
                <th>Portions</th>
                <th>Ingredient</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<hr>