<?php
/**
 * @author Andriy Tolstokorov
 */

class SubscribeForm extends CFormModel
{
    const FORM_ID = 'subscribe-form';

    public $email;
    public $verifyCode;

    public function rules()
    {
        return array(
            array(
                'email',
                'required',
                'message' => 'Поле обов\'язкове!'
            ),

            array(
                'email',
                'email',
                'allowEmpty' => TRUE,
                'message' => 'Не правильний email!'
            ),

            array(
                'verifyCode',
                'captcha',
                'allowEmpty'=>!CCaptcha::checkRequirements(),
                'captchaAction' => Yii::app()->createUrl( 'site/captcha' ),
                'message' => 'Код введено невірно!'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'verifyCode' => 'Код',
            'email' => 'email',
        );
    }

    public function save()
    {
        $model = new Subscribers();

        $model->email = $this->email;
        try
        {
            if ( $model->save( FALSE ) )
            {
                // notification
            }
        }
        catch( Exception $e )
        {
            return FALSE;
        }
    }

    public function sendEmail()
    {
        $this->checkEmailConditions();
        Yii::import('application.extensions.yii-mail.YiiMailMessage');

        $message = new YiiMailMessage();

        $message->setSubject( $this->emailSubject );
        $message->view = $this->emailViewFile;
        $message->setBody(
            $this->emailParams,
            'text/html'
        );

        $message->setTo( $this->receiverEmail );
        //$message->from = $this->senderEmail;

        return Yii::app()->mail->send( $message );
    }
}