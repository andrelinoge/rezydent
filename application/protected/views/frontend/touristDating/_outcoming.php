<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $messages Messages[] */
?>

<? if( is_array( $messages ) ): ?>
    <input type="hidden" id="outcomingCount" value="<?= count( $messages ); ?>"/>

    <? foreach( $messages as $message ): ?>
        <li class="clearfix" id="message-<?= $message->id; ?>">
            <div class="user">
                <a href="<?= $this->createUrl( 'touristDating/view', array( 'id' => $message->receiver_id ) ); ?>">
                    <img class="avatar"
                         width="60px"
                         height="60px"
                         src="<?= $message->getReceiver()->getMicroThumbnail(); ?>"
                         alt="<?= $message->getReceiver()->getFirstName(); ?>" />
                </a>
            </div>

            <div class="message">
                <span class="reply-link">
                    <a href="#" class="deleteOutcomingMessage" data-id="<?= $message->id; ?>">Видалити</a> |
                    <a href="<?= $this->createUrl( 'viewMessage', array( 'id' => $message->id ) ); ?>">Переглянути повністю</a>
                </span>
                <div class="info">
                    <h2>
                        <a href="<?= $this->createUrl( 'touristDating/view', array( 'id' => $message->receiver_id ) ); ?>">
                            <?= $message->getReceiver()->getFirstName(); ?>
                        </a>
                    </h2>
                    <div class="meta"><?= $message->getCreatedAt(); ?></div>
                    <div class="meta"><? if( $message->is_new ): ?>Не прочитане<? else: ?>Прочитане<? endif; ?></div>
                </div>
                <p><?= $message->getText( 20, TRUE ); ?></p>
            </div>
        </li>
    <? endforeach; ?>

    <div class="clear"></div>
    <br/>
    <?
        $this->widget(
            'application.widgets.Templated.Pager',
            array(
                'pagination' => $pagination,
                'viewFile' => 'frontend-outcoming-messages',
                'prevPageLabel' => '‹',
                'firstPageLabel' => '«',
                'nextPageLabel' => '›',
                'lastPageLabel' => '»'
            )
        );
    ?>
<? else: ?>
    <p>Ви ще нікому не писали.</p>
<? endif; ?>