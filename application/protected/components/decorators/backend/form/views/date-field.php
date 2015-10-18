<?php
/**
 * User: andrelinoge
 * Date: 12/9/12
 */

/** @var $model CFormModel*/
?>

<script type="text/javascript">
    jQuery( document ).ready( function(){
        jQuery( "#<?= CHtml::activeId( $model, $attribute )?>" ).datepicker({
            format: 'mm-dd-yyyy'
        });
    });
</script>

<div class="row-form clearfix">
    <div class="span2"><?= $model->getAttributeLabel( $attribute ); ?></div>
    <div class="span2">
        <?= CHtml::activeTextField( $model, $attribute, $htmlOptions ); ?>
        <span class="error" id="<?= CHtml::activeId($model, $attribute ); ?>_error">
            <?= $model->getError( $attribute ); ?>
        </span>
    </div>
</div>