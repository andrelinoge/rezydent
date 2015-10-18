<?php
/**
 * @author Andriy Tolstokorov
 */

class ChangePasswordForm extends CFormModel
{
    const FORM_ID = 'change-password-form';

    public $old;
    public $new;
    public $confirm;

    /** @var null User */
    protected $_userModel = NULL;

    public function rules()
    {
        return array(
            array(
                'old, new, confirm',
                'required',
                'message' => 'Поле обов\'язкове!'
            ),
            array(
                'old',
                'validateOldPass',
            ),
            array(
                'confirm',
                'compare',
                'compareAttribute' => 'new',
                'operator' => '==',
                'message' => 'Паролі не співпадають'
            ),
        );
    }

    public function validateOldPass($attribute,$params)
    {
        $model = $this->getUserModel();

        if( !$model::isPasswordValid( $this->old, $model->password, $model->salt ) )
        {
            $this->addError($attribute, 'Старий пароль не вірний');
        }
    }

    public function attributeLabels()
    {
        return array(
            'old' => 'Старий пароль',
            'new' => 'Новий пароль',
            'confirm' => 'Підтвердження нового паролю'
        );
    }

    public function save()
    {
        $model = $this->getUserModel();
        $model->changePassword( $this->new );
        $model->save( FALSE );
    }

    /**
     * @param User $model
     */
    public function setUserModel( User $model )
    {
        $this->_userModel = $model;
    }

    /**
     * @return User
     * @throws CException
     */
    public function getUserModel()
    {
        if ( empty( $this->_userModel ) )
        {
            throw new CException( 'User model is not set' );
        }
        else
        {
            return $this->_userModel;
        }
    }

    public function useActiveUserModel()
    {
        if ( !Yii::app()->user->isGuest )
        {
            $this->_userModel = Yii::app()->user->getModel();
        }
    }
}