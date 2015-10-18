<?php


class ContactForm extends AbstractEmailForm
{
    const FORM_ID = 'contact-form';

	public $name;
	public $email;
	public $message;
	public $verifyCode;

	public function rules()
	{
		return array(
			array(
                'name, email, message',
                'required',
                'message' => 'Поле обов\'язкове!'
            ),

			array(
                'email',
                'email',
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
            'name' => 'Ім\'я',
            'email' => 'email',
            'message' => 'Текст'
		);
	}

    public function save()
    {
        $model = new ContactMessage();

        $model->email = $this->email;
        $model->name = $this->name;
        $model->text = $this->message;

        if ( $model->save( FALSE ) )
        {
            $this->emailSubject = 'Контактне повідомлення з сайту РЕЗИДЕНТ';
            $this->receiverEmail = Yii::app()->params[ 'emails' ][ 'notificationReceiver' ];
            $this->emailViewFile = 'contact';
            $this->emailParams = array(
                'name' => $this->name,
                'email' => $this->email,
                'message' => $this->message
            );
            $this->senderEmail = Yii::app()->params[ 'emails' ][ 'defaultSender' ];

            if ( $this->sendEmail() )
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