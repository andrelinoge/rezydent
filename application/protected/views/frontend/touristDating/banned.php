<?
/** @var $this TouristDatingController */
/** @var $pageModel StaticPages */

$baseUrl = $this->getBehavioralBaseUrl();

$onFocus = 'frontendController.removeErrorHighlighting( this )';
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' );

$onFocus = 'frontendController.removeErrorHighlighting( this )';
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
                <h3>
                    <?= $pageModel->getTitle(); ?>
                </h3>
                <p>
                    <?= $pageModel->getText(); ?>
                </p>

                <h2>Напишіть нам</h2>
                <!-- Begin Form -->
                <div class="form-container" style="width: 600px">
                    <?
                    $form = $this->beginWidget(
                        'CActiveForm',
                        array(
                            'id'          => $formModel::FORM_ID,
                            'htmlOptions' => array(
                                'name'  => get_class($formModel),
                                'class' => 'forms',
                            )
                        )
                    );
                    ?>
                    <fieldset>
                        <ol>
                            <li class="form-row text-input-row">
                                <?= $form->textField(
                                    $formModel,
                                    'name',
                                    array(
                                        'class' => 'text-input',
                                        'onFocus' => $onFocus,
                                        'placeholder' => "І'мя (обов'язкове)",
                                    )
                                ); ?>
                            </li>

                            <li class="form-row text-input-row">
                                <?= $form->textField(
                                    $formModel,
                                    'email',
                                    array(
                                        'class' => 'text-input',
                                        'onFocus' => $onFocus,
                                        'placeholder' => "Email (обов'язкове)",
                                    )
                                ); ?>
                            </li>

                            <li class="form-row text-area-row">
                                <?= $form->textArea(
                                    $formModel,
                                    'message',
                                    array(
                                        'class' => 'text-area',
                                        'onFocus' => $onFocus
                                    )
                                ); ?>
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
                                                'class' => 'button aqua',
                                                'style' => 'float: left; display: block; margin-top: 5px;',
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
                                        $formModel,
                                        'verifyCode',
                                        array(
                                            'class' => 'text-input',
                                            'onFocus' => $onFocus,
                                            'placeholder' => 'Введіть код',
                                        )
                                    ); ?>
                                </li>
                            <? endif; ?>

                            <li class="button-row">
                                <?
                                $onclick = 'return frontendController.ajaxFormSubmit(\'' . $formModel::FORM_ID;
                                $onclick .= '\', function() {jQuery( "#captcha_btn").click();} );';
                                echo CHtml::submitButton(
                                    'Відправити',
                                    array(
                                        'onclick' => $onclick,
                                        'class'   => 'button aqua'
                                    )
                                );
                                ?>
                            </li>
                        </ol>
                    </fieldset>

                    <? $this->endWidget(); ?>
                </div>
                <!-- End Form -->
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

