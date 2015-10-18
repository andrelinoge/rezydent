<?php

/**
 * This is the model class for table "trip".
 *
 * The followings are the available columns in table 'trip':
 * @property integer $id
 * @property integer $with_id
 * @property string $with
 * @property integer $companion_id
 * @property string $companion
 * @property integer $tickets
 * @property integer $hotel
 * @property integer $purpose_id
 * @property string $purpose
 * @property integer $country_id
 * @property string $country
 * @property string $comment
 * @property integer $start_at
 * @property integer $end_at
 * @property integer $created_at
 * @property integer $owner_id
 * @property string $owner_name
 * @property integer $owner_age
 * @property integer $children
 * @property integer $views
 *
 * The followings are the available model relations:
 * @property TripCompanion $companionCatalog
 * @property TripPurpose $purposeCatalog
 * @property Country $countryCatalog
 * @property User $owner
 * @property TripWith $withCatalog
 */
class Trip extends BaseTable
{
    const FORM_ID = 'trip-form';
    protected $_initial;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Trip the static model class
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
		return 'trip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('with_id, companion_id, purpose_id, country_id, start_at, end_at', 'required'),
			array('with_id, companion_id, purpose_id, country_id, created_at, owner_id, owner_age, children', 'numerical', 'integerOnly'=>true),
			array('with, companion, purpose, country, owner_name', 'length', 'max'=>255),

            array('id, with_id, with, companion_id, companion, tickets, hotel, purpose_id, purpose, country_id, country, comment, start_at, end_at, created_at, owner_id, owner_name, owner_age, children, views',
                'safe',
            ),

			array('id, with_id, with, companion_id, companion, tickets, hotel, purpose_id, purpose, country_id, country, comment, start_at, end_at, created_at, owner_id, owner_name, owner_age, children, views',
                'safe',
                'on' => 'search'
            ),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'companionCatalog' => array(self::BELONGS_TO, 'TripCompanion', 'companion_id'),
			'purposeCatalog' => array(self::BELONGS_TO, 'TripPurpose', 'purpose_id'),
			'countryCatalog' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
			'withCatalog' => array(self::BELONGS_TO, 'TripWith', 'with_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'with_id' => 'Їду з',
			'with' => 'Їду з',
			'companion_id' => 'Шукаю',
			'companion' => 'Шукаю',
			'tickets' => 'Наявність квитків',
			'hotel' => 'Заброньований готель',
			'purpose_id' => 'Ціль',
			'purpose' => 'Ціль',
			'country_id' => 'Країна',
			'country' => 'Країна',
			'comment' => 'Коментар',
			'start_at' => 'Від',
			'end_at' => 'До',
			'created_at' => 'Створено',
			'owner_id' => 'id власниак',
			'owner_name' => 'Ім\'я власника',
			'owner_age' => 'Вік власника',
			'children' => 'Діти',
			'views' => 'Переглядів',
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
		$criteria->compare('with_id',$this->with_id);
		$criteria->compare('with',$this->with,true);
		$criteria->compare('companion_id',$this->companion_id);
		$criteria->compare('companion',$this->companion,true);
		$criteria->compare('tickets',$this->tickets);
		$criteria->compare('hotel',$this->hotel);
		$criteria->compare('purpose_id',$this->purpose_id);
		$criteria->compare('purpose',$this->purpose,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('start_at',$this->start_at);
		$criteria->compare('end_at',$this->end_at);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('owner_name',$this->owner_name,true);
		$criteria->compare('owner_age',$this->owner_age);
		$criteria->compare('children',$this->children);
		$criteria->compare('views',$this->views);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function frontendSearch()
    {
        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend' ][ 'tripsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        $criteria = new CDbCriteria();

        $criteria->compare( 'owner_age', $this->owner_age, true );
        $criteria->compare( 'country_id', $this->country_id, true );
        $criteria->compare( 'purpose_id', $this->purpose_id, true );
        $criteria->compare( 'with_id', $this->with_id, true );
        $criteria->compare( 'companion_id', $this->companion_id, true );

        if ( !empty( $this->start_at ) )
        {
            $criteria->addCondition( 'start_at > :startAt' );
            $criteria->params += array( 'startAt' => $this->start_at );
        }

        $criteria->order = 't.id DESC';
        $pagination[ 'route' ] = 'touristDating/tripsPaginationHandler';


        $this->_dataProvider = new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
            )
        );

        return $this->_foundData = ( $this->_dataProvider->totalItemCount > 0 );
    }

    public function retrieveMyScheduledTrips()
    {
        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend' ][ 'tripsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        $criteria = new CDbCriteria();

        $criteria->condition = 'end_at > ' . time();
        $criteria->addCondition( 'owner_id = ' . Yii::app()->user->id );
        $criteria->order = 't.id DESC';
        //$pagination[ 'route' ] = 'touristDating/outcomingMessagesPaginationHandler';


        $this->_dataProvider = new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
            )
        );

        return $this->_foundData = ( $this->_dataProvider->totalItemCount > 0 );
    }

    public function retrieveMyPastTrips()
    {
        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend' ][ 'tripsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        $criteria = new CDbCriteria();

        $criteria->condition = 'end_at < ' . time();
        $criteria->addCondition( 'owner_id = ' . Yii::app()->user->id );
        $criteria->order = 't.id DESC';
        $pagination[ 'route' ] = 'touristDating/myPastTripsPaginationHandler';


        $this->_dataProvider = new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
            )
        );

        return $this->_foundData = ( $this->_dataProvider->totalItemCount > 0 );
    }

    public function retrieveScheduledTrips( $ownerId )
    {
        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend' ][ 'tripsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        $criteria = new CDbCriteria();

        $criteria->condition = 'end_at > ' . time();
        $criteria->addCondition( 'owner_id = ' . $ownerId );
        $criteria->order = 't.id DESC';


        $this->_dataProvider = new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
            )
        );

        return $this->_foundData = ( $this->_dataProvider->totalItemCount > 0 );
    }

    public function retrievePastTrips( $ownerId )
    {
        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend' ][ 'tripsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        $criteria = new CDbCriteria();

        $criteria->condition = 'end_at < ' . time();
        $criteria->addCondition( 'owner_id = ' . $ownerId );
        $criteria->order = 't.id DESC';
        $pagination[ 'route' ] = 'touristDating/pastTripsPaginationHandler';


        $this->_dataProvider = new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
                'pagination'    => $pagination,
            )
        );

        return $this->_foundData = ( $this->_dataProvider->totalItemCount > 0 );
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getCompanion()
    {
        return $this->companion;
    }

    public function getCompanionCatalog()
    {
        return $this->companionCatalog;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getCountryCatalog()
    {
        return $this->countryCatalog;
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

    public function getEndAt( $full = TRUE )
    {
        if ( $full )
        {
            return date( 'j', $this->end_at ) . ' '
                . $this->getMonthName( date( 'm', $this->end_at ) ) . ' ' . date( 'Y', $this->end_at );
        }
        else
        {
            return date( 'd.m.y', $this->end_at );
        }
    }

    public function getHotel()
    {
        return $this->hotel;
    }

    public function getHotelValue()
    {
        return ( $this->hotel ) ? 'так' : 'ні';
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getOwnerAge()
    {
        return $this->owner_age;
    }

    public function getOwnerName()
    {
        return $this->owner_name;
    }

    public function getPurpose()
    {
        return $this->purpose;
    }

    public function getPurposeCatalog()
    {
        return $this->purposeCatalog;
    }

    public function getStartAt( $full = TRUE )
    {
        if ( $full )
        {
            return date( 'j', $this->start_at ) . ' '
                . $this->getMonthName( date( 'm', $this->start_at ) ) . ' ' . date( 'Y', $this->start_at );
        }
        else
        {
            return date( 'd.m.y', $this->start_at );
        }
    }

    public function getTickets()
    {
        return $this->tickets;
    }

    public function getTicketsValue()
    {
        return ( $this->tickets ) ? 'є' : 'нема';
    }

    public function getViews()
    {
        return $this->views;
    }

    public function getWith()
    {
        return $this->with;
    }

    public function getWithCatalog()
    {
        return $this->withCatalog;
    }

    public function afterFind()
    {
        $this->_initial = $this->getAttributes();
    }

    public function beforeSave()
    {
        if ( !is_numeric( $this->end_at ) )
        {
            $this->end_at = strtotime( $this->end_at );
        }

        if ( !is_numeric( $this->start_at ) )
        {
            $this->start_at = strtotime( $this->start_at );
        }

        if ( $this->getIsNewRecord() )
        {
            $this->_createNew();
        }
        else
        {
            $this->_updateExisting();
        }

        return parent::beforeSave();
    }

    protected function _createNew()
    {
        $this->with = TripWith::getValueById( $this->with_id );
        $this->companion = TripCompanion::getValueById( $this->companion_id );
        $this->country = Country::getValueById( $this->country_id );
        $this->purpose = TripPurpose::getValueById( $this->purpose_id );

        /** @var $owner User */
        $owner = Yii::app()->user->getModel();
        $this->owner_age = $owner->getAge();
        $this->owner_name = $owner->getFirstName();
        $this->owner_id = $owner->id;

        $this->views = 0;
        $this->created_at = time();

        if ( $this->end_at < $this->start_at )
        {
            $t =  $this->end_at;
            $this->end_at = $this->start_at;
            $this->start_at = $t;
        }
    }

    protected function _updateExisting()
    {
        if ( $this->purpose_id != $this->_initial[ 'purpose_id' ] )
        {
            $this->purpose = TripPurpose::getValueById( $this->purpose_id );
        }

        if ( $this->country_id != $this->_initial[ 'country_id' ] )
        {
            $this->country = Country::getValueById( $this->country_id );
        }

        if ( $this->with_id != $this->_initial[ 'with_id' ] )
        {
            $this->with = TripWith::getValueById( $this->with_id );
        }

        if ( $this->companion_id != $this->_initial[ 'companion_id' ] )
        {
            $this->companion = TripCompanion::getValueById( $this->companion_id );
        }

        if ( $this->end_at < $this->start_at )
        {
            $t =  $this->end_at;
            $this->end_at = $this->start_at;
            $this->start_at = $t;
        }
    }

    public function increaseViews()
    {
        if ( Yii::app()->user->isGuest )
        {
            $this->views++;
            $this->save( FALSE );
        }
        else
        {
            if ( $this->owner_id != Yii::app()->user->id )
            {
                $this->views++;
                $this->save( FALSE );
            }
        }
    }

    public function getUserTrips()
    {
        $criteria=new CDbCriteria;

        //$criteria->compare( 'owner_id', $this->owner_id );
        $criteria->compare( 'country_id', $this->country_id );
        $criteria->compare( 'purpose_id', $this->purpose_id );
        $criteria->compare( 'with_id', $this->with_id );
        $criteria->compare( 'companion_id', $this->companion_id );

        $criteria->addCondition( 'owner_id = :userId' );
        $criteria->params += array( ':userId' => $this->owner_id );

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['backend']['itemsPerPage'],
                'pageVar'=>'page',
            ),
            'sort'=>array(
                'defaultOrder'=>'created_at',
                'sortVar'=>'sort',
                'attributes'=>array(
                    'country_id',
                    'purpose_id',
                    'with_id',
                    'companion_id'
                ),
            ),
        ));
    }

    public static function getHeadersForListGrid()
    {
        return array(
            'country_id',
            'purpose_id',
            'with_id',
            'companion_id',
            'start_at',
            'end_at'
        );
    }

    public function getUsersTripsRowValues()
    {
        return array(
            $this->getCountry(),
            $this->getPurpose(),
            $this->getWith(),
            $this->getCompanion(),
            $this->getStartAt( FALSE ),
            $this->getEndAt( FALSE )

        );
    }

    public static function getFiltersForListGrid()
    {
        return array(
            'country_id' => Country::getOptions( 'країна' ),
            'purpose_id' => TripPurpose::getOptions( 'ціль' ),
            'with_id' => TripWith::getOptions( 'з ким' ),
            'companion_id' => TripCompanion::getOptions( 'шукає' )
        );
    }

    public static function getStartPeriods( $defaultText = '' )
    {
        $months = array(
            'Січень',
            'Лютий',
            'Березень',
            'Квітень',
            'Травень',
            'Червень',
            'Липень',
            'Серпень',
            'Вересень',
            'Жовтень',
            'Листопад',
            'Грудень'
        );

        $month = date( 'm', time() );
        $year = date( 'Y', time() );

        $result = ( !empty( $defaultText ) ) ? array( ' ' => $defaultText ) : array();

        for ( $i = $month; $i <= 12; $i++ )
        {
            $result[ mktime( 0, 0, 0, $i, 1,  $year ) ] = $months[ $i - 1 ] . ' ' . $year;
        }

        $year++;

        for ( $i = 1; $i < $month; $i++ )
        {
            $result[ mktime( 0, 0, 0, $i, 1, $year ) ] = $months[ $i - 1 ] . ' ' . $year;
        }

        return $result;
    }

    //      Scopes

    public function byOwner( $userId  )
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'condition' => 'owner_id = :userId',
                    'params' => array( ':userId' => $userId )
                )
            );
        return $this;
    }

}