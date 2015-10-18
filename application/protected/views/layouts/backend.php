<?php
/**
 * @author Andre Linoge
 */

/** @var $this Controller */

$baseUrl = $this->getBehavioralBaseUrl();

Yii::app()
    ->clientScript
    ->registerCssFile( $baseUrl . '/css/stylesheets.css' )
    ->registerCssFile( $baseUrl . '/css/mystyles.css' );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <!--[if gt IE 8]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->

    <title><?= $this->pageTitle; ?></title>

    <link rel="icon" type="image/ico" href="favicon.ico"/>

    <!--[if lt IE 8]>
    <link href="<?= $this->getBehavioralBaseUrl(); ?>/css/ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->
</head>
<body>
<div class="wrapper">

<div class="header">
    <a class="logo"
       href="<?= Yii::app()->homeUrl; ?>">
        <h1 style="font-size: 21px; line-height: 20px; margin: 0px;">Резидент</h1>
    </a>
    <a class="go-site"
       href="<?= Yii::app()->getBaseUrl(TRUE) . '/'; ?>">
        <h1 style="font-size: 21px; line-height: 20px; margin: 0px;"><?= _( 'Перейти на сайт' ); ?></h1>
    </a>
    <ul class="header_menu">
        <li class="list_icon"><a href="#">&nbsp;</a></li>
    </ul>
</div>

<div class="menu">

<div class="breadLine">
    <div class="adminControl" style="background: none;">
        <?= Yii::app()->user->getModel()->getFullName(); ?>
        <div style="float: right">
            <a href="<?= $this->createUrl( 'site/logout'); ?>">
            <span class="icon-share-alt"></span>
                <?= _( 'Вийти' ); ?>
            </a>
        </div>
    </div>
</div>

<?
    $this->widget('application.widgets.Templated.Menu',
        array(
            'active' => ucfirst( $this->id ),
            'items'  => $this->getMenu(),
            'viewFile' => 'backend'
        )
    );
?>


<div class="dr"><span></span></div>

</div>

<div class="content">


<div class="breadLine">
    <?
        $this->widget('application.widgets.Templated.BreadCrumbs',
            array(
                'items'  => $this->breadcrumbs,
                'viewFile' => 'backend'
            )
        );
    ?>
</div>

<div class="workplace" id="work_space">
    <?= $content; ?>
</div>

</div>
</div>

<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js'></script>
<script type='text/javascript' src='<?= $baseUrl; ?>/js/plugins/jquery/jquery.mousewheel.min.js'></script>
<script type='text/javascript' src='<?= $baseUrl; ?>/js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
<script type='text/javascript' src='<?= $baseUrl; ?>/js/plugins/bootstrap.min.js'></script>

<script type='text/javascript' src='<?= $baseUrl; ?>/js/plugins/sparklines/jquery.sparkline.min.js'></script>

<script type='text/javascript' src='<?= $baseUrl; ?>/js/plugins/select2/select2.min.js'></script>

<script type='text/javascript' src='<?= $baseUrl; ?>/js/plugins/uniform/uniform.js'></script>

<script type='text/javascript' src='<?= $baseUrl; ?>/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>

<script type='text/javascript' src='<?= $baseUrl; ?>/js/plugins/fancybox/jquery.fancybox.pack.js'></script>

<script type='text/javascript' src='<?= $baseUrl; ?>/js/init.layout.js'></script>

</body>
</html>
