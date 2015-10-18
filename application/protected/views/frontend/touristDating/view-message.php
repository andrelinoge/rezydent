<?
/** @var $this TouristDatingController */
/** @var $model Messages */
/** @var $user User  */

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
            <div class="comments">
                <h3><? if( $isReceived ): ?>Одержане<? else: ?>Надіслане<? endif; ?> повідомлення</h3>
                <ol class="commentlist" id="incoming-block">
                    <li class="clearfix">
                        <div class="user">
                            <a href="<?= $this->createUrl( 'touristDating/view', array( 'id' => $user->id ) ); ?>">
                                <img class="avatar"
                                     width="60px"
                                     height="60px"
                                     src="<?= $user->getMicroThumbnail(); ?>"
                                     alt="<?= $user->getFirstName(); ?>" />
                            </a>
                        </div>

                        <div class="message" style="background-color: #F5F5F5">
                            <span class="reply-link">
                                <a href="#"
                                   onclick="if (confirm( 'Видалити повідомлення' )) {
                                       frontendController.ajaxPost(
                                       '<?= $this->createUrl( 'deleteMessageHandler', array( 'id' => $model->id ) ); ?>',
                                       {}, function(data){ window.location = '<?= $this->createUrl( 'messages');?>' } );} return false;"
                                   >Видалити</a>

                                <? if ( $isReceived ): ?>
                                    <a id="message-popup" href="#message-form-holder">Відповісти</a>
                                <? endif; ?>
                            </span>
                            <div class="info">
                                <h2>
                                    <a href="<?= $this->createUrl( 'touristDating/view', array( 'id' => $user->id ) ); ?>">
                                        <?= $user->getFirstName(); ?>
                                    </a>
                                </h2>
                                <div class="meta"><?= $model->getCreatedAt(); ?></div>
                            </div>
                            <p><?= $model->getText(); ?></p>
                        </div>
                    </li>
                </ol>
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

<? if ( $isReceived ): ?>
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

    <script>
        $(
            function()
            {
                $( "#message-popup" ).fancybox(
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

<? endif; ?>