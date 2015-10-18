<?php
/**
 * @author: Andriy Tolstokorov
 * Date: 12/8/12
 */

/** @var $this BackendController */

Yii::import('application.components.decorators.backend.form.FormDecorator');
Yii::app()
    ->clientScript
    ->registerPackage( 'uploader' );
?>

<script type="text/javascript">
    var uploadController;
    jQuery( document ).ready(
        function()
        {
            uploadController = new uploadControllerClass();

            uploadController.initArticleImageUploader(
                '<?= $this->createUrl( 'change' ); ?>',
                '.uploadButtons',
                {
                    'allowedExtensions':[ 'jpg', 'jpeg', 'png' ],
                    'sizeLimit':20000000
                }
            );
        }
    );
</script>

<div class="row-fluid">

    <div class="span12">
        <div class="head clearfix">
            <div class="isw-picture"></div>
            <h1><?= _( 'Зображення в слайдері' ); ?></h1>
        </div>
        <div class="block gallery clearfix">

            <? foreach( $slides as $fileName => $src ): ?>
                <div class="row-form clearfix">
                    <div class="span10">
                        <?= _( 'Попередній перегляд:' ); ?>
                        <div class="clear"></div>

                        <a class="fancybox"
                           id = "fancy-<?= $fileName; ?>"
                           href="<?= $src; ?>" style="margin: 15px;">
                            <img class="img-polaroid"
                                 width="520px"
                                 height="190px"
                                 id="img-<?= $fileName; ?>"
                                 src="<?= $src; ?>" />
                        </a>
                    </div>

                    <div class="span2">
                        <div class="btn" id="uploadButton-<?= $fileName; ?>">
                            <?= _( 'Завантажити' ); ?>
                        </div>
                    </div>

                </div>

                <script type="text/javascript">
                    jQuery( document ).ready(
                        function()
                        {
                            uploadController.initSliderImageUploader(
                                '<?= $this->createUrl( 'change' ); ?>',
                                'uploadButton-<?= $fileName; ?>',
                                {
                                    'allowedExtensions':[ 'jpg', 'jpeg', 'png' ],
                                    'sizeLimit': <?= Yii::app()->params[ 'uploader' ][ 'sizeLimit' ]; ?>
                                },
                                {
                                    'fileName' : '<?= $fileName; ?>'
                                }
                            );
                        }
                    );
                </script>

            <? endforeach; ?>
        </div>

    </div>

</div>

