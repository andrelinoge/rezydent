<?php
/**
 * User: andrelinoge
 * Date: 12/4/12
 */

class ListGrid extends CWidget
{
    /** @var $model ActiveRecord */
    public $model;

    /** @var string */
    public $dataProviderGetterMethod;

    /** @var string name of model method, that retrieves array with */
    public $rowCellsGetterMethod;

    /** @var string field name with primary key. Default "id" */
    public $primary = 'id';

    /** @var string route for list action*/
    public $ajaxUpdateAction = 'index';

    /** @var bool if TRUE show create btn */
    public $enableCreating = TRUE;

    /** @var bool if TRUE show edit btn */
    public $enableEditing = TRUE;

    /** @var bool if TRUE show delete btn */
    public $enableDeleting = TRUE;

    /** @var string route for edit action*/
    public $actionEdit = 'edit';

    /** @var bool|string pre generated url for edit action*/
    public $actionEditUrl = FALSE;

    /** @var string route for delete action*/
    public $actionDelete = 'delete';

    /** @var bool|string pre generated url for delete action */
    public $actionDeleteUrl = FALSE;

    /** @var string route for creating new item action */
    public $actionCreate = 'add';

    /** @var bool|string pre generated url for create action */
    public $actionCreateUrl = FALSE;

    /** @var bool If TRUE - send AJAX request for items delete  */
    public $useAjaxDelete   = TRUE;

    /** @var string message for delete confirmation */
    public $deleteConfirmMessage = 'Are you sure, you want to delete this item?';

    /** @var string name of view file. Default "default" */
    public $viewFile = 'default';

    /** @var string name of view file. Default "list-grid" */
    public $viewFolder = 'list-grid';

    /** @var bool enable or disable data sort. Defaule TRUE */
    public $enableSort = TRUE;

    /** @var array with fields for table header(the same fields as in model) */
    public $listHeaders;

    /** @var array with filter options. array( 'field' => array( for dropDown list ) ) */
    public $listFilters = NULL;

    /** @var bool if TRUE - show check boxes column for group operations. Default TRUE */
    public $allowGroupOperations = TRUE;

    /** @var string name for checkboxes. Default checkAll */
    public $groupingCheckboxName = 'checkAll';

    /** @var string id for DIV block, that wrap widget block. Used for AJAX refresh, pagination etc */
    public $widgetWrapperId = 'pageHolder';

    /** @var string id for Form element, that wraps mail table.
     * Via this id you may access form elements such as checkbox (for example to perform group delete) */
    public $widgetFormId = 'widget-form';

    /** @var bool If TRUE - don't render additional scripts.
     * If you are using AJAX set this flag to reduce traffic */
    public $skipScripts = FALSE;

    /** @var bool if TRUE show selector for items limit per page */
    public $enableItemsLimitSelector = TRUE;


    protected $_sortableFields;
    protected $_countOfItems;
    /** @var $_dataProvider CDataProvider */
    public $_dataProvider;

    public function init()
    {
        $dataProviderGetterMethod = $this->dataProviderGetterMethod;

        $this->_dataProvider = $this->model->{$dataProviderGetterMethod}();
        $this->_countOfItems = $this->_dataProvider->getTotalItemCount();
        $this->_sortableFields = array();

        $sortAttributes = $this->_dataProvider->getSort()->attributes;
        foreach( $sortAttributes as $field => $value ) {
            if ( is_string( $value ) ) {
                $this->_sortableFields[] = $value;
            } else {
                $this->_sortableFields[] = $field;
            }
        }

    }

    public function run()
    {
        $itemsLimitSelect = CHtml::dropDownList(
            'items_limit',
            Yii::app()->request->getParam( 'items_limit', Yii::app()->params[ 'backend' ][ 'itemsPerPage' ] ),
            Yii::app()->params[ 'backend' ][ 'itemsPerPageOptions' ],
            array(
                'onchange' => 'changeItemsPerPageLimit( this )',
                'data-action_url' => $this->getActionUrlWithoutParam( 'items_limit' )
            )
        );

        $this->render(
            $this->getView(),
            array(
                'enableSort'    => $this->enableSort,
                'models'        => $this->_dataProvider->data,
                'model'         => $this->model,
                'isData'        => $this->_countOfItems > 0,
                'countOfItems'  => $this->_countOfItems,
                'listHeaders'   => $this->listHeaders,
                'listFilters'   => $this->listFilters,
                'sortableFields'=> $this->_sortableFields,
                'action'        => $this->ajaxUpdateAction,
                'pagination'    => $this->_dataProvider->getPagination(),
                'primary'       => $this->primary,
                'actionEdit'    => $this->actionEdit,
                'actionDelete'  => $this->actionDelete,
                'useAjaxDelete' => $this->useAjaxDelete,
                'widgetFormId'  => $this->widgetFormId,
                'skipScripts'   => $this->skipScripts,
                'allowGroupOperations'  => $this->allowGroupOperations,
                'groupingCheckboxName'  => $this->groupingCheckboxName,
                'widgetWrapperId'       => $this->widgetWrapperId,
                'deleteConfirmMessage'  => $this->deleteConfirmMessage,
                'rowCellsGetterMethod'  => $this->rowCellsGetterMethod,
                'itemsLimitSelect'      => $itemsLimitSelect,
                'enableItemsLimitSelector' => $this->enableItemsLimitSelector
            )
        );
    }

