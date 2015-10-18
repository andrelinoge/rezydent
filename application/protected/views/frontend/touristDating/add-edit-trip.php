<?php
/**
 * @author Andriy Tolstokorov
 */
/** @var $this TouristDatingController */
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
                <h4>Заповніть необхідні поля</h4>
                <?
                    $this->renderPartial(
                        '_trip-form',
                        array(
                            'model' => $model,
                            'purposeOptions' => $purposeOptions,
                            'withOptions' => $withOptions,
                            'companionOptions' => $companionOptions,
                            'countryOptions' => $countryOptions
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