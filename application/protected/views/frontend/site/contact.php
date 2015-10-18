<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' );

/** @var $this SiteController */
/** @var $pageModel StaticPages */
/** @var $models Faq[] */

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
        <div class="page-intro line clearfix">
            <h1 class="page-title"><?= $pageModel->getTitle(); ?></h1>
        </div>

        <div class="map">
            <iframe width="100%"
                    height="400"
                    frameborder="0"
                    scrolling="no"
                    marginheight="0"
                    marginwidth="0"
                    src="https://maps.google.com.ua/maps?f=q&amp;source=s_q&amp;hl=uk&amp;geocode=&amp;q=18%D0%B0+%D0%94%D0%BD%D1%96%D1%81%D1%82%D1%80%D0%BE%D0%B2%D1%81%D1%8C%D0%BA%D0%B0+%D0%B2%D1%83%D0%BB%D0%B8%D1%86%D1%8F,+%D0%86%D0%B2%D0%B0%D0%BD%D0%BE-%D0%A4%D1%80%D0%B0%D0%BD%D0%BA%D1%96%D0%B2%D1%81%D1%8C%D0%BA,+%D0%86%D0%B2%D0%B0%D0%BD%D0%BE-%D0%A4%D1%80%D0%B0%D0%BD%D0%BA%D1%96%D0%B2%D1%81%D1%8C%D0%BA%D0%B0+%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C&amp;aq=0&amp;oq=%D0%94%D0%BD%D1%96%D1%81%D1%82%D1%80%D0%BE%D0%B2%D1%81%D1%8C%D0%BA%D0%B0+18%D0%B0&amp;sll=48.911773,24.717129&amp;sspn=0.182993,0.308647&amp;ie=UTF8&amp;hq=&amp;hnear=%D0%94%D0%BD%D1%96%D1%81%D1%82%D1%80%D0%BE%D0%B2%D1%81%D1%8C%D0%BA%D0%B0+%D0%B2%D1%83%D0%BB.,+18%D0%90,+%D0%86%D0%B2%D0%B0%D0%BD%D0%BE-%D0%A4%D1%80%D0%B0%D0%BD%D0%BA%D1%96%D0%B2%D1%81%D1%8C%D0%BA,+%D0%86%D0%B2%D0%B0%D0%BD%D0%BE-%D0%A4%D1%80%D0%B0%D0%BD%D0%BA%D1%96%D0%B2%D1%81%D1%8C%D0%BA%D0%B0+%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C&amp;ll=48.925062,24.71252&amp;spn=0.005717,0.009645&amp;t=m&amp;z=14&amp;output=embed"></iframe>
        </div>

        <br />
        <div class="content">
            <h2>Напишіть нам</h2>
            <!-- Begin Form -->
            <div class="form-container">
                <div class="response"></div>
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
        <div class="sidebar">
            <div class="sidebox">
                <h3>Наша адреса</h3>
                <p><?= $pageModel->getText(); ?></p>
            </div>

        </div>
        <div class="clear"></div>
    </div>
    <!-- End Inner -->

</div>