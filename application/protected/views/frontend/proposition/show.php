<?
/** @var $this NewsController */
/** @var $pageModel News */
/** @var $model News */

Yii::app()
    ->clientScript
    ->registerScriptFile( getPublicUrl() . '/common/js/plugins/scrollTo/jquery.scrollto.js', ClientScript::POS_END )
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

        <div class="content">
            <div class="post" style="background: none;">
                <h1 class="line">
                    <?= $pageModel->getTitle(); ?>
                </h1>
                <!--
                <div class="frame">
                    <img alt="<?//= $pageModel->getTitle(); ?>" src="<?= $pageModel->getMediumThumbnail(); ?>">
                </div>
                -->
                <div>
                    <?= $pageModel->getText(); ?>
                </div>
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebox">
                <h3>Інші пропозиції</h3>
                <ul class="post-list">

                    <? foreach( $models as $model ): ?>
                        <?
                        $url = $this->createUrl(
                            'show',
                            array(
                                'key' => $model->getTitleAsUrlParam( TRUE ),
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
                            <div class="meta" style="width: 180px">
                                <h6>
                                    <a href="<?= $url; ?>">
                                        <?= $model->getTitle( 25, TRUE )?>
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
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="clear"></div>

    </div>
</div>