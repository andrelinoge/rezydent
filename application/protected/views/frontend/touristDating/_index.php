<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $trips Trip[] */
?>

<? if( is_array( $trips ) ): ?>
    <? foreach( $trips as $trip ): ?>
        <div class="tripItem">
            <table>
                <tr>
                    <td rowspan="3">
                        <a href="<?= $this->createUrl( 'view', array( 'id' => $trip->owner_id ) ); ?>">
                            <img src="<?= $trip->getOwner()->getSmallThumbnail(); ?>"
                                 width="150px"
                                 alt="<?= $trip->getOwner()->getFirstName(); ?>" />
                        </a>
                    </td>
                    <td colspan="2" style="vertical-align: text-top; height: 20px">
                        <p class="tripOwner">
                            <a href="<?= $this->createUrl( 'view', array( 'id' => $trip->owner_id ) ); ?>">
                                <?= $trip->getOwner()->getFirstName(); ?> ( <?= $trip->getOwner()->getAge(); ?>, <?= $trip->getOwner()->getCountry(); ?>)
                            </a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="vertical-align: text-top">
                        Їду в <strong><?= $trip->getCountry(); ?></strong>, з <?= $trip->getStartAt(); ?> до <?= $trip->getEndAt(); ?>.
                        <br/>
                        Шукаю <strong><?= $trip->getCompanion(); ?></strong>, для <?= $trip->getPurpose(); ?>
                    </td>
                </tr>
                <tr style="vertical-align: bottom">
                    <td style="width: 30%">
                        <?= $trip->getCreatedAt(); ?>
                    </td>
                    <td style="width: 30%; text-align: center">
                        <span class="icon-eye"></span> <?= $trip->getViews(); ?>
                    </td>
                    <td style="width: 30%; text-align: right">
                        <a href="<?= $this->createUrl( 'trip', array( 'id' => $trip->id ) ); ?>">
                            Детальніше <span class="icon-right-hand"></span>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    <? endforeach; ?>
<? else: ?>
    <br/>
    <h4>
        За вашим запитом - нічого не знайдено!
    </h4>
<? endif; ?>

<div class="clear"></div>
<br/>
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

