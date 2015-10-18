<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

/** @var $model ContactMessage */

?>

<div class="row-fluid">

    <div class="span12">
        <div class="head clearfix">
            <div class="isw-chats"></div>
            <h1>Повідомлення від користувача</h1>
        </div>
        <div class="block messaging">
            <div class="itemIn">
                <div class="text">
                    <div class="info clearfix">
                        <span class="name"><?= $model->getName(); ?></span>
                        <span class="date"><?= $model->getCreatedAt(); ?></span>
                    </div>
                    <?= $model->getText(); ?>
                </div>
            </div>
            <a href="mailto:<?= $model->getEmail(); ?>?subject=Повідомлення від турагенства РЕЗИДЕНТ"
                class="btn">
                Відповісти
            </a>
        </div>
    </div>

</div>