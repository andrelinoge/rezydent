<?php
/**
 * @author: Andriy Tolstokorov
 */

/** @var $model BaseMultilingualForm */

Yii::import('application.components.decorators.backend.form.FormDecorator');
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' );
?>

<?= CHtml::beginForm( $action, 'post', array( 'id' => $formId, 'name' => get_class( $model ) ) ); ?>

    <?= FormDecorator::textField( $model, 'first_name', array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>
    <?= FormDecorator::textField( $model, 'last_name', array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>
    <?= FormDecorator::textField( $model, 'email', array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>
    <?= FormDecorator::textField( $model, 'password', array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>

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
