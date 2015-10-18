<?php
/**
 * @author: Andriy Tolstokorov
 *
 *
 * This base class for form that represents multilingual catalog form
 */

class BaseCatalogFormML extends AbstractMultilingualForm
{
    const FORM_ID = 'base-catalog-form';

    // NOTE: add or remove necessary fields depending on count of languages
    public $value_en;
    public $value_uk;
    public $value_ru;
    public $catalog_id = NULL;
    public $parent_id = NULL;

    protected $_catalogModelClassName = NULL;
    protected $_isNewRecord = TRUE;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // all catalog values  are required
            array( 'value_en', 'required' ),
            array( 'value_uk', 'required' ),
            array( 'value_ru', 'required' ),
            array( 'value_en, value_uk, value_ru', 'length','max' => 255 )
        );
    }

    /** Create new records depending on fieldsMap and class properties */
    protected function createNewRecords()
    {
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();
        $newItemId = $modelClassName::getLastId() + 1;
        // create set of catalog records with the same catalog_id
        foreach( $this->getLanguages() as $lang ) {
            $valueField = 'value_' . $lang;

            /** @var $model BaseCatalogTableML */
            $model = new $modelClassName;
            $model->catalog_id = $newItemId;
            $model->parent_id = $this->parent_id;
            $model->value = $this->{$valueField};
            $model->lang = $lang;
            $model->save();
        }
    }

    /** Update old records or create new ones if they are missing */
    protected function updateRecords()
    {
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();

        if ( $this->catalog_id === NULL ) {
            throw new CException( 'attribute catalog_id is not set' );
        }

        // updates all catalog records with the same catalog_id
        foreach( $this->getLanguages() as  $lang ) {
            $valueField = 'value_' . $lang;

            /** @var $model BaseCatalogTableML */
            $model = $modelClassName::model()->findByAttributes(
                array(
                    'catalog_id' => $this->catalog_id,
                    'lang' => $lang
                )
            );

            if ( $model ) {
                $model->value = $this->{$valueField};
                $model->save();
            } else { // if record not found ( for example to project add more languages) - create new one
                $model = new $modelClassName();
                $model->catalog_id = $this->catalog_id;
                $model->parent_id = $this->parent_id;
                $model->value = $this->{$valueField};
                $model->lang = $lang;
                $model->save();
            }

        }
    }

    /**
     * Loads data into model
     * @param $categoryId integer catalog id
     * @throws CException
     */
    public function loadData( $categoryId )
    {
        if ( (int)$categoryId <= 0 ) {
            throw new CException( 'Invalid catalog id!' );
        }
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();

        $this->_isNewRecord = FALSE;
        $this->catalog_id = $categoryId;

        foreach( $this->getLanguages() as $lang ) {
            /** @var $model BaseCatalogTableML */
            $model = $modelClassName::model()->findByAttributes(
                array(
                    'catalog_id' => $this->catalog_id,
                    'lang' => $lang
                )
            );
            $valueField = 'value_' . $lang;
            if ( $model ) {
                $this->{$valueField} = $model->getValue();
            } else {
                $this->{$valueField} = NULL;
            }
        }
    }
}