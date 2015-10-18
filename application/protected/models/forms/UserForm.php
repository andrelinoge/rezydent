<?php
/**
 * @author Andriy Tolstokorov
 */

class UserForm extends CFormModel
{
    const FORM_ID = 'user-form';

    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $sex;
    public $languages;
    public $about;
    public $marital_id;
    public $contacts;
    public $city;
    public $country;

    /** @var User */
    protected $_userModel = NULL;


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        return array(
            array( 'first_name, last_name, sex', 'required'),
            array( 'email,  first_name, last_name, sex', 'required'),
            array( 'email, password, first_name, last_name', 'length', 'max'=>255),
            array( 'email', 'email' ),
            array( 'email', 'isUnique' ),
            array( 'password, sex, languages, about, marital_id, contacts, city, country', 'safe'),

            array( 'email, first_name, last_name, password', 'safe', 'on'=>'search'),
        );
    }

    public function isUnique($attribute,$params)
    {
        $model = User::model()->findByAttributes( array( 'email' => $this->$attribute ) );

        if ( $model )
        {
            if ( $this->_userModel )
            {
                if ( $this->_userModel->id != $model->id )
                {
                    $this->addError($attribute, 'Такий email вже використовується' );
                }
            }
            else
            {
                $this->addError($attribute, 'Такий email вже використовується' );
            }
        }
    }

    public function save()
    {
        if ( $this->_userModel )
        {
            $attributes = $this->attributes;

            if ( empty( $this->password ) )
            {
                unset( $attributes[ 'password' ] );
            }

            $this->_userModel->setAttributes( $attributes );
            $this->_userModel->save();

        }
        else
        {
            $user = new User();

            $user->role = WebUser::ROLE_USER;
            $user->attributes = $this->attributes;

            $user->save();
        }
    }

    public static function getInstance( $id = NULL )
    {
        $form = new UserForm();

        if ( $id )
        {
            $user = User::model()->findByPk( $id );

            if ( $user )
            {
                $form->attributes = $user->attributes;
                $form->unsetAttributes( array( 'password' ) );
                $form->_userModel = $user;
            }
        }

        return $form;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'first_name' => _( 'Ім\'я' ),
            'last_name' => _( 'Прізвище' ),

        );
    }
}