<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $trips Trip[] */
?>

<? if ( !empty( $trips ) ): ?>
        <? foreach( $trips as $trip ): ?>
            <div class="tripItem">
                <span class="icon-users"></span>  Шукаю - <strong><?= $trip->getCompanion(); ?></strong>
                <br/>
                <span class="icon-flag-1"></span>  Їду в - <strong><?= $trip->getCountry(); ?></strong>
                <br/>
                <span class="icon-calendar"></span>  Термін поїздки: з <strong><?= $trip->getStartAt( FALSE ); ?></strong> до <strong><?= $trip->getEndAt( FALSE ); ?></strong>
                <br/>
                <span class="icon-eye"></span>  Переглядів: <strong><?= $trip->getViews(); ?></strong>
                <br />
                <span class="icon-credit-card-1"></span>  Квитки: <strong><?= $trip->getTicketsValue(); ?></strong>
                <br />
                <a href="<?= $this->createUrl( 'trip', array( 'id' => $trip->id ) ); ?>" class="tripMoreInfo">
                    Дізнатися більше <span class="icon-right-hand"></span>
                </a>
            </div>
        <? endforeach; ?>

    <div class="clear"></div>
    <br/>
    <?
        $this->widget(
            'application.widgets.Templated.Pager',
            array(
                'pagination' => $pagination,
                'viewFile' => 'frontend-past-trips',
                'prevPageLabel' => '‹',
                'firstPageLabel' => '«',
                'nextPageLabel' => '›',
                'lastPageLabel' => '»'
            )
        );
    ?>
<? else: ?>
    <p>
        Список минулих подорожей порожній
    </p>
<? endif; ?>