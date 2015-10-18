<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

abstract class AbstractEmailForm extends CFormModel
{
    /** @var string email subject */
    public  $notificationSubject = NULL;
    /** @var string template file for email */
    public $notificationViewFile = NULL;
    /** @var string email of receiver */
    public $notificationReceiver = NULL;
    /** @var string email of sender */
    public $notificationSender = NULL;
    /** @var array list of params for email (used in template file) */
    public $notificationParams = array();

    /** @var string */
    public $receiverEmail = '';
    /** @var string */
    public $senderEmail = '';
    /** @var string */
    public $emailSubject = '';
    /** @var string */
    public $emailViewFile = '';
    public $emailParams = array();

    /**
     * Send notification for user, that has sent message for administration
     * @return mixed
     */
    public function sendSenderNotification()
    {
        $this->checkNotificationCondition();
        Yii::import('application.extensions.yii-mail.YiiMailMessage');

        $senderNotification = new YiiMailMessage();
        $senderNotification->setSubject( $this->notificationSubject );
        $senderNotification->view = $this->notificationViewFile;
        $senderNotification->setBody(
            $this->notificationParams,
            'text/html'
        );

        $senderNotification->setTo( $this->notificationReceiver );
        $senderNotification->from = $this->notificationSender;

        return Yii::app()->mail->send($senderNotification);
    }

    /**
     * Check condition for sending notification
     * @throws CException
     */
    protected function checkNotificationCondition()
    {
        if ( is_null( $this->notificationSubject ) )
        {
            throw new CException( 'Notification subject is missing' );
        }

        if ( is_null( $this->notificationViewFile ) )
        {
            throw new CException( 'Notification file file name is missing' );
        }

        if ( is_null( $this->notificationSender ) )
        {
            throw new CException( 'Email of sender is missing' );
        }

        if ( is_null( $this->notificationReceiver ) )
        {
            throw new CException( 'Email of receiver is missing' );
        }
    }

    protected function checkEmailConditions()
    {
        if ( is_null( $this->emailSubject ) )
        {
            throw new CException( 'Email subject is missing' );
        }

        if ( is_null( $this->emailViewFile ) )
        {
            throw new CException( 'Email file file name is missing' );
        }

        if ( is_null( $this->senderEmail ) )
        {
            throw new CException( 'Email of sender is missing' );
        }

        if ( is_null( $this->receiverEmail ) )
        {
            throw new CException( 'Email of receiver is missing' );
        }
    }

    /**
     * Send email message
     * @return mixed
     */
    abstract public function sendEmail();
}