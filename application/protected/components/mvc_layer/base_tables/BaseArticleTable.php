<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0

 * This is the base model class for article
 *
 * The followings are the available columns in any article table:
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $key_words
 * @property integer $created_at
 * @property integer $edited_at
 * @property integer $author_id
 * @property integer $editor_id
 * @property integer $publish_at
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $image
 */

class BaseArticleTable extends BaseTable
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

    protected $initialImage = NULL;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array( 'title, text', 'required' ),
            array( 'title', 'length', 'max'=>255 ),
            array(
                'created_at, edited_at, publish_at, author_id, editor_id',
                'numerical',
                'integerOnly' => TRUE
            ),

            array( 'meta_keywords, meta_description, tags, image', 'safe'),

            array(
                'id, title, text, created_at, edited_at, publish_at, author_id, editor_id,
                 meta_keywords, meta_description, tags',
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
            'text' => _( 'Text' ),
            'title' => _( 'Title' ),
            'meta_keywords' => _( 'Key words' ),
            'meta_description' => _( 'Description' ),
            'tags' => _( 'Key words' )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('author_id',$this->author_id);
        $criteria->compare('editor_id',$this->editor_id);
        $criteria->compare('crated_at',$this->crated_at,true);
        $criteria->compare('edited_at',$this->edited_at,true);
        $criteria->compare('publish_at',$this->publich_at,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function beforeValidate()
    {
        if ( !empty( $this->created_at ) )
        {
            if ( !is_numeric( $this->created_at ) )
            {
                $this->created_at = strtotime( $this->created_at );
            }
        }

        return parent::beforeValidate();
    }

    /**
     * @return bool|void
     */
    public function beforeSave()
    {
        if ( $this->isNewRecord ) {
            if ( empty( $this->created_at ) )
            {
                $this->created_at = time();
                if ( !Yii::app()->user->isGuest ) {
                    $this->author_id = Yii::app()->user->id;
                }
            }
        } else {
            $this->edited_at = time();
            if ( !Yii::app()->user->isGuest ) {
                $this->editor_id = Yii::app()->user->id;
            }
        }

        return parent::beforeSave();
    }

    /**
     * return value as URL param
     * @return string
     */
    public function getTitleAsUrlParam( $toTranslit = FALSE )
    {
        return $this->prepareForUrl( $this->title, $toTranslit );
    }

    //              Static

    /**
     * Retrieves a list of titles as $article_id => $title array
     * @static
     * @return array
     */
    public static function getTitles( )
    {
        // get array with data. Through DAO this will be a bit of quicker.
        $query = 'SELECT id, title FROM ' . static::tableName();
        $records = Yii::app()
            ->db
            ->createCommand( $query )
            ->queryAll();

        // prepare result array
        $data = array();
        foreach( $records as $record ) {
            $data[ $record[ 'id' ] ] = $record[ 'title' ];
        }

        return $data;
    }

    /**
     * @return string retrieves text
     */
    public function getText( $limit = NULL, $useThreeDots = FALSE )
    {
        if ( !$limit )
        {
            return $this->text;
        }
        else
        {
            $text = str_replace( "\t", '', $this->text );

            $text = trim( strip_tags( $text ) );

            if ( mb_strlen( $text, 'utf-8' ) <= $limit )
            {
                return $text;
            }
            else
            {
                return ( $useThreeDots) ?
                    mb_substr( $text, 0, $limit, 'UTF-8' ) . '...' :
                    mb_substr( $text, 0, $limit, 'UTF-8' );
            }
        }
    }

    /**
     * @return string retrieves title
     */
    public function getTitle( $limit = NULL, $useThreeDots = FALSE )
    {
        if ( !$limit )
        {
            return $this->title;
        }
        else
        {
            if ( mb_strlen( $this->title, 'utf-8' ) <= $limit )
            {
                return $this->title;
            }
            else
            {
                return ( $useThreeDots) ?
                    strip_tags( mb_substr( $this->title, 0, $limit, 'UTF-8' ) ) . '...' :
                    strip_tags( mb_substr( $this->title, 0, $limit, 'UTF-8' ) );
            }
        }
    }

    /**
     * @return string retrieves keywords for META tag
     */
    public function getMetaKeyWords()
    {
        return $this->meta_keywords;
    }

    /**
     * @return string retrieves description for META tag
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * @param null|string $format rule for convertation from the timestamp to string
     * @param null|string $textOnNull if field is empty - return hind ( default is "-")
     * @param null|string $format if this param set in FALSE and value is empty - return NULL
     * @return string retrieves formatted date of creation
     */
    public function getCreatedAt( $format = NULL, $textOnNull = '-', $ifNullReturnDefText = TRUE )
    {
        if ( !$format ) {
            $format = 'd-m-Y';
        }

        if ( $this->created_at > 0 )
        {
            return date( $format, $this->created_at );
        }
        else
        {
            if ( $ifNullReturnDefText )
            {
                if ( $textOnNull )
                {
                    return $textOnNull;
                }
            }
            else
            {
                return NULL;
            }

        }
    }

    /**
     * @param null|string $format
     * @return string retrieves formatted date of editing
     */
    public function getEditedAt( $format = NULL )
    {
        if ( !$format ) {
            $format = 'd-m-Y';
        }

        if ( $this->edited_at > 0 ) {
            return date( $format, $this->edited_at );
        } else {
            return _( 'not edited' );
        }
    }

    /**
     * @param null|string $format
     * @return string retrieves formatted date of publishing
     */
    public function getPublishAt( $format = NULL )
    {
        if ( !$format ) {
            $format = 'd-m-Y';
        }

        if ( $this->publish_at > 0 ) {
            return date( $format, $this->publish_at );
        } else {
            return _( 'publish date not set' );
        }
    }

    /**
     * return author
     * @return string
     */
    public function getAuthor()
    {
        if ( $this->author_id > 0 )
        {
            return $this->author_id;
        }
        else
        {
            return _( 'Admin' );
        }
    }

    /**
     * return editor
     * @return string
     */
    public function getEditor()
    {
        if ( $this->editor_id > 0 )
        {
            return $this->editor_id;
        }
        else
        {
            return _( 'Admin' );
        }
    }

    /**
     * Return list of tags as one string
     * @param $delimiter
     * @param string $textOnEmpty
     * @return string
     */
    public function getTagsList( $delimiter, $textOnEmpty = '-' )
    {
        if ( !empty( $this->tags ) )
        {
            $result = array();
            foreach( $this->tags as $tag )
            {
                $result[] = $tag->getValue();
            }

            return implode( $delimiter, $result );
        }
        else
        {
            return $textOnEmpty;
        }
    }

    /**
     * Get list of inner pages for current model as array "title" => "url"
     * @param $controllerName string controller name
     * @param $actionName  string action name, that will operate with article
     * @return array
     */
    public static function getInnerLinks( $controllerName, $actionName, $params = array() )
    {
        $result = array();
        /** @var $models BaseArticleTable[] */
        $models = static::model()->findAll();
        $actionFullName = $controllerName . '/' . $actionName;
        $fullParams = array();
        /** @var $model ElectricBoilers */
        foreach( $models as $model )
        {
            $fullParams = array(
                'key'   => $model->getTitleAsUrlParam( TRUE ),
                'id'    => $model->id
            ) + $params;

            $url = Yii::app()
                ->controller
                ->createAbsoluteUrl(
                $actionFullName,
                $fullParams
            );

            $url = str_replace( '/backend.php/', '/', $url );
            $result[ $model->getTitle() ] = $url;
        }

        return $result;
    }

    public function afterSave()
    {
        if ( static::USE_TAGS )
        {
            $this->saveTags();
        }

        if ( static::USE_IMAGE )
        {
            $this->saveImage();
        }
    }

    /**
     * Save tags for article
     */
    protected function saveTags()
    {
        $this->checkConstants();
        $articleId = $this->id;
        $tags = $this->tags;
        if ( $this->isNewRecord )
        {
            if ( !empty( $tags ) )
            {
                $this->addTags( $articleId, $tags );
            }
        }
        else
        {
            if ( is_array( $tags ) &&( !empty( $tags ) ) )
            {
                /*
                    we received array with the same or different values of tags -
                    in any case that will be an array  with numbers
                 */
                if ( is_numeric( $tags[0] ) )
                {
                    $this->changeTags( $articleId, $tags );
                }
                /*
                    if $tags was filled with models and user has removed from form all tags
                    we will receive empty array and $tags will be the same as after initialization
                */
                elseif( is_object( $tags[0] ) )
                {
                    $this->deleteAllTags( $articleId );
                }
            }
        }
    }

    /**
     * Check if tags are ready for use with this article model
     * @throws CException
     */
    protected function checkConstants()
    {
        $isSomethingMissing = is_null( static::RELATION_TABLE_NAME )
            || is_null( static::ARTICLE_PRIMARY_KEY_IN_RELATION )
            || is_null( static::TAG_PRIMARY_KEY_IN_RELATION )
            || is_null( static::RELATION_MODEL_CLASS )
            || is_null( static::TAGS_MODEL_CLASS );

        if ( $isSomethingMissing )
        {
            throw new CException( 'To use tags in article, you must override class constants' );
        }
    }

    /**
     * Remove all tags from target article
     * @param int $articleId
     */
    protected function deleteAllTags( $articleId )
    {
        $query = 'DELETE FROM '
            . static::RELATION_TABLE_NAME
            . ' WHERE '
            . static::ARTICLE_PRIMARY_KEY_IN_RELATION
            . ' = :articleId';

        Yii::app()
            ->db
            ->createCommand( $query )
            ->bindValue( ':articleId', $articleId, PDO::PARAM_INT )
            ->execute();
    }

    /**
     * Add/remove tags after article modification (if necessary)
     * @param int $articleId
     * @param array $tags
     */
    protected function changeTags( $articleId, &$tags )
    {
        // get current tags to compare and make changes
        $query = 'SELECT ' . static::TAG_PRIMARY_KEY_IN_RELATION .  ' FROM '
            . static::RELATION_TABLE_NAME
            . ' WHERE '
            . static::ARTICLE_PRIMARY_KEY_IN_RELATION
            . ' = :articleId';

        $currentTags = Yii::app()
            ->db
            ->createCommand( $query )
            ->bindValue( ':articleId', $articleId, PDO::PARAM_INT )
            ->queryColumn();

        $tagToAdd = array_diff( $tags, $currentTags );

        if ( !empty( $tagToAdd ) )
        {
            $this->addTags( $this->id, $tagToAdd );
        }

        $tagsToDelete = array_diff( $currentTags, $tags );

        if ( !empty( $tagsToDelete ) )
        {
            $this->removeTags( $articleId, $tagsToDelete );
        }
    }

    /**
     * @param int $articleId
     * @param array $newTags
     */
    protected function addTags( $articleId, &$newTags )
    {
        $sql = 'INSERT INTO '
            . static::RELATION_TABLE_NAME
            . '('
            . static::ARTICLE_PRIMARY_KEY_IN_RELATION
            . ','
            . static::TAG_PRIMARY_KEY_IN_RELATION
            . ') VALUES(:articleId,:tagId)';

        $command = Yii::app()->db->createCommand( $sql );

        foreach( $newTags as $tagId )
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
        if ( $this->initialImage != $this->image )
        {
            $this->deleteOldImage();

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

            @unlink( $this->getTempFolder( TRUE ) . $this->image );
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

    public function afterFind()
    {
        if ( static::USE_IMAGE )
        {
            $this->initialImage = $this->image;
        }
    }

    protected function deleteOldImage()
    {
        if ( file_exists( $this->getImagesFolder( TRUE ) . $this->initialImage ) )
        {
            @unlink( $this->getImagesFolder( TRUE ) . $this->initialImage );

            if ( !empty( $this->thumbsSettings ) )
            {
                foreach( $this->thumbsSettings as $prefix => $dimension )
                {
                    @unlink( $this->getImagesFolder( TRUE ) . $prefix . $this->initialImage );
                }
            }
        }
    }

    public function afterDelete()
    {
        if ( static::USE_IMAGE )
        {
            if ( file_exists( $this->getImagesFolder( TRUE ) . $this->image ) )
            {
                @unlink( $this->getImagesFolder( TRUE ) . $this->image );

                if ( !empty( $this->thumbsSettings ) )
                {
                    foreach( $this->thumbsSettings as $prefix => $dimension )
                    {
                        @unlink( $this->getImagesFolder( TRUE ) . $prefix . $this->image );
                    }
                }
            }
        }
    }
}