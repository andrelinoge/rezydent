<?php
/**
 * User: andrelinoge
 * Date: 12/4/12
 */

Yii::import('application.widgets.Templated.ListGrid');

$this->widget(
    'ListGrid',
    array(
        'primary'       => $primaryField,
        'viewFile'      => 'backend-user-trips',
        'enableSort'    => TRUE,
        'model'         => $model,
        'listHeaders'   => $listHeaders,
        'listFilters'   => $listFilters,
        'widgetFormId'  => $widgetFormId, // to access checkboxes via form id
        'skipScripts'   => $skipScripts,
        'actionCreateUrl'       => $actionCreateUrl,
        'actionEdit'       => $actionEdit,
        'actionDelete'       => $actionDelete,
        'dataProviderGetterMethod' => $dataProviderGetterMethod,
        'rowCellsGetterMethod'  => 'getUsersTripsRowValues',
        'deleteConfirmMessage'  => 'Are you sure, you want to delete this item?',
        'groupingCheckboxName'  => $groupingCheckboxName,
        'widgetWrapperId'       => $widgetWrapperId,
        'allowGroupOperations' => TRUE,
        'enableEditing' => FALSE,
        'enableCreating' => FALSE,
        'ajaxUpdateAction' => 'trips'
    )
);

?>