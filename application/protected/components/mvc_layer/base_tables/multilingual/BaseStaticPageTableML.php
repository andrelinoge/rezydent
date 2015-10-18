<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 *
 * This is the base model class for multilingual static pages
 *
 * The followings are the available columns in any table, that represents static page:
 * @property integer $id
 * @property integer $page_id
 * @property string $lang
 * @property string $text
 * @property string $meta_keywords
 * @property string $meta_description
 */

class BaseStaticPageTableML extends BaseTableML
{
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array( 'title', 'safe' ),
            array( 'text', 'required' ),
            array(
                'page_id,',
                'numerical',
                'integerOnly' => TRUE
            ),

            array( 'meta_keywords, meta_description', 'safe'),

            array(
                'id, page_id, lang, text, meta_keywords, meta_description, title',
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
            'title' => 'Page title',
            'text' => 'Text',
            'meta_keywords' => 'Key words',
            'meta_description' => 'Description'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
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
            return _( 'Page without title');
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