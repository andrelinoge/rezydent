<?php
/**
 * @author: Andriy Tolstokorov
 */

/** @var $model BaseCatalogArticleTable */

Yii::import('application.components.decorators.backend.form.FormDecorator');
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' )
    ->registerPackage( 'ckEditor' )
    ->registerPackage( 'fileUploader' )
    ->registerPackage( 'zeroClipboard' )
    ->registerPackage( 'uploader' );
?>


<script type="text/javascript">
    jQuery( document ).ready(
            function()
            {
                backendController = new backendControllerClass();
                uploadController = new uploadControllerClass();

                backendController.initClipboard(
                        '<?= getPublicUrl(); ?>/common/js/plugins/ZeroClipboard/ZeroClipboard.swf',
                        '.copy-into-clipboard'
                );

                uploadController.initArticleImageUploader(
                        '<?= $imageUploadHandlerUrl; ?>',
                        'uploadButton',
                        {
                            'allowedExtensions':[ 'jpg', 'jpeg', 'png' ],
                            'sizeLimit':20000000
                        }
                );
            }
    );
</script>

<?= CHtml::beginForm( $action, 'post', array( 'id' => $formId, 'name' => get_class( $model ) ) ); ?>

<?=
FormDecorator::textField(
    $model,
    'title',
    array(
        'onclick' => 'backendController.removeErrorHighlighting( this )',
    )
);
?>
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
<?=
FormDecorator::textArea(
    $model,
    'meta_description',
    array(
        'onclick' => 'backendController.removeErrorHighlighting( this )'
    )
);
?>
<?=
FormDecorator::textArea(
    $model,
    'meta_keywords',
    array(
        'onclick' => 'backendController.removeErrorHighlighting( this )'
    )
);
?>

<?= CHtml::activeHiddenField( $model, 'image', array( 'id' => 'article-image-field' ) )?>

<div class="row-fluid">
    <?=
    FormDecorator::dateField(
        $model,
        'created_at',
        array(
            'value' => $model->getCreatedAt( 'd/m/Y', NULL, FALSE )
        )
    );
    ?>
</div>

<div class="footer tar">
    <?=
    CHtml::submitButton(
        'Зберегти',
        array(
            'class' => 'btn',
            'onclick' => 'return backendController.ajaxSubmitFormCK(\'' . $formId. '\')'
        )
    );
    ?>
</div>


<?= CHtml::endForm(); ?>
