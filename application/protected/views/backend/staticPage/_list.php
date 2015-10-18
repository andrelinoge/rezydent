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
        'dataProviderGetterMethod' => $dataProviderGetterMethod,
        'model'         => $model,
        'listHeaders'       => $listHeaders,
        'rowCellsGetterMethod'=> $rowCellsGetterMethod,
        'allowGroupOperations'  => FALSE,
        'widgetWrapperId' => $widgetWrapperId,
        'widgetFormId'  => $widgetFormId, // to access checkboxes via form id
        'skipScripts'   => $skipScripts,
        'enableCreating'  => FALSE,
        'enableDeleting'  => FALSE,
    )
);

?>