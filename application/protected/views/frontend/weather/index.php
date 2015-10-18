<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */

$title = $pageModel->getTitle();
$text = $pageModel->getText();
?>

<div class="white-wrapper">
    <div class="inner" id="content-container">
        <?
            $this->widget(
                'application.widgets.Templated.BreadCrumbs',
                array(
                    'viewFile' => 'frontend',
                    'items' => $this->breadcrumbs
                )
            );
        ?>

        <? if( !empty( $title ) ): ?>
            <h1 class="line"><?= $title; ?></h1>
        <? endif; ?>
        <? if( !empty( $text ) ): ?>
            <div class="content">
                <?= $text; ?>
            </div>
        <? endif; ?>

        <div>
            <object width="900" height="500" id="umapper_embed" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"><param value="kmlPath=http://umapper.s3.amazonaws.com/maps/kml/120181.kml" name="FlashVars"><param value="always" name="allowScriptAccess"><param value="true" name="allowFullScreen"><param value="http://umapper.s3.amazonaws.com/templates/swf/embed_weather.swf" name="movie"><param value="high" name="quality"><embed width="900" height="500" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="umapper_embed" quality="high" allowfullscreen="true" allowscriptaccess="always" flashvars="kmlPath=http://umapper.s3.amazonaws.com/maps/kml/120181.kml" src="http://umapper.s3.amazonaws.com/templates/swf/embed_weather.swf"></object>
        </div>
        <br/><br/><br/>
        <!--
        <a class="button aqua" href="<?//= $this->createUrl( 'resort' ); ?>">Погода на курортах</a>
        &nbsp;&nbsp;
        <a class="button aqua" href="<?//= $this->createUrl( 'sea' ); ?>">Температура морів</a>
        -->
        <div class="clear"></div>
    </div>
</div>