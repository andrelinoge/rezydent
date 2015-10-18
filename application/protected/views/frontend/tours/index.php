<?php
/** @var $this ToursController */
/** @var $pageModel StaticPages */
$title = $pageModel->getTitle();
$text = $pageModel->getText();
$baseUrl = $this->getBehavioralBaseUrl();
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
            <div class="">
                <?= $text; ?>
            </div>
        <? endif; ?>

        <div class="clear"></div>

        <div class="two-third">
            &nbsp;
            <div id="tour_search_module">
                <br><br><br><br>
                <img
                    style="margin: 0 auto"
                    width="30px"
                    height="30px"
                    src="<?= $baseUrl; ?>/style/images/loading.gif"
                    />
            </div>
        </div>

        <div class="one-third last">
            <? $this->widget( 'application.widgets.Frontend.Common.Tours' ); ?>
            <br><br>
            <div class="clear"></div>
            <? $this->widget( 'application.widgets.Frontend.Common.LastNews' ); ?>
        </div>

        <div class="clear"></div>
    </div>
</div>
<script src="http://module.ittour.com.ua/tour_search.jsx?id=269D766797G25282933N445&ver=1&type=2970"></script>