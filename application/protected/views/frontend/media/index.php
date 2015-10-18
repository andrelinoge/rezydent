<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */
/** @var $model News  */

$title = $pageModel->getTitle();
$text = $pageModel->getText();
?>


<div class="white-wrapper">
    <div class="inner" >
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

        <div class="content">
            <div class="grid-wrapper">
                <div class="grid blog">
                    <? $i = 1; ?>
                    <? foreach( $models as $model ): ?>
                        <div class="post">
                            <div class="info">
                                <div class="date">
                                    <div class="day"><?= $model->getCreatedAt( 'd' ); ?></div>
                                    <div class="month">
                                        <?= $this->getMonth( $model->getCreatedAt( 'm' ) ); ?>
                                    </div>
                                </div>
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
                                            <?= $model->getTitle( 25, TRUE ); ?>
                                        </a>
                                    </h6>

                                </div>
                            </div>
                            <div class="frame">
                                <a href="<?= $url; ?>">
                                    <img alt="<?= $model->getTitle(); ?>" src="<?= $model->getSmallThumbnail(); ?>">
                                </a>
                            </div>
                            <div class="clear"></div>
                            <div>
                                <? if( mb_strlen( strip_tags( $model->getText() ), 'utf-8' ) > 200 ): ?>
                                    <?= $model->getText( 200, TRUE ); ?>
                                    <a href="<?= $url; ?>"> Читати далі</a>
                                <? else: ?>
                                    <?= strip_tags( $model->getText() ); ?>
                                    <a href="<?= $url; ?>"> Читати далі</a>
                                <? endif; ?>
                            </div>
                        </div>
                        <? $i++; ?>
                        <? if( $i > 3 ): ?>
                            <? $i = 1; ?>
                        <? endif; ?>
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
        <div class="sidebar">
            <div class="sidebox">
                <h3>Архів</h3>
                <ul class="list">
                    <? foreach( $archiveYears as $year ): ?>
                        <li>
                            <a href="<?= $this->createUrl( 'index', array( 'year' => $year ) ); ?>"><?= $year; ?></a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>