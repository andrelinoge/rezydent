<?php
/**
 * @author Andriy Tolstokorov
 */

$onFocus = 'frontendController.removeErrorHighlighting( this )';
Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' )
    ->registerScriptFile( 'http://code.jquery.com/ui/1.10.2/jquery-ui.js', ClientScript::POS_END )
    ->registerCssFile( 'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css' );
?>

    <?
    $form = $this->beginWidget(
        'CActiveForm',
        array(
            'id'          => $model::FORM_ID,
            'htmlOptions' => array(
                'name'  => get_class( $model ),
                'class' => 'forms',
            )
        )
    );
    ?>
    <fieldset>
        <ol>
            <li class="form-row text-input-row">
                <?= $form->dropDownList(
                    $model,
                    'country_id',
                    $countryOptions,
                    array(
                        'class' => 'text-input',
                        'onFocus' => $onFocus,
                    )
                ); ?>
            </li>

            <li class="form-row text-input-row">
                <?= $form->dropDownList(
                    $model,
                    'with_id',
                    $withOptions,
                    array(
                        'class' => 'text-input',
                        'onFocus' => $onFocus,
                    )
                ); ?>
            </li>

            <li class="form-row text-input-row">
                <?= $form->dropDownList(
                    $model,
                    'companion_id',
                    $companionOptions,
                    array(
                        'class' => 'text-input',
                        'onFocus' => $onFocus,
                    )
                ); ?>
            </li>

            <li class="form-row text-input-row">
                <?= $form->dropDownList(
                    $model,
                    'purpose_id',
                    $purposeOptions,
                    array(
                        'class' => 'text-input',
                        'onFocus' => $onFocus,
                    )
                ); ?>
            </li>

            <li class="form-row" style="width: 220px;">
                <span>Термін поїздки</span>
                <?= $form->textField(
                    $model,
                    'start_at',
                    array(
                        'class' => 'text-input',
                        'onFocus' => $onFocus,
                        'value' => $model->getStartAt( FALSE ),
                        'placeholder' => 'З'
                    )
                ); ?>
            </li>

            <li class="form-row" style="width: 220px;">
                <?= $form->textField(
                    $model,
                    'end_at',
                    array(
                        'class' => 'text-input',
                        'onFocus' => $onFocus,
                        'value' => $model->getEndAt( FALSE ),
                        'placeholder' => 'До'
                    )
                ); ?>
            </li>

            <li class="form-row">
                <?= $form->checkBox(
                    $model,
                    'tickets',
                    array(
                        'onFocus' => $onFocus,
                        'style' => 'width: auto;'
                    )
                ); ?>
                <span>Наявність квитків</span>
            </li>

            <li class="form-row" >
                <?= $form->checkBox(
                    $model,
                    'hotel',
                    array(
                        'onFocus' => $onFocus,
                        'style' => 'width: auto;'
                    )
                ); ?>
                <span>Заброньований готель</span>
            </li>

            <li class="form-row">
                <?= $form->textField(
                    $model,
                    'children',
                    array(
                        'class' => 'text-input',
                        'placeholder' => 'Кількість дітей',
                    )
                ); ?>
            </li>

            <li class="form-row text-area-row">
                <?= $form->textArea(
                    $model,
                    'comment',
                    array(
                        'class' => 'text-area',
                        'onFocus' => $onFocus,
                        'placeholder' => "Комеентар...",
                    )
                ); ?>
            </li>
            <br/>
            <li class="button-row">
                <?
                $onclick = 'return frontendController.ajaxFormSubmit(\'' . $model::FORM_ID;
                $onclick .= '\', function(){ $.fancybox.close(); $("#message-text").val("") } );';
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
        $.datepicker.setDefaults($.datepicker.regional['ua']);
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

            jQuery( '#TripForm_start_at' ).datepicker(
                {
                    changeMonth: true,
                    changeYear: true
                }
            );

            jQuery( '#TripForm_end_at' ).datepicker(
                {
                    changeMonth: true,
                    changeYear: true
                }
            );

            jQuery( '#TripForm_children' ).spinner(
                {
                    min: 0
                }
            );
        }
    );
</script>