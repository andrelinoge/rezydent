<?php
/**
 * @author Andriy Tolstokorov
 */

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
            <div class="clear"></div>
        <? endif; ?>

        <div>

        <?= $seaTemperature; ?>

        </div>

        <div class="clear"></div>
        <br/><br/>
        <!--
        <a class="button aqua" href="<?//= $this->createUrl( 'resort' ); ?>">Погода на курортах</a>
        &nbsp;&nbsp;
        <a class="button aqua" href="<?//= $this->createUrl( 'index' ); ?>">Погода на карті світу</a>
        <div class="clear"></div>
        -->
    </div>
</div>