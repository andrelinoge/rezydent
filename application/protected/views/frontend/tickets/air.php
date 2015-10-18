<?
/** @var $this SiteController */
/** @var $pageModel StaticPages */

$title = $pageModel->getTitle();
$text = $pageModel->getText();
?>

<div class="white-wrapper" id="content-container">
    <div class="inner">
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
        <div class="clear"></div>
        <div class="center">
            <iframe width="850px"
                    height="1000px"
                    src="http://anex.symphony.cz/ru_UA/index.php?WEB_ID=anex9">
            </iframe>
        </div>
        <div class="clear"></div>
        <? if( !empty( $text ) ): ?>
            <div>
                <?= $text; ?>
            </div>
            <br/>
        <? endif; ?>
    </div>
</div>