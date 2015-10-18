<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 * Additional layer for action classes
 */

abstract class Action extends CAction
{
    public $isMultilingual = NULL;
    /**
     * Verify all necessary properties were set
     * @throws CException
     */
    protected function checkConditions( $requiredProperties = array() )
    {
        foreach( $requiredProperties as $property ) {

            if ( $this->{$property} === FALSE ||
                 empty( $this->{$property} ) ||
                 $this->{$property} === array() ) {

                throw new CException( $property . ' was not set!');
            }
        }
    }

    public function run()
    {
        if ( $this->isMultilingual === NULL )
        {
            if ( isset( Yii::app()->params[ 'general' ][ 'isMultilingual' ] ) )
            {
                $this->isMultilingual = Yii::app()->params[ 'general' ][ 'isMultilingual' ];
            }
            else
            {
                $this->isMultilingual = FALSE;
            }
        }

        if ( $this->isMultilingual )
        {
            $this->runMultilingual();
        }
        else
        {
            $this->runMonolingual();
        }
    }

    abstract public function runMultilingual();

    abstract public function runMonolingual();
}