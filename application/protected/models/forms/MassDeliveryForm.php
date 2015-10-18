<?php


class MassDeliveryForm extends AbstractEmailForm
{
    const FORM_ID = 'delivery-form';

    public $subject;
    public $text;

    public function rules()
    {
        return array(
            array(
                'subject, text',
                'required',
                'message' => 'Поле обов\'язкове!'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'subject' => 'Тема',
            'text' => 'Текст'
        );
    }

    public function save()
    {
        $this->sendEmail();
    }

    public function sendEmail()
    {
        $this->checkEmailConditions();
        Yii::import('application.extensions.yii-mail.YiiMailMessage');

        $message = new YiiMailMessage();

        $message->setSubject( $this->subject );
        $message->view = 'mass-delivery';

        $message->setBody(
            array(
                'text' => $this->text
            ),
            'text/html'
        );

        $message->from = Yii::app()->params[ 'emails' ][ 'defaultSender' ];

        if ( is_array( $this->receiverEmail ) )
        {
            foreach( $this->receiverEmail as $email )
            {
                $message->setTo( $email );
                Yii::app()->mail->send( $message );
            }
        }

        return TRUE;
    }
}