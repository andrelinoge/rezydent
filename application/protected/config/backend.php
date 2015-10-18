<?php
/**
 * @author Andre Linoge
 */

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        // Application modules
        'modules'=>array(
            'gii'=>array(
                'class'=>'system.gii.GiiModule',
                'password'=>'1111',
                // If removed, Gii defaults to localhost only. Edit carefully to taste.
                'ipFilters'=>array('127.0.0.1','::1'),
            ),
        ),
        'components'=>array(
            'user'=>array(
                // enable/disable cookie-based authentication
                'allowAutoLogin' => FALSE,
                'class' => 'WebUser',
                'loginUrl' => '/backend.php/site/login'
            ),
            // uncomment the following to enable URLs in path-format
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => TRUE
            ),

            'gettext' => array(
                'class' => 'ext.yii-gettext.GetText',
                'domain' => 'backend'
            ),

            'errorHandler'=>array(
                'errorAction'=>'site/error',
            ),
        )
    )
);