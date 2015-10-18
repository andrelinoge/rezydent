<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $this ToursController */
/** @var $pageModel StaticPages */
/** @var $toursModels ToursAbroad[] */
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
        <h1 class="line"><?= $title; ?></h1>

        <div class="clear"></div>

        <div class="two-third">
            <?= $text; ?>

            <? $counter = 0; ?>

            <? foreach( $toursModels as $model ): ?>
                <?
                    $counter++;
                ?>
                <div class="one-third <?= ( $counter % 3 == 0 ) ? 'last' : ''; ?>">
                    <a href="<?= $this->createUrl( 'abroadShow', array( 'key' => $model->getTitleAsUrlParam( TRUE ), 'id' => $model->id ) ); ?>">
                        <h3 class="center">
                            <?= $model->getCountry(); ?>
                        </h3>
                        <img src="<?= $model->getSmallThumbnail();?>"
                             width="320px"
                             height="170px"
                             alt="<?= $model->getCountry(); ?>">
                    </a>
                </div>
                <?= ( $counter % 3 == 0 ) ? '<div class="clear"></div><br/>' : ''; ?>
            <?endforeach; ?>
        </div>

        <div class="one-third last">
            <? $this->widget( 'application.widgets.Frontend.Common.Tours' ); ?>
            <br><br>
            <div class="clear"></div>
            <? $this->widget( 'application.widgets.Frontend.Common.LastNews', array( 'titleLimit' => 19 ) ); ?>
            <br><br>
            <div class="clear"></div>
            <? $this->widget( 'application.widgets.Frontend.Common.LastMedia' ); ?>
        </div>

        <div class="clear"></div>
    </div>
</div>