<?php
/**
 * User: andrelinoge
 * Date: 12/8/12
 */

/** @var $model BaseCatalogFormML */
/** @var $this Controller */
?>

<? foreach( $models as $index => $model ): ?>
    <?
        $this->renderPartial(
            $partialEditView,
            array(
                'formView'  => $formView,
                'model'     => $model,
                'pageTitle'     => $pageTitle . ' #' . $index,
                'formId'    => $model::FORM_ID . $index,
                'formAction'    => $this->createUrl( 'partialUpdate', array( 'id' => $index ) )
            )
        );
    ?>
<? endforeach; ?>
