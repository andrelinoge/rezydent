<?php
/**
 * @author: Andriy Tolstokorov
 * Date: 12/8/12
 */

/** @var $this BackendController */
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' )
    ->registerPackage( 'fileUploader' )
    ->registerPackage( 'uploader' );
?>

<script>
    $(
        function()
        {
            uploadController.initUserAvatarUploader(
                '<?= $changeUserAvatarHandlerUrl; ?>',
                'uploadButton',
                {
                    'allowedExtensions':[ 'jpg', 'jpeg', 'png' ],
                    'sizeLimit':20000000
                }
            );
        }
    );
</script>

<div class="row-fluid">
        <div class="span8">
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
                            'action'    => $formAction
                        )
                    );
                ?>
            </div>
        </div>

        <div class="span4">
            <div class="head clearfix">
                <div class="isw-documents"></div>
                <h1>Фотографія</h1>
            </div>
            <div class="block-fluid tabs pagination-centered">
                <? if ( $user->hasPhoto() ): ?>
                    <br/>
                    <a href="<?= $user->getOriginalPhoto(); ?>" class="fancybox" id="avatar-fancy">
                        <img src="<?= $user->getSmallThumbnail(); ?>"
                             alt="<?= $user->getFirstName(); ?>"
                             id="avatar-img" />
                    </a>
                    <br/><br/>
                    <div class="btn" id="uploadButton">
                        Змінити фото
                    </div>
                <? else: ?>
                    <br/>
                    <a href="<?= $user->getOriginalPhoto(); ?>" class="fancybox" id="avatar-fancy">
                        <img src="<?= Yii::app()->params[ 'user' ][ 'defaultAvatar' ]; ?>"
                             alt="<?= $user->getFirstName(); ?>"
                             id="avatar-img" />
                    </a>
                    <br/><br/>
                    <div class="button"
                         id="uploadButton">
                        Завантажити фото
                    </div>
                <? endif; ?>
            </div>
        </div>

</div>