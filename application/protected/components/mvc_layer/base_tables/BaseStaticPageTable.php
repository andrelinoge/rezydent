<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 *
 * This is the base model class for monolingual static pages
 *
 * The followings are the available columns in any table, that represents static page:
 * @property integer $id
 * @property integer $page_id
 * @property string $text
 * @property string $meta_keywords
 * @property string $meta_description
 */

class BaseStaticPageTable extends BaseTable
{
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array( 'id, page_id, title, text', 'safe' ),
            //array( 'text', 'required' ),
            array(
                'page_id,',
                'numerical',
                'integerOnly' => TRUE
            ),

            array( 'meta_keywords, meta_description', 'safe'),

            array(
                'id, page_id, text, meta_keywords, meta_description, title',
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
            'title' => 'Заголовок торінки',
            'text' => 'Текст',
            'meta_keywords' => 'Ключові слова для мета тегів',
            'meta_description' => 'Опис для мета тегів'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('text',$this->text,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * @return string retrieves title
     */
    public function getTitle()
    {
        if ( strlen( $this->title ) > 0 ) {
            return $this->title;
        } else {
            return '';
        }

    }

    /**
     * @return string retrieves text
     */
    public function getText()
    {
        return $this->text;
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

    public function byPageId( $pageId )
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'page_id = :pageId',
                'params'=> array(
                    ':pageId' => $pageId
                ),
            )
        );

        return $this;
    }

}