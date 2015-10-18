<?
/** @var $message Messages */
?>
<div class="row-fluid">

    <div class="span12">
        <div class="row-fluid">
            <div class="head clearfix">
                <div class="isw-picture"></div>
                <h1>Повідомлення</h1>
            </div>
            <div class="block clearfix">
                <div class="span2">
                    <div class="ucard clearfix">
                        <div class="right">
                            <p><span class="label label-info">Відправиник</span></p>
                            <h4><?= $message->getSender()->getFirstName(); ?></h4>
                            <div class="image">
                                <a href="<?= $message->getSender()->getOriginalPhoto(); ?>" class="fancybox">
                                    <img class="img-polaroid"
                                         width="150px"
                                         height="150px"
                                         src="<?= $message->getSender()->getSmallThumbnail();?>">
                                </a>
                            </div>
                            <ul class="control">
                                <li>
                                    <span class="icon-calendar"></span>
                                    <a href="<?= $this->createUrl( 'trips', array( 'userId' => $message->getSender()->id ) ); ?>">
                                        Оголошення
                                    </a>
                                </li>
                                <li>
                                    <span class="icon-comment"></span>
                                    <a href="<?= $this->createUrl( 'messages', array( 'userId' => $message->getSender()->id ) ); ?>">
                                        Переписка
                                    </a>
                                </li>
                                <li>
                                    <span class="icon-zoom-in"></span>
                                    <a href="<?= $this->createUrl( 'view', array( 'userId' => $message->getSender()->id ) ); ?>">
                                        Профайл
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="span2">
                    <div class="ucard clearfix">
                        <div class="right">
                            <p><span class="label label-success">Одержувач</span></p>
                            <h4><?= $message->getReceiver()->getFirstName(); ?></h4>
                            <div class="image">
                                <a href="<?= $message->getReceiver()->getOriginalPhoto(); ?>" class="fancybox">
                                    <img class="img-polaroid"
                                         width="150px"
                                         height="150px"
                                         src="<?= $message->getReceiver()->getSmallThumbnail();?>">
                                </a>
                            </div>
                            <ul class="control">
                                <li>
                                    <span class="icon-calendar"></span>
                                    <a href="<?= $this->createUrl( 'trips', array( 'userId' => $message->getReceiver()->id ) ); ?>">
                                        Оголошення
                                    </a>
                                </li>
                                <li>
                                    <span class="icon-comment"></span>
                                    <a href="<?= $this->createUrl( 'messages', array( 'userId' => $message->getReceiver()->id ) ); ?>">
                                        Переписка
                                    </a>
                                </li>
                                <li>
                                    <span class="icon-zoom-in"></span>
                                    <a href="<?= $this->createUrl( 'view', array( 'userId' => $message->getReceiver()->id ) ); ?>">
                                        Профайл
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="span8">
                    <p><span class="label label-inverse">Текст:</span></p>
                    <p>
                        <?= $message->getText(); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
