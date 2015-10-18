<?php
/** @var $models Media[] */
?>

<h2>Фото та відео</h2>
<ul class="post-list">

    <? foreach( $models as $model ): ?>
        <?
        $url = createUrl(
            'media/show',
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