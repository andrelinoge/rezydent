<?php
/**
 * @author Andre Linoge
 */

$routes = array(
    '/' => 'site/index',
    'passenger' => 'site/passenger',
    'contact' => 'site/contact',
    'work' => 'site/work',
    'faq' => 'site/faq',
    'tickets' => 'tickets/index',


    'news' => 'news/index',
    'new/<key:>/<id:\d+>' => 'news/show',

    'media' => 'media/index',
    'media/<key:>/<id:\d+>' => 'media/show',

    'tours' => 'tours/index',
    'tours/health/<key:>/<id:\d+>' => 'tours/healthShow',
    'tours/children/<key:>/<id:\d+>' => 'tours/childrenShow',
    'tours/abroad/<key:>/<id:\d+>' => 'tours/abroadShow',
    'tours/ukraine/<key:>/<id:\d+>' => 'tours/ukraineShow',

    'propositions' => 'proposition/index',
    'proposition/<key:>/<id:\d+>' => 'proposition/show',

    'embassies' => 'embassies/index',
    'embassies/<key:>/<id:\d+>' => 'embassies/show',
);