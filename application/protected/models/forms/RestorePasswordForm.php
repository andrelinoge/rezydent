<?php
/**
 * @author Andriy Tolstokorov
 */

class RestorePasswordForm extends CFormModel
{
    const FORM_ID = 'restore-password-form';

    public $email;

    public function rules()
    {
        return array(
            array(
                'email',
                'required',
                'message' => 'Введіть email, вказаний при реєстрації    !'
            ),

            array(
                'email',
                'email',
                'allowEmpty' => TRUE,
                'message' => 'Не правильний email!'
            ),

            array(
                'email',
                'isRegistered'
            ),
        );
    }

    public function isRegistered( $attribute,$params )
    {
        if ( !empty( $this->email ) )
        {
            if( User::isEmailUnique( $this->email ) )
            {
                $this->addError($attribute, 'Такий email не знайдений');
            }
        }
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Ім\'я',
            'email' => 'email',
            'password' => 'Пароль',
            'birthday' => 'День народження',
            'confirm' => 'Підтвердження'
        );
    }

    public function save()
    {
        /** @var $user User */
        $user = User::model()->findByAttributes( array( 'email' => $this->email ) );

        if ( $user )
        {
            $newPassword = substr( md5( rand(1, 100) ), 0, 8 );
            $user->changePassword( $newPassword );
            $user->save();

            Yii::import('application.extensions.yii-mail.YiiMailMessage');

            $message = new YiiMailMessage();

            $message->setSubject( 'Відновлення паролю на сайті РЕЗИДЕНТ' );
            $message->view = 'restore-password';
            $message->setBody(
                array(
                    'name' => $user->getFirstName(),
                    'password' => $newPassword
                ),
                'text/html'
            );

            $message->setTo( $this->email );
            $message->from = Yii::app()->params[ 'emails' ][ 'defaultSender' ];
            Yii::app()->mail->send( $message );
        }

    }

}