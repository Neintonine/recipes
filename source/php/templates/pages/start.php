<?php

/**
 * @var \League\Plates\Template\Template $this
 */

$this->layout("layout::main", [ "pageId" => "start" ]);

?>

<?php $this->start("sidebar"); ?>

<?php $this->end(); ?>
<?php $this->start("content"); ?>

<?php $this->end(); ?>