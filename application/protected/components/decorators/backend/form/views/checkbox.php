<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */
?>

<div class="row-form clearfix">
    <div class="span3"><?= $model->getAttributeLabel( $attribute ); ?></div>
    <div class="span8">
        <?= CHtml::activeCheckBox( $model, $attribute, $htmlOptions ); ?>
    </div>
</div>