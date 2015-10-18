<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

/** @var $this SiteController */
/** @var $pageModel StaticPages */
/** @var $models Faq[] */

$onFocus = 'frontendController.removeErrorHighlighting( this )';
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' );
?>


<div class="white-wrapper">
    <!-- Begin Inner -->
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
        <h1 class="line"><?= $pageModel->getTitle(); ?></h1>
        <div>
            <?= $pageModel->getText(); ?>
        </div>
    </div>
</div>


<div class="white-wrapper">
    <div class="inner">
        <div class="one-half">
            <? foreach( $models as $model ): ?>
            <div class="toggle">
                <h4 class="title"><?= $model->getTitle(); ?></h4>
                <div class="togglebox">
                    <div>
                        <?= $model->getText(); ?>
                    </div>
                </div>
            </div>
            <? endforeach; ?>
        </div>

        <div class="one-half last">
            <h4>Замовити консультацію</h4>
            <div class="response"></div>
            <?
            $form = $this->beginWidget(
                'CActiveForm',
                array(
                    'id'          => $formConsultation::FORM_ID,
                    'action'      => $this->createUrl( 'consultationHandler' ),
                    'htmlOptions' => array(
                        'name'  => get_class($formConsultation),
                        'class' => 'forms',
                    )
                )
            );
            ?>
            <fieldset>
                <ol>
                    <li class="form-row text-input-row">
                        <?= $form->textField(
                            $formConsultation,
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
                            $formConsultation,
                            'phone',
                            array(
                                'class' => 'text-input',
                                'onFocus' => $onFocus,
                                'placeholder' => "Телефон (обов'язкове)",
                            )
                        ); ?>
                    </li>

                    <li class="form-row text-input-row">
                        <?= $form->textField(
                            $formConsultation,
                            'email',
                            array(
                                'class' => 'text-input',
                                'onFocus' => $onFocus,
                                'placeholder' => "Email",
                                'style' => 'width: 50%'
                            )
                        ); ?>
                        <?= $form->textField(
                            $formConsultation,
                            'skype',
                            array(
                                'class' => 'text-input',
                                'onFocus' => $onFocus,
                                'placeholder' => "Скайп",
                                'style' => 'width: 49%'
                            )
                        ); ?>
                    </li>

                    <li class="form-row text-input-row">

                    </li>

                    <li class="form-row text-area-row">
                        <?= $form->textArea(
                            $formConsultation,
                            'text',
                            array(
                                'class' => 'text-area',
                                'onFocus' => $onFocus,
                                'placeholder' => "Ваше повідомелення",
                                'style' => 'min-height: 150px;',
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
                                        'class' => 'button gray',
                                        'style' => 'float: left; display: block; margin-top: 10px; margin-left: 5px;',
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
                                $formConsultation,
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
                        $onclick = 'return frontendController.ajaxFormSubmit(\'' . $formConsultation::FORM_ID;
                        $onclick .= '\', function( data ) {$( "#captcha_btn").click();} );';
                        echo CHtml::submitButton(
                            'Відправити',
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

        <div class="clear"></div>
    </div>
</div>