<?php
/**
 * @author Andre Linoge
 */

class phpAuthManager extends CPhpAuthManager{

    public function init()
    {
        // Roles description will put in file auth.php in config folder of application
        if($this->authFile === NULL){
            $this->authFile = Yii::getPathOfAlias( 'application.config.auth' ).'.php';
        }

        parent::init();

        // assign user role id with role description from auth.php
        if( !Yii::app()->user->isGuest ) {
            $this->assign(
                self::getRoleName( Yii::app()->user->getRole() ),
                Yii::app()->user->id
            );
        }
    }

    /**
     * return description for user role using User model
     * @param $roleId
     * @return mixed
     */
    static function getRoleName( $roleId )
    {
        $result = WebUser::ROLE_NAME_GUEST;

        switch( $roleId ) {
            case WebUser::ROLE_USER:
                return WebUser::ROLE_NAME_USER;
                break;

            case WebUser::ROLE_ADMIN:
                return WebUser::ROLE_NAME_ADMIN;
                break;
        }

        return $result;
    }
}