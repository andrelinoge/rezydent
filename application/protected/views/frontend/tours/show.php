<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $this ToursController */
/** @var $pageModel ToursChildren */
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

        <div class="two-third">
            <div class="post" style="background: none;">
                <h2 class="line">
                    <?= $pageModel->getTitle(); ?>
                </h2>

                <div id="content-container">
                    <?= $pageModel->getText(); ?>
                </div>
            </div>

            <div class="clear"></div>
        </div>

        <div class="one-fourth last">
            <? $this->widget( 'application.widgets.Frontend.Common.Tours' ); ?>
            <br><br>
            <div class="clear"></div>
            <?// $this->widget( 'application.widgets.Frontend.Common.LastNews', array( 'titleLimit' => 19 ) ); ?>
            <br><br>
            <div class="clear"></div>
            <?// $this->widget( 'application.widgets.Frontend.Common.LastMedia' ); ?>
        </div>

        <div class="clear"></div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(
        function()
        {
            $('.tabs').easytabs(
                {
                    animationSpeed: 300,
                    updateHash: false,
                    defaultTab: ".default"
                }
            );
        });
</script>