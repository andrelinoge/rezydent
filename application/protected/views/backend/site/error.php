<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="errorPage">
    <p class="name"><?= $code; ?></p>
    <p class="description"><?= CHtml::encode($message); ?></p>
    <p>
        <button class="btn btn-danger"
                onClick="document.location.href = '<?= $this->createUrl( 'site/index'); ?>';"><?= _( 'Back to main' ); ?></button>
        <button class="btn btn-warning"
                onClick="history.back();"><?= _( 'Previous page' ); ?></button>
    </p>
</div>