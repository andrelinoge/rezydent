<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */
?>

<div class="white-wrapper">
    <div class="inner" id="content-container">
        <?
        $this->widget(
            'application.widgets.Templated.BreadCrumbs',
            array(
                'viewFile' => 'frontend',
                'items' => $this->breadcrumbs
            )
        );
        ?>

        <div class="page-intro line clearfix">
            <h1 class="page-title"><?= $pageModel->getTitle(); ?></h1>
        </div>
        <?= $pageModel->getText(); ?>
    </div>
</div>