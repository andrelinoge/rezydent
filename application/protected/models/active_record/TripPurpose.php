<?php

/**
 * This is the model class for table "trip_purpose".
 *
 * The followings are the available columns in table 'trip_purpose':
 * @property integer $id
 * @property integer $parent_id
 * @property string $value
 */
class TripPurpose extends BaseCatalogTable
{
    const FORM_ID = 'trip_purpose-form';
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
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
        return 'trip_purpose';
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
                'catalog_id',
                'value'
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
            'value',
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
            $this->getValue(),
        );
    }

    public static function getOptions( $firstItem = NULL )
    {
        // get array with data. Through DAO this will be a bit of quicker.
        $query = 'SELECT id, value FROM ' . static::tableName();
        $records = Yii::app()
            ->db
            ->createCommand( $query )
            ->queryAll();

        // prepare result array
        $data = array();

        foreach( $records as $record )
        {
            $data[ $record[ 'id' ] ] = $record[ 'value' ];
        }

        if ( $firstItem )
        {
            $prompt = array( '' => $firstItem );
            return $prompt + $data;
        }
        else
        {
            return $data;
        }
    }

}