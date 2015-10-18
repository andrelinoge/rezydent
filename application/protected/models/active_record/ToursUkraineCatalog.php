<?php

/**
 * This is the model class for table "test_catalog".
 *
 * The followings are the available columns in table 'test_catalog':
 * @property integer $id
 * @property integer $parent_id
 * @property string $value
 * @property ToursUkraine[] $tours
 */
class ToursUkraineCatalog extends BaseCatalogTable
{
    const FORM_ID = 'tours-ukraine-form';
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'tours' => array(
                self::HAS_MANY,
                'ToursUkraine',
                array(
                    'catalog_id' => 'id'
                ),
                'joinType' => 'INNER JOIN'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'value' => 'Категорія'
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tours_ukraine_catalog';
    }

    /**
     * Returns data provider for Templated ListGrid
     * @return CActiveDataProvider
     */
    public function backendSearch()
    {
        $criteria = new CDbCriteria();

        if ( $this->parent_id !== NULL )
        {
            $criteria->compare('parent_id', $this->parent_id );
        }

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
    public static function getHeadersForListGrid()
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

    /**
     * @return array|ToursUkraine[]
     */
    public function getTours()
    {
        if ( !empty( $this->tours ) )
        {
            return $this->tours;
        }
        else
        {
            return array();
        }
    }

}