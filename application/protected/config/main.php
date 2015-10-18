<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

/*
TODO: merge include those arrays in this config in production
*/

require_once 'routes.php'; // contains $routes
require_once 'params.php'; // contains $applicationParams
require_once 'packages.php'; // contains clientScript packages settings

$applicationDir = dirname( dirname ( dirname( __FILE__ ) ) );

return array(
	'basePath' => $applicationDir . '/protected',
    'runtimePath' => $applicationDir . '/public/runtime',
	'name' => 'Туристичне агентсво Резидент',

	// preloading 'log' component
	'preload'=>array( 'log'),

	// autoloading model and component classes
	'import'=>array(
        'application.controllers.backend.*',
		'application.models.*',
        'application.models.active_record.*',
        'application.models.forms.*',
		'application.components.*',
        'application.components.system.*', // includes such components as auth or WebUser
        'application.components.third_part.*', // includes such components as ImageRoutine, PayPal, social API classes
        // includes additional layers for MVC
        'application.components.mvc_layer.*',
        'application.components.mvc_layer.base_tables.*',
        'application.components.mvc_layer.base_forms.*',
        'application.components.mvc_layer.base_tables.multilingual.*',
        'application.components.mvc_layer.base_forms.multilingual.*',
        'application.widgets.*' // widgets
	),

    // Set application behavior
    'behaviors'=>array(
        'runEnd'=>array(
            'class'=>'application.components.system.ApplicationEndBehavior',
        ),
    ),

	// application components
	'components'=>array(
        // Assets
        'assetManager' => array(
            'basePath' => $applicationDir . '/public/assets',
            'baseUrl'  => '/application/public/assets/'
        ),
        // User
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin' => TRUE,
            'class' => 'WebUser', // located in components/system/ and is inherit for CWebUser
            'loginUrl' => '/touristDating/index'
		),

        // Auth
        'authManager'=>array(
            'class'=>'phpAuthManager',
            'defaultRoles' => array('guest'),
        ),

        // URLs
		'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => FALSE,
            'rules' => $routes,
		),

        // DB
		'db'=>array(
			'emulatePrepare' => true,

            // production
            /*
            'connectionString' => 'mysql:host=rezydent.mysql.ukraine.com.ua;dbname=rezydent_db',
            'username' => 'rezydent_db',
			'password' => 'ajwZpPCA',
             */
            'connectionString' => 'mysql:host=localhost;dbname=rezydent_db',
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
            //'schemaCachingDuration'=> 3600
            'enableProfiling'       => TRUE,
            'enableParamLogging'    => TRUE
		),

        // Error
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

        // Log
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					//'class'=>'CFileLogRoute',
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute', // comment in production version
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

        'gettext' => array(
            'class' => 'ext.yii-gettext.GetText',
            'domain' => 'frontend'
        ),

        // Cache

        'cache' => array(
            //'class' => 'system.caching.CMemCache',
            'class' => 'system.caching.CDummyCache',
            //'useMemcached' => TRUE, // use libmemcached library, written in C, to work with memcache server
        ),

        // Mail
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'viewPath' => 'application.views.mail-templates',
            'logging' => true,
            'dryRun' => false,
            'transportOptions' => array(
                'host' => 'mail.ukraine.com.ua',
                'username' => 'info@rezydent.com.ua',
                'password' => 'u343yHPz',
                'port' => 25,
            ),
        ),

        // ClientScript
        'clientScript'=>array(
            'class' => 'ClientScript',
            'packages' => $clientScriptPackages,
            'coreScriptPosition' => CClientScript::POS_END
        )
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => $applicationParams,
    // Locale settings
    'sourceLanguage' => 'ru_RU',
    'language' => 'en',
    'charset' => 'utf-8'
);
