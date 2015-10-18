<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class BaseTagsFormML extends AbstractMultilingualForm
{
    const FORM_ID = 'base-tags-form';
    const ATTENDANCE_TABLE_NAME = '';
    const ATTENDANCE_MODEL_CLASS = '';

    // NOTE: add or remove necessary fields depending on count of languages
    public $value_en;
    public $value_uk;
    public $value_ru;
    public $tag_id = NULL;

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
            $model->tag_id = $newItemId;
            $model->value = $this->{$valueField};
            $model->lang = $lang;
            $model->save();
        }

        $attendanceModelClass = static::ATTENDANCE_MODEL_CLASS;

        if ( !empty( $attendanceModelClass ) )
        {
            /** @var $attendance CActiveRecord */
            $attendance = new $attendanceModelClass;
            $attendance->tag_id = $newItemId;
            $attendance->count = 0;
            $attendance->save( FALSE );
        }
    }

    /** Update old records or create new ones if they are missing */
    protected function updateRecords()
    {
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();

        if ( $this->tag_id === NULL ) {
            throw new CException( 'attribute tag_id is not set' );
        }

        // updates all catalog records with the same tag_id
        foreach( $this->getLanguages() as  $lang ) {
            $valueField = 'value_' . $lang;

            /** @var $model BaseCatalogTableML */
            $model = $modelClassName::model()->findByAttributes(
                array(
                    'tag_id' => $this->tag_id,
                    'lang' => $lang
                )
            );

            if ( $model ) {
                $model->value = $this->{$valueField};
                $model->save();
            } else { // if record not found ( for example to project add more languages) - create new one
                $model = new $modelClassName();
                $model->tag_id = $this->tag_id;
                $model->value = $this->{$valueField};
                $model->lang = $lang;
                $model->save();
            }

        }
    }

    /**
     * Loads data into model
     * @param $primaryId integer catalog id
     * @throws CException
     */
    public function loadData( $primaryId )
    {
        if ( (int)$primaryId <= 0 ) {
            throw new CException( 'Invalid catalog id!' );
        }
        /** @var $modelClassName string holds name of model class */
        $modelClassName = $this->getTableModelClassName();

        $this->_isNewRecord = FALSE;
        $this->tag_id = $primaryId;

        foreach( $this->getLanguages() as $lang ) {
            /** @var $model BaseCatalogTableML */
            $model = $modelClassName::model()->findByAttributes(
                array(
                    'tag_id' => $this->tag_id,
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