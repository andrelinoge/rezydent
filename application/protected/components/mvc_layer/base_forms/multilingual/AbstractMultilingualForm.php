<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

abstract class AbstractMultilingualForm extends CFormModel
{
    protected $_tableModelClassName = NULL;
    protected $_isNewRecord = TRUE;

    /** array with available languages */
    public function getLanguages( $withDescription = FALSE )
    {
        if ( $withDescription )
        {
            return Yii::app()->params->availableLocalesWithDescription;
        }
        else
        {
            return Yii::app()->params->availableLocalesInShortForm;
        }
    }


    /**
     * @param $name string class name for work model
     */
    public function setTableModelClassName( $name )
    {
        if ( !is_string( $name ) || ( strlen( $name ) == 0 ) ) {
            throw new CException( 'Wrong class name of model!' );
        }
        $this->_tableModelClassName = $name;
    }

    /**
     * Returns class name for work model
     * @return null
     * @throws CException
     */
    public function getTableModelClassName()
    {
        if ( $this->_tableModelClassName === NULL ) {
            throw new CException( 'Class name for model is required' );
        } else {
            return $this->_tableModelClassName;
        }
    }

    /** Create new records or update old records */
    public function save()
    {
        if ( $this->_isNewRecord ) {
            $this->createNewRecords();
        } else {
            $this->updateRecords();
        }
    }

    /** Create new records depending on available languages and class properties */
    abstract protected function createNewRecords();

    /** Update old records or create new ones if they are missing */
    abstract protected function updateRecords();

    /**
     * Loads data into model
     * @param $itemId integer item id
     * @throws CException
     */
    abstract public function loadData( $itemId );

}