<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $pageModel ToursAbroad */
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

        <h1 class="line">
            <?= $pageModel->getTitle(); ?>
        </h1>
        <div class="clear"></div>

        <div style="float: left;" id="content-container">
            <?= $pageModel->getText(); ?>
        </div>

        <div class="clear"></div>
        <br/>

        <div class="center">
            <iframe style="border: 1px solid;" src="<?= $pageModel->frame_url; ?>" width="800px" height="600px"></iframe>
        </div>
    </div>
</div>