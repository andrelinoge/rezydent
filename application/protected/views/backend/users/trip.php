<?php
/**
 * @author: Andriy Tolstokorov
 * Date: 12/8/12
 */

/** @var $this BackendController */
/** @var $trip Trip */
/** @var $user User */
?>

<div class="row-fluid">
    <div class="span8">
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>Перегляд подорожі користувача <?= $user->getFirstName(); ?></h1>
        </div>
        <div class="block">
            <div class="row-fluid">
                <div class="span6">
                    <dl>
                        <dt>Країна</dt>
                        <dd><?= $trip->getCountry(); ?></dd>

                        <dt>Ціль</dt>
                        <dd><?= $trip->getPurpose(); ?></dd>

                        <dt>Їде з</dt>
                        <dd><?= $trip->getWith(); ?></dd>

                        <dt>Шукає</dt>
                        <dd><?= $trip->getCompanion(); ?></dd>

                        <dt>Коментар</dt>
                        <dd><?= $trip->getComment(); ?></dd>
                    </dl>
                </div>

                <div class="span6">
                    <dl>
                        <dt>Термін</dt>
                        <dd><?= $trip->getStartAt(); ?> - <?= $trip->getEndAt(); ?></dd>

                        <dt>Наявність квитків</dt>
                        <dd><?= $trip->getTicketsValue(); ?></dd>

                        <dt>Бронь готелю</dt>
                        <dd><?= $trip->getHotelValue(); ?></dd>

                        <dt>Кількість дітей</dt>
                        <dd><?= $trip->getChildren(); ?></dd>

                        <dt>Створено</dt>
                        <dd><?= $trip->getCreatedAt(); ?></dd>
                    </dl>
                </div>
            </div>

            <a href="<?= $this->createUrl( 'trips', array( 'userId' => $user->id ) ); ?>" class="btn"><span class="isw-left"></span>Назад</a>
        </div>
    </div>

</div>