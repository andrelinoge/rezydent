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
 * @property integer $is_visible
 * @property integer $show_in_slider
 * @property string $days
 * @property string $price
 * @property string $comment
 * Relations
 * @property BaseCatalogTable $catalog
 */
class Propositions extends BaseCatalogArticleTable
{
    const FORM_ID = 'propositions-form';

    const USE_TAGS = FALSE;
    const USE_IMAGE = TRUE;

    const RELATION_TABLE_NAME = '';
    const RELATION_MODEL_CLASS = '';
    const ARTICLE_PRIMARY_KEY_IN_RELATION = '';
    const TAG_PRIMARY_KEY_IN_RELATION = '';
    const TAGS_MODEL_CLASS = '';

    const THUMB_PREFIX_MICRO = 'mi_';
    const THUMB_PREFIX_VERY_SMALL = 'vs_';

    public function init()
    {
        if ( static::USE_IMAGE )
        {
            $this->setTempFolder( '/public/uploads/temp/' );
            $this->setImagesFolder( '/public/uploads/propositions/' );
            $this->setThumbsSettings(
                array(
                    static::THUMB_PREFIX_MEDIUM => array( 640, 480 ),
                    static::THUMB_PREFIX_SMALL => array( 240, 150 ),
                    static::THUMB_PREFIX_VERY_SMALL => array( 160, 100 ),
                    static::THUMB_PREFIX_MICRO => array( 60, 60 )
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
            'is_visible' => 'Пропозиція відображається на сайті',
            'show_in_slider' => 'Пропозиція відображається в слайдері',
            'meta_keywords' =>  'Ключові слова для мета тегів' ,
            'meta_description' =>  'Мета опис',
            'price' => 'Ціна',
            'days' => 'Днів',
            'comment' => 'Короткий коментар'
        );
    }

    public function rules()
    {

        return array(
            array( 'title, text', 'required' ),
            array( 'title', 'length', 'max'=>255 ),
            array(
                'id, created_at, edited_at, publish_at, author_id, editor_id, catalog_id',
                'numerical',
                'integerOnly' => TRUE
            ),

            array( 'id, meta_keywords, meta_description, is_visible, image, show_in_slider, price, days,comment', 'safe'),

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
        return 'propositions';
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
                'is_visible',
                'show_in_slider'
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

    public function frontendSearch()
    {
        $criteria = new CDbCriteria();

        $criteria->compare( 'is_visible', TRUE );

        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend'][ 'propositionsPerPage' ] );

        $pagination = array(
            //'pageSize' => $limit,
            'pageVar'=>'page',
        );

        // This column headers for those fields will be active
        $sort = array(
            'sortVar'       => 'sort',
            'defaultOrder'  => 'created_at DESC'
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
            'is_visible',
            'show_in_slider'
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
            $this->getVisibilityValue(),
            $this->getVisibilityOnSliderValue()
        );
    }

    /**
     * @return array with filters for templated ListGrid widget
     */
    public static function getFiltersForListGrid()
    {
        return array(
            'catalog_id' => EmbassiesCatalog::getOptions( _('- Фільтрувати -' ), NULL, TRUE ),
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
        return TestCatalog::getOptions( _( 'Виберіть категорію' ), TRUE );
    }

    public function beforeValidate()
    {
        $this->publish_at = empty( $this->publish_at ) ? 0 : strtotime( $this->publish_at );
        return parent::beforeValidate();
    }

    public function getVisibilityValue()
    {
        if ( $this->is_visible )
        {
            return 'Так';
        }
        else
        {
            return 'Ні';
        }
    }

    public function getVisibilityOnSliderValue()
    {
        if ( $this->show_in_slider )
        {
            return 'Так';
        }
        else
        {
            return 'Ні';
        }
    }

    public function getMicroThumbnail()
    {
        if ( !empty( $this->image ) )
        {
            return static::PATH_MODIFIER . $this->imagesFolder . static::THUMB_PREFIX_MICRO . $this->image;
        }
        else
        {
            return NULL;
        }
    }

    public function getVerySmallThumbnail()
    {
        if ( !empty( $this->image ) )
        {
            return static::PATH_MODIFIER . $this->imagesFolder . static::THUMB_PREFIX_VERY_SMALL . $this->image;
        }
        else
        {
            return NULL;
        }
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function getComment()
    {
        return $this->comment;
    }
}