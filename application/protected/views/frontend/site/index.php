<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */

$title = $pageModel->getTitle();
$text = $pageModel->getText();
$baseUrl = $this->getBehavioralBaseUrl();

$onFocus = 'frontendController.removeErrorHighlighting( this )';
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' );

?>

<style>
    #google_translate_element img {
        display: inline-block;
    }

</style>

<div class="white-wrapper">
    <div class="inner">

        <? if( !empty( $title ) ): ?>
            <h1 class="line"><?= $title; ?></h1>
        <? endif; ?>

        <?if( !empty( $text ) ): ?>
            <div class="">
                <?= $text; ?>
            </div>
        <?endif; ?>

        <div class="clear"></div>

        <div class="one-fourth">
            <? $this->widget( 'application.widgets.Frontend.Common.Tours' ); ?>
        </div>

        <div class="one-half center">
            <h2>Пошук турів</h2>
            <div id="tour_search_module" style="margin-left: 22%">
                <br><br>
                <img
                    width="30px"
                    height="30px"
                    style="margin-left: 22%"
                    src="<?= $baseUrl; ?>/style/images/loading.gif"
                />
            </div>
        </div>

        <div class="one-fourth last">
            <a href="<?= $this->createUrl( 'touristDating/index' ); ?>"
               class="button aqua"
               style="opacity: 1; width: 210px; text-align: center;">Туристичні знайомства</a>

            <a href="<?= $this->createUrl( 'weather/index' ); ?>"
               class="button aqua"
               style="opacity: 1; width: 210px; text-align: center;">Погода</a>

            <a href="<?= $this->createUrl( 'site/faq' ); ?>"
               id="consultationPopup"
               class="button aqua"
               style="opacity: 1; width: 210px; text-align: center;">Запитання</a>

            <a href="#subscribeFormHolder"
               class="button aqua"
               id="subscribePopup"
               style="opacity: 1; width: 210px; text-align: center;">Підписатися на розсилку</a>

            <div id="google_translate_element"></div>
            <div class="clear"></div>
            <?
                $this->widget(
                    'application.widgets.Frontend.Common.LastMedia',
                    array(
                        'titleLimit' => 19
                    )
                );
            ?>

            <?
                $this->widget(
                    'application.widgets.Frontend.Common.LastNews',
                    array(
                        'titleLimit' => 19
                    )
                );
            ?>
        </div>

        <div class="clear"></div>
    </div>

    <div style="display:none">
        <div class="form-container" id="subscribeFormHolder">
            <h4>Підписатися на e-mail розсилку</h4>
            <div class="response"></div>
            <?
            $form = $this->beginWidget(
                'CActiveForm',
                array(
                    'id'          => $formSubscribe::FORM_ID,
                    'action'      => $this->createUrl( 'subscribeHandler' ),
                    'htmlOptions' => array(
                        'name'  => get_class($formSubscribe),
                        'class' => 'forms',
                    )
                )
            );
            ?>
            <fieldset>
                <ol>
                    <li class="form-row text-input-row">
                        <?= $form->textField(
                            $formSubscribe,
                            'email',
                            array(
                                'class' => 'text-input',
                                'onFocus' => $onFocus,
                                'placeholder' => "Email (обов'язкове)",
                            )
                        ); ?>
                    </li>

                    <? if(CCaptcha::checkRequirements()): ?>
                        <li class="form-row">
                            <?
                            $this->widget(
                                'CCaptcha',
                                array(
                                    'captchaAction' => Yii::app()->createUrl( 'site/captcha' ),
                                    'buttonLabel'   => 'Обновити',
                                    'buttonOptions' => array(
                                        'class' => 'button gray',
                                        'style' => 'float: left; display: block; margin-top: 10px; margin-left: 5px;',
                                        'id' => 'subscribe-captcha-btn'
                                    ),
                                    'imageOptions' => array(
                                        'style' => 'float: left; display: block;'
                                    ),
                                    'clickableImage' => TRUE
                                )
                            );
                            ?>
                            <?= $form->textField(
                                $formSubscribe,
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
                        $onclick = 'return frontendController.ajaxFormSubmit(\'' . $formSubscribe::FORM_ID;
                        $onclick .= '\', function(data) { $( "#subscribe-captcha-btn" ).click();} );';
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
    </div>

</div>

<script src="http://module.ittour.com.ua/tour_search.jsx?id=40818D21G919N5544210968&ver=1&type=2974"></script>



<script type="text/javascript">
    jQuery(
        function()
        {
            jQuery("a#consultationPopup").fancybox(
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

    jQuery(
        function()
        {
            jQuery("a#subscribePopup").fancybox(
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