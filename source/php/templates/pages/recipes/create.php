<?php
declare(strict_types=1);
$this->layout("layout::main", [ "resourceId" => "default" ]);
?>

<?php $this->start("head") ?>
<meta
    name="api-endpoints"
    data-api-tags-save="/api/save/tags"
>
<?php $this->end(); ?>

<?php $this->start("sidebar"); ?>

<div>
    <h4>Tags</h4>
    <div>

    </div>
</div>

<?php $this->end(); ?>

<div class="ms-2">
    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-lg" id="name" placeholder>
        <label for="name">Name</label>
    </div>
</div>
