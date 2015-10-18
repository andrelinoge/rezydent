<?php
/**
 * @author: Andriy Tolstokorov
 * Date: 12/8/12
 */

/** @var $model CModel */
?>



<div class="row-fluid">

    <div class="span12">
        <div class="head clearfix">
            <div class="isw-documents"></div>
            <h1><?= $pageTitle; ?></h1>
        </div>
        <div class="block-fluid tabs">
            <?php
                $this->renderPartial(
                    '_form',
                    array(
                        'model'     => $model,
                        'formId'    => $formId,
                        'action'    => $formAction,
                        'innerLinks'=> $innerLinks
                    )
                );
            ?>
        </div>
    </div>

</div>