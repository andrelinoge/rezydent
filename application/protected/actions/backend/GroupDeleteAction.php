<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class GroupDeleteAction extends Action
{
    public $redirectUrl = '';
    public $groupingCheckboxName = '';
    public $flashSuccessMessage = '';
    public $flashWarningNoItems = '';
    public $primaryId = NULL;
    public $tableModelClass = NULL;

    public function runMonolingual()
    {
        // check if action is configured
        $this->checkConditions(
            array( 'redirectUrl', 'primaryId', 'tableModelClass', 'groupingCheckboxName' )
        );

        // check if something was selected
        if ( !isset( $_GET[ $this->groupingCheckboxName ] ) )
        { // if not - redirect + flash message
            if ( !empty( $this->flashWarningNoItems ) )
            {
                Yii::app()->user->setFlash( 'warning-message', $this->flashWarningNoItems );
            }
            $this->getController()->redirect( $this->redirectUrl );
        }
        else
        {
            $criteria = new CDbCriteria();
            $criteria->addInCondition( $this->primaryId, $_GET[ $this->groupingCheckboxName ] );

            $this->getController()
                ->createModel( $this->tableModelClass )
                ->deleteAll( $criteria );

            if ( !empty( $this->flashSuccessMessage ) )
            {
                Yii::app()
                    ->user
                    ->setFlash(
                    'success-message',
                    count( $_GET[ $this->groupingCheckboxName ] ) . $this->flashSuccessMessage
                );
            }
            $this->getController()->redirect( $this->redirectUrl );
        }
    }

    public function runMultilingual()
    {
        // check if action is configured
        $this->checkConditions(
            array( 'redirectUrl', 'primaryId', 'tableModelClass', 'groupingCheckboxName' )
        );

        // check if something was selected
        if ( !isset( $_GET[ $this->groupingCheckboxName ] ) ) { // if not - redirect + flash message
            if ( !empty( $this->flashWarningNoItems ) ) {
                Yii::app()->user->setFlash( 'warning-message', $this->flashWarningNoItems );
            }
            $this->getController()->redirect( $this->redirectUrl );
        } else {

            $criteria = new CDbCriteria();
            $criteria->addInCondition( $this->primaryId, $_GET[ $this->groupingCheckboxName ] );

            $this->getController()
                ->createModel( $this->tableModelClass )
                ->deleteAll( $criteria );

            if ( !empty( $this->flashSuccessMessage ) ) {
                Yii::app()
                    ->user
                    ->setFlash(
                        'success-message',
                        count( $_GET[ $this->groupingCheckboxName ] ) . $this->flashSuccessMessage
                );
            }
            $this->getController()->redirect( $this->redirectUrl );
        }
    }
}