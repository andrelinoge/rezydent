<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class BaseCatalogArticleTableML extends BaseArticleTableML
{
    // if set TRUE, model will react in tags
    const USE_TAGS = FALSE;
    // name for intermediary table in many-to-many relations
    const RELATION_TABLE_NAME = NULL;
    // class name of model for intermediary table
    const RELATION_MODEL_CLASS = NULL;
    // field name in intermediary table to link articles
    const ARTICLE_PRIMARY_KEY_IN_RELATION = 'article_id';
    // field name in intermediary table to link tags
    const TAG_PRIMARY_KEY_IN_RELATION = 'tag_id';
    // class for tags model
    const TAGS_MODEL_CLASS = NULL;
    // if set TRUE, model will react on image field (file move to image folder and create thumbs)
    const USE_IMAGE = FALSE;

    const PATH_MODIFIER = '/application';

    const THUMB_PREFIX_SMALL = 's_';
    const THUMB_PREFIX_MEDIUM = 'm_';

    protected $tempFolder = NULL;
    protected $imagesFolder = NULL;
    protected $thumbsSettings = array();

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        return array(
            array( 'article_id, lang, title, text', 'required' ),
            array( 'title', 'length', 'max'=>255 ),
            array( 'lang', 'length', 'max'=>2 ),
            array(
                'article_id, created_at, edited_at, author_id, editor_id, catalog_id',
                'numerical',
                'integerOnly' => TRUE
            ),

            array(
                'publish_at',
                'numerical',
                'allowEmpty' => TRUE
            ),

            array( 'meta_keywords, meta_description, image, tags', 'safe'),

            array(
                'id, article_id, lang, title, text, created_at, edited_at, publish_at, author_id, editor_id,
                 meta_keywords, meta_description, catalog_id',
                'safe',
                'on'=>'search'
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'article_id' => 'ID',
            'catalog_id' => 'Catalog ID',
            'lang' => 'Lang',
            'text' => _( 'Text' ),
            'title' => _( 'Title' ),
            'meta_keywords' => _( 'Key words' ),
            'meta_description' => _( 'Description' )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare( 'id',           $this->id                );
        $criteria->compare( 'article_id',   $this->article_id        );
        $criteria->compare( 'catalog_id',   $this->catalog_id        );
        $criteria->compare( 'lang',         $this->lang              );
        $criteria->compare( 'title',        $this->title,       TRUE );
        $criteria->compare( 'text',         $this->text,        TRUE );
        $criteria->compare( 'author_id',    $this->author_id         );
        $criteria->compare( 'editor_id',    $this->editor_id         );
        $criteria->compare( 'crated_at',    $this->crated_at,   TRUE );
        $criteria->compare( 'edited_at',    $this->edited_at,   TRUE );
        $criteria->compare( 'publish_at',   $this->publich_at,  TRUE );

        return new CActiveDataProvider(
            $this,
            array(
                'criteria'=>$criteria,
            )
        );
    }

    /**
     * @param string $folder
     * @return mixed
     * @throws CException
     */
    public function setImagesFolder( $folder )
    {
        if ( !is_writable( Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . $folder ) )
        {
            throw new CException( 'Image folder is not writable or does not exists. Folder: ' . $folder );
        }

        return $this->imagesFolder = $folder;
    }

    /**
     * @return string
     * @throws CException
     */
    public function getImagesFolder( $fullPath = FALSE )
    {
        if ( !empty( $this->imagesFolder ) )
        {
            if ( $fullPath )
            {
                return Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . $this->imagesFolder;
            }
            else
            {
                return self::PATH_MODIFIER . $this->imagesFolder;
            }
        }
        else
        {
            throw new CException( 'Image folder is not set!' );
        }
    }

    /**
     * @param string $folder
     * @return mixed
     * @throws CException
     */
    public function setTempFolder( $folder )
    {
        if ( !is_writable( Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . $folder ) )
        {
            throw new CException( 'Image folder is not writable or does not exists. Folder: ' . $folder );
        }

        return $this->tempFolder = $folder;
    }

    /**
     * @return string
     * @throws CException
     */
    public function getTempFolder( $fullPath = FALSE )
    {
        if ( !empty( $this->tempFolder ) )
        {
            if ( $fullPath )
            {
                return Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . $this->tempFolder;
            }
            else
            {
                return $this->tempFolder;
            }
        }
        else
        {
            throw new CException( 'Temporary folder for images is not set!' );
        }
    }

    /**
     * Settings for thumbs. Format: array( $thumbPrefix => array( $thumbsWidth, $thumbHeight ) )
     * @param array $thumbsSettings
     * @throws CException
     */
    public function setThumbsSettings( $thumbsSettings )
    {
        if ( !is_array( $thumbsSettings ) )
        {
            throw new CException( 'Settings for thumbs must be an array. Array format: $prefix => array( $width, $height )');
        }
        else
        {
            $this->thumbsSettings = $thumbsSettings;
        }
    }

    /**
     * Settings for thumbs. Format: array( $thumbPrefix => array( $thumbsWidth, $thumbHeight ) )
     * @return array
     */
    public function getThumbsSettings()
    {
        return $this->thumbsSettings;
    }

    /**
     * Copy image from temporary folder to proper destination and create thumbnails
     */
    protected function saveImage()
    {
        $imageHandler= new CImageHandler();
        $imageHandler->load( $this->getTempFolder( TRUE ) . $this->image );
        $imageHandler->save($this->getImagesFolder( TRUE ) . $imageHandler->getBaseFileName() );

        $settings = $this->getThumbsSettings();

        if ( !empty( $settings ) )
        {
            $imageHandler= new CImageHandler();
            $imageHandler->load( $this->getTempFolder( TRUE ) . $this->image );

            foreach( $settings as $prefix => $dimensions )
            {
                list( $width, $height ) = $dimensions;
                $imageHandler
                    ->thumb( $width, $height )
                    ->save( $this->getImagesFolder( TRUE ) . $prefix . $imageHandler->getBaseFileName() );
            }
        }
    }

    /**
     * @return null|string path to original image for src attribute
     */
    public function getOriginalImage()
    {
        if ( !empty( $this->image ) )
        {
            return static::PATH_MODIFIER . $this->imagesFolder . $this->image;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * @return null|string path to small thumbnail for src attribute
     */
    public function getSmallThumbnail()
    {
        if ( !empty( $this->image ) )
        {
            return static::PATH_MODIFIER . $this->imagesFolder . static::THUMB_PREFIX_SMALL . $this->image;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * @return null|string path to medium thumbnail for src attribute
     */
    public function getMediumThumbnail()
    {
        if ( !empty( $this->image ) )
        {
            return static::PATH_MODIFIER . $this->imagesFolder . static::THUMB_PREFIX_MEDIUM . $this->image;
        }
        else
        {
            return NULL;
        }
    }
}