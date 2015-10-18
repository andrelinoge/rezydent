<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */


class ListAction extends Action
{
    public $view = 'list';
    public $partialView = '_list';
    public $model = NULL;
    public $listHeaders = NULL;
    public $listFilters = NULL;
    public $primaryField = NULL;
    public $widgetWrapperId = 'widget-wrapper-id';
    public $widgetFormId = 'widget-form-id';
    public $groupingCheckboxName = 'ids';
    public $pageTitle = 'Page title';
    public $listTitle = 'List title';
    public $rowCellsGetterMethod = 'getRowValues';
    public $dataProviderGetterMethod = 'backendSearch';

    public $actionCreateUrl = '';
    public $actionEditUrl = '';
    public $actionDeleteUrl = '';
    public $actionGroupEditUrl = '';
    public $actionGroupDeleteUrl = '';

    public $actionCreate = '';
    public $actionEdit = '';
    public $actionDelete = '';
    public $actionGroupEdit = '';
    public $actionGroupDelete = '';

    public function run()
    {
        // check if all necessary properties are set
        $this->checkConditions(
            array( 'model', 'listHeaders', 'primaryField' )
        );

        $modelClass = get_class( $this->model );

        $actionCreateUrl = $this->getProperUrl( $this->actionCreateUrl, $this->actionCreate );
        $actionEditUrl = $this->getProperUrl( $this->actionEditUrl, $this->actionEdit );
        $actionDeleteUrl = $this->getProperUrl( $this->actionDeleteUrl, $this->actionDelete );
        $actionGroupEditUrl = $this->getProperUrl( $this->actionGroupEditUrl, $this->actionGroupEdit );
        $actionGroupDeleteUrl = $this->getProperUrl( $this->actionGroupDeleteUrl, $this->actionGroupDelete );

        if ( isAjax() )
        {

            if( isset( $_GET[ $modelClass ] ) )
            {
                $this->model->attributes = $_GET[ $modelClass ];
            }

            $this->getController()->renderPartial(
                $this->partialView,
                array(
                    'model' => $this->model,
                    'listHeaders' => $this->listHeaders,
                    'listFilters' => $this->listFilters,
                    'primaryField' => $this->primaryField,
                    'widgetWrapperId' => $this->widgetWrapperId, // this will be id of block and part of form id
                    'widgetFormId'  => $this->widgetFormId, // to access checkboxes via form id
                    'groupingCheckboxName'  => $this->groupingCheckboxName,
                    'skipScripts'   => TRUE,
                    'rowCellsGetterMethod' => $this->rowCellsGetterMethod,
                    'dataProviderGetterMethod' => $this->dataProviderGetterMethod,

                    'actionCreateUrl'  => $actionCreateUrl,
                    'actionEditUrl' => $actionEditUrl,
                    'actionDeleteUrl' => $actionDeleteUrl,
                    'actionGroupEditUrl' => $actionGroupEditUrl,
                    'actionGroupDeleteUrl' => $actionGroupDeleteUrl,

                    'actionCreate'  => $this->actionCreate,
                    'actionEdit' => $this->actionEdit,
                    'actionDelete' => $this->actionDelete,
                    'actionGroupEdit' => $this->actionGroupEdit,
                    'actionGroupDelete' => $this->actionGroupDelete
                )
            );
        }
        else
        {
            $this->getController()->render(
                $this->view,
                array(
                    'partialView' => $this->partialView,
                    'model' => $this->model,
                    'listHeaders' => $this->listHeaders,
                    'listFilters' => $this->listFilters,
                    'primaryField' => $this->primaryField,
                    'pageTitle' => $this->pageTitle,
                    'listTitle' => $this->listTitle,
                    'widgetWrapperId' => $this->widgetWrapperId, // this will be id of block and part of form id
                    'widgetFormId'  => $this->widgetFormId, // to access checkboxes via form id
                    'groupingCheckboxName'  => $this->groupingCheckboxName,
                    'skipScripts'   => FALSE,
                    'rowCellsGetterMethod' => $this->rowCellsGetterMethod,
                    'dataProviderGetterMethod' => $this->dataProviderGetterMethod,

                    'actionCreateUrl'  => $actionCreateUrl,
                    'actionEditUrl' => $actionEditUrl,
                    'actionDeleteUrl' => $actionDeleteUrl,
                    'actionGroupEditUrl' => $actionGroupEditUrl,
                    'actionGroupDeleteUrl' => $actionGroupDeleteUrl,

                    'actionCreate'  => $this->actionCreate,
                    'actionEdit' => $this->actionEdit,
                    'actionDelete' => $this->actionDelete,
                    'actionGroupEdit' => $this->actionGroupEdit,
                    'actionGroupDelete' => $this->actionGroupDelete
                )
            );
        }
    }

    public function runMonolingual()
    {
        /*
         * just to satisfy abstract parent class
         */
    }

    public function runMultilingual()
    {
        /*
         * just to satisfy abstract parent class
         */
    }

    protected function getProperUrl( $url, $action )
    {
        if ( !empty( $url ) )
        {
            return $url;
        }
        else
        {
            if ( !empty( $action ) )
            {
                return $this->getController()->createUrl( $action );
            }
            else
            {
                return '#';
            }
        }
    }
}