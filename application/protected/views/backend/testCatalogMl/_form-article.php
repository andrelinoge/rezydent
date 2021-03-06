<?php
/**
 * @author: Andriy Tolstokorov
 */

/** @var $model BaseMultilingualForm */

Yii::import('application.components.decorators.backend.form.FormDecorator');
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' )
    ->registerPackage( 'ckEditor' )
    ->registerPackage( 'zeroClipboard' )
    ->registerPackage( 'fileUploader' )
    ->registerPackage( 'uploader' );
?>


<script type="text/javascript">
    jQuery( document ).ready( function(){
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
                'allowedExtensions':[ 'jpg', 'png' ],
                'sizeLimit':20000000
            }
        );
    });
</script>

<?= CHtml::beginForm( $action, 'post', array( 'id' => $formId, 'name' => get_class( $model ) ) ); ?>

<ul>
    <?php foreach( $model->getLanguages( TRUE ) as $language => $description ): ?>
        <li><a href="#tabs-<?= $language; ?>"><?= $description; ?></a></li>
    <?php endforeach; ?>
</ul>
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

<?php foreach( $model->getLanguages() as $language ): ?>
    <div id="tabs-<?= $language; ?>">
        <?=
            FormDecorator::textField(
                $model,
                'title_' . $language,
                array(
                    'onclick' => 'backendController.removeErrorHighlighting( this )',
                )
            );
        ?>
        <?=
            FormDecorator::textArea(
                $model,
                'text_' . $language,
                array(
                    'onclick' => 'backendController.removeErrorHighlighting( this )',
                    'class' => 'ckeditor'
                )
            );
        ?>
        <?=
            FormDecorator::textArea(
                $model,
                'meta_description_' . $language,
                array(
                    'onclick' => 'backendController.removeErrorHighlighting( this )'
                )
            );
        ?>
        <?=
            FormDecorator::textArea(
                $model,
                'meta_keywords_' . $language,
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
                        onchange="return backendController.onSelectPageUrl( '#copy-page-url-<?= $formId; ?>-<?= $language; ?>', this);">
                    <option value=""><?= _( 'choose page...'); ?></option>
                    <? foreach( StaticPagesMl::getInnerLinks( $language ) as $pageTitle => $pageLink ): ?>
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
            <div class="span2"><?= _( 'Page url:' ); ?></div>
            <div class="span7">
                <strong>
                    <a id="copy-page-url-<?= $formId; ?>-<?= $language; ?>"
                       class="copy-into-clipboard"
                       data-clipboard-text=""
                       onclick="return false;"
                       title="<?= _('click me to copy into clipboard' ); ?>">
                        <?= _( 'Select page:' ); ?>
                    </a>
                </strong>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="row-fluid">
    <?=
        FormDecorator::dateField(
            $model,
            'publish_at'
        );
    ?>
</div>

<?=
FormDecorator::multiSelect(
    $model,
    'tags',
    TestTagsMl::getOptions(),
    array(
        'onclick' => 'backendController.removeErrorHighlighting( this )'
    )
);
?>

<div class="footer tar">
    <?=
    CHtml::submitButton(
        'Save',
        array(
            'class' => 'btn',
            'onclick' => 'return backendController.ajaxSubmitFormCK(\'' . $formId. '\')'
        )
    );
    ?>
</div>

<?= CHtml::activeHiddenField( $model, 'image', array( 'id' => 'article-image-field' ) )?>

<?= CHtml::endForm(); ?>
