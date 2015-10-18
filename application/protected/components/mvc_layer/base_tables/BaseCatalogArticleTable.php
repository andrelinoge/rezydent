<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

abstract class BaseCatalogArticleTable extends BaseArticleTable
{

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        return array(
            array( 'title, text, catalog_id', 'required' ),
            array( 'title', 'length', 'max'=>255 ),
            array(
                'id, created_at, edited_at, publish_at, author_id, editor_id, catalog_id',
                'numerical',
                'integerOnly' => TRUE
            ),

            array( 'id, meta_keywords, meta_description, tags, image', 'safe'),

            array(
                'id, title, text, created_at, edited_at, publish_at, author_id, editor_id,
                 meta_keywords, meta_description, catalog_id, image',
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
            'catalog_id' => 'Тип',
            'text' => 'Текст',
            'title' => 'Заголовок',
            'meta_keywords' => 'Ключові слова для мета тегів',
            'meta_description' => 'Мета опис',
            'publish_at' => 'Опублікувати',
            'created_at' => 'Створено'
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
        $criteria->compare( 'catalog_id',   $this->catalog_id        );
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

    abstract public function getCatalogOptions();

}