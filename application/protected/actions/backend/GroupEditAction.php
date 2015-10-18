<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */
class GroupEditAction extends Action
{
    /** @var string */
    public $groupingCheckboxName = '';
    /** @var string */
    public $redirectUrl = '';
    /** @var string */
    public $formModelClass = NULL;
    /** @var string */
    public $tableModelClass = NULL;
    /** @var string */
    public $pageTitle = 'Edit group of records';
    /** @var string */
    public $view = 'group-edit';
    /** @var string */
    public $partialEditView = 'add-edit';
    /** @var string */
    public $formView = '_form';
    /** @var array Array of inner links for monolingual sites */
    public $innerLinks = array();

    public function runMonolingual()
    {
        // check if action is configured
        $this->checkConditions(
            array( 'tableModelClass', 'view', 'formView' )
        );

        // check if something was selected
        if ( !isset( $_GET[ $this->groupingCheckboxName ] ) )
        { // if not - redirect + flash message
            Yii::app()->user->setFlash( 'warning-message', 'No items selected!');
            $this->redirect( $this->createUrl( 'index' ) );
        }
        else
        {
            $models = array();
            /** @var $tableModel BaseTable */
            $tableModel = new $this->tableModelClass;
            foreach ( $_GET[ $this->groupingCheckboxName ] as $id )
            {
                $models[ $id ] = $tableModel->findByPk( $id );
            }

            $this->getController()->render(
                $this->view,
                array(
                    'models' => $models,
                    'pageTitle' => $this->pageTitle,
                    'partialEditView' => $this->partialEditView,
                    'formView' => $this->formView,
                    'innerLinks' => $this->innerLinks
                )
            );
        }
    }

    public function runMultilingual()
    {
        // check if action is configured
        $this->checkConditions(
            array( 'formModelClass', 'tableModelClass', 'view', 'formView' )
        );

        // check if something was selected
        if ( !isset( $_GET[ $this->groupingCheckboxName ] ) )
        { // if not - redirect + flash message
            Yii::app()->user->setFlash( 'warning-message', 'No items selected!');
            $this->redirect( $this->createUrl( 'index' ) );
        }
        else
        {
            $models = array();

            foreach ( $_GET[ $this->groupingCheckboxName ] as $id )
            {
                /** @var $model BaseMultilingualForm */
                $model = $this->getController()->createModel( $this->formModelClass );
                $model->setTableModelClassName( $this->tableModelClass );
                // load data to model via model method (for multilingual purpose)
                $model->loadData( $id );
                $models[$id] = $model;
            }

            $this->getController()->render(
                $this->view,
                array(
                    'models' => $models,
                    'pageTitle' => $this->pageTitle,
                    'partialEditView' => $this->partialEditView,
                    'formView' => $this->formView
                )
            );
        }
    }
}