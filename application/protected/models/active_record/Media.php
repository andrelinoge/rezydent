<?php

/**
 * This is the model class for table "news".
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
 * Relations

 */
class Media extends BaseCatalogArticleTable
{
    const FORM_ID = 'news-form';

    const USE_TAGS = FALSE;
    const USE_IMAGE = TRUE;

    const RELATION_TABLE_NAME = 'relation_cat_articles_tags';
    const RELATION_MODEL_CLASS = 'RelationCatArticlesTags';
    const ARTICLE_PRIMARY_KEY_IN_RELATION = 'article_id';
    const TAG_PRIMARY_KEY_IN_RELATION = 'tag_id';
    const TAGS_MODEL_CLASS = 'TestTags';

    const THUMB_PREFIX_MICRO = 'mi_';

    public function init()
    {
        if ( static::USE_IMAGE )
        {
            $this->setTempFolder( '/public/uploads/temp/' );
            $this->setImagesFolder( '/public/uploads/media/' );
            $this->setThumbsSettings(
                array(
                    static::THUMB_PREFIX_MEDIUM => array( 500, 350 ),
                    static::THUMB_PREFIX_SMALL => array( 440, 230 ),
                    static::THUMB_PREFIX_MICRO => array( 60, 60)
                )
            );
        }

        parent::init();
    }

    public function rules()
    {

        return array(
            array( 'title, text', 'required' ),
            array( 'title', 'length', 'max'=>255 ),
            array(
                'id, created_at, edited_at, publish_at, author_id, editor_id',
                'numerical',
                'integerOnly' => TRUE
            ),

            array( 'id, meta_keywords, meta_description, image', 'safe'),

            array(
                'id, title, text, created_at, edited_at, publish_at, author_id, editor_id,
                 meta_keywords, meta_description, image',
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
        return 'media';
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
                'created_at',
                'publish_at',
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

    public function frontendSearch( $year )
    {
        $criteria = new CDbCriteria();

        if ( $year )
        {
            $criteria->addBetweenCondition( 'created_at', mktime( 0, 0, 0, 1, 1, $year), mktime( 0, 0, 0, 12, 31, $year) );
        }

        $limit = Yii::app()
            ->request
            ->getParam( 'items_limit', Yii::app()->params[ 'frontend'][ 'itemsPerPage' ] );

        $pagination = array(
            'pageSize' => $limit,
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
            'created_at',
            'publish_at',
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
            $this->getCreatedAt(),
            $this->getPublishAt()
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
        return array();
    }

    public function beforeValidate()
    {
        $this->publish_at = empty( $this->publish_at ) ? 0 : strtotime( $this->publish_at );
        return parent::beforeValidate();
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

    public static function getYearsForArchive()
    {
        $query = 'SELECT MIN( created_at ) FROM ' . static::tableName();
        $minDate = (int)Yii::app()
            ->db
            ->createCommand( $query )
            ->queryScalar();

        $minYear = date( 'Y', $minDate );
        $currentYear = date( 'Y' );

        $result = array();
        for( $i = $minYear; $i <= $currentYear; $i++ )
        {
            $result[] = $i;
        }

        return $result;
    }

}