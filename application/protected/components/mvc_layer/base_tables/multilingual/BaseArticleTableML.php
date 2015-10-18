<?php
/**
 * This is the base model class for multilingual article
 *
 * The followings are the available columns in any article table:
 * @property integer $id
 * @property integer $article_id
 * @property string $lang
 * @property string $title
 * @property string $text
 * @property integer $created_at
 * @property integer $edited_at
 * @property integer $author_id
 * @property integer $editor_id
 * @property integer $publish_at
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $image
 */

 class BaseArticleTableML extends BaseTableML
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
                 'article_id, created_at, edited_at, author_id, editor_id',
                 'numerical',
                 'integerOnly' => TRUE
             ),

             array(
                 'publish_at',
                 'numerical',
                 'allowEmpty' => TRUE
             ),

             array( 'meta_keywords, meta_description, image', 'safe'),

             array(
                 'id, article_id, lang, title, text, created_at, edited_at, publish_at, author_id, editor_id,
                 meta_keywords, meta_description',
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
             'lang' => 'Lang',
             'text' => _('Text'),
             'title' => _('Title'),
             'meta_keywords' => _('Key words'),
             'meta_description' => _('Description')
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
         $criteria->compare('article_id',$this->article_id);
         $criteria->compare('lang',$this->lang);
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

     public function beforeSave()
     {
         if ( $this->isNewRecord ) {
             $this->created_at = time();
             if ( !Yii::app()->user->isGuest ) {
                 $this->author_id = Yii::app()->user->id;
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
     public function getTitleAsUrlParam()
     {
         return $this->prepareForUrl( $this->title );
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
             return ( $useThreeDots) ?
                 strip_tags( mb_substr( $this->text, 0, $limit, 'UTF-8' ) ) . '...' :
                 strip_tags( mb_substr( $this->text, 0, $limit, 'UTF-8' ) );
         }
     }

     /**
      * @return string retrieves title
      */
     public function getTitle()
     {
         return $this->title;
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
         if ( $this->author_id > 0 ) {
             return $this->author_id;
         } else {
             return _( 'No author' );
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
             return _( 'No editor' );
         }
     }

     /**
      * return article id
      * @return int
      */
     public function getArticleId()
     {
         return $this->article_id;
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

     /**
      * Get list of inner pages for current model as array "title" => "url"
      * @param $controllerName string controller name
      * @param $actionName  string action name, that will operate with article
      * @return array
      */
     public static function getInnerLinks( $controllerName, $actionName, $params = array() )
     {
         $result = array();
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

     //      Scopes

     /**
      * @param integer $articleId
      * @return BaseArticleTableML
      */
     public function byArticleId( $articleId )
     {
         $this->getDbCriteria()->mergeWith(
             array(
                 'condition' => 'article_id = :articleId',
                 'params'=> array(
                     ':articleId' => $articleId
                 ),
             )
         );

         return $this;
     }


     //              Static

     /**
      * Retrieves a list of titles as $article_id => $title array
      * @static
      * @return array
      */
     public static function getTitles( $language = NULL )
     {
         if ( !$language ) {
             $language = self::getCurrentLanguage();
         }

         // get array with data. Through DAO this will be a bit of quicker.
         $query = 'SELECT article_id, title FROM ' . static::tableName() . ' where lang = :language';
         $records = Yii::app()
             ->db
             ->createCommand( $query )
             ->bindValue(":lang", $language, PDO::PARAM_STR )
             ->queryAll();

         // prepare result array
         $data = array();
         foreach( $records as $record ) {
             $data[ $record[ 'article_id' ] ] = $record[ 'title' ];
         }

         return $data;
     }

     /**
      * @return int retrieves last article id
      */
     public static function getLastId()
     {
         $query = 'SELECT MAX( article_id ) FROM ' . static::tableName();
         return (int)Yii::app()
             ->db
             ->createCommand( $query )
             ->queryScalar();

     }
 }
