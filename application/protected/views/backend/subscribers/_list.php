<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

Yii::import('application.widgets.Templated.ListGrid');
$this->widget(
    'ListGrid',
    array(
        'primary'       => $primaryField,
        'viewFile'      => 'backend',
        'enableSort'    => TRUE,
        'dataProviderGetterMethod' => $dataProviderGetterMethod,
        'model'         => $model,
        'listHeaders'       => $listHeaders,
        'rowCellsGetterMethod'=> 'getRowValues',
        'deleteConfirmMessage' => _( 'Are you sure, you want to delete this item?' ),
        'groupingCheckboxName'  => $groupingCheckboxName,
        'widgetWrapperId' => $widgetWrapperId,
        'widgetFormId'  => $widgetFormId, // to access checkboxes via form id
        'skipScripts'   => $skipScripts,
        'actionCreateUrl'   => $actionCreateUrl,
        'enableCreating' => FALSE,
        'enableEditing' => FALSE
    )
);

?>