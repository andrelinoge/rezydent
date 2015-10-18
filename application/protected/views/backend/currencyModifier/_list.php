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
        'viewFile'      => 'backend',
        'enableSort'    => FALSE,
        'model'         => $model,
        'listHeaders'   => $listHeaders,
        'widgetFormId'  => $widgetFormId, // to access checkboxes via form id
        'skipScripts'   => $skipScripts,
        'actionCreateUrl'       => $actionCreateUrl,
        'dataProviderGetterMethod' => 'backendSearch',
        'rowCellsGetterMethod'  => 'getRowValues',
        'deleteConfirmMessage'  => 'Are you sure, you want to delete this item?',
        'groupingCheckboxName'  => $groupingCheckboxName,
        'widgetWrapperId'       => $widgetWrapperId,
        'enableCreating'        => FALSE,
        'enableEditing'         => TRUE,
        'enableDeleting'        => FALSE,
        'allowGroupOperations' => FALSE,
        'enableItemsLimitSelector' => FALSE
    )
);

?>