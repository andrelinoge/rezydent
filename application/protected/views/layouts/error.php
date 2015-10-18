<?
/* @var $this Controller */
$baseUrl = $this->getBehavioralBaseUrl();

Yii::app()
    ->clientScript
    ->registerCssFile( $baseUrl . '/style.css' )
    ->registerCssFile( $baseUrl . '/style/css/media-queries.css' )
//    ->registerCssFile( $baseUrl . '/style/js/fancybox/jquery.fancybox.css'  )
//    ->registerCssFile( $baseUrl . '/style/js/fancybox/helpers/jquery.fancybox-buttons.css' )
//    ->registerCssFile( $baseUrl . '/style/js/fancybox/helpers/jquery.fancybox-thumbs.css' )
//    ->registerCssFile( $baseUrl . '/style/type/fontello.css' )
//->registerScriptFile( $baseUrl . '/style/js/jquery.min.js', ClientScript::POS_HEAD )
    ->registerScriptFile( $baseUrl . '/style/js/ddsmoothmenu.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/selectnav.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.themepunch.plugins.min.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.themepunch.revolution.min.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/jquery.themepunch.megafoliopro.min.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/fullwidth-slider.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.easytabs.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/twitter.min.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.dcflickr.1.0.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.jribbble-0.11.0.ugly.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.slickforms.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/jquery.fitvids.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.isotope.min.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/jquery.address.min.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.fancybox.pack.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/fancybox/helpers/jquery.fancybox-buttons.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/fancybox/helpers/jquery.fancybox-thumbs.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/fancybox/helpers/jquery.fancybox-media.js', ClientScript::POS_END )
//    ->registerScriptFile( $baseUrl . '/style/js/jquery.dpSocialTimeline.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/jquery.themepunch.showbizpro.js', ClientScript::POS_END )
    ->registerScriptFile( $baseUrl . '/style/js/init_layout.js', ClientScript::POS_END );

?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?= $this->pageTitle; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= $baseUrl; ?>/style/images/favicon.png" />

    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700italic,700,500italic,500,400italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--[if IE 8]>
    <link rel="stylesheet" type="text/css" href="<?= $baseUrl; ?>/style/css/ie8.css" media="all" />
    <![endif]-->
    <!--[if IE 9]>
    <link rel="stylesheet" type="text/css" href="<?= $baseUrl; ?>/style/css/ie9.css" media="all" />
    <![endif]-->
</head>
<body class="box-layout">

<div class="top-wrapper">

    <div class="inner" style="padding: 0px;">

        <div class="header">
            <div class="logo" style="width: 1060px;">
                <div style="display: block; float: left; margin-top: 5px;">
                    <a href="<?= $this->createUrl( 'site/index' ); ?>">
                        <img style="margin-left: 15px; display: inline-block; float: left"
                             src="<?= $baseUrl; ?>/style/images/rezident_logo_t.png"
                             alt="Туристичне агентство Резидент">
                        <div style="float:left; margin-top: 0px; margin-left: 10px">
                            <h2>РЕЗИДЕНТ</h2>
                            <h4 style="margin-top: -5px;">Туристичне агентство</h4>
                        </div>

                    </a>
                </div>
                <div style="display: block; float: right;  padding-top: 5px;">
                    <h4 style="line-height: 12px;">
                        м. Івано-Франківськ,&nbsp;вул. Дністровська
                    </h4>
                    <h4 style="line-height: 12px;">
                        тел.&nbsp;&nbsp;(0342) 55 - 96 - 65,&nbsp;моб.&nbsp;&nbsp;097 - 22 - 92 - 490
                    </h4>
                </div>
            </div>

            <div class="clear"></div>
        </div>

        <div id="menu" class="menu clearfix">
            <?
            $this->widget('application.widgets.Templated.Menu',
                array(
                    'active' => ucfirst( $this->id ),
                    'items'  => $this->getMenu(),
                    'viewFile' => 'frontend'
                )
            );
            ?>
        </div>
    </div>

</div>

<div class="box-wrapper">
    <?= $content; ?>

    <div class="divider white-wrapper"></div>

    <div class="site-generator-wrapper">
        <div class="site-generator">
            <div class="copyright">
                <p>© 2013 Резидент. Всі права захищені.</p>
            </div>
        </div>
    </div>

</div>
<!-- End Box Wrapper -->

</body>
</html>