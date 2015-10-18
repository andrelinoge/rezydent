<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

Yii::app()
    ->clientScript
    ->registerPackage( 'jqueryForm' );
?>

<div class="loginBox">
    <div class="loginForm" style="margin-top: 110px;">
        <?= CHtml::beginForm(
                '',
                'post',
                array(
                    'id' => 'login-form',
                    'name' => get_class( $model ),
                    'class' => 'form-horizontal'
                )
            );
        ?>
        <div class="control-group">
            <div class="input-prepend">
                <span class="add-on"><span class="icon-envelope"></span></span>
                <?= CHtml::activeTextField(
                        $model,
                        'email',
                        array(
                            'placeholder' => 'Email'
                        )
                    );
                ?>
                <span class="error" id="<?= CHtml::activeId($model, 'email' ); ?>_error">
                    <?= $model->getError( 'email' ); ?>
                </span>
            </div>
        </div>
        <div class="control-group">
            <div class="input-prepend">
                <span class="add-on"><span class="icon-lock"></span></span>
                <?= CHtml::activePasswordField(
                        $model,
                        'password',
                        array(
                            'placeholder' => 'Password'
                        )
                    );
                ?>
                <span class="error"
                      id="<?= CHtml::activeId($model, 'password' ); ?>_error">
                    <?= $model->getError( 'password' ); ?>
                </span>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span8">
                <div class="control-group" style="margin-top: 5px;">
                    <label class="checkbox"><?= CHtml::activeCheckBox( $model, 'rememberMe' ); ?> Remember me</label>
                </div>
            </div>
            <div class="span4">
                <?=
                    CHtml::submitButton(
                        _( 'Log in' ),
                        array(
                            'class' => 'btn btn-block',
                            'onclick' => 'return backendController.ajaxSubmitForm( "login-form" );'
                        )
                    );
                ?>
            </div>
        </div>
        <?= CHtml::endForm(); ?>
    </div>
</div>