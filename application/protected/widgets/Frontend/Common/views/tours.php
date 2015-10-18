<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $propositions Propositions[] */
?>
<h2 >Пошук туру</h2>

<a href="<?= createUrl( 'tours/abroad' ); ?>"
   id="consultationPopup"
   class="button aqua"
   style="opacity: 1; width: 200px; text-align: center;">
    <?= $titleToursAbroad; ?>
</a>

<a href="<?= createUrl( 'tours/children' ); ?>"
   id="consultationPopup"
   class="button aqua"
   style="opacity: 1; width: 200px; text-align: center;">
    <?= $titleToursChildren; ?>
</a>

<a href="<?= createUrl( 'tours/health' ); ?>"
   id="consultationPopup"
   class="button aqua"
   style="opacity: 1; width: 200px; text-align: center;">
    <?= $titleToursHealth; ?>
</a>

<a href="<?= createUrl( 'tours/ukraine' ); ?>"
   id="consultationPopup"
   class="button aqua"
   style="opacity: 1; width: 200px; text-align: center;">
    <?= $titleToursUkraine; ?>
</a>


<h2>Акційні пропозиції</h2>
<? foreach( $propositions as $proposition ): ?>
    <div>
        <?
        $url = createUrl(
            'proposition/show',
            array(
                'key' => $proposition->getTitleAsUrlParam( TRUE ),
                'id' => $proposition->id
            )
        );
        ?>
        <a href="<?= $url; ?>" >
            <img src="<?= $proposition->getSmallThumbnail(); ?>"  alt="" />
            <h4><?= $proposition->getTitle(); ?></h4>
        </a>
    </div>
<? endforeach; ?>
