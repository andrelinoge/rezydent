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
 * Relations
 * @property BaseCatalogTable $catalog
 * @property TestTags[] $tags
 */
class ToursUkraine extends BaseCatalogArticleTable
{
    const FORM_ID = 'form';

    const USE_TAGS = FALSE;
    const USE_IMAGE = TRUE;

    const RELATION_TABLE_NAME = 'relation_cat_articles_tags';
    const RELATION_MODEL_CLASS = 'RelationCatArticlesTags';
    const ARTICLE_PRIMARY_KEY_IN_RELATION = 'article_id';
    const TAG_PRIMARY_KEY_IN_RELATION = 'tag_id';
    const TAGS_MODEL_CLASS = 'TestTags';

    public function init()
    {
        if ( static::USE_IMAGE )
        {
            $this->setTempFolder( '/public/uploads/temp/' );
            $this->setImagesFolder( '/public/uploads/tours/' );
            $this->setThumbsSettings(
                array(
                    static::THUMB_PREFIX_MEDIUM => array( 640, 480 ),
                    static::THUMB_PREFIX_SMALL => array( 320, 200 ),
                )
            );
        }

        parent::init();
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
        return 'tours_ukraine';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'catalog' => array(
                self::BELONGS_TO,
                'ToursUkraineCatalog',
                array(
                    'catalog_id' => 'id'
                ),
                'joinType' => 'INNER JOIN'
            ),
        );
    }

    /**
     * Returns data provider for Templated ListGrid
     * @return CActiveDataProvider
     */
    public function backendSearch()
    {
        $criteria = new CDbCriteria();
        $criteria->alias = 'catalog_articles';
        $criteria->compare( 'catalog_articles.catalog_id', $this->catalog_id);

        $criteria->with = array( 'catalog' );

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
                'catalog_id',
                'author_id',
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

    /**
     * Returns list of field names which will be used as headers for list grid columns
     * @return array
     */
    public static function getHeadersForListGrid()
    {
        return array(
            'title',
            'catalog_id',
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
            $this->getCatalog()->getValue()
        );
    }

    /**
     * @return array with filters for templated ListGrid widget
     */
    public static function getFiltersForListGrid()
    {
        return array(
            'catalog_id' => ToursUkraineCatalog::getOptions( _('- Категорія -' ), NULL, TRUE ),
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
        return ToursUkraineCatalog::getOptions( _( 'Виберіть категорію' ), TRUE );
    }

    public function beforeValidate()
    {
        $this->publish_at = empty( $this->publish_at ) ? 0 : strtotime( $this->publish_at );
        return parent::beforeValidate();
    }
}