<?
/** @var $this TouristDatingController */
/** @var $scheduledTrips Trip[] */
/** @var $pastTrips Trip[] */

$baseUrl = $this->getBehavioralBaseUrl();
$onFocus = 'frontendController.removeErrorHighlighting( this )';
?>

<div class="white-wrapper">
    <div class="inner" id="content-container">
        <?
        $this->widget(
            'application.widgets.Templated.BreadCrumbs',
            array(
                'viewFile' => 'frontend',
                'items' => $this->breadcrumbs
            )
        );
        ?>

        <div class="content">

            <div class="one-third">
                <h2><?= ucfirst( $user->getFirstName() ); ?></h2>
                <a href="<?= $user->getOriginalPhoto(); ?>"
                   title="<?= $user->getFirstName(); ?>"
                   class="fancy">
                    <img alt="<?= $user->getFirstName(); ?>"
                         width="200px"
                         class="left" src="<?= $user->getSmallThumbnail();?>">
                </a>
                <div class="clear"></div>
                <br/>

                <a href="#message-form-holder"
                   class="button navy"
                   style="width: 210px;"
                   id="message-popup"><span class="icon-mail"></span> Написати повідомлення</a>

                <a href="<?= $this->createUrl( 'photos', array( 'id' => $user->id ) ); ?>"
                   style="width: 210px;"
                   class="button navy"><span class="icon-picture"></span> Переглянути фото (<?= $countOfPhotos; ?>)</a>

                <a href="<?= $this->createUrl( 'trips', array( 'id' => $user->id ) ); ?>"
                   style="width: 210px;"
                   class="button navy"><span class="icon-address"></span> Переглянути поїздки</a>
            </div>

            <div class="three-fifth last">
                <div class="tabs tab-container">
                    <ul class="etabs">
                        <li class="tab">
                            <a href="#scheduled">
                                <span class="icon-calendar-1"></span> Заплановані поїздки
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#past">
                                <span class="icon-ok-circle"></span> Минулі поїздки
                            </a>
                        </li>
                    </ul>

                    <div class="panel-container">
                        <div id="scheduled">
                            <? if( is_array( $scheduledTrips ) ): ?>
                                <? foreach( $scheduledTrips as $trip ): ?>
                                    <div class="tripItem">
                                        <span class="icon-users"></span>  Шукаю <strong><?= $trip->getCompanion(); ?></strong>
                                        <br/>
                                        <span class="icon-flag-1"></span>  Їду в <strong><?= $trip->getCountry(); ?></strong>
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
                                    <div class="clear"></div>
                                <? endforeach ?>
                                <div class="clear"></div>
                                <br/>
                            <? else: ?>
                                <p>
                                    Запланованих поїздок ще немає
                                </p>
                            <? endif; ?>
                        </div>

                        <div id="past">
                            <?
                            $this->renderPartial(
                                '_past-trips',
                                array(
                                    'trips' => $pastTrips,
                                    'pagination' => $pastTripsPagination
                                )
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebox">
                <? $this->widget( 'application.widgets.Frontend.Dating.AccountSideBar' ); ?>
            </div>

            <div class="sidebox">
                <? $this->widget( 'application.widgets.Frontend.Common.Tours' ); ?>
            </div>
        </div>

        <div class="clear"></div>

    </div>
</div>

<script>
    $(document).ready( function() {
        $('.tabs').easytabs({
            animationSpeed: 300,
            updateHash: false
        });

        $( document ).on(
            'click',
            '#past a.pastTripsPagerButton',
            function( event )
            {
                $( '#past').load( $( event.target).attr( 'href' ) );
                return false;
            }
        );
    });
</script>


<? if ( !Yii::app()->user->isGuest ): ?>
    <div style="display:none; width: 800px">
        <div class="form-container" id="message-form-holder">
            <h4>Повідомлення для <?= $user->getFirstName(); ?></h4>
            <div class="response"></div>
            <?
            $form = $this->beginWidget(
                'CActiveForm',
                array(
                    'id'          => $messageForm::FORM_ID,
                    'action'      => $sendMessageHandlerUrl,
                    'htmlOptions' => array(
                        'name'  => get_class( $messageForm ),
                        'class' => 'forms',
                        'style' => 'width: 400px;'
                    )
                )
            );
            ?>
            <fieldset>
                <ol>
                    <li class="form-row text-area-row">
                        <?= $form->textArea(
                            $messageForm,
                            'text',
                            array(
                                'class' => 'text-area',
                                'onFocus' => $onFocus,
                                'id' => 'message-text',
                                'placeholder' => "Ваше повідомлення...",
                            )
                        ); ?>

                        <?= $form->hiddenField( $messageForm, 'receiver_id' ); ?>
                    </li>
                    <br/>
                    <li class="button-row center">
                        <?
                        $onclick = 'return frontendController.ajaxFormSubmit(\'' . $messageForm::FORM_ID;
                        $onclick .= '\', function(){ $.fancybox.close(); $("#message-text").val("") } );';
                        echo CHtml::submitButton(
                            'Надіслати',
                            array(
                                'onclick' => $onclick,
                                'class'   => 'button navy'
                            )
                        );
                        ?>
                    </li>
                </ol>
            </fieldset>

            <? $this->endWidget(); ?>
        </div>
    </div>

<? else: ?>

    <div style="display:none; width: 800px">
        <div  id="message-form-holder">
            <h4>Для того,щоб написати повідомлення для <?= $user->getFirstName(); ?>, авторизуйтесь або зарєструйтесь!</h4>
        </div>
    </div>

<? endif; ?>

<script>
    jQuery(
        function()
        {
            jQuery( '.fancy' ).fancybox(
                {
                    closeBtn: true,
                    openEffect : 'fade',
                    closeEffect : 'fade',
                    prevEffect : 'fade',
                    nextEffect : 'fade',
                    helpers : {
                        overlay : {
                            opacity: 0.9
                        }
                    }
                }
            );

            jQuery( "#message-popup" ).fancybox(
                {
                    closeBtn: true,
                    openEffect : 'fade',
                    closeEffect : 'fade',
                    prevEffect : 'fade',
                    nextEffect : 'fade',
                    helpers : {
                        overlay : {
                            opacity: 0.9
                        }
                    }
                }
            );
        }
    );
</script>