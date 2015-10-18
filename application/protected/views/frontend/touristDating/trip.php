<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $model Trip */
/** @var $this TouristDatingController */

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
                   class="button"
                   style="width: 210px;"
                   id="message-popup"><span class="icon-mail"></span> Написати повідомлення</a>

                <a href="<?= $this->createUrl( 'photos', array( 'id' => $user->id ) ); ?>"
                   style="width: 210px;"
                   class="button"><span class="icon-picture"></span> Переглянути фото (<?= $countOfPhotos; ?>)</a>

                <a href="<?= $this->createUrl( 'trips', array( 'id' => $user->id ) ); ?>"
                   style="width: 210px;"
                   class="button"><span class="icon-address"></span> Переглянути поїздки</a>
            </div>

            <div class="two-fourth last">
                <h3>Деталі поїздки</h3>
                <table class="tripInfo">
                    <tr>
                        <td>
                            Їду в
                        </td>
                        <td>
                            <strong>
                                <?= $model->getCountry(); ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Термін
                        </td>
                        <td>
                            З <strong><?= $model->getStartAt(); ?></strong> До <strong><?= $model->getEndAt(); ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Поїздку заплановано
                        </td>
                        <td>
                            <strong><?= $model->getCreatedAt() ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Для
                        </td>
                        <td>
                            <strong><?= $model->getPurpose(); ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Їду з
                        </td>
                        <td>
                            <strong><?= $model->getWith(); ?></strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Шукаю
                        </td>
                        <td>
                            <strong><?= $model->getCompanion(); ?></strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Кількість дітей
                        </td>
                        <td>
                            <strong><?= $model->getChildren(); ?></strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Наявність квитків
                        </td>
                        <td>
                            <strong><?= $model->getTicketsValue(); ?></strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Заброньовано готель
                        </td>
                        <td>
                            <strong><?= $model->getHotelValue(); ?></strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Переглядів
                        </td>
                        <td>
                            <strong><?= $model->getViews(); ?></strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Коментар
                        </td>
                        <td>
                            <strong><?= $model->getComment(); ?></strong>
                        </td>
                    </tr>
                </table>
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
                                'class'   => 'btn-submit'
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