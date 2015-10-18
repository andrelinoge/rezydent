<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */
?>
<div class="row-form clearfix">
<div class="span2"><?= $model->getAttributeLabel( $attribute ); ?></div>
<div class="clear"></div>
<div class="span11">
    <?= CHtml::activeDropDownList( $model, $attribute, $data, $htmlOptions ); ?>
    <span class="error" id="<?= CHtml::activeId($model, $attribute ); ?>_error">
        <?= $model->getError( $attribute ); ?>
    </span>
</div>
</div>