<?php


class ConsultationForm extends AbstractEmailForm
{
    const FORM_ID = 'consultation-form';

    public $name;
    public $email;
    public $phone;
    public $skype;
    public $text;
    public $verifyCode;

    public function rules()
    {
        return array(
            array(
                'name, phone',
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

            array(
                'skype, text',
                'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'verifyCode' => 'Код',
            'name' => 'Ім\'я',
            'email' => 'email',
            'phone' => 'Телефон',
            'skype' => 'Скайп',
            'text' => 'Текст'
        );
    }

    public function save()
    {
        $model = new ConsultationRequest();

        $model->email = $this->email;
        $model->name = $this->name;
        $model->phone = $this->phone;
        $model->skype = $this->skype;
        $model->text = $this->text;

        if ( $model->save( FALSE ) )
        {
            $this->emailSubject = 'Замовлення консультації з сайту РЕЗИДЕНТ';
            $this->receiverEmail = Yii::app()->params[ 'emails' ][ 'notificationReceiver' ];
            $this->emailViewFile = 'consultation';
            $this->emailParams = array(
                'name' => $model->getName(),
                'email' => $model->getEmail( FALSE, TRUE ),
                'message' => $model->getText(),
                'phone' => $this->phone,
                'skype' => $this->skype
            );
            $this->senderEmail = Yii::app()->params[ 'emails' ][ 'defaultSender' ];

            if ( $this->sendEmail() )
            {
                if ( !empty( $this->email ) )
                {
                    $this->notificationSubject = 'Повідомлення від сайту http://rezydent.com.ua';
                    $this->notificationViewFile = 'sender-notification';
                    $this->notificationParams = array();
                    $this->notificationReceiver = $this->email;
                    $this->notificationSender = Yii::app()->params[ 'emails' ][ 'defaultSender' ];

                    $this->sendSenderNotification();
                }
            }
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
        $message->from = $this->senderEmail;

        return Yii::app()->mail->send( $message );
    }
}