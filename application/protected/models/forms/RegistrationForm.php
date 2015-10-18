<?php
/**
 * @author Andriy Tolstokorov
 */

class RegistrationForm extends CFormModel
{
    const FORM_ID = 'registration-form';

    public $name;
    public $email;
    public $password;
    public $confirm;
    public $sex;
    public $subscribe;

    protected $_userModel;

    public function rules()
    {
        return array(
            array(
                'name, email, password, confirm, sex',
                'required',
                'message' => 'Поле обов\'язкове!'
            ),

            array(
                'password',
                'length',
                'min' => 6,
                'tooShort' => 'Пароль надто короткий(мінімум 6 символів)'
            ),

            array(
                'email',
                'email',
                'allowEmpty' => TRUE,
                'message' => 'Не правильний email!'
            ),

            array(
                'email',
                'isUnique'
            ),

            array(
                'confirm',
                'compare',
                'compareAttribute' => 'password',
                'operator' => '==',
                'message' => 'Паролі не співпадають'
            ),
        );
    }

    public function isUnique( $attribute,$params )
    {
        if( !User::isEmailUnique( $this->email ) )
        {
            $this->addError($attribute, 'Така поштова скринька вже використовується');
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
        if ( $this->registerUser() )
        {
            if ( $this->subscribe )
            {
                $this->addSubscriber();
            }

            $this->login();
        }
    }

    protected function registerUser()
    {
        $model = new User();

        $model->first_name = $this->name;
        $model->password = $this->password;
        $model->email = $this->email;
        $model->sex = $this->sex;
        $model->role = WebUser::ROLE_USER;

        if ( $model->save( FALSE ) )
        {
            Yii::import('application.extensions.yii-mail.YiiMailMessage');

            $message = new YiiMailMessage();

            $message->setSubject( 'Вітаємо на сайті РЕЗИДЕНТ' );
            $message->view = 'registration-notification';
            $message->setBody(
                array(
                    'name' => $this->name,
                    'password' => $this->password,
                ),
                'text/html'
            );

            $message->setTo( $this->email );
            $message->from  = Yii::app()->params[ 'emails' ][ 'defaultSender' ];
            Yii::app()->mail->send( $message );

            $this->_userModel = $model;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    protected function addSubscriber()
    {
        $model = new Subscribers();
        $model->email = $this->email;
        $model->save();
    }

    protected function login()
    {
        $identity = new UserIdentity();
        $identity->applyUserModel( $this->_userModel );

        Yii::app()->user->login( $identity );
        Yii::app()->user->setModel( $this->_userModel );
    }
}