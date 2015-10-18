<?php

/**
 * This is the model class for table "photos".
 *
 * The followings are the available columns in table 'photos':
 * @property integer $id
 * @property integer $owner_id
 * @property string $file_name
 *
 * The followings are the available model relations:
 * @property User $owner
 */
class Photos extends BaseTable
{
    const FORM_ID = 'user-form';
    const THUMB_PREFIX_SMALL = 's_';

    protected $_response;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Photos the static model class
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
		return 'photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('owner_id, file_name', 'required'),
			array('owner_id', 'numerical', 'integerOnly'=>true),
			array('file_name', 'length', 'max'=>255),

			array('id, owner_id, file_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner_id' => 'Owner',
			'file_name' => 'File Name',
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
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('file_name',$this->file_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @return null|string path to small thumbnail for src attribute
     */
    public function getSmallThumbnail()
    {
        return Yii::app()->params[ 'src' ][ 'userPhotos' ] . $this->owner_id . DIRECTORY_SEPARATOR . static::THUMB_PREFIX_SMALL . $this->file_name;
    }

    /**
     * @return string
     */
    public function getOriginal()
    {
        return Yii::app()->params[ 'src' ][ 'userPhotos' ] . $this->owner_id . DIRECTORY_SEPARATOR . $this->file_name;
    }


    public static function getUserPhotos( $userId )
    {
        return self::model()->findAllByAttributes( array( 'owner_id' => $userId ) );
    }

    /**
     * Upload and apply new avatar
     * @return bool
     * @throws CException
     */
    public static function uploadPhoto( $userId )
    {
        // folder for uploaded files
        $tempFolder = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'temp' ];
        $photosFolder = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'userPhotos' ];
        $photosFolder .= $userId . DIRECTORY_SEPARATOR;

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

            $imageHandler->save( $photosFolder . $result['filename'] );
            $imageHandler->cropAndScaleFromCenter( 300, 300 );
            $imageHandler->save( $photosFolder . self::THUMB_PREFIX_SMALL . $result['filename'] );

            $model = new Photos();
            $model->owner_id = $userId;
            $model->file_name = $result['filename'];
            $model->save();

            return array(
                'originalSrc' => $model->getOriginal(),
                'thumbSrc' => $model->getSmallThumbnail(),
                'photoId' => $model->id
            );

        }
        else
        {
            throw new CException( $result[ 'error' ] );
        }
    }

    public function afterDelete()
    {
        $this->_removeOldPhoto();
    }

    protected function _removeOldPhoto()
    {
        @unlink(
            Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'userPhotos' ]
                . $this->owner_id . DIRECTORY_SEPARATOR . self::THUMB_PREFIX_SMALL . $this->file_name
        );

        @unlink(
            Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'userPhotos' ]
                . $this->owner_id . DIRECTORY_SEPARATOR . $this->file_name
        );
    }

    /**
     * @param $id owner id
     * @return int count of photos
     */
    public static function getCountOfPhotos( $id )
    {
        return self::model()->countByAttributes( array( 'owner_id' => $id ) );
    }

    public static function deleteAllByOwnerId( $id )
    {
        /** @var $models Photos[] */
        $models = self::model()->findAllByAttributes( array( 'owner_id' => $id ) );
        if ( $models )
        {
            foreach( $models as $model )
            {
                $model->delete();
            }
        }
    }

}