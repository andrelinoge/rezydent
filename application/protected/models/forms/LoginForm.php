<?php


class LoginForm extends CFormModel
{
    const FORM_ID = 'login-form';

	public $email;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('email, password', 'required', 'message' => 'Поле обов\'язкове'),
			array('rememberMe', 'boolean'),
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe' => 'Запам\'ятати мене',
		);
	}

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate( $attribute, $params )
    {
        if( !$this->hasErrors() )
        {
            $this->_identity = new UserIdentity();
            if( !$this->_identity->authByEmailPassDb( $this->email, $this->password ) )
            {
                $this->addError('password','Невірний пароль або email');
            }
        }
    }

    public function isUserBanned()
    {
        if( $this->_identity === NULL )
        {
            $this->_identity = new UserIdentity();
            $this->_identity->authByEmailPassStatic( $this->email, $this->password );
        }

        return $this->_identity->getUserModel()->is_banned;
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if( $this->_identity === NULL )
        {
            $this->_identity = new UserIdentity();
            $this->_identity->authByEmailPassStatic( $this->email, $this->password );
        }

        if( $this->_identity->errorCode === UserIdentity::ERROR_NONE ) {
            $duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login( $this->_identity, $duration );
            Yii::app()->user->setModel( $this->_identity->getUserModel() );
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
