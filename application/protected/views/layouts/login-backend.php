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

    <title>Login - admin panel</title>

    <link rel="icon" type="image/ico" href="favicon.ico"/>

    <!--[if lt IE 8]>
    <link href="<?= $this->getBehavioralBaseUrl(); ?>/css/ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->
</head>
<body>


<?= $content; ?>

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