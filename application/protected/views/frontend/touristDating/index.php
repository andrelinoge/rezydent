<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */
/** @var $trips Trip[] */

$title = $pageModel->getTitle();
$text = $pageModel->getText();
$baseUrl = $this->getBehavioralBaseUrl();

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
            <? if( !empty( $title ) ): ?>
                <h1 class="line"><?= $title; ?></h1>
            <? endif; ?>

            <? if( !empty( $text ) ): ?>
                <div class="">
                    <?= $text; ?>
                </div>
                <div class="clear"></div>
            <? endif; ?>

            <?
            $form = $this->beginWidget(
                'CActiveForm',
                array(
                    'id'          => $model::FORM_ID,
                    //'method'      => $get,
                    'htmlOptions' => array(
                        'name'  => get_class( $model ),
                        'class' => 'forms',
                    )
                )
            );
            ?>
            <fieldset>
                <ol>
                    <li class="form-row text-input-row" style="display: block; float: left;">
                        <?= $form->dropDownList(
                            $model,
                            'country_id',
                            Country::getOptions( 'Куди їдемо?' ),
                            array(
                                'class' => 'text-input',
                                'style' => 'width: 150px;'
                            )
                        ); ?>
                    </li>

                    <li class="form-row text-input-row" style="display: block; float: left; margin-left: 15px;">
                        <?= $form->dropDownList(
                            $model,
                            'with_id',
                            TripWith::getOptions( 'З ким?' ),
                            array(
                                'class' => 'text-input',
                                'style' => 'width: 150px;'
                            )
                        ); ?>
                    </li>

                    <li class="button-row" style="display: block; float: left; margin-left: 15px; margin-top: 3px;">
                        <?
                        $onclick = 'return frontendController.ajaxFormSubmit(\'' . $model::FORM_ID;
                        $onclick .= '\', function(data){ $("#trips").html( data.html ) } );';
                        echo CHtml::submitButton(
                            'Знайти!',
                            array(
                                'onclick' => $onclick,
                                'class'   => 'button navy',
                                'style' => 'width: 150px;'
                            )
                        );
                        ?>
                    </li>

                    <a style="display: block; float: left; margin-top: 5px; margin-left: 15px"
                       href="#"
                       onclick="return toggleAdvanced( this )">
                        <span class="icon-plus-1" id="indicator"></span> Розширений пошук
                    </a>

                    <div class="clear"></div>

                    <div style="display: none;" id="advanced-options">
                        <li class="form-row text-input-row" style="display: block; float: left;">
                            <?= $form->dropDownList(
                                $model,
                                'companion_id',
                                TripCompanion::getOptions( 'Кого шукаємо?' ),
                                array(
                                    'class' => 'text-input',
                                    'style' => 'width: 150px;'
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row" style="display: block; float: left; margin-left: 15px;">
                            <?= $form->dropDownList(
                                $model,
                                'owner_age',
                                User::getAgesForFilter( 'Вік супутника' ),
                                array(
                                    'class' => 'text-input',
                                    'style' => 'width: 150px;'
                                )
                            ); ?>
                        </li>

                        <li class="form-row text-input-row" style="display: block; float: left; margin-left: 15px;">
                            <?= $form->dropDownList(
                                $model,
                                'start_at',
                                Trip::getStartPeriods( 'Коли їдемо?' ),
                                array(
                                    'class' => 'text-input',
                                    'style' => 'width: 150px;',
                                )
                            ); ?>
                        </li>
                    </div>
                </ol>
            </fieldset>

            <? $this->endWidget(); ?>

            <div id="trips">
                <?
                    $this->renderPartial(
                        '_index',
                        array(
                            'trips' => $trips,
                            'pagination' => $pagination
                        )
                    );
                ?>
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
    var isAdvancedOpen = false;

    function toggleAdvanced( caller )
    {
        $( '#advanced-options').toggle();
        var $span = $( '#indicator' );

        if ( isAdvancedOpen )
        {
            $span.attr( 'class', 'icon-plus-1');
            isAdvancedOpen = false;
        }
        else
        {
            $span.attr( 'class', 'icon-minus-1');
            isAdvancedOpen = true;
        }

        return false;
    }

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

            $( document).on(
                'click',
                'div.page-navi ul li a',
                function( event )
                {
                    $( '#trips').load( event.target.getAttribute( 'href' ) );
                    return false;
                }
            );

        }
    );
</script>