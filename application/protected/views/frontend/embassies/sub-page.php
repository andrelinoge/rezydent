<?
/** @var $this SiteController */
/** @var $model Embassies[] */

?>

<div class="white-wrapper">
    <div class="inner">
        <h1 class="line"><?= $pageTitle; ?></h1>
        <div class="content">
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
                <h4>
                    <a href="<?= $url; ?>">
                        <?= $model->getCountry();?>
                    </a>
                </h4>
                <p>
                    <a href="<?= $url; ?>">
                        <?= $model->getTitle(); ?>
                    </a>
                </p>
            <? endforeach; ?>
        </div>
        <div class="clear"></div>
    </div>
</div>