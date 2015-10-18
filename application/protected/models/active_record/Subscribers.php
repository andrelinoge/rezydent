<?php

/**
 * This is the model class for table "subscribers".
 *
 * The followings are the available columns in table 'subscribers':
 * @property integer $id
 * @property string $email
 * @property string $created_at
 */
class Subscribers extends BaseArticleTable
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Subscribers the static model class
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
		return 'subscribers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email', 'length', 'max'=>255),
			array('id, email, created_at', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
            'created_at' => 'Підписався',
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
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        if ( $this->getIsNewRecord() )
        {
            $this->created_at = time();
        }

        return TRUE;
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
                'email',
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
                'email',
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
            'email',
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
            $this->getEmail( TRUE ),
            $this->getCreatedAt(),
        );
    }

    public static function getEmails( $limit = FALSE )
    {
        if ( $limit )
        {
            $query = 'SELECT email FROM ' . static::tableName() . ' LIMIT ' . $limit;
        }
        else
        {
            $query = 'SELECT email FROM ' . static::tableName();
        }

        return Yii::app()
            ->db
            ->createCommand( $query )
            ->queryColumn();
    }

    public static function getEmailsString()
    {
        $query = 'SELECT email FROM ' . static::tableName();

        $result = Yii::app()
            ->db
            ->createCommand( $query )
            ->queryColumn();

        return implode( ', ', $result );
    }
}