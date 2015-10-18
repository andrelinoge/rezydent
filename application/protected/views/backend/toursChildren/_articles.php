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
        'deleteConfirmMessage' => 'Are you sure, you want to delete this item?',
        'groupingCheckboxName'  => $groupingCheckboxName,
        'widgetWrapperId' => $widgetWrapperId,
        'widgetFormId'  => $widgetFormId, // to access checkboxes via form id
        'skipScripts'   => $skipScripts,
        'actionEdit'    => 'editArticle',
        'actionDelete'    => 'deleteArticle',
        'actionCreateUrl' => $actionCreateUrl,
        'ajaxUpdateAction' => 'articles'
    )
);

?>