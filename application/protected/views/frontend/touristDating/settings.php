<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */
/** @var $trips Trip[] */
/** @var $userModel User  */

$baseUrl = $this->getBehavioralBaseUrl();

$onFocus = 'frontendController.removeErrorHighlighting( this )';
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' )
    ->registerScriptFile( 'http://code.jquery.com/ui/1.10.2/jquery-ui.js', ClientScript::POS_END )
    ->registerCssFile( 'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css' );
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

            <div class="form-container">
                <h2 class="line">Особисті дані</h2>
                <div class="response"></div>
                <?
                $form = $this->beginWidget(
                    'CActiveForm',
                    array(
                        'id'          => $userModel::FORM_ID,
                        'action'      => $updateProfileAction,
                        'htmlOptions' => array(
                            'name'  => get_class( $userModel ),
                            'class' => 'forms',
                        )
                    )
                );
                ?>
                <fieldset>
                    <ol>
                        <li class="form-row text-input-row">
                            <span>Ім'я</span>
                            <?= $form->textField(
                                $userModel,
                                'first_name',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row">
                            <span>Стать</span>
                            <?= $form->dropdownList(
                                    $userModel,
                                    'sex',
                                    $sexOptions,
                                    array(
                                        'class' => 'text-input',
                                        'onFocus' => $onFocus,
                                    )
                                );
                            ?>
                        </li>

                        <li class="form-row text-input-row">
                            <span>День народження</span>
                            <?= $form->textField(
                                $userModel,
                                'birthday',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'value' => $userModel->getBirthday( 'd-m-Y', ' ' ),
                                )
                            );
                            ?>
                        </li>

                        <li class="form-row text-input-row">
                            <span>Країна</span>
                            <?= $form->textField(
                                $userModel,
                                'country',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row">
                            <span>Місто</span>
                            <?= $form->textField(
                                $userModel,
                                'city',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row">
                            <span>Сімейний стан</span>
                            <?= $form->dropdownList(
                                $userModel,
                                'marital_id',
                                $maritalStatuses,
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                )
                            );
                            ?>
                        </li>

                        <li class="form-row text-input-row">
                            <span>Контакти</span>
                            <?= $form->textField(
                                $userModel,
                                'contacts',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row">
                            <span>Знання мов</span>
                            <?= $form->textField(
                                $userModel,
                                'languages',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                )
                            ); ?>
                        </li>

                        <span>Про себе</span>
                        <li class="form-row text-area-row">
                            <?= $form->textArea(
                                $userModel,
                                'about',
                                array(
                                    'class' => 'text-area',
                                    'onFocus' => $onFocus,
                                )
                            ); ?>
                        </li>

                        <br/>

                        <li class="button-row">
                            <?
                            $onclick = 'return frontendController.ajaxFormSubmit(\'' . $userModel::FORM_ID;
                            $onclick .= '\' );';
                            echo CHtml::submitButton(
                                'Зберегти',
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

            <br/><br/>
            <div class="form-container">
                <h2 class="line">Змінити пароль</h2>
                <div class="response"></div>
                <?
                $form = $this->beginWidget(
                    'CActiveForm',
                    array(
                        'id'          => $changePasswordForm::FORM_ID,
                        'action'      => $changePasswordAction,
                        'htmlOptions' => array(
                            'name'  => get_class( $changePasswordForm ),
                            'class' => 'forms',
                        )
                    )
                );
                ?>
                <fieldset>
                    <ol>
                        <li class="form-row text-input-row">
                            <?= $form->passwordField(
                                $changePasswordForm,
                                'old',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => "Старий пароль",
                                )
                            ); ?>
                        </li>
                        <li class="form-row text-input-row">
                            <?= $form->passwordField(
                                $changePasswordForm,
                                'new',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => "Новий пароль",
                                )
                            ); ?>
                        </li>
                        <li class="form-row text-input-row">
                            <?= $form->passwordField(
                                $changePasswordForm,
                                'confirm',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => 'Підтвердження'
                                )
                            ); ?>
                        </li>

                        <li class="button-row">
                            <?
                            $onclick = 'return frontendController.ajaxFormSubmit(\'' . $changePasswordForm::FORM_ID;
                            $onclick .= '\' );';
                            echo CHtml::submitButton(
                                'Змінити',
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
    jQuery(function($){
        $.datepicker.regional['ua'] = {
            closeText: 'Закрити',
            prevText: 'Попередній',
            nextText: 'Наступний',
            currentText: 'Aujourd\'hui',
            monthNames: ['Січень','Лютий','Березень','Квітень','Травень','Червень',
                'Липень','Серпень','Вересень','Жовтень','Листопад','Грудень'],
            monthNamesShort: ['Січ.','Лют.', 'Бер.','Квіт.','Трав.','Черв.',
                'Лип.','Серп.','Вер.','Жовт.','Лист.','Груд.'],
            dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
            dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
            dayNamesMin: [ 'Нд', 'Пн','Вт','Ср','Чт','Пт','Сб'],
            weekHeader: 'Sem.',
            dateFormat: 'dd-mm-yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['fr']);
    });

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

            $.datepicker.setDefaults( $.datepicker.regional[ "ua" ] );

            jQuery( '#User_birthday' ).datepicker(
                {
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1950:1995"
                }
            );
        }
    );
</script>