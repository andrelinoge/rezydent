<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class PartialUpdateAction extends Action
{
    /** @var string */
    public $formModelClass = '';
    /** @var string */
    public $tableModelClass = '';
    /** @var string */
    public $nonAjaxRedirectUrl = '';
    /** @var string */
    public $updateRecordId = NULL;

    public function runMonolingual()
    {
        // check if action is configured
        $this->checkConditions(
            array(
                'updateRecordId', 'tableModelClass', 'nonAjaxRedirectUrl'
            )
        );

        /** @var $tableModel BaseTable */
        $tableModel = new $this->tableModelClass;
        /** @var $model BaseTable */
        $model = $tableModel->findByPk( $this->updateRecordId );

        $this->getController()->setModel( $model );
        $this->getController()->processUpdate();

        if ( !isAjax() )
        {
            $this->redirect( $this->nonAjaxRedirectUrl );
        }
    }

    public function runMultilingual()
    {
        // check if action is configured
        $this->checkConditions(
            array(
                'updateRecordId', 'formModelClass', 'tableModelClass',
                'nonAjaxRedirectUrl'
            )
        );

        $model = $this->getController()->createModel( $this->formModelClass );
        $model->setTableModelClassName( $this->tableModelClass );
        // load data to model via model method
        $model->loadData( $this->updateRecordId );

        $this->getController()->setModel( $model );
        $this->getController()->processUpdate();

        if ( !isAjax() )
        {
            $this->redirect( $this->nonAjaxRedirectUrl );
        }
    }

}