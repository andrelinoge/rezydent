<?
/** @var $this TouristDatingController */
/** @var $photos Photos[] */

$baseUrl = $this->getBehavioralBaseUrl();

$onFocus = 'frontendController.removeErrorHighlighting( this )';
Yii::app()
    ->clientScript
    ->registerPackage( 'fileUploader' )
    ->registerPackage( 'uploader' );
?>

<script>
    $(
        function()
        {
            uploadController.initUserPhotosUploader(
                '<?= $photosUploadHandlerUrl; ?>',
                'photoUploadButton',
                {
                    'allowedExtensions':[ 'jpg', 'jpeg', 'png' ],
                    'sizeLimit':20000000
                }
            );
        }
    );
</script>

<div class="white-wrapper">
<div class="inner">
<?
    $this->widget(
        'application.widgets.Templated.BreadCrumbs',
        array(
            'viewFile' => 'frontend',
            'items' => $this->breadcrumbs
        )
    );
?>

<div class="content">

    <? if( !empty( $photos ) ): ?>
        <ul class="items col4" id="photos-container">
            <? foreach( $photos as $photo ): ?>
                <li class="frame item center" id="photo-<?= $photo->id; ?>">
                    <a href="<?= $photo->getOriginal(); ?>" class="fancy">
                        <img alt="" width="200px;" src="<?= $photo->getSmallThumbnail(); ?>">
                    </a>
                    <a href="#"
                       data-id = "<?= $photo->id; ?>"
                       class="button red offsetFromPhoto deletePhoto">
                        <span class="icon-erase"></span> Видалити
                    </a>
                </li>
            <? endforeach; ?>
        </ul>
    <? else: ?>
        <p id="noPhotoMsg">
            <b>У вас ще немає фотографій</b>
        </p>
        <ul class="items col4" id="photos-container">

        </ul>
    <? endif; ?>
    <br/>
    <div class="clear"></div>
    <div id="photoUploadButton" class="button navy" style="cursor: pointer">
        Завантажити фотографії
    </div>
</div>

<div class="sidebar">
    <div class="sidebox">
        <? $this->widget( 'application.widgets.Frontend.Dating.AccountSideBar' ); ?>
    </div>

    <div class="sidebox">
        <? $this->widget( 'application.widgets.Frontend.Common.Tours' ); ?>
    </div>
</div>

<div class="clear"></div>

</div>
</div>


<script type="text/javascript">
    jQuery(document).ready(
        function()
        {
            $( 'a.fancy' ).fancybox();

            // OnClick event handler for delete buttons
            $( document ).on(
                'click',
                'a.deletePhoto',
                function( event )
                {
                    var id = $( event.target ).data( 'id' );
                    if( confirm( 'Видалити фотографію?' ) )
                    {
                        frontendController.ajaxPost(
                            '<?= $this->createUrl( 'deletePhotoHandler' );?>',
                            {
                                'id' : id
                            },
                            function( data )
                            {
                                if ( data.status == true )
                                {
                                    $( '#photo-' + id).remove();
                                }
                            }
                        );
                    }
                    return false;
                }
            );
        }
    );
</script>