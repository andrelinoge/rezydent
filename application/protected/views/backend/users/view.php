<?
/** @var $user User */
/** @var $photos Photos[] */
/** @var $lastTrips Trip[] */
/** @var $lastComplaints UserComplaints[] */
?>
<div class="row-fluid">

    <div class="span6">
        <div class="row-fluid">
            <div class="span4">
                <div class="ucard clearfix">
                    <div class="right">
                        <h4><?= $user->getFirstName(); ?></h4>
                        <div class="image">
                            <a href="<?= $user->getOriginalPhoto(); ?>" class="fancybox">
                                <img class="img-polaroid"
                                     width="150px"
                                     height="150px"
                                     src="<?= $user->getSmallThumbnail();?>">
                            </a>
                        </div>
                        <ul class="control">
                            <li>
                                <span class="icon-user"></span>
                                Статус:
                                <a href="#" onclick="return toggleBanStatus(); ">
                                    <strong id="status"><?= ( $user->is_banned ) ? 'заблокований' : 'розблокований' ;?></strong>
                                </a>
                            </li>
                            <li>
                                <span class="icon-calendar"></span>
                                <a href="<?= $this->createUrl( 'trips', array( 'userId' => $user->id ) ); ?>">
                                    Оголошення
                                </a>
                            </li>
                            <li>
                                <span class="icon-comment"></span>
                                <a href="<?= $this->createUrl( 'messages', array( 'userId' => $user->id ) ); ?>">
                                    Переписка
                                </a>
                            </li>
                            <li>
                                <span class="icon-pencil"></span>
                                <a href="<?= $this->createUrl( 'editUser', array( 'id' => $user->id ) ); ?>">
                                    Редагувати
                                </a>
                            </li>
                            <li>
                                <span class="icon-remove"></span>
                                <a href="<?= $this->createUrl( 'deleteUser', array( 'id' => $user->id ) ); ?>"
                                    onclick="return confirm( 'Видалити користувача?');">
                                    Видалити
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="span8">
                <div class="block ucard">

                    <div class="info">
                        <ul class="rows">
                            <li class="heading">Основні дані</li>

                            <li>
                                <div class="title">Імя:</div>
                                <div class="text"><?= $user->getFirstName(); ?></div>
                            </li>

                            <li>
                                <div class="title">Стать:</div>
                                <div class="text"><?= $user->getSex(); ?></div>
                            </li>

                            <li>
                                <div class="title">Email:</div>
                                <div class="text"><?= $user->getEmail() ?></div>
                            </li>

                            <li>
                                <div class="title">Вік:</div>
                                <div class="text"><?= $user->getAge(); ?></div>
                            </li>

                            <li>
                                <div class="title">Сімейний стан</div>
                                <div class="text"><?= $user->getMaritalStatus( 'не вказаний' ); ?></div>
                            </li>

                            <li>
                                <div class="title">Країна</div>
                                <div class="text"><?= $user->getCountry( 'не вказана' ); ?></div>
                            </li>

                            <li>
                                <div class="title">Місто</div>
                                <div class="text"><?= $user->getCity( 'не вказано' ); ?></div>
                            </li>

                            <li>
                                <div class="title">Контакти</div>
                                <div class="text"><?= $user->getContacts( 'не вказані' ); ?></div>
                            </li>

                            <li>
                                <div class="title">Знання мов</div>
                                <div class="text"><?= $user->getLanguages( 'не вказано' ); ?></div>
                            </li>

                            <li>
                                <div class="title">Про себе:</div>
                                <div class="text"><?= $user->getAbout( 'не вказано' ); ?></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="span6">
        <div class="row-fluid">
            <div class="span9">
                <div class="block ucard">

                    <div class="info">
                        <ul class="rows">
                            <li class="heading">Останні оголошення</li>
                            <? if ( !empty( $lastTrips ) ): ?>
                                <? foreach( $lastTrips as $trip  ): ?>
                                    <li>
                                        <div class="title"><?= $trip->getCountry(); ?></div>
                                        <div class="text"><?= $trip->getStartAt() ?> - <?= $trip->getEndAt(); ?></div>
                                    </li>
                                <? endforeach; ?>
                                <li style="padding: 10px">
                                    <a href="<?= $this->createUrl( 'trips', array( 'userId' => $user->id ) ); ?>"
                                       class="btn">Переглянути всі<span class="isw-right"></span></a>
                                </li>
                            <? else: ?>
                                <li>
                                    <div class="text">Оголошення відсутні</div>
                                </li>
                            <? endif; ?>
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <div class="info" style="margin-top: 3px">
                        <ul class="rows">
                            <li class="heading">Останні скарги на користувача</li>
                            <? if ( !empty( $lastComplaints ) ): ?>
                                <? foreach( $lastComplaints as $complaint  ): ?>
                                    <li>
                                        <div class="title"><?= $complaint->getFromUser()->getFirstName(); ?></div>
                                        <div class="text"><?= $complaint->getContent( 50, TRUE ); ?></div>
                                    </li>
                                <? endforeach; ?>
                                <li style="padding: 10px">
                                    <a href="<?= $this->createUrl( 'complaints', array( 'userId' => $user->id ) ); ?>"
                                       class="btn">Переглянути всі<span class="isw-right"></span></a>
                                </li>
                            <? else: ?>
                                <li>
                                    <div class="text">Скарги відсутні</div>
                                </li>
                            <? endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row-fluid">
    <div class="span12">
        <div class="head clearfix">
            <div class="isw-picture"></div>
            <h1>Фотографії</h1>
        </div>
        <div class="block thumbs clearfix">
            <? if ( is_array( $photos ) ): ?>
                <? foreach( $photos as $photo ): ?>
                    <div class="thumbnail" id="item-<?= $photo->id; ?>">
                        <a class="fancybox"
                           rel="group"
                           href="<?= $photo->getOriginal(); ?>">
                            <img src="<?= $photo->getSmallThumbnail(); ?>"
                                 width="200px"
                                 height="150px"
                                 class="img-polaroid"/>
                        </a>
                        <div class="caption">
                            <br/>
                            <p>
                                <a class="btn btn-danger deletePhoto"
                                   data-id = "<?= $photo->id; ?>"
                                   href="#">Видалити</a>
                            </p>
                        </div>
                    </div>
                <? endforeach; ?>
            <? else: ?>
                <p>
                    Фотографій ще немає
                </p>
            <? endif; ?>
        </div>

    </div>
</div>

<script>
    function toggleBanStatus()
    {
        if( confirm( 'Змінити статус?' ) )
        {
            backendController.ajaxPost(
                '<?= $this->createUrl( 'changeBanStatusHandler' );?>',
                {
                    'id' : <?= $user->id; ?>
                },
                function( data )
                {
                    if ( data.status == true )
                    {
                        $( '#status').html( data.newUserStatus );
                    }
                }
            );
        }
        return false;
    }

    $(document).ready(
        function()
        {
            $( document ).on(
                'click',
                'a.deletePhoto',
                function( event )
                {
                    var id = $( event.target ).data( 'id' );
                    if( confirm( 'Видалити фотографію?' ) )
                    {
                        backendController.ajaxPost(
                            '<?= $this->createUrl( 'deletePhotoHandler' );?>',
                            {
                                'id' : id
                            },
                            function( data )
                            {
                                if ( data.status == true )
                                {
                                    $( '#item-' + id).remove();
                                }
                            }
                        );
                    }
                    return false;
                }
            );
        }
    );
</script>