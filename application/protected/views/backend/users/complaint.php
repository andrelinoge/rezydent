<?php
/**
 * @author: Andriy Tolstokorov
 * Date: 12/8/12
 */

/** @var $this BackendController */
/** @var $complaint UserComplaints */
/** @var $user User */
?>

<div class="row-fluid">
    <div class="span8">
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1>Перегляд скарги на користувача: <?= $user->getFirstName(); ?></h1>
        </div>
        <div class="block">
            <div class="row-fluid">
                <div class="span6">
                    <dl>
                        <dt>Від</dt>
                        <dd>
                            <a href="<?= $this->createUrl( 'view', array( 'userId' => $complaint->getFromId() ) ); ?>">
                                <?= $complaint->getFromUser()->getFirstName(); ?>
                            </a>
                        </dd>

                        <dt>Причина</dt>
                        <dd><?= $complaint->getContent(); ?></dd>

                        <dt>Створено</dt>
                        <dd><?= $complaint->getCreatedAt(); ?></dd>
                    </dl>
                </div>

            </div>

            <a href="<?= $this->createUrl( 'complaints', array( 'userId' => $user->id ) ); ?>" class="btn"><span class="isw-left"></span>Назад</a>
        </div>
    </div>

</div>