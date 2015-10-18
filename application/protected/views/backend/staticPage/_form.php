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
?>

<script type="text/javascript">
    jQuery( document).ready( function(){
        backendController = new backendControllerClass();
        backendController.initClipboard(
            '<?= getPublicUrl(); ?>/common/js/plugins/ZeroClipboard/ZeroClipboard.swf',
            '.copy-into-clipboard'
        );
    });
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

        <? if( !empty( $innerLinks ) ): ?>
            <div class="row-form clearfix">
                <div class="span2"><?= _( 'Available inner links:' ); ?></div>
                <div class="span10">
                    <select style="width: 100%;"
                            onchange="return backendController.onSelectPageUrl( '#copy-page-url-<?= $formId; ?>', this);">
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
                <div class="span2"><?= _( 'Page url:' ); ?></div>
                <div class="span7">
                    <strong>
                        <a id="copy-page-url-<?= $formId; ?>"
                           class="copy-into-clipboard"
                           data-clipboard-text=""
                           onclick="return false;"
                           title="<?= _('click me to copy into clipboard' ); ?>">
                            <?= _( 'Select page:' ); ?>
                        </a>
                    </strong>
                </div>
            </div>
        <? endif; ?>
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
