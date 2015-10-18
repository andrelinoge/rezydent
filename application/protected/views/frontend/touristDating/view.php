<?
/** @var $this TouristDatingController */
/** @var $user User */
/** @var $trips Trip[] */
/** @var $complaintForm ComplaintForm */

$baseUrl = $this->getBehavioralBaseUrl();

$onFocus = 'frontendController.removeErrorHighlighting( this )';
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' );
?>

<div class="white-wrapper">
    <div class="inner">
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
            <div class="inner">
                <div class="one-fourth">
                    <h2><?= $user->getFirstName(); ?></h2>
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

                    <? if ( !Yii::app()->user->isGuest ): ?>
                        <a href="#complaint-form-holder"
                           style="width: 210px;"
                           id="complaint-popup"
                           class="button red"><span class=" icon-thumbs-down-1"></span> Поскаржитись</a>
                    <? endif; ?>
                </div>

                <div class="three-fourth last">
                    <br/>
                    <ul>
                        <li><h4>Основні відомості</h4></li>
                        <li>Стать: <i><?= $user->getSex(); ?></i></li>
                        <li>Вік: <i><?= $user->getAge(); ?></i></li>
                        <li>Сімейний стан: <i><?= $user->getMaritalStatus(); ?></i></li>

                        <? if (!empty( $country ) ): ?>
                            <li>Країна: <i><?= $user->getCountry( 'Не вказано' ); ?></i></li>
                        <? endif; ?>

                        <? if (!empty( $city ) ): ?>
                            <li>Місто: <i><?= $user->getCity( 'Не вказано' ); ?></i></li>
                        <? endif; ?>

                        <? if (!empty( $contacts ) ): ?>
                            <li>Контакти: <i><?= $user->getContacts( 'Не вказано' ); ?></i></li>
                        <? endif; ?>

                        <? if (!empty( $languages ) ): ?>
                            <li>Знання мов: <i><?= $user->getLanguages( 'Не вказано' ); ?></i></li>
                        <? endif; ?>

                        <? if (!empty( $about ) ): ?>
                            <br/>
                            <li><h4>Про себе</h4></li>
                            <p><?= $about; ?></p>
                        <? endif; ?>
                    </ul>
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
                                'placeholder' => "Ваше повідомлення...",
                            )
                        ); ?>

                        <?= $form->hiddenField( $messageForm, 'receiver_id' ); ?>
                    </li>
                    <br/>
                    <li class="button-row center">
                        <?
                        $onclick = 'return frontendController.ajaxFormSubmit(\'' . $messageForm::FORM_ID;
                        $onclick .= '\', function(){ $.fancybox.close(); $("#MessageForm_text").val("") } );';
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

    <div style="display:none; width: 800px">
        <div class="form-container" id="complaint-form-holder">
            <h4>Скарга на <?= $user->getFirstName(); ?></h4>
            <div class="response"></div>
            <?
            $form = $this->beginWidget(
                'CActiveForm',
                array(
                    'id'          => $complaintForm::FORM_ID,
                    'action'      => $this->createUrl( 'complaintHandler' ),
                    'htmlOptions' => array(
                        'name'  => get_class( $complaintForm ),
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
                            $complaintForm,
                            'content',
                            array(
                                'class' => 'text-area',
                                'onFocus' => $onFocus,
                                'placeholder' => "Причина скарги...",
                            )
                        ); ?>

                        <?= $form->hiddenField( $complaintForm, 'on_id' ); ?>
                    </li>

                    <?php if(CCaptcha::checkRequirements()): ?>
                        <li class="form-row">
                            <?php
                            $this->widget(
                                'CCaptcha',
                                array(
                                    'captchaAction' => Yii::app()->createUrl( 'site/captcha' ),
                                    'buttonLabel'   => 'Обновити',
                                    'buttonOptions' => array(
                                        'class' => 'button navy',
                                        'style' => 'float: left; display: block; margin-top: 10px; margin-left: 15px;',
                                        'id' => 'captcha_btn'
                                    ),
                                    'imageOptions' => array(
                                        'style' => 'float: left; display: block;'
                                    ),
                                    'clickableImage' => TRUE
                                )
                            );
                            ?>
                            <?= $form->textField(
                                $complaintForm,
                                'verifyCode',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => 'Введіть код',
                                )
                            ); ?>
                        </li>
                    <? endif; ?>

                    <br/>
                    <li class="button-row center">
                        <?
                        $onclick = 'return frontendController.ajaxFormSubmit(\'' . $complaintForm::FORM_ID;
                        $onclick .= '\', function( data ){ if ( data.status == true ) { $.fancybox.close(); $("#ComplaintForm_content").val(""); jQuery( "#captcha_btn").click(); } } );';
                        echo CHtml::submitButton(
                            'Поскаржитись',
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

            jQuery( "#complaint-popup" ).fancybox(
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