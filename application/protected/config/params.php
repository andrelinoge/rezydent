<?php
/**
 * @author Andre Linoge
 * Date: 11/17/12
 */

// Application configs like count items per page, emails, IDs etc.
$applicationParams = array(
    'defaultLocale'                 => 'en',
    'availableLocalesInShortForm'   => array( 'en', 'uk', 'ru' ),
    'availableLocalesInFullForm'    => array(
        'en' => 'en_US',
        'uk' => 'uk_UA',
        'ru' => 'ru_RU'
    ),
    'availableLocalesWithDescription' => array(
        'en' => 'English',
        'uk' => 'Українська',
        'ru' => 'Русский',
    ),

    'adminIdentity' => array(
        'email' => 'admin@mail.com',
        'password' => '1111',
        'first_name' => 'Адміністратор',
        'last_name' => ''
    ),

    'frontend' => array(
        'blogPageSize' => 2,
        'itemsPerPage' => 4,
        'propositionsPerPage' => 6,
        'tripsPerPage' => 10,
        'messagesPerPage' => 10,
    ),

    'backend' => array(
        'itemsPerPage' => 10,
        'itemsPerPageOptions' => array(
            '5' => '5',
            '10' => '10',
            '20' => '20',
            '30' => '30',
            '50' => '50',
        ),
        'lastTripsInView' => 3,
        'lastComplaintsInView' => 3,
    ),

    'emails' => array(
        'admin'     => 'andrelinoge87@gmail.com',
        'studio'    => 'tolstokorov.studio@gmail.com',
        'notificationReceiver' => 'lesia7785@mail.ru',
        'defaultSender' => 'info@rezydent.com.ua',
        'limitForSend' => 500
    ),

    'folders' => array(
        'temp' => '/public/uploads/temp/',
        'slides' => '/public/uploads/slides/',
        'userPhotos' => '/public/uploads/user-photos/',
        'userAvatars' => '/public/uploads/user-avatars/',
    ),

    'src' => array(
        'slides' => '/application/public/uploads/slides/',
        'userPhotos' => '/application/public/uploads/user-photos/',
        'userAvatars' => '/application/public/uploads/user-avatars/',
    ),

    'uploader' => array(
        'allowedFileExtensions' => array( 'jpg', 'jpeg', 'png' ),
        'sizeLimit' => 10485760
    ),

    'user' => array(
        'defaultAvatar' => '/application/public/uploads/default-pictures/no-photo.png',
        'complaintsLimitBeforeBan' => 3
    )
);