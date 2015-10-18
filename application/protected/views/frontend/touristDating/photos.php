<?
/** @var $this TouristDatingController */
/** @var $photos Photos[] */

$baseUrl = $this->getBehavioralBaseUrl();

$onFocus = 'frontendController.removeErrorHighlighting( this )';

?>

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
        <ul class="items col4">
            <? foreach( $photos as $photo ): ?>
                <li class="frame item center">
                    <a href="<?= $photo->getOriginal(); ?>" class="fancy" rel="group1">
                        <img alt="" width="200px;" src="<?= $photo->getSmallThumbnail(); ?>">
                    </a>
                </li>
            <? endforeach; ?>
        </ul>
    <? else: ?>
        <p id="noPhotoMsg">
            <b>Користувач ще не завантажив фотографій</b>
        </p>
    <? endif; ?>
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
        }
    );
</script>