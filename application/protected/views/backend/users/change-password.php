<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $this BackendController */

Yii::import('application.components.decorators.backend.form.FormDecorator');
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' );
?>

<div class="row-fluid">

    <div class="span8">
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1><?= $pageTitle; ?></h1>
        </div>
        <div class="block-fluid tabs">
            <?= CHtml::beginForm( '', 'post', array( 'id' => $formId, 'name' => get_class( $model ) ) ); ?>

            <?= FormDecorator::textField( $model, 'old', array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>
            <?= FormDecorator::textField( $model, 'new', array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>
            <?= FormDecorator::textField( $model, 'confirm', array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>

            <div class="footer tar">
                <?=
                CHtml::submitButton(
                    'Save',
                    array(
                        'class' => 'btn',
                        'onclick' => 'return backendController.ajaxSubmitForm(\'' . $formId. '\')'
                    )
                );
                ?>
            </div>
            <?= CHtml::endForm(); ?>
        </div>
    </div>

</div>