<?
/** @var $this NewsController */
/** @var $pageModel News */
/** @var $model News */

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

        <div class="content">
            <div class="post">
                <div class="info">
                    <div class="date">
                        <div class="day"><?= $pageModel->getCreatedAt( 'd' )?></div>
                        <div class="month"><?= $this->getMonth( $pageModel->getCreatedAt( 'm' ) ); ?></div>
                    </div>
                    <div class="details">
                        <h6>
                            <?= $pageModel->getTitle(); ?>
                        </h6>
                    </div>
                </div>
                <div class="frame">
                    <img alt="<?= $pageModel->getTitle(); ?>" src="<?= $pageModel->getMediumThumbnail(); ?>">
                </div>
                <div id="content-container">
                    <?= $pageModel->getText(); ?>
                </div>
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebox">
                <h3>Останні новини</h3>
                <ul class="post-list">

                    <? foreach( $lastNews as $model ): ?>
                        <?
                            $url = $this->createUrl(
                                'show',
                                array(
                                    'key' => $model->getTitleAsUrlParam(),
                                    'id' => $model->id
                                )
                            );
                        ?>

                        <li>
                            <div class="frame">
                                <a href="<?= $url; ?>">
                                    <img alt="<?= $model->getTitle(); ?>" src="<?= $model->getMicroThumbnail(); ?>">
                                </a>
                            </div>
                            <div class="meta">
                                <h6>
                                    <a href="<?= $url; ?>">
                                        <?= $model->getTitle( 25, TRUE )?>
                                    </a>
                                </h6>
                                <em><?= $model->getCreatedAt( 'd m Y'); ?></em>
                            </div>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>

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