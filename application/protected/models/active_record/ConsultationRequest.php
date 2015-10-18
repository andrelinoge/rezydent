<?php

/**
 * This is the model class for table "consultation_request".
 *
 * The followings are the available columns in table 'consultation_request':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $skype
 * @property integer $is_new
 * @property string $created_at
 * @property string $text
 */
class ConsultationRequest extends BaseArticleTable
{
    const USE_TAGS = FALSE;
    const USE_IMAGE = FALSE;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ConsultationRequest the static model class
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
		return 'consultation_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		return array(
			array('name, phone', 'required'),
			array('phone', 'length', 'max'=>20),
			array('email, skype', 'length', 'max'=>255, 'allowEmpty' => TRUE ),

			array('id, name, phone, email, skype, is_new, created_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        return array(
            'id' => 'ID',
            'name' => 'Ім\'я',
            'email' => 'Email',
            'text' => 'Текст',
            'is_new' => 'Нове',
            'created_at' => 'Створено',
            'phone' => 'Телефон',
            'skype' => 'Скайп'
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
		$criteria->compare('name',$this->name);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('skype',$this->skype,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        if ( $this->getIsNewRecord() )
        {
            $this->is_new = TRUE;
            $this->created_at = time();
        }

        return TRUE;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail( $getLink = FALSE, $skipDefaultText = FALSE )
    {
        if ( !empty( $this->email ) )
        {
            if ( $getLink )
            {

                return CHtml::link( $this->email, 'mailto:' . $this->email . '?subject=Повідомлення від турагенства РЕЗИДЕНТ' );
            }
            else
            {
                return $this->email;
            }
        }
        else
        {
            if ( $skipDefaultText )
            {
                return NULL;
            }
            else
            {
                return 'Не вказано';
            }
        }

    }

    public function getPhone()
    {
        if ( !empty( $this->phone ) )
        {
            return $this->phone;
        }
        else
        {
            return 'Не вказано';
        }
    }

    public function getSkype()
    {
        if ( !empty( $this->skype ) )
        {
            return $this->skype;
        }
        else
        {
            return 'Не вказано';
        }
    }


    /**
     * Returns data provider for Templated ListGrid
     * @return CActiveDataProvider
     */
    public function backendSearch()
    {
        $criteria = new CDbCriteria();

        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params['backend']['itemsPerPage'] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        // This column headers for those fields will be active
        $sort = array(
            'sortVar'       =>'sort',
            'attributes' => array(
                'name',
                'email',
                'phone',
                'skype',
                'created_at'
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
    public function backendSearchNew()
    {
        $criteria = new CDbCriteria();
        $criteria->compare( 'is_new', TRUE );

        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params['backend']['itemsPerPage'] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        // This column headers for those fields will be active
        $sort = array(
            'sortVar'       =>'sort',
            'attributes' => array(
                'name',
                'email',
                'phone',
                'skype',
                'created_at'
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
    public function getHeadersForListGrid()
    {
        return array(
            'name',
            'email',
            'phone',
            'skype',
            'created_at'
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
            $this->getName(),
            $this->getEmail( TRUE ),
            $this->getPhone(),
            $this->getSkype(),
            $this->getCreatedAt(),
        );
    }

    //              Static

    public static function getNewMessagesCount()
    {
        $query = 'SELECT COUNT( id ) FROM ' . static::tableName() . ' WHERE isNew = 1';
        return (int)Yii::app()
            ->db
            ->createCommand( $query )
            ->queryScalar();
    }
}