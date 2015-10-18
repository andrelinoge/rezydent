<?php
/**
 * This file contains global function - shortcuts to reduce typing
 */

/**
 * This is the shortcut to Yii::t with default category 'site'
 */
function t( $message, $category = 'site', $params = array(), $source = NULL, $language = NULL ) {
    return Yii::t( $category, $message, $params, $source, $language );
}

/**
 * This is the shortcut to Yii::app()->request()->getParam() with default value NULL
 */
function getParam( $key, $default = NULL ) {
    return Yii::app()->request->getParam( $key, $default );
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function createUrl( $route, $params = array() ) {
    return Yii::app()->createUrl( $route, $params );
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function getPublicUrl( $pathTuPublic = '/application/public' ) {
    return Yii::app()->request->baseUrl . $pathTuPublic;
}

/**
 * check if request is ajax
 * @return bool
 */
function isAjax() {
    return Yii::app()->request->isAjaxRequest || isset( $_GET[ 'ajax' ] ) || isset( $_POST[ 'ajax' ] );
}

/**
 * This function check if request is AJAX or POST
 * @return bool
 */
function isPostOrAjaxRequest() {
    return Yii::app()->request->isPostRequest || isAjax();
}