<?php
/**
 * @author Andre Linoge
 */

class WebUser extends CWebUser {
    /* ROLES AND THEIR DESCRIPTION */
    const ROLE_USER         = 1;
    const ROLE_ADMIN        = 2;
    const ROLE_NAME_GUEST   = 'guest';
    const ROLE_NAME_USER    = 'user';
    const ROLE_NAME_ADMIN   = 'admin';

    /**
     * @var null|User $_model
     */
    private $_model = NULL;

    /**
     * @return int user role
     */
    function getRole()
    {
        /** @var $user User */
        $user = $this->getModel();
        if( $user ) {
            return $user->role;
        }
    }

    /**
     * @return null|User
     */
    public function getModel()
    {
        if ( !$this->isGuest && $this->_model === NULL )
        {
            if ( $this->id === 0 )
            {
                $this->_model = new StaticAdminUser();
            }
            else
            {
                $this->_model = User::model()->findByPkCached( $this->id );
            }
        }
        return $this->_model;
    }

    public function setModel( $model )
    {
        if ( !( $model instanceof User ) && !( $model instanceof StaticAdminUser ) ) {
            throw new CException( 'model must instance of User or StaticAdminUser class' );
        }
        $this->_model = $model;
    }

    public function refreshModel(){
        $this->_model=User::refreshModel($this->id);
    }

    /**
     * @return bool - is user admin
     */
    function isAdmin()
    {
        if( $this->isGuest )
        {
            return FALSE;
        }
        else
        {
            return (int)$this->getRole() == (int)self::ROLE_ADMIN;
        }
    }

    /**
     * @return bool - is user a simple user
     */
    public function isUser()
    {
        if( $this->isGuest ) {
            return FALSE;
        } else {
            return (int)$this->getRole() == (int)self::ROLE_USER;
        }
    }

    public function canAccessDashboard()
    {
        if ( $this->isGuest ) {
            return FALSE;
        } else {
            if ( $this->isAdmin() ) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}