<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $this ToursController */
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

        <? if ( !empty( $title ) ): ?>
            <h1 class="line">
                <?= $title; ?>
            </h1>
            <div class="clear"></div>
        <? endif; ?>

        <div class="two-third">
            <? if ( !empty( $title ) ): ?>
                <?= $text; ?>
            <? endif; ?>
            <div class="clear"></div>
            <div class="tabs side-tab-container">
                <ul class="etabs" style="width: 240px;">
                    <? $isFirst = TRUE; ?>
                    <? foreach( $toursModels as $model ): ?>
                        <li class="<?= ( $isFirst ) ? 'default' : ''; ?> tab ">
                            <a href="#tab-<?= $model->id; ?>">
                                <?= $model->getValue(); ?>
                            </a>
                        </li>
                        <? $isFirst = FALSE; ?>
                    <? endforeach; ?>
                </ul>

                <div class="panel-container" style="width: 350px;">
                    <? foreach( $toursModels as $model ): ?>
                        <div id="tab-<?= $model->id; ?>" class="tab-item">
                            <? foreach( $model->getTours() as $tour ): ?>
                                <?
                                $url = $this->createUrl(
                                    'ukraineShow',
                                    array(
                                        'key' => $tour->getTitleAsUrlParam( TRUE ),
                                        'id' => $tour->id
                                    )
                                );
                                ?>
                                <a style="display: block;" href="<?= $url; ?>">
                                    <?= $tour->getTitle();?>
                                </a>
                                <br/>
                            <? endforeach; ?>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
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