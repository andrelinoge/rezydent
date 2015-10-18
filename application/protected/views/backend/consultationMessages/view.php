<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

/** @var $model ConsultationRequest */
?>

<div class="row-fluid">

    <div class="span12">
        <div class="head clearfix">
            <div class="isw-chats"></div>
            <h1>Запит на консультацію</h1>
        </div>
        <div class="block messaging">
            <div class="itemIn">
                <div class="text">
                    <div class="info clearfix">
                        <span style="color: #005580; float: left; font-size: 11px;">
                        <b>Ім'я: </b><?= $model->getName(); ?>
                    </span>
                        <span class="date"><?= $model->getCreatedAt(); ?></span>
                    </div>
                    <span style="color: #005580; float: left; font-size: 11px;">
                        <b>Телефон: </b><?= $model->getPhone(); ?>
                    </span>
                    <br />
                    <span style="color: #005580; float: left; font-size: 11px;">
                        <b>email: </b><?= $model->getEmail(); ?>
                    </span>
                    <br />
                    <span style="color: #005580; float: left; font-size: 11px;">
                        <b>Скайп: </b><?= $model->getSkype(); ?>
                    </span>
                    <br /><br />

                    <span style="color: #005580; float: left; font-size: 11px;">
                        <b>Повідомлення:</b>
                    </span>
                    <br />
                    <?= $model->getText(); ?>
                </div>
            </div>
            <? $email = $model->getEmail( FALSE, TRUE ); ?>
            <? if ( !empty( $email ) ): ?>
                <a href="mailto:<?= $email; ?>?subject=Повідомлення від турагенства РЕЗИДЕНТ"
                    class="btn">
                    Відповісти
                </a>
            <? endif; ?>
        </div>
    </div>

</div>