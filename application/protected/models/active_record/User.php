<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $role
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $first_name
 * @property string $last_name
 * @property string $photo
 * @property string $country
 * @property string $city
 * @property string $contacts
 * @property integer $marital_id
 * @property string $marital
 * @property integer $birthday
 * @property string $languages
 * @property string $about
 * @property integer $sex
 * @property integer $is_banned
 */
class User extends CActiveRecord
{
    const FORM_ID = 'user-form';

    const CACHE_KEY_USER_MODEL = 'userModel_';
    const CACHE_TTL_USER_MODEL = 600; // 10 min
    const MIN_PASSWORD_LENGTH = 6;
    const SALT = 'qweasdzxc123'; // salt for protection id when it sends with post data

    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    const THUMB_PREFIX_SMALL = 's_';
    const SMALL_THUMB_WIDTH = 300;
    const SMALL_THUMB_HEIGHT = 300;

    const THUMB_PREFIX_MICRO = 'mi_';
    const MICRO_THUMB_WIDTH = 100;
    const MICRO_THUMB_HEIGHT = 100;

    /** @var string after find - will holds full name */
    public $fullName;

    /** @var string */
    protected $_initialPassword;
    protected $_initialAttributes;

    protected $_response;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		return array(
			array('role, email, password', 'required'),
			array('email, password, first_name, last_name, country, city', 'length', 'max'=>255),
            array( 'email', 'unique' ),

			array(
                'id, email, first_name, last_name, password,last_name, sex, birthday, marital_id, languages, contacts, about, country, city, is_banned',
                'safe',
            ),

            array(
                'sex',
                'required',
                'message' => 'Обовя\'зкове поле',
                'on' => 'edit'
            ),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role' => _( 'Role' ),
			'email' => 'Email',
			'password' => _( 'Пароль' ),
			'salt' => _( 'Salt' ),
			'first_name' => _( 'Ім\'я' ),
			'last_name' => _( 'Прізвище' ),
            'city' => 'Місто',
            'country' => 'Країна',
            'languages' => 'Знання мов',
            'contacts' => 'Контакти',
            'marital_id' => 'Сімейний стан',
            'sex' => 'Стать',
            'is_banned' => 'Бан'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('role',$this->role);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Retrieves a list of models based on the current search/filter conditions for admins.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchAdmins()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->condition = 'role = :role';
        $criteria->params = array( ':role' => WebUser::ROLE_ADMIN );
        $criteria->compare('email',$this->email,true);
        $criteria->compare('first_name',$this->first_name,true);
        $criteria->compare('last_name',$this->last_name,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['backend']['itemsPerPage'],
                'pageVar'=>'page',
            ),
            'sort'=>array(
                'defaultOrder'=>'first_name, last_name',
                'sortVar'=>'sort',
                'attributes'=>array(
                    'first_name',
                    'last_name',
                    'email'
                ),
            ),
        ));
    }

    public function searchUsers()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->condition = 'role = :role';
        $criteria->params = array( ':role' => WebUser::ROLE_USER );
        $criteria->compare('email',$this->email,true);
        $criteria->compare('first_name',$this->first_name,true);
        $criteria->compare('last_name',$this->last_name,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['backend']['itemsPerPage'],
                'pageVar'=>'page',
            ),
            'sort'=>array(
                'defaultOrder'=>'first_name, last_name',
                'sortVar'=>'sort',
                'attributes'=>array(
                    'first_name',
                    'last_name',
                    'email'
                ),
            ),
        ));
    }

    public function beforeSave()
    {
        $this->_convertBirthday();

        if ( $this->getIsNewRecord() )
        {
            $this->_setPassword();
            $this->_setCatalogValues();
        }
        else
        {
            $this->_updatePassword();
            $this->_updateCatalogValues();
        }
        return parent::beforeSave();
    }

    public function afterDelete()
    {
        Photos::deleteAllByOwnerId( $this->id );
    }

    protected function _setPassword()
    {
        $this->salt = substr( sha1(rand()),0,10 );
        $this->password = self::getPasswordHash( $this->password, $this->salt );
    }

    protected function _setCatalogValues()
    {
        if ( !empty( $this->marital_id ) )
        {
            $this->marital = MaritalStatus::getValueById( $this->marital_id );
        }
    }

    protected function _updatePassword()
    {
        if ( !empty($this->password) )
        {
            // generate has for new password
            if ( $this->password != $this->_initialPassword )
            {
                $this->password = self::getPasswordHash( $this->password, $this->salt );
            }
        }
        else
        {
            // use old hash for old password
            $this->password = $this->_initialPassword;
        }
    }

    protected function _updateCatalogValues()
    {
        if ( $this->_initialAttributes[ 'marital_id' ] != $this->marital_id )
        {
            $this->marital = MaritalStatus::getValueById( $this->marital_id );
        }
    }

    protected function _updateRelatedModels()
    {
        if ( $this->_initialAttributes[ 'first_name' ] != $this->first_name )
        {
            Trip::model()->updateAll(
                array(
                    'owner_name' => $this->first_name
                ),
                'owner_id = :userId',
                array(
                    ':userId' => $this->id
                )
            );
        }

        if ( $this->_initialAttributes[ 'birthday' ] != $this->birthday )
        {
            Trip::model()->updateAll(
                array(
                    'owner_age' => $this->getAge()
                ),
                'owner_id = :userId',
                array(
                    ':userId' => $this->id
                )
            );
        }
    }

    protected function _convertBirthday()
    {
        if ( !empty( $this->birthday ) )
        {
            if ( !is_numeric( $this->birthday ) )
            {
                $this->birthday = strtotime( $this->birthday );
            }
        }
    }

    public function afterSave()
    {
        parent::afterSave();
        if ( $this->getIsNewRecord() )
        {
            // create additional staff: profiles, etc
            mkdir( Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'userPhotos' ] . $this->id );
        }
        else
        {
            // delete cached model
            self::purgeCache( $this->id );
        }

        $this->_updateRelatedModels();
        return TRUE;
    }

    /**
     * Save initial password for case, when user will change any data except password
     */
    public function afterFind()
    {
        $this->_initialPassword = $this->password;
        $this->fullName = $this->first_name . ' ' . $this->last_name;
        $this->_initialAttributes = $this->attributes;
    }

    /**
     * generate new password
     * @param $newPassword string
     */
    public function changePassword( $newPassword )
    {
        $this->salt = substr( sha1(rand()),0,10 );
        $this->password = $newPassword;
    }

    /**
     * @return bool
     */
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
        return $this->fullName;
    }

    /**
     * @param null|string $format rule for convertation from the timestamp to string
     * @param null|string $textOnNull if field is empty - return hind ( default is "-")
     * @param null|string $format if this param set in FALSE and value is empty - return NULL
     * @return string retrieves formatted date of creation
     */
    public function getBirthday( $format = NULL, $textOnNull = '-', $ifNullReturnDefText = TRUE )
    {
        if ( !$format )
        {
            $format = 'd-m-Y';
        }

        if ( (int)$this->birthday > 0 )
        {
            return date( $format, $this->birthday );
        }
        else
        {
            if ( $ifNullReturnDefText )
            {
                if ( $textOnNull )
                {
                    return $textOnNull;
                }
            }
            else
            {
                return NULL;
            }

        }
    }

    public function getSex( $onlyLetter = FALSE )
    {
        if ( $onlyLetter )
        {
            switch ( $this->sex )
            {
                case self::SEX_MALE :
                    return 'Ч';
                break;

                case self::SEX_FEMALE :
                    return 'Ж';
                break;

                default:
                    return '-';
            }
        }
        else
        {
            switch ( $this->sex )
            {
                case self::SEX_MALE :
                    return 'Чоловіча';
                    break;

                case self::SEX_FEMALE :
                    return 'Жіноча';
                    break;

                default:
                    return 'Не вибрано';
            }
        }
    }

    public function getIsBannedValue()
    {
        if ( $this->is_banned )
        {
            return 'Так';
        }
        else
        {
            return 'Ні';
        }
    }

    //              Static

    /**
     * find model in cache, and if model no in cache - get from DB and save in cache
     * @static
     * @param $id int user id
     * @return User
     */
    public static function findByPkCached( $id )
    {
        $user = self::getUserModelFromCache( $id );
        if ( !$user )
        {
            $user = self::refreshModel( $id );
        }

        return $user;
    }

    /**
     * get user model from cache by user id
     * @static
     * @param $id int user id
     * @return mixed
     */
    public static function getUserModelFromCache( $id )
    {
        return Yii::app()
            ->cache
            ->get( self::CACHE_KEY_USER_MODEL . $id);
    }

    /**
     * @static Refreshes user model in memcache
     * @param int $id - user id
     * @return User
     */
    public static function refreshModel( $id )
    {
        $model = User::model()->findByPk( $id );

        Yii::app()->cache->set(
            self::CACHE_KEY_USER_MODEL . $id,
            $model,
            self::CACHE_TTL_USER_MODEL
        );

        return $model;
    }

    /**
     * clean cache
     * @param $id integer user id
     */
    public static function purgeCache( $id )
    {
        Yii::app()->cache->delete(
            self::CACHE_KEY_USER_MODEL . $id
        );
    }

    /**
     * @static
     * @param $password string
     * @param $salt string
     * @return string
     */
    public static function getPasswordHash( $password, $salt )
    {
        return sha1( sha1( $password ) . $salt );
    }

    /**
     * @static
     * @param $password string initial password value
     * @param $passwordHash string encrypted password value with salt
     * @param $salt string
     * @return bool
     */
    public static function isPasswordValid( $password, $passwordHash, $salt)
    {
        return $passwordHash === self::getPasswordHash( $password, $salt );
    }

    /**
     * @return array
     */
    public static function getAdmins()
    {
        return self::model()->findAllByAttributes( array( 'role' => WebUser::ROLE_ADMIN ) );
    }

    /**
     * @return CActiveRecord
     * @throws CException
     */
    public static function getCurrentUser()
    {
        if ( !Yii::app()->user->isGuest )
        {
            return self::model()->findByPk( Yii::app()->user->id );
        }
        else
        {
            throw new CException( 'User not logged in' );
        }
    }

    /**
     * Returns data provider for Templated ListGrid
     * @return CActiveDataProvider
     */
    public function backendSearch()
    {
        $criteria = new CDbCriteria();

        $criteria->compare( 'role', WebUser::ROLE_ADMIN );

        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'backend'][ 'itemsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        // This column headers for those fields will be active
        $sort = array(
            'sortVar'       =>'sort',
            'attributes' => array(
                'first_name',
                'last_name',
                'email'
            )
        );

        return new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
                'sort'          => $sort
            )
        );
    }

    /**
     * Returns data provider for Templated ListGrid
     * @return CActiveDataProvider
     */
    public function backendUsersSearch()
    {
        $criteria = new CDbCriteria();

        $criteria->compare( 'first_name', $this->first_name, TRUE );
        $criteria->compare( 'email', $this->email, TRUE );
        $criteria->compare( 'id', $this->id );
        $criteria->compare( 'marital_id', $this->marital_id );
        $criteria->compare( 'sex', $this->sex );
        $criteria->compare( 'is_banned', $this->is_banned );

        $criteria->compare( 'role', WebUser::ROLE_USER );

        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'backend'][ 'itemsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        // This column headers for those fields will be active
        $sort = array(
            'sortVar'       =>'sort',
            'attributes' => array(
                'id',
                'first_name',
                'email',
                'sex',
                'marital_id',
                'is_banned'
            )
        );

        return new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
                'sort'          => $sort
            )
        );
    }

    /**
     * Returns list of field names which will be used as headers for list grid columns
     * @return array
     */
    public static function getHeadersForListGrid()
    {
        return array(
            'id',
            'first_name',
            'last_name',
            'email'
        );
    }

    public  static function getUserHeadersForListGrid()
    {
        return array(
            'id',
            'first_name',
            'email',
            'sex',
            'marital_id',
            'is_banned'
        );
    }

    /**
     * return array with values for row cells in Templated ListGrid.
     * Note: order and count of fields must be the same as those that returns method for column headers
     * @return array
     */
    public function getRowValues()
    {
        return array(
            $this->id,
            $this->getFirstName(),
            $this->getEmail(),
        );
    }

    public function getUsersRowValues()
    {
        return array(
            $this->id,
            $this->getFirstName(),
            $this->getEmail(),
            $this->getSex(),
            $this->getMaritalStatus(),
            $this->getIsBannedValue()
        );
    }

    /**
     * @return array with filters for templated ListGrid widget
     */
    public static function getFiltersForListGrid()
    {
        return array(
        );
    }

    /**
     * @return array with filters for templated ListGrid widget
     */
    public static function getUsersFiltersForListGrid()
    {
        return array(
            'id'  => '',
            'first_name' => '',
            'email' => '',
            'sex' => self::getSexOptions(),
            'marital_id' => MaritalStatus::getOptions( 'Сімейни стан' ),
            'is_banned' => self::getBannedOptions()
        );
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return array with sex options for select
     */
    public static function getSexOptions()
    {
        return array(
            '' => 'Стать',
            static::SEX_MALE => 'Чоловіча',
            static::SEX_FEMALE => 'Жіноча'
        );
    }

    public static function getBannedOptions()
    {
        return array(
            '' => 'Бан',
            TRUE => 'Є',
            FALSE => 'Нема'
        );
    }

    public function getCountry( $defaultText = '' )
    {
        return empty( $this->country )?$defaultText:$this->country;
    }

    public function getCity( $defaultText = '' )
    {
        return empty( $this->city )?$defaultText:$this->city;
    }

    public function getContacts( $defaultText = '' )
    {
        return empty( $this->contacts )?$defaultText:$this->contacts;
    }

    public function getLanguages( $defaultText = '' )
    {
        return empty( $this->languages )?$defaultText:$this->languages;
    }

    public function getMaritalStatus( $defaultText = '' )
    {
        return empty( $this->marital )?$defaultText:$this->marital;
    }

    public function getAge()
    {
        $timeZone  = new DateTimeZone('Europe/Kiev');
        $age = new DateTime();
        return $age->setTimestamp( $this->birthday )
            ->diff( new DateTime('now', $timeZone ) )
            ->y;
    }

    public function getAbout( $defaultText = '' )
    {
        return empty( $this->about )?$defaultText:$this->about;
    }

    /**
     * @return null|string path to small thumbnail for src attribute
     */
    public function getSmallThumbnail()
    {
        if ( !empty( $this->photo ) )
        {
            return Yii::app()->params[ 'src' ][ 'userAvatars' ] . static::THUMB_PREFIX_SMALL . $this->photo;
        }
        else
        {
            return Yii::app()->params[ 'user' ][ 'defaultAvatar' ];
        }
    }

    public function getMicroThumbnail()
    {
        if ( !empty( $this->photo ) )
        {
            return Yii::app()->params[ 'src' ][ 'userAvatars' ] . static::THUMB_PREFIX_MICRO . $this->photo;
        }
        else
        {
            return Yii::app()->params[ 'user' ][ 'defaultAvatar' ];
        }
    }

    /**
     * @return string
     */
    public function getOriginalPhoto()
    {
        if ( !empty( $this->photo ) )
        {
            return Yii::app()->params[ 'src' ][ 'userAvatars' ] .  $this->photo;
        }
        else
        {
            return Yii::app()->params[ 'user' ][ 'defaultAvatar' ];
        }
    }

    /**
     * @return bool
     */
    public function hasPhoto()
    {
        return !empty( $this->photo );
    }

    /**
     * check if email already in use
     * @param $email
     * @return bool
     */
    public static function isEmailUnique( $email )
    {
        $sql = 'SELECT email FROM user WHERE email = :email';
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam( ':email', $email, PDO::PARAM_STR );

        $result = $command->queryRow();

        return $result === FALSE;
    }

    /**
     * Upload and apply new avatar
     * @return bool
     * @throws CException
     */
    public function changeAvatar()
    {
        // folder for uploaded files
        $tempFolder = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'temp' ];
        $avatarsFolder = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'userAvatars' ];

        if (!is_writable( $tempFolder ) )
        {
            throw new CException( 'temporary folder is not exists or not writable. Path:' . $tempFolder );
        }

        // Upload to temp folder
        $uploader = new FileUploader(
            Yii::app()->params[ 'uploader' ][ 'allowedFileExtensions' ],
            Yii::app()->params[ 'uploader' ][ 'sizeLimit' ]
        );

        $result = $uploader->handleUpload( $tempFolder );

        if ( !isset( $result['error'] ) )
        {
            // Move file to target folder and make thumbs
            $imageHandler = new CImageHandler();
            $imageHandler->load( $tempFolder . $result['filename'] );

            try
            {
                $imageHandler->save( $avatarsFolder . $result['filename'] );
                $imageHandler->cropAndScaleFromCenter( self::SMALL_THUMB_WIDTH, self::SMALL_THUMB_HEIGHT );
                $imageHandler->save( $avatarsFolder . self::THUMB_PREFIX_SMALL . $result['filename'] );
                $imageHandler->load( $tempFolder . $result['filename'] );
                $imageHandler->cropAndScaleFromCenter( self::MICRO_THUMB_WIDTH, self::MICRO_THUMB_HEIGHT );
                $imageHandler->save( $avatarsFolder . self::THUMB_PREFIX_MICRO . $result['filename'] );

                if ( $this->hasPhoto() )
                {
                    $this->_removeOldPhoto();
                }

                $this->photo = $result['filename'];

                $this->_response = array(
                    'originalSrc' => $this->getOriginalPhoto(),
                    'thumbSrc' => $this->getSmallThumbnail()
                );

                $this->save( FALSE );
                return TRUE;
            }
            catch ( CException $e )
            {
                $this->_response = array(
                    'errorMessage' => $e->getMessage()
                );

                return FALSE;
            }
        }
        else
        {
            $this->_response = array(
                'errorMessage' => $result[ 'error' ]
            );

            return FALSE;
        }
    }

    protected function _removeOldPhoto()
    {
        @unlink(
            Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'userAvatars' ]
                . self::THUMB_PREFIX_SMALL . $this->photo
        );

        @unlink(
            Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'userAvatars' ]
                . self::THUMB_PREFIX_MICRO . $this->photo
        );

        @unlink(
            Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'userAvatars' ]
                . $this->photo
        );
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public static function getAgesForFilter( $defaultText = '' )
    {
        $result = !( empty( $defaultText ) ) ? array( '' => $defaultText ) : array();

        for( $i = 18; $i < 70; $i++ )
        {
            $result[ $i ] = $i;
        }

        return $result;
    }

}
