<?php
/**
 * @author: Andriy Tolstokorov
 * Date: 12/8/12
 */

/** @var $this BackendController */
?>

<div class="row-fluid">

    <div class="span8">
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1><?= $pageTitle; ?></h1>
        </div>
        <div class="block-fluid tabs">
            <?php
                $this->renderPartial(
                    $formView,
                    array(
                        'model'     => $model,
                        'formId'    => $formId,
                        'action'    => $formAction
                    )
                );
            ?>
        </div>
    </div>

</div>