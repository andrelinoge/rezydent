<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 *
 * This is the model class for table "static_page".
 *
 * The followings are the available columns in table 'static_page':
 * @property integer $id
 * @property integer $page_id
 * @property string $title
 * @property string $text
 * @property string $meta_keywords
 * @property string $meta_description
 */
class StaticPages extends BaseStaticPageTable
{
    const HOME = 1;
    const CONTACT = 2;
    const FAQ = 3;
    const WORK = 4;
    const EMBASSIES = 5;
    const TOURS = 6;
    const HOT_PROPOSITION = 7;
    const NEWS = 8;
    const TICKETS = 9;
    const TICKETS_AIR = 10;
    const TICKETS_TRAIN = 11;
    const EMBASSIES_WITH_VISA = 12;
    const EMBASSIES_WITHOUT_VISA = 13;
    const TOURS_CHILDREN = 14;
    const TOURS_UKRAINE = 15;
    const TOURS_HEALTH = 16;
    const TOURS_ABROAD = 17;
    const PASSENGER = 18;
    const WEATHER = 19;
    const WEATHER_RESORT = 20;
    const WEATHER_SEA = 21;
    const MEDIA = 22;
    const TOURIST_DATING = 23;
    const ACCOUNT_BANNED = 24;

    const FORM_ID = 'static-page-form';
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return StaticPages the static model class
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
        return 'static_pages';
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
            ->getParam( 'items_limit', Yii::app()->params[ 'backend'][ 'itemsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
            'pageVar'=>'page',
        );

        // This column headers for those fields will be active
        $sort = array(
            'sortVar'       =>'sort',
            'attributes' => array(
                'title',
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
     * return array with values for row cells in Templated ListGrid.
     * Note: order and count of fields must be the same as those that returns method for column headers
     * @return array
     */
    public function getRowValues()
    {
        return array(
            $this->getTitle()
        );
    }

    /**
     * Returns list of field names which will be used as headers for list grid columns
     * @return array
     */
    public static function getInnerLinks()
    {
        return array(
            'Test' => '/test_url',
            'Test1' => '/test_url1',
            'Test2' => '/test_url2',
            'TestGroup' => array(
                'Test5' => '/test_url5',
                'Test6' => '/test_url6',
            ),
        );
    }

    public static function getHeadersForListGrid()
    {
        return array(
            'title'
        );
    }
}