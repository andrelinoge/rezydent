<?php
/**
 * @author Andriy Tolstokorov
 */

class TripForm extends CFormModel
{
    const FORM_ID = 'trip-form';
    public $with_id;
    public $companion_id;
    public $tickets;
    public $hotel;
    public $purpose_id;
    public $country_id;
    public $comment;
    public $start_at;
    public $end_at;
    public $children = 0;

    /** @var Trip */
    protected $_initial;
    protected $_isNew = TRUE;

    public function rules()
    {
        return array(
            array(
                'with_id, companion_id, purpose_id, country_id, start_at, end_at',
                'required',
                'message' => 'Поле обов\'язкове до заповнення'
            ),

            array(
                'tickets, hotel, comment, children', 'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'with_id' => 'Їду з',
            'companion_id' => 'Шукаю',
            'purpose_id' => 'Ціль',
            'country_id' => 'Країна',
            'start_at' => 'З',
            'end_at' => 'до',
            'hotel' => 'Заброньований готель',
            'tickets' => 'Є квитки',
            'children' => 'Кількість дітей',
            'comment' => 'Коментар'
        );
    }

    public function save()
    {
        if ( $this->_isNew )
        {
            $model = new Trip();
            $model->setAttributes( $this->getAttributes() );
            $model->save();
        }
        else
        {
            $this->_initial->setAttributes( $this->getAttributes() );
            $this->_initial->save();
        }
    }

    public function load( $id )
    {
        $trip = Trip::model()->findByPk( $id );
        if ( $trip )
        {
            $this->_isNew = FALSE;
            $this->_initial = $trip;
            $this->setAttributes( $trip->getAttributes() );
        }
        else
        {
            throw new CHttpException( '404' );
        }
    }

    public function getStartAt()
    {
        if ( $this->start_at )
        {
            if ( is_numeric( $this->start_at ) )
            {
                return date( 'd-m-Y', $this->start_at );
            }
            else
            {
                $this->start_at;
            }
        }
        else
        {
            return '';
        }
    }

    public function getEndAt()
    {
        if ( $this->end_at )
        {
            if ( is_numeric( $this->end_at ) )
            {
                return date( 'd-m-Y', $this->end_at );
            }
            else
            {
                return $this->end_at;
            }
        }
        else
        {
            return '';
        }
    }
}