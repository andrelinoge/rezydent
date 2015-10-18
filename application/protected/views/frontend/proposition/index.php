<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */
/** @var $models Propositions  */

$title = $pageModel->getTitle();
$text = $pageModel->getText();
?>


<div class="white-wrapper" id="content-container">
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

        <div class="page-intro line clearfix">
            <? if( !empty( $title ) ): ?>
                <h1 class="page-title"><?= $title; ?></h1>
            <? endif; ?>
        </div>
        <? if( !empty( $text ) ): ?>
            <div class="intro">
                <?= $text; ?>
            </div>
        <? endif; ?>

        <div class="">

            <div class="tabs side-tab-container">
                <ul class="etabs" style="width: 300px; padding-top: 20px;">
                    <? $isFirst = TRUE; ?>
                    <? foreach( $models as $model ): ?>
                        <li class="<?= ( $isFirst ) ? 'default' : ''; ?> tab ">
                            <a  href="#tab-<?= $model->id; ?>">
                                <?= $model->getTitle(); ?>
                            </a>
                        </li>
                        <? $isFirst = FALSE; ?>
                    <? endforeach; ?>
                </ul>

                <div class="panel-container">
                    <? foreach( $models as $model ): ?>
                        <div id="tab-<?= $model->id; ?>" class="tab-item">
                            <div class="post">
                                <div class="info">
                                    <div class="details">
                                        <?
                                        $url = $this->createUrl(
                                            'show',
                                            array(
                                                'key' => $model->getTitleAsUrlParam( TRUE ),
                                                'id' => $model->id
                                            )
                                        );
                                        ?>
                                        <h6>
                                            <a href="<?= $url; ?>">
                                                <?= $model->getTitle( NULL, TRUE ); ?>
                                            </a>
                                        </h6>

                                        <?
                                        $price = $model->getPrice();
                                        $days = $model->getDays();
                                        $comment = $model->getComment();
                                        ?>

                                        <div class="frame" style="float: left; clear: none;">
                                            <a href="<?= $url; ?>">
                                                <img alt="<?= $model->getTitle(); ?>"
                                                     width="220px"
                                                     height="160px"
                                                     src="<?= $model->getSmallThumbnail(); ?>">
                                            </a>
                                        </div>
                                        <div style="float: left; margin-left: 20px">
                                            <? if( !empty( $price ) ): ?>
                                                Ціна: <strong><?= $price?></strong>
                                                <br/>
                                            <? endif; ?>

                                            <? if( !empty( $days ) ): ?>
                                                Кількість днів: <strong><?= $days; ?></strong>
                                            <? endif; ?>

                                            <? if( !empty( $comment ) ): ?>
                                                <br/><i><?= $comment; ?></i>
                                            <? else: ?>
                                                <br/><br/>
                                            <? endif; ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div>
                                    <p>
                                        <? if( mb_strlen( strip_tags( $model->getText() ), 'utf-8' ) > 150 ): ?>
                                            <?= $model->getText( 350, TRUE ); ?>
                                        <? else: ?>
                                            <?= $model->getText(); ?>
                                        <? endif; ?>
                                        <br/><br/>
                                        <a href="<?= $url; ?>" class="button aqua">Дізнатися більше</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>

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