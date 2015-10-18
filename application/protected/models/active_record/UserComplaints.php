<?php

/**
 * This is the model class for table "user_complaints".
 *
 * The followings are the available columns in table 'user_complaints':
 * @property integer $id
 * @property integer $from_id
 * @property integer $on_id
 * @property string $content
 * @property integer $created_at
 *
 * The followings are the available model relations:
 * @property User $onUser
 * @property User $fromUser
 */
class UserComplaints extends BaseTable
{
    const FORM_ID = 'complaint-form';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserComplaints the static model class
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
		return 'user_complaints';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('from_id, on_id, content', 'required'),
			array('from_id, on_id, created_at', 'numerical', 'integerOnly'=>true),

			array('id, from_id, on_id, content, created_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'onUser' => array( self::BELONGS_TO, 'User', 'on_id' ),
			'fromUser' => array( self::BELONGS_TO, 'User', 'from_id' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_id' => 'Від',
			'on_id' => 'На',
			'content' => 'Причина',
			'created_at' => 'Створено',
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
		$criteria->compare('from_id',$this->from_id);
		$criteria->compare('on_id',$this->on_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getContent( $limit = NULL, $useThreeDots = FALSE )
    {
        if ( !$limit )
        {
            return $this->content;
        }
        else
        {
            $text = str_replace( "\t", '', $this->content );

            $text = trim( strip_tags( $text ) );

            if ( mb_strlen( $text, 'utf-8' ) <= $limit )
            {
                return $text;
            }
            else
            {
                return ( $useThreeDots) ?
                    mb_substr( $text, 0, $limit, 'UTF-8' ) . '...' :
                    mb_substr( $text, 0, $limit, 'UTF-8' );
            }
        }
    }

    public function getCreatedAt( $full = TRUE )
    {
        if ( $full )
        {
            return date( 'j', $this->created_at ) . ' '
                . $this->getMonthName( date( 'm', $this->created_at ) ) . ' ' . date( 'Y', $this->created_at );
        }
        else
        {
            return date( 'd.m.y', $this->created_at );
        }
    }

    public function getFromUser()
    {
        return $this->fromUser;
    }

    public function getFromId()
    {
        return $this->from_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOnUser()
    {
        return $this->onUser;
    }

    public function getOnId()
    {
        return $this->on_id;
    }

    //      Backend

    /**
     * Returns data provider for Templated ListGrid
     * @return CActiveDataProvider
     */
    public function retrieveComplaints()
    {
        $criteria = new CDbCriteria();

        $criteria->compare( 'on_id', $this->on_id );

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
                'from_id',
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
            'from_id',
            'content',
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
            $this->getFromUser()->getFirstName(),
            $this->getContent( 150 ),
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

    public static function createComplaint( $fromId, $onId, $content )
    {
        $model = new UserComplaints();
        if ( $model->findByAttributes( array( 'from_id' => $fromId, 'on_id' => $onId ) ) )
        {
            return;
        }

        $model->from_id = $fromId;
        $model->on_id = $onId;
        $model->content = $content;
        $model->created_at = time();

        if ( $model->save() )
        {
            $count = $model->countByAttributes( array( 'on_id' => $onId ) );
            if ( $count % Yii::app()->params[ 'user' ][ 'complaintsLimitBeforeBan' ] == 0 )
            {
                /** @var $user User */
                $user = User::model()->findByPk( $onId );
                $user->is_banned = TRUE;
                $user->save();
            }
        }

    }

    //      Scopes

    public function onUser( $userId  )
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'condition' => 'on_id = :userId',
                    'params' => array( ':userId' => $userId )
                )
            );
        return $this;
    }

    public function fromUser( $userId  )
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'condition' => 'from_id = :userId',
                    'params' => array( ':userId' => $userId )
                )
            );
        return $this;
    }
}