<?php
/**
 * @author Andrelinoge
 * Date: 12/4/12
 * $items array must array like this:
 * $menuItems = array(
    array(
        'title' => "Menu !",
        'url' => $this->createUrl( 'controller/action' ),
        'activityMarker' => 'site'  // by comparing $activityMarker and $active params widget will
                                    // know if menu is active or opened
    ),

    array(
    'title' => "Menu with sub-menu",
        'url' => $this->createUrl( 'controller/action' ),
        'activityMarker' => 'SubMenu',
        'active' => "<param to compare with sub-items $activityMarker's>", // usually action name
        'items' => array(
            array(
                'title' => "sub-menu 1",
                'url' => $this->createUrl( 'controller/action1' ),
                'activityMarker' => 'action1'
            ),
            array(
                'title' => "sub-menu 2",
                'url' => $this->createUrl( 'controller/action2' ),
                'activityMarker' => 'action2'
            ),
            array(
                'title' => "sub-menu 3",
                'url' => $this->createUrl( 'controller/action3' ),
                'activityMarker' => 'action3'
            ),
        )
    )
);
 */

class Menu extends CWidget
{
    /** @var array with menu */
    public $items;
    /** @var string active menu item */
    public $active;
    /** @var string menu template */
    public $viewFile = 'default';
    /** @var string folder with menu templates */
    public $viewFolder = 'menu';

    public function init()
    {
        if ( !is_array( $this->items ) ) {
            throw new CException( 'Wrong options format. Look widget php-doc for help.');
        }
    }

    public function run()
    {

        $this->render(
            $this->getView(),
            array(
                'items' => $this->items,
                'active' => $this->active
            )
        );
    }

    protected function getView()
    {
        return $this->viewFolder . '/' . $this->viewFile;
    }
}