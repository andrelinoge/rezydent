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
FormDecorator::dropDownList(
    $model,
    'catalog_id',
    $model::getCatalogOptions(),
    array(
        'onclick' => 'backendController.removeErrorHighlighting( this )',
    )
);
?>

<?=
FormDecorator::textField(
    $model,
    'country',
    array(
        'onclick' => 'backendController.removeErrorHighlighting( this )',
    )
);
?>

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

<!-- OPTIONAL CODE -->
<div class="row-form clearfix">
    <div class="span2"><?= _( 'Available inner links:' ); ?></div>
    <div class="span10">
        <select style="width: 100%;"
                onchange="return backendController.onSelectPageUrl( '#copy-page-url', this);">
            <option value=""><?= _( 'choose page...'); ?></option>
            <? foreach( $innerLinks as $pageTitle => $pageLink ): ?>
                <? if( is_array( $pageLink ) ): ?>
                    <optgroup label="<?= $pageTitle; ?>">
                        <? foreach( $pageLink as $pageTitleInGroup => $pageLinkInGroup ): ?>
                            <option value="<?= $pageLinkInGroup; ?>"><?= $pageTitleInGroup; ?></option>
                        <? endforeach; ?>
                    </optgroup>
                <? else: ?>
                    <option value="<?= $pageLink; ?>"><?= $pageTitle; ?></option>
                <? endif; ?>
            <? endforeach; ?>
        </select>
    </div>
</div>

<div class="row-form clearfix">
    <div class="span2"><?= _( 'Посилання:' ); ?></div>
    <div class="span7">
        <strong>
            <a id="copy-page-url"
               class="copy-into-clipboard"
               data-clipboard-text=""
               onclick="return false;"
               title="<?= _('клікніть тут, щоб занести до буферу' ); ?>">
                <?= _( 'Виберіть сторінку:' ); ?>
            </a>
        </strong>
    </div>
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
