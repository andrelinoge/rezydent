<?php
/**
 * @author Andre Linoge
 *
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /** @var integer */
    protected $_id;
    /** @var User */
    protected $_userModel;

    const EMPTY_STRING = 0;

    public function __construct() {}

    /**
     * authorize using user's email and password from DB
     * @param $email
     * @param $password
     * @return bool
     */
    public function authByEmailPassDb( $email, $password )
    {

        if ( strlen( $email ) == self::EMPTY_STRING ) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return FALSE;
        }

        if ( strlen( $password ) == self::EMPTY_STRING ) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
            return FALSE;
        }

        /** @var $userModel User */
        $userModel = User::model()->findByAttributes(
            array(
                'email' => $email
            )
        );

        if( $userModel === NULL ) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;

        } else if( !$this->isPasswordValid( $password, $userModel->password, $userModel->salt ) ) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $userModel->id; // users` Id
            $this->saveStates( $userModel );
            $this->errorCode = self::ERROR_NONE;
        }

        $this->_userModel = $userModel;
        return !$this->errorCode;
    }

    /**
     * Authorize user by email and password, that stores in config file (non DB authorization)
     * @param $email string
     * @param $password string
     * @return bool
     */
    public function authByEmailPassStatic( $email, $password )
    {

        if ( strlen( $email ) == self::EMPTY_STRING ) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return FALSE;
        }

        if ( strlen( $password ) == self::EMPTY_STRING ) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
            return FALSE;
        }

        /** @var $adminModel  StaticAdminUser */
        $adminModel = new StaticAdminUser();

        if( !$adminModel->isIdentityCorrect( $email, $password ) )  {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $adminModel->id; // users` Id
            $this->saveStates( $adminModel );
            $this->errorCode = self::ERROR_NONE;
        }
        $this->_userModel = $adminModel;
        return !$this->errorCode;
    }

    /**
     * save different states from user model for quick access without model (role for verifications,
     * user name for layout etc.)
     * @param User $model
     */
    protected function saveStates( $model )
    {

    }

    /**
     * check if user password is valid.
     * @param $password string password from login form
     * @param $passwordHash string password from DB
     * @param $salt string user salt, also from DB
     * @return bool
     */
    public function isPasswordValid( $password, $passwordHash, $salt )
    {
        // You may use any validation algorithm and define it anywhere you want.
        return User::isPasswordValid( $password, $passwordHash, $salt );
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return User
     */
    public function getUserModel()
    {
        return $this->_userModel;
    }

    public function applyUserModel( User $model )
    {
        $this->_id = $model->id; // users` Id
        $this->saveStates( $model );
        $this->errorCode = self::ERROR_NONE;

        $this->_userModel = $model;
        return !$this->errorCode;
    }

}