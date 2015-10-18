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
            <div class="grid-wrapper">
                <div class="grid blog">
                    <? $i = 1; ?>
                    <? foreach( $models as $model ): ?>
                        <div class="post" style="width: 230px; <?= ( $i % 4 == 0 ) ? 'margin-right: 0px;' : 'margin-right: 20px;'; ?>">
                            <div class="info">
                                <div class="details">
                                    <?
                                    $url = $this->createUrl(
                                        'show',
                                        array(
                                            'key' => $model->getTitleAsUrlParam(),
                                            'id' => $model->id
                                        )
                                    );
                                    ?>
                                    <h6>
                                        <a href="<?= $url; ?>">
                                            <?= $model->getTitle( 25, TRUE ); ?>
                                        </a>
                                    </h6>

                                    <?
                                    $price = $model->getPrice();
                                    $days = $model->getDays();
                                    $comment = $model->getComment();
                                    ?>
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
                            <div class="frame">
                                <a href="<?= $url; ?>">
                                    <img alt="<?= $model->getTitle(); ?>"
                                         width="220px"
                                         height="160px"
                                         src="<?= $model->getSmallThumbnail(); ?>">
                                </a>
                            </div>
                            <div class="clear"></div>
                            <div>
                                <p>
                                    <?// if( mb_strlen( strip_tags( $model->getText() ), 'utf-8' ) > 150 ): ?>
                                        <?//= $model->getText( 150, TRUE ); ?>
                                        <a href="<?= $url; ?>"> Читати далі</a>
                                    <?// else: ?>
                                        <?//= $model->getText(); ?>
                                    <?// endif; ?>
                                </p>
                            </div>
                        </div>
                        <? $i++; ?>
                    <? endforeach; ?>
                </div>
            </div>

            <?
            $this->widget(
                'application.widgets.Templated.Pager',
                array(
                    'pagination' => $pagination,
                    'viewFile' => 'frontend',
                    'prevPageLabel' => '‹',
                    'firstPageLabel' => '«',
                    'nextPageLabel' => '›',
                    'lastPageLabel' => '»'
                )
            );
            ?>


        </div>
        <div class="clear"></div>
    </div>
</div>