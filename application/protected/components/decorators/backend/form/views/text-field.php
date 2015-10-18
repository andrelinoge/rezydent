<?php
/**
 * User: andrelinoge
 * Date: 12/9/12
 */

/** @var $model CFormModel*/
?>

<div class="row-form clearfix">
    <div class="span3"><?= $model->getAttributeLabel( $attribute ); ?></div>
    <div class="clear"></div>
    <div class="span11">
        <?= CHtml::activeTextField( $model, $attribute, $htmlOptions ); ?>
        <span class="error" id="<?= CHtml::activeId($model, $attribute ); ?>_error">
            <?= $model->getError( $attribute ); ?>
        </span>
    </div>
</div>