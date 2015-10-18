<?php
    /**
     * User: andrelinoge
     * Date: 12/9/12
     */
?>

<div class="row-form clearfix">
    <div class="span3"><?= $model->getAttributeLabel( $attribute ); ?></div>
    <div class="clear"></div>
    <div class="span11">
        <?= CHtml::activeTextArea( $model, $attribute, $htmlOptions ); ?>
        <span class="error" id="<?= CHtml::activeId($model, $attribute ); ?>_error">
            <?= $model->getError( $attribute ); ?>
        </span>
    </div>
</div>