    /**
     * get url for sort
     * @param $field string
     * @return string
     */
    public function getUrlForSort( $field )
    {
        $sortVar = $this->_dataProvider->getSort()->sortVar;
        $sortParam = $field;
        $isAscOrder = isset( $_GET[ $sortVar ] ) && $_GET[ $sortVar ] == $field;
        $isDescOrder = isset( $_GET[ $sortVar ] ) && $_GET[ $sortVar ] == $field.'.desc';

        $params = $_GET;
        if ( isset( $params[ 'page' ] ) ) { // start from first page
            unset( $params[ 'page' ] );
        }

        if ( $isAscOrder ) {
            $sortParam .= '.desc';
        }

        if ( $isDescOrder ) { // if last order direction was DESC - remove order at all
            unset( $params[ 'sort' ] );
            return $this->getController()->createUrl( $this->ajaxUpdateAction, $params );
        }

        $params[ 'sort' ] = $sortParam;

        return $this->getController()->createUrl( $this->ajaxUpdateAction, $params );
    }

    /**
     * Returns URL for current action without target param
     * @param $paramKey
     * @return string
     */
    public function getActionUrlWithoutParam( $paramKey )
    {
        $params = $_GET;
        if ( is_array( $paramKey )) {
            foreach( $paramKey as $key => $subKey) {
                if ( isset( $params[ $key ] ) && isset( $params[ $key ][ $subKey ] ) ) {
                    unset( $params[ $key ][ $subKey ] );
                }
            }
        } else {
            if ( isset( $params[ $paramKey ] ) ) {
                unset( $params[ $paramKey ] );
            }
        }

        return $this->getController()->createUrl( $this->ajaxUpdateAction, $params );
    }

    /**
     * Returns url for edit action
     * @param $id integer id of primary key
     * @return string
     */
    public function getEditActionURL( $params = array() )
    {
        if ( $this->actionEditUrl !== FALSE && strlen($this->actionEditUrl) > 0 ) {
            return $this->actionEditUrl;
        } else {
            return $this->getController()->createUrl( $this->actionEdit, $params );
        }
    }

    /**
     * Returns pre generated or generated url for delete action
     * @param array $params url params
     * @return string
     */
    public function getDeleteActionURL( $params = array() )
    {
        if ( $this->actionDeleteUrl !== FALSE && strlen($this->actionDeleteUrl) > 0 ) {
            return $this->actionDeleteUrl;
        } else {
            return $this->getController()->createUrl( $this->actionDelete, $params );
        }
    }

    /**
     * Returns pre generated or generated url for create action
     * @param array $params url params
     * @return bool|string
     */
    public function getCreateActionUrl( $params = array() )
    {
        if ( $this->actionCreateUrl !== FALSE && strlen($this->actionCreateUrl) > 0 ) {
            return $this->actionCreateUrl;
        } else {
            return $this->getController()->createUrl( $this->actionCreate, $params );
        }
    }

    /**
     * Check if target field is among sort fields and is sorted by ASC
     * @param $field
     * @return bool
     */
    public function isAscSort( $field )
    {
        $sortVar = $this->_dataProvider->getSort()->sortVar;
        return isset( $_GET[ $sortVar ] ) && $_GET[ $sortVar ] == $field;
    }

    /**
     * Check if target field is among sort fields and is sorted by DESC
     * @param $field
     * @return bool
     */
    public function isDescSort( $field )
    {
        $sortVar = $this->_dataProvider->getSort()->sortVar;
        return isset( $_GET[ $sortVar ] ) && $_GET[ $sortVar ] == ( $field . '.desc' );
    }

    /**
     * @return string relative path for template file
     */
    protected function getView()
    {
        return $this->viewFolder . '/' . $this->viewFile;
    }

    public function createFilter( $field, $options )
    {
        if ( is_array( $options ) )
        {
            return CHtml::activeDropDownList(
                $this->model,
                $field,
                $options,
                array(
                    'onchange' => 'return onChangeFilter( this, \''. $this->widgetFormId .'\', \''.
                        $this->getActionUrlWithoutParam(
                            array( get_class($this->model) => $field )
                        ).'\' )',
                    'style' => 'width: auto;'
                )
            );
        }
        else
        {
            return CHtml::activeTextField(
                $this->model,
                $field,
                array(
                    'onchange' => 'return onChangeFilter( this, \''. $this->widgetFormId .'\', \''.
                        $this->getActionUrlWithoutParam(
                            array( get_class($this->model) => $field )
                        ).'\' )',
                    'style' => 'width: 100px;'
                )
            );
        }
    }
}