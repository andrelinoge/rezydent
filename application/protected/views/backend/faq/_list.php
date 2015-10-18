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
        'enableSort'    => TRUE,
        'dataProviderGetterMethod' => 'backendSearch',
        'model'         => $model,
        'listHeaders'       => $listHeaders,
        'listFilters'       => $listFilters,
        'rowCellsGetterMethod'=> 'getRowValues',
        'deleteConfirmMessage' => 'Ви дійсно бажаєте видалити цей запис?',
        'groupingCheckboxName'  => $groupingCheckboxName,
        'widgetWrapperId' => $widgetWrapperId,
        'widgetFormId'  => $widgetFormId, // to access checkboxes via form id
        'skipScripts'   => $skipScripts,
        'actionEdit'    => 'edit',
        'actionDelete'    => 'delete',
        'actionCreateUrl' => $actionCreateUrl,
        'ajaxUpdateAction' => 'index'
    )
);

?>