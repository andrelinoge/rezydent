<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 * This base class for form that represents multilingual static page
 */

class BaseStaticPageFormML extends AbstractMultilingualForm
{
    const FORM_ID = 'base-static-page-form';

    // NOTE: add or remove necessary fields depending on available languages
    public $title_en;
    public $text_en;

    public $title_uk;
    public $text_uk;

    public $title_ru;
    public $text_ru;

    public $meta_keywords_uk;
    public $meta_description_uk;

    public $meta_keywords_en;
    public $meta_description_en;

    public $meta_keywords_ru;
    public $meta_description_ru;

    public $page_id = NULL;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // en
            array( 'title_en', 'safe' ),
            array( 'text_en', 'required' ),
            array( 'meta_keywords_en', 'safe' ),
            array( 'meta_description_en', 'safe' ),
            // uk
            array( 'title_uk', 'safe' ),
            array( 'text_uk', 'required' ),
            array( 'meta_keywords_uk', 'safe' ),
            array( 'meta_description_uk', 'safe' ),
            // ru
            array( 'title_ru', 'safe' ),
            array( 'text_ru', 'required' ),
            array( 'meta_keywords_ru', 'safe' ),
            array( 'meta_description_ru', 'safe' ),

            array(
                'title_uk, title_en, title_ru',
                'length',
                'max' => 255
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'title_en' => _( 'Title' ),
            'text_en' => _( 'Text' ),
            'meta_keywords_en' => _( 'Keywords for meta tag' ),
            'meta_description_en' => _( 'Description for meta tag' ),
            // uk
            'title_uk' => _( 'Title' ),
            'text_uk' => _( 'Text' ),
            'meta_keywords_uk' => _( 'Keywords for meta tag' ),
            'meta_description_uk' => _( 'Description for meta tag' ),
            // ru
            'title_ru' => _( 'Title' ),
            'text_ru' => _( 'Text' ),
            'meta_keywords_ru' => _( 'Keywords for meta tag' ),
            'meta_description_ru' => _( 'Description for meta tag' )
        );
    }

    /** Create new records depending on available languages and class properties */
    protected function createNewRecords()
    {
        // Count of static pages should be fixed
        throw new CException( 'Count of static pages should be fixed' );
    }

    /** Update old records or create new ones if they are missing */
    protected function updateRecords()
    {
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();

        if ( $this->page_id === NULL ) {
            throw new CException( 'attribute page_id is not set' );
        }

        // updates all catalog records with the same catalog_id
        foreach( $this->getLanguages() as $lang ) {
            $titleField = 'title_' . $lang;
            $textField = 'text_' . $lang;
            $metaDescriptionField = 'meta_description_' . $lang;
            $metaKeywordsField = 'meta_keywords_' . $lang;

            /** @var $model BaseArticleTableML */
            $model = $modelClassName::model()->findByAttributes(
                array(
                    'page_id' => $this->page_id,
                    'lang' => $lang
                )
            );

            if ( $model ) {
                $model->title = $this->{$titleField};
                $model->text = $this->{$textField};
                $model->meta_description = $this->{$metaDescriptionField};
                $model->meta_keywords = $this->{$metaKeywordsField};
                $model->save( FALSE );
            } else { // if record not found ( for example to project add more languages) - create new one
                /** @var $model BaseStaticPageTableML */
                $model = new $modelClassName;
                $model->page_id = $this->page_id;
                $model->title = $this->{$titleField};
                $model->text = $this->{$textField};
                $model->lang = $lang;
                $model->meta_description = $this->{$metaDescriptionField};
                $model->meta_keywords = $this->{$metaKeywordsField};
                $model->save( FALSE );
            }

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
            throw new CException( 'Invalid page id!' );
        }
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();

        $this->_isNewRecord = FALSE;
        $this->page_id = $itemId;

        foreach( $this->getLanguages() as $lang ) {
            /** @var $model BaseStaticPageTableML */
            $model = $modelClassName::model()->findByAttributes(
                array(
                    'page_id' => $this->page_id,
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
            } else {
                $this->{$titleField} = NULL;
                $this->{$textField} = NULL;
                $this->{$metaDescriptionField} = NULL;
                $this->{$metaKeywordsField} = NULL;
            }
        }
    }
}