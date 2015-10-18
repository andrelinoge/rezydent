<?php
/**
 * @author Andriy Tolstokorov
 */

/** @var $model User */

Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' )
    ->registerPackage( 'fileUploader' )
    ->registerPackage( 'uploader' );

$onFocus = 'frontendController.removeErrorHighlighting( this )';
?>

<script>
    $(
        function()
        {
            uploadController.initUserAvatarUploader(
                '<?= $avatarUploadHandlerUrl; ?>',
                'uploadButton',
                {
                    'allowedExtensions':[ 'jpg', 'jpeg', 'png' ],
                    'sizeLimit':20000000
                }
            );
        }
    );
</script>

<? if ( Yii::app()->user->isGuest ): ?>
        <div class="form-container">
            <h2>Ввійти</h2>
            <div class="response"></div>
            <?
                $form = $this->beginWidget(
                    'CActiveForm',
                    array(
                        'id'          => $loginForm::FORM_ID,
                        'action'      => $loginHandlerUrl,
                        'htmlOptions' => array(
                            'name'  => get_class($loginForm),
                            'class' => 'forms',
                        )
                    )
                );
            ?>
            <fieldset>
                <ol>
                    <li class="form-row text-input-row">
                        <?= $form->textField(
                            $loginForm,
                            'email',
                            array(
                                'class' => 'text-input',
                                'onFocus' => $onFocus,
                                'placeholder' => "email",
                            )
                        ); ?>
                    </li>
                    <li class="form-row text-input-row">
                        <?= $form->passwordField(
                            $loginForm,
                            'password',
                            array(
                                'class' => 'text-input',
                                'onFocus' => $onFocus,
                                'placeholder' => "пароль",
                            )
                        ); ?>
                    </li>
                    <li class="form-row">
                        <?= $form->checkBox(
                            $loginForm,
                            'rememberMe',
                            array(
                                'onFocus' => $onFocus,
                                'style' => 'width: auto;'
                            )
                        ); ?>
                        Запамятати мене
                        <br/>
                    </li>

                    <li class="form-row">
                        <a href="#registrationFormHolder" id="registrationPopup">Зареєструватися</a> або
                        <a href="#restorePasswordFormHolder" id="restorePasswordPopup">Відновити пароль</a>
                    </li>

                    <li class="button-row">
                        <?
                        $onclick = 'return frontendController.ajaxFormSubmit(\'' . $loginForm::FORM_ID;
                        $onclick .= '\' );';
                        echo CHtml::submitButton(
                            'Ввійти',
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

        <div style="display:none; width: 800px">
            <div class="form-container" id="registrationFormHolder">
                <h4>Реєстрація</h4>
                <div class="response"></div>
                <?
                $form = $this->beginWidget(
                    'CActiveForm',
                    array(
                        'id'          => $registrationForm::FORM_ID,
                        'action'      => $registrationHandlerUrl,
                        'htmlOptions' => array(
                            'name'  => get_class($registrationForm),
                            'class' => 'forms',
                            'style' => 'width: 400px;'
                        )
                    )
                );
                ?>
                <fieldset>
                    <ol>
                        <li class="form-row text-input-row">
                            <?= $form->textField(
                                $registrationForm,
                                'name',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => "Ім'я",
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row">
                            <?= $form->dropdownList(
                                $registrationForm,
                                'sex',
                                User::getSexOptions(),
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => "Стать",
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row">
                            <?= $form->textField(
                                $registrationForm,
                                'email',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => "email",
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row">
                            <?= $form->passwordField(
                                $registrationForm,
                                'password',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => "Пароль",
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row">
                            <?= $form->passwordField(
                                $registrationForm,
                                'confirm',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => "Повтор паролю",
                                )
                            ); ?>
                        </li>

                        <li class="form-row">
                            <?= $form->checkBox(
                                $registrationForm,
                                'subscribe',
                                array(
                                    'style' => 'width: auto;',
                                    'title' => "Підписатися на розсилку",
                                )
                            ); ?>
                            Підписатися на розсилку
                        </li>

                        <li class="button-row center">
                            <?
                            $onclick = 'return frontendController.ajaxFormSubmit(\'' . $registrationForm::FORM_ID;
                            $onclick .= '\', function(data){ if ( data.status == true ) $.fancybox.close(); } );';
                            echo CHtml::submitButton(
                                'Зареєструватися',
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

        <div style="display:none">
            <div class="form-container" id="restorePasswordFormHolder">
                <h4>Відновлення паролю</h4>
                <div class="response"></div>
                <?
                $form = $this->beginWidget(
                    'CActiveForm',
                    array(
                        'id'          => $restorePasswordForm::FORM_ID,
                        'action'      => $restorePasswordHandlerUrl,
                        'htmlOptions' => array(
                            'name'  => get_class($restorePasswordForm),
                            'class' => 'forms',
                            'style' => 'width: 400px'
                        )
                    )
                );
                ?>
                <fieldset>
                    <ol>
                        <li class="form-row text-input-row">
                            <?= $form->textField(
                                $restorePasswordForm,
                                'email',
                                array(
                                    'class' => 'text-input',
                                    'onFocus' => $onFocus,
                                    'placeholder' => "Ваш email",
                                )
                            ); ?>
                        </li>

                        <li class="button-row center">
                            <?
                            $onclick = 'return frontendController.ajaxFormSubmit(\'' . $restorePasswordForm::FORM_ID;
                            $onclick .= '\', function(){ $.fancybox.close(); } );';
                            echo CHtml::submitButton(
                                'Вислати новий',
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

        <script>
            jQuery(
                function()
                {
                    jQuery("#registrationPopup").fancybox(
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

                    jQuery( "#restorePasswordPopup" ).fancybox(
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
<? else: ?>
    <h4 class="line"><?= $model->getFirstName(); ?></h4>
    <? if ( $model->hasPhoto() ): ?>
        <a href="<?= $model->getOriginalPhoto(); ?>" class="fancy" id="avatar-fancy">
            <img src="<?= $model->getSmallThumbnail(); ?>"
                 alt="<?= $model->getFirstName(); ?>"
                 id="avatar-img"
                />
        </a>
        <div class="center">
            <div id="uploadButton">
                Змінити фото
            </div>
        </div>
    <? else: ?>
        <a href="<?= $model->getOriginalPhoto(); ?>" class="fancy" id="avatar-fancy">
            <img src="<?= Yii::app()->params[ 'user' ][ 'defaultAvatar' ]; ?>"
                 alt="<?= $model->getFirstName(); ?>"
                 id="avatar-img"
                />
        </a>
        <div class="center">
            <div style="color: darkred"
                 id="uploadButton">
                Завантажити фото
            </div>
        </div>
    <? endif; ?>

    <br/>
    <a href="<?= createUrl( 'touristDating/myTrips' ); ?>"
       class="button navy"
       style="opacity: 1; width: 180px;"><span class="icon-flight-1"></span> Мої подорожі</a>

    <a href="<?= createUrl( 'touristDating/messages' ); ?>"
       class="button navy"
       style="opacity: 1; width: 180px;"><span class="icon-chat"></span> Мої повідомлення</a>

    <a href="<?= createUrl( 'touristDating/settings' ); ?>"
       class="button navy"
       style="opacity: 1; width: 180px;"><span class="icon-cog-1"></span> Налаштування</a>

    <a href="<?= createUrl( 'touristDating/myPhotos' ); ?>"
       class="button navy"
       style="opacity: 1; width: 180px;"><span class="icon-picture-1"></span> Мої фотографії</a>

    <a href="<?= createUrl( 'site/logout' ); ?>"
       class="button navy"
       style="opacity: 1; width: 180px;"><span class="icon-off"></span> Вихід</a>
<? endif; ?>