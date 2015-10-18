<?php
/**
 * @author: Andriy Tolstokorov
 * Date: 12/8/12
 */

/** @var $this BackendController */
?>


<div class="row-fluid">

    <div class="span12">
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1><?= $pageTitle; ?></h1>
        </div>
        <div class="block-fluid tabs">
            <?php
            $this->renderPartial(
                $formView,
                array(
                    'model'     => $model,
                    'formId'    => $formId,
                    'action'    => $formAction,
                    'innerLinks'=> $innerLinks,
                    'imageUploadHandlerUrl' => $imageUploadHandlerUrl
                )
            );
            ?>
        </div>
    </div>
</div>

<? if ( $model::USE_IMAGE ): ?>
<div class="row-fluid">

    <div class="span12">
        <div class="head clearfix">
            <div class="isw-picture"></div>
            <h1><?= _( 'Article cover image' ); ?></h1>
        </div>
        <div class="block gallery clearfix">


            <div class="row-form clearfix">
                <div class="span10">
                    <?= _( 'Article image preview:' ); ?>
                    <? $src = $model->getOriginalImage(); ?>
                    <div class="clear"></div>
                    <? if ( empty( $src ) ): ?>
                    <strong id="upload-image-hint">
                        <?= _( 'You has not uploaded any image' ); ?>
                    </strong>
                    <? endif; ?>
                    <a class="fancybox"
                       id = "article-image-fancy"
                       href="<?= $src; ?>" style="margin: 15px;">
                        <img class="img-polaroid"
                             width="<?= $coverPreviewWidth; ?>px"
                             height="<?= $coverPreviewHeight; ?>px"
                            <? if ( empty( $src ) ): ?>style="display: none;"<? endif; ?>
                             id="article-image"
                             src="<?= $src; ?>" />
                    </a>
                </div>
                <div class="span2">
                    <div class="btn"
                         id="uploadButton">
                        <?= _( 'Upload image' ); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<? endif; ?>