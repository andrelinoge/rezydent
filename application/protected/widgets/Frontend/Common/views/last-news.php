<?php
/** @var $models News[] */
?>

<h2>Останні новини</h2>
<ul class="post-list">

    <? foreach( $models as $model ): ?>
        <?
        $url = createUrl(
            'news/show',
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
            <div class="meta">
                <h6>
                    <a href="<?= $url; ?>"><?= $model->getTitle( $titleLimit, TRUE )?></a>
                </h6>
                <em><?= $model->getCreatedAt( 'd m Y'); ?></em>
            </div>
        </li>
    <? endforeach; ?>
</ul>