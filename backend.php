<?php

define( 'APPLICATION_END', 'backend' );

// change the following paths if necessary
$rootDir =  dirname(__FILE__);
$yii = $rootDir . '/framework/yii.php';
$config = $rootDir . '/application/protected/config/backend.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once( 'shortcuts.php' );
require_once($yii);

Yii::createWebApplication($config)->runEnd( APPLICATION_END );
