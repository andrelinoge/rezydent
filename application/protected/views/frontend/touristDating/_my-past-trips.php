<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $trips Trip[] */
?>

<? if ( !empty( $trips ) ): ?>
    <input type="hidden" value="<?= count( $trips ); ?>" id="pastCount" />
    <table class="myTrips">
        <thead>
        <td>
            Їду в
        </td>
        <td>
            Термін поїздки
        </td>
        <td>
            Створено
        </td>
        <td>
            Переглядів
        </td>
        <td>
            Дії
        </td>
        </thead>

        <tbody>
        <? foreach( $trips as $trip ): ?>
            <tr id="item-<?= $trip->id; ?>" style="text-align: center">
                <td style="text-align: left">
                    <a href="<?= $this->createUrl( 'myTrip', array( 'id' => $trip->id ) ); ?>">
                        <?= $trip->getCountry(); ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $this->createUrl( 'myTrip', array( 'id' => $trip->id ) ); ?>">
                        <?= $trip->getStartAt( FALSE ); ?> <span class="icon-right"></span> <?= $trip->getEndAt( FALSE ); ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $this->createUrl( 'myTrip', array( 'id' => $trip->id ) ); ?>">
                        <?= $trip->getCreatedAt( FALSE ); ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $this->createUrl( 'myTrip', array( 'id' => $trip->id ) ); ?>">
                        <?= $trip->getViews(); ?>
                        </a>
                </td>
                <td>
                    <a href="<?= $this->createUrl( 'CreateUpdateTrip', array( 'id' => $trip->id ) )?>"
                       style="padding: 0 10px; margin-right: 10px;"
                       class="button navy">
                        <span class="icon-edit"></span>
                        Редагувати
                    </a>
                    <a href="#"
                       style="padding: 0 10px"
                       class="deleteTrip button red"
                       data-id="<?= $trip->id; ?>"><span class="icon-erase"></span>Видалити</a>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>

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