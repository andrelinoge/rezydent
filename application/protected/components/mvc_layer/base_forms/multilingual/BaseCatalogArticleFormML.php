<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

abstract class BaseCatalogArticleFormML extends AbstractMultilingualForm
{
    const FORM_ID = 'base-catalog-article-form';

    // For tags support
    const USE_TAGS = TRUE;

    const RELATION_TABLE_NAME = 'relation_articles_tags_ml';
    const RELATION_MODEL_CLASS = 'RelationArticlesTagsMl';

    const ARTICLE_PRIMARY_KEY_IN_RELATION = 'article_id';
    const TAG_PRIMARY_KEY_IN_RELATION = 'tag_id';
    const TAGS_MODEL_CLASS = 'TestTagsMl';

    // For cover image support
    const USE_IMAGE = FALSE;

    const PATH_MODIFIER = '/application';

    const THUMB_PREFIX_SMALL = 's_';
    const THUMB_PREFIX_MEDIUM = 'm_';

    // NOTE: add or remove necessary fields depending on available languages
    public $title_en;
    public $text_en;
    public $meta_keywords_en;
    public $meta_description_en;

    public $title_uk;
    public $text_uk;
    public $meta_keywords_uk;
    public $meta_description_uk;

    public $title_ru;
    public $text_ru;
    public $meta_keywords_ru;
    public $meta_description_ru;

    // Common fields
    public $catalog_id = NULL;
    public $publish_at = '';
    public $image = NULL;
    public $tags = array();

    // Fields for inner purposes
    protected $article_id = NULL;
    protected $initialTags = array();

    public function rules()
    {
        return array(
            // en
            array( 'title_en', 'required' ),
            array( 'text_en', 'required' ),
            array( 'meta_keywords_en', 'safe' ),
            array( 'meta_description_en', 'safe' ),
            // uk
            array( 'title_uk', 'required' ),
            array( 'text_uk', 'required' ),
            array( 'meta_keywords_uk', 'safe' ),
            array( 'meta_description_uk', 'safe' ),
            // ru
            array( 'title_ru', 'required' ),
            array( 'text_ru', 'required' ),
            array( 'meta_keywords_ru', 'safe' ),
            array( 'meta_description_ru', 'safe' ),

            array( 'catalog_id', 'required' ),
            array(
                'title_en, title_uk, title_ru',
                'length',
                'max' => 255
            ),
            array( 'publish_at, tags, image', 'safe' ),
        );
    }

    /** Create new records depending on available languages and class properties */
    protected function createNewRecords()
    {
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();
        $newItemId = $modelClassName::getLastId() + 1;

        $publishAt = strtotime( $this->publish_at );
        $publishAt = ( $publishAt === FALSE ) ? NULL : $publishAt;

        // create set of catalog records with the same catalog_id
        foreach( $this->getLanguages() as $lang )
        {
            $titleField = 'title_' . $lang;
            $textField = 'text_' . $lang;
            $metaDescriptionField = 'meta_description_' . $lang;
            $metaKeywordsField = 'meta_keywords_' . $lang;

            /** @var $model BaseArticleTableML */
            $model = new $modelClassName;
            $model->article_id = $newItemId;
            $model->catalog_id = $this->catalog_id;
            $model->title = $this->{$titleField};
            $model->text = $this->{$textField};
            $model->lang = $lang;
            $model->publish_at = $publishAt;
            $model->meta_description = $this->{$metaDescriptionField};
            $model->meta_keywords = $this->{$metaKeywordsField};
            $model->image = $this->image;
            $model->save();
        }

        if ( static::USE_TAGS )
        {
            $this->addTags( $newItemId, $this->tags );
        }

        if ( static::USE_IMAGE )
        {
            $this->saveImage();
        }
    }

    /** Update old records or create new ones if they are missing */
    protected function updateRecords()
    {
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();

        if ( $this->article_id === NULL )
        {
            throw new CException( 'attribute article_id is not set' );
        }

        // updates all catalog records with the same catalog_id
        foreach( $this->getLanguages() as $lang )
        {
            $titleField = 'title_' . $lang;
            $textField = 'text_' . $lang;
            $metaDescriptionField = 'meta_description_' . $lang;
            $metaKeywordsField = 'meta_keywords_' . $lang;

            /** @var $model BaseArticleTableML */
            $model = $modelClassName::model()->findByAttributes(
                array(
                    'article_id' => $this->article_id,
                    'lang' => $lang
                )
            );

            if ( $model )
            {
                $model->catalog_id = $this->catalog_id;
                $model->title = $this->{$titleField};
                $model->text = $this->{$textField};
                $model->meta_description = $this->{$metaDescriptionField};
                $model->meta_keywords = $this->{$metaKeywordsField};
                $model->publish_at = empty( $this->publish_at ) ? 0 : strtotime( $this->publish_at );
                $model->save();
                $model->image = $this->image;
            }
            else
            {
                // if record not found ( for example to project add more languages) - create new one
                /** @var $model BaseCatalogArticleTableML */
                $model = new $modelClassName;
                $model->article_id = $this->article_id;
                $model->catalog_id = $this->catalog_id;
                $model->title = $this->{$titleField};
                $model->text = $this->{$textField};
                $model->lang = $lang;
                $model->publish_at = empty( $this->publish_at ) ? 0 : strtotime( $this->publish_at );
                $model->meta_description = $this->{$metaDescriptionField};
                $model->meta_keywords = $this->{$metaKeywordsField};
                $model->image = $this->image;
                $model->save();
            }
        }

        if ( static::USE_TAGS )
        {
            $this->updateTags();
        }

        if ( static::USE_IMAGE )
        {
            $this->saveImage();
        }
    }

    /**
     * Loads data into model
     * @param $itemId integer item id
     * @throws CException
     */
    public function loadData( $itemId )
    {
        if ( (int)$itemId <= 0 ) {
            throw new CException( 'Invalid article id!' );
        }
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();

        $this->_isNewRecord = FALSE;
        $this->article_id = $itemId;

        foreach( $this->getLanguages() as $lang ) {
            /** @var $model BaseArticleTableML */
            $model = $modelClassName::model()->findByAttributes(
                array(
                    'article_id' => $this->article_id,
                    'lang' => $lang
                )
            );

            $titleField = 'title_' . $lang;
            $textField = 'text_' . $lang;
            $metaDescriptionField = 'meta_description_' . $lang;
            $metaKeywordsField = 'meta_keywords_' . $lang;

            if ( $model ) {
                $this->{$titleField} = $model->getTitle();
                $this->{$textField} = $model->getText();
                $this->{$metaDescriptionField} = $model->getMetaDescription();
                $this->{$metaKeywordsField} = $model->getMetaKeyWords();
                $this->publish_at = $model->getPublishAt();
                $this->catalog_id = $model->catalog_id;

                if ( static::USE_IMAGE )
                {
                    $this->image = $model->image;
                }
            } else {
                $this->{$titleField} = NULL;
                $this->{$textField} = NULL;
                $this->{$metaDescriptionField} = NULL;
                $this->{$metaKeywordsField} = NULL;
                $this->publish_at = NULL;
            }
        }

        // if keywords for article is enabled - allow operations with them
        if ( static::USE_TAGS )
        {
            /** @var $tagsModelClass CActiveRecord */
            $tagsModelClass = static::RELATION_MODEL_CLASS;
            $tags = $tagsModelClass::model()->findAllByAttributes( array( 'article_id' => $itemId ) );

            if ( $tags )
            {
                foreach( $tags as $tag )
                {
                    $this->tags[] = $tag->tag_id;
                }
            }

            $this->initialTags = $this->tags;
        }
    }

    /**
     * @param int $newItemId
     * @param int[] $tags
     */
    protected function addTags( $articleId, $tags )
    {
        if ( !empty( $this->tags ) )
        {
            /** @var $tagsModelClass CActiveRecord */
            $tagsModelClass = static::RELATION_MODEL_CLASS;
            foreach( $tags as $tagId )
            {
                $model = new $tagsModelClass;
                $model->tag_id = $tagId;
                $model->article_id = $articleId;
                $model->save( FALSE );
            }
        }
    }

    /**
     *
     */
    protected function updateTags()
    {
        if ( !empty( $this->tags ) )
        {
            // add new tags
            $tagToAdd = array_diff( $this->tags, $this->initialTags );

            if ( !empty( $tagToAdd ) )
            {
                $this->addTags( $this->article_id, $tagToAdd );
            }

            // remove old
            $tagsToDelete = array_diff( $this->initialTags, $this->tags );

            if ( !empty( $tagsToDelete ) )
            {
                $this->removeTags( $this->article_id, $tagsToDelete );
            }
        }
        else
        {
            if ( !empty( $this->initialTags ) )
            {
                $this->deleteAllTags();
            }
        }
    }

    /**
     * Delete all tags for current article
     */
    protected function deleteAllTags()
    {
        $query = 'DELETE FROM '
            . static::RELATION_TABLE_NAME
            . ' WHERE '
            . static::ARTICLE_PRIMARY_KEY_IN_RELATION
            . ' = :articleId';

        Yii::app()
            ->db
            ->createCommand( $query )
            ->bindValue( ':articleId', $this->article_id, PDO::PARAM_INT )
            ->execute();
    }

    /**
     * @param int $articleId
     * @param array $newTags
     */
    protected function removeTags( $articleId, &$oldTags )
    {
        $sql = 'DELETE FROM '
            . static::RELATION_TABLE_NAME
            . ' WHERE '
            . static::ARTICLE_PRIMARY_KEY_IN_RELATION
            . ' = :articleId AND '
            . static::TAG_PRIMARY_KEY_IN_RELATION
            . ' = :tagId';

        $command = Yii::app()->db->createCommand( $sql );

        foreach( $oldTags as $tagId )
        {
            $command->bindParam(
                ':articleId',
                $articleId,
                PDO::PARAM_INT
            );

            $command->bindParam(
                ':tagId',
                $tagId,
                PDO::PARAM_INT
            );

            $command->execute();
        }
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


    abstract public function getCatalogOptions();
}