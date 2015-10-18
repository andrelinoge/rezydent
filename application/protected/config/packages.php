<?php
/**
 * @author Andre Linoge
 */

$controllersPath = '/application/public/' . APPLICATION_END . '/js/controllers/';

$clientScriptPackages = array(
    // Unique package Id
    'jquery' => array(
        // path to JS and CSS
        'baseUrl' => '/application/public/common/js/',
        'js' => array( 'jquery-1.8.3.min.js' ),
        'position' => CClientScript::POS_HEAD
    ),

    'jqueryForm' => array(
        'baseUrl' => '/application/public/common/js/',
        'js' => array( 'jquery.form.js' ),
        'depends'=>array( 'jquery' ),
    ),

    'jqueryValidator' => array(
        'baseUrl' => '/application/public/common/js/',
        'js' => array( 'jquery.validate.js', 'additional-validators.min.js' ),
        'depends'=>array( 'jquery', 'jqueryForm' ),
    ),

    'fileUploader' => array(
        'baseUrl' => '/application/public/common/js/plugins/fileupload/',
        'js' => array( 'fileuploader.js' ),
        'css' => array( 'fileuploader.css' ),
        'depends'=>array( 'jquery' ),
    ),

    'uploader' => array(
        'baseUrl' => $controllersPath,
        'js' => array( 'uploadController.js'),
        'depends'=>array( 'fileUploader' ),
        'position' => CClientScript::POS_HEAD
    ),

    'applicationEndController' => array(
        'baseUrl' => $controllersPath,
        'js' => array( APPLICATION_END . 'Controller.js'),
        'depends'=>array( 'jquery' ),
    ),

    'bootstrapDatePicker' => array(
        'baseUrl' => '/application/public/common/js/plugins/bootstrap-datepicker/',
        'css'=> array( 'css/datepicker.css'),
        'js' => array( 'js/bootstrap-datepicker.js' ),
        'depends'=>array( 'jquery' ),
    ),

    'bootstrapTimePicker' => array(
        'baseUrl' => '/application/public/common/js/plugins/bootstrap-timepicker/',
        'js' => array( 'js/bootstrap-timepicker.js' ),
        'depends'=>array( 'jquery' ),
    ),

    'ckEditor' => array(
        'baseUrl' => '/application/public/common/js/plugins/ckeditor/',
        'js' => array( 'ckeditor.js' ),
        'depends'=>array( 'jquery' ),
    ),

    'zeroClipboard' => array(
        'baseUrl' => '/application/public/common/js/plugins/ZeroClipboard/',
        'js' => array( 'ZeroClipboard.min.js' ),
        'depends'=>array( 'jquery' ),
    ),

    'multiSelect' => array(
        'baseUrl' => '/application/public/backend/js/plugins/multiselect/',
        'js' => array( 'jquery.multi-select.js' ),
        'depends'=>array( 'jquery' ),
    )
);