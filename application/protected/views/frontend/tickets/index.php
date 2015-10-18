<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */

$title = $pageModel->getTitle();
$text = $pageModel->getText();
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

        <? if( !empty( $title ) ): ?>
            <h1 class="line"><?= $title; ?></h1>
        <? endif; ?>
        <a class="button aqua" href="<?= $this->createUrl( 'air' ); ?>">Авіаквитки</a>
        &nbsp;&nbsp;
        <a class="button aqua" href="<?= $this->createUrl( 'train' ); ?>">Ж\д квитки</a>
        <div class="clear"></div>
        <? if( !empty( $text ) ): ?>
            <div>
                <?= $text; ?>
            </div>
        <? endif; ?>
    </div>
</div>