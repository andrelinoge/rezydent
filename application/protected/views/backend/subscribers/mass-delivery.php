<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

/** @var $model MassDeliveryForm */

Yii::import('application.components.decorators.backend.form.FormDecorator');
Yii::app()
    ->clientScript
    ->registerPackage( 'ckEditor' )
    ->registerPackage( 'jqueryForm' );
?>

<div class="row-fluid">

    <div class="span10">
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>Масова розсилка</h1>
        </div>
        <div class="block-fluid tabs">
            <?= CHtml::beginForm( '', 'post', array( 'id' => $formId, 'name' => get_class( $model ) ) ); ?>
            <?= FormDecorator::textField( $model, 'subject', array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>
            <?=
                FormDecorator::textArea(
                    $model,
                    'text',
                    array(
                        'onclick' => 'backendController.removeErrorHighlighting( this )',
                        'class' => 'ckeditor'
                    )
                );
            ?>
            <div class="footer tar">
                <?=
                    CHtml::submitButton(
                        'Відправити',
                        array(
                            'class' => 'btn',
                            'onclick' => 'return backendController.ajaxSubmitFormCK(\'' . $formId. '\')'
                        )
                    );
                ?>
            </div>
            <?= CHtml::endForm(); ?>
        </div>
    </div>

</div>