<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0

 * This is the model class that represents admin user
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $role
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 */
class StaticAdminUser
{
    public $id;
    public $role;
    public $email;
    public $password;
    public $first_name;
    public $last_name;

    public function __construct()
    {
        $identity = Yii::app()->params->adminIdentity;
        $this->id = 0;
        $this->role = WebUser::ROLE_ADMIN;
        $this->first_name = $identity[ 'first_name' ];
        $this->last_name = $identity[ 'last_name' ];
        $this->password = $identity[ 'password' ];
        $this->email = $identity[ 'email' ];
    }

    function isAdmin()
    {
        return $this->role == (int)WebUser::ROLE_ADMIN;
    }

    //              Getters/Setters

    /**
     * get full user name: first_name + last_name
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Check if input email/password match identity data from config
     * @param $email string
     * @param $password string
     * @return bool
     */
    public function isIdentityCorrect( $email, $password )
    {
        return ( $this->email == $email ) && ( $this->password == $password );
    }
}