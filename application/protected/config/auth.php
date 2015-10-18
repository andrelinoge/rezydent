<?php
/**
 * @author Andre Linoge
 * Date: 11/17/12
 */

// Describes all roles in application and their hierarchy

return array(
    'guest' => array(
        'type'          => CAuthItem::TYPE_ROLE,
        'description'   => 'guest',
        'bizRule'       => NULL,
        'data'          => NULL
    ),

    'user' => array(
        'type'          => CAuthItem::TYPE_ROLE,
        'description'   => 'user',
        'children'      => array( 'guest' ), // inherit from guest
        'bizRule'       => NULL,
        'data'          => NULL
    ),

    'admin' => array(
        'type'          => CAuthItem::TYPE_ROLE,
        'description'   => 'admin',
        'children'      => array( 'moderator' ), // allow admin everything that allowed to moderator
        'bizRule'       => NULL,
        'data'          => NULL
    )
);