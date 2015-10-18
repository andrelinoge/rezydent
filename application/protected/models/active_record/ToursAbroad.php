<?php

/**
 * This is the model class for table "test_catalog_article".
 *
 * The followings are the available columns in table 'test_catalog_article':
 * @property integer $id
 * @property integer $catalog_id
 * @property string $title
 * @property string $text
 * @property integer $author_id
 * @property integer $editor_id
 * @property string $created_at
 * @property string $edited_at
 * @property string $publish_at
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $image
 * @property string $country
 * @property string $frame_url
 * Relations
 * @property BaseCatalogTable $catalog
 */
class ToursAbroad extends BaseCatalogArticleTable
{
    const FORM_ID = 'propositions-form';

    const USE_TAGS = FALSE;
    const USE_IMAGE = TRUE;

    const RELATION_TABLE_NAME = '';
    const RELATION_MODEL_CLASS = '';
    const ARTICLE_PRIMARY_KEY_IN_RELATION = '';
    const TAG_PRIMARY_KEY_IN_RELATION = '';
    const TAGS_MODEL_CLASS = '';

    public function init()
    {
        if ( static::USE_IMAGE )
        {
            $this->setTempFolder( '/public/uploads/temp/' );
            $this->setImagesFolder( '/public/uploads/tours_abroad/' );
            $this->setThumbsSettings(
                array(
                    static::THUMB_PREFIX_MEDIUM => array( 500, 400 ),
                    static::THUMB_PREFIX_SMALL => array( 320, 200 ),
                )
            );
        }

        parent::init();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'catalog_id' => 'Catalog ID',
            'text' => 'Текст' ,
            'title' =>  'Заголовок' ,
            'is_visible' => 'Пропозиція виводиться',
            'meta_keywords' =>  'Ключові слова для мета тегів' ,
            'meta_description' =>  'Мета опис',
            'country' =>  'Країна',
            'frame_url' =>  'Посилання для фрейму'
        );
    }

    public function rules()
    {

        return array(
            array( 'title, text, country, frame_url', 'required' ),
            array( 'title', 'length', 'max'=>255 ),
            array(
                'id, created_at, edited_at, publish_at, author_id, editor_id, catalog_id',
                'numerical',
                'integerOnly' => TRUE
            ),

            array( 'id, meta_keywords, meta_description, is_visible, image', 'safe'),

            array(
                'id, title, text, created_at, edited_at, publish_at, author_id, editor_id,
                 meta_keywords, meta_description, catalog_id, image, is_visible',
                'safe',
                'on'=>'search'
            ),
        );
    }

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
        return 'tours_abroad';
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
                'country'
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
            'title',
            'country',
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
            $this->getTitle(),
            $this->getCountry()
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

    /**
     * @return BaseCatalogTableML
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    public function getCatalogOptions()
    {
    }

    public function beforeValidate()
    {
        $this->publish_at = empty( $this->publish_at ) ? 0 : strtotime( $this->publish_at );
        return parent::beforeValidate();
    }

    public function getCountry()
    {
        return $this->country;
    }
}