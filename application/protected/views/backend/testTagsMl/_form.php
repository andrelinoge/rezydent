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

    <ul>
        <?php foreach( $model->getLanguages( TRUE ) as $language => $description ): ?>
            <li><a href="#tabs-<?= $language; ?>"><?= $description; ?></a></li>
        <?php endforeach; ?>
    </ul>

    <?php foreach( $model->getLanguages() as $lang ): ?>
        <div id="tabs-<?= $lang; ?>">
            <?= FormDecorator::textField( $model, 'value_' . $lang, array( 'onclick' => 'backendController.removeErrorHighlighting( this )' ) ); ?>
        </div>
    <?php endforeach; ?>

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
