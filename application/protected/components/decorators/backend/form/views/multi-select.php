<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 *
 * @var $model CFormModel
 */

Yii::app()
    ->clientScript
    ->registerPackage( 'multiSelect' )

?>
<script type="text/javascript">
    jQuery( document).ready( function()
    {
        if( jQuery( "#<?= CHtml::activeId($model, $attribute ); ?>" ).length > 0 )
        {
            jQuery( "#<?= CHtml::activeId($model, $attribute ); ?>" ).multiSelect();
        }
    });
</script>

<div class="row-form clearfix">
    <div class="span3"><?= $model->getAttributeLabel( $attribute ); ?></div>
    <div class="clear"></div>
    <div class="span11">

        <?= CHtml::activeListBox( $model,$attribute, $data, array('multiple' => 'multiple') )?>
        <span class="error" id="<?= CHtml::activeId($model, $attribute ); ?>_error">
            <?= $model->getError( $attribute ); ?>
        </span>
    </div>
</div>
