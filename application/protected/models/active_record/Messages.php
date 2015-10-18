<?php

/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property integer $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $is_new
 * @property string $text
 * @property integer $created_at
 * @property integer $deleted_by_sender
 * @property integer $deleted_by_receiver
 *
 * The followings are the available model relations:
 * @property User $receiver
 * @property User $sender
 */
class Messages extends BaseTable
{
    const INCOMING = 1;
    const OUTCOMING = 2;

    public $userId = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Messages the static model class
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
		return 'messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('sender_id, receiver_id, is_new, text', 'required'),
			array('sender_id, receiver_id, is_new', 'numerical', 'integerOnly'=>true),
			array('id, sender_id, receiver_id, is_new, text, created_at, deleted_by_sender, deleted_by_receiver', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'receiver' => array(self::BELONGS_TO, 'User', 'receiver_id'),
			'sender' => array(self::BELONGS_TO, 'User', 'sender_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sender_id' => 'Відправник',
			'receiver_id' => 'Одержувач',
			'is_new' => 'Прочитане',
			'text' => 'Текст',
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
		$criteria->compare('sender_id',$this->sender_id);
		$criteria->compare('receiver_id',$this->receiver_id);
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @return string retrieves text
     */
    public function getText( $limit = NULL, $useThreeDots = FALSE )
    {
        if ( !$limit )
        {
            return $this->text;
        }
        else
        {
            $text = str_replace( "\t", '', $this->text );

            $text = trim( strip_tags( $text ) );

            if ( mb_strlen( $text, 'utf-8' ) <= $limit )
            {
                return $text;
            }
            else
            {
                return ( $useThreeDots) ?
                    mb_substr( $text, 0, $limit, 'UTF-8' ) . '...' :
                    mb_substr( strip_tags( $this->text ), 0, $limit, 'UTF-8' );
            }
        }
    }

    public function beforeSave()
    {
        if ( $this->isNewRecord )
        {
            $this->created_at = time();
        }

        return parent::beforeSave();
    }

    // Scopes

    public function bySenderId( $id  )
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'condition' => 'sender_id = :id',
                    'params' => array( ':id' => $id )
                )
            );
        return $this;
    }

    public function byReceiverId( $id  )
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'condition' => 'receiver_id = :id',
                    'params' => array( ':id' => $id )
                )
            );
        return $this;
    }

    public function onlyNew()
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'condition' => 'is_new = 1'
                )
            );
        return $this;
    }

    public function notDeleteBySender()
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'condition' => 'deleted_by_sender = 0'
                )
            );
        return $this;
    }

    public function notDeleteByReceiver()
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'condition' => 'deleted_by_receiver = 0'
                )
            );
        return $this;
    }

    public function markAsRead()
    {
        if ( (int)$this->is_new == 1 )
        {
            $this->is_new = 0;
            $this->save( FALSE );
        }
    }

    public static function getCountOfNewMessage( $userId )
    {
        return self::model()->count( 'is_new = 1 AND receiver_id = :userId AND deleted_by_receiver = 0', array( ':userId' => $userId ) );
    }

    public function retrieveMessages( $type )
    {
        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend' ][ 'messagesPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        $criteria = new CDbCriteria();

        if ( $type == self::OUTCOMING )
        {
            $criteria->compare('sender_id', Yii::app()->user->id );
            $criteria->compare('deleted_by_sender', 0 );
            $criteria->with = 'receiver';
            $criteria->order = 't.id DESC, is_new ASC';
            $pagination[ 'route' ] = 'touristDating/outcomingMessagesPaginationHandler';
        }
        else
        {
            $criteria->compare('receiver_id', Yii::app()->user->id );
            $criteria->compare('deleted_by_receiver', 0 );
            $criteria->with = 'sender';
            $criteria->order = 't.id DESC, is_new ASC';
            $pagination[ 'route' ] = 'touristDating/incomingMessagesPaginationHandler';
        }

        $this->_dataProvider = new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
            )
        );

        return $this->_foundData = ( $this->_dataProvider->totalItemCount > 0 );
    }

    public function retrieveNewMessages()
    {
        $criteria = new CDbCriteria();
        $criteria->compare( 'is_new', 1 );

        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend' ][ 'messagesPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        $this->_dataProvider = new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
            )
        );

        return $this->_foundData = ( $this->_dataProvider->totalItemCount > 0 );
    }

    public function getCreatedAt( $full = TRUE )
    {
        if ( $full )
        {
            return date( 'd', $this->created_at ) . ' '
                . $this->getMonthName( date( 'm', $this->created_at ) ) . ' ' . date( 'Y', $this->created_at );
        }
        else
        {
            return date( 'd-m-y', $this->created_at );
        }
    }

    public static function deleteMessage( $id )
    {
        /** @var $model Messages */
        if ( $model = self::model()->findByPk( $id ) )
        {
            if ( $model->receiver_id == Yii::app()->user->id )
            {
                if ( $model->deleted_by_sender )
                {
                    $model->delete();
                }
                else
                {
                    $model->deleted_by_receiver = TRUE;
                    $model->save( FALSE );
                }
            }
            else
            {
                if ( $model->deleted_by_receiver )
                {
                    $model->delete();
                }
                else
                {
                    $model->deleted_by_sender = TRUE;
                    $model->save( FALSE );
                }
            }
        }
    }

    public function getUserMessages()
    {
        $criteria = new CDbCriteria();

        $criteria->condition = 'sender_id = :userId OR receiver_id = :userId';
        $criteria->params = array(
            ':userId' => $this->userId
        );
        $criteria->with = array( 'sender', 'receiver' );

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
                'sender_id',
                'receiver_id',
                'created_at',
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

    public static function getHeadersForListGrid()
    {
        return array(
            'sender_id',
            'receiver_id',
            'created_at',
            'text'
        );
    }

    public static function getFiltersForListGrid()
    {
        return array();
    }

    public function getRowValues()
    {
        return array(
            $this->sender->getFirstName(),
            $this->receiver->getFirstName(),
            $this->getCreatedAt(),
            $this->getText( 100 )
        );
    }
}