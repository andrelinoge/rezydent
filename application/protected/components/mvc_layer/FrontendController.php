<?php
/**
 * @author Andre Linoge
 */

class FrontendController extends Controller
{
    public function init()
    {
        $this->pageTitle = Yii::app()->name;
        $this->setLayout( 'main' );
        parent::init();
    }

    public function getMenu()
    {
        $currentAction = strtolower( $this->action->id );

        $menuItems = array(
            array(
                'title' => _( 'Головна' ) ,
                'url' => $this->createUrl( 'site/index' ),
                'activityMarker' => 'site'
            ),

            array(
                'title' => _( 'Пошук туру' ) ,
                'url' => $this->createUrl( 'tours/index' ),
                'activityMarker' => 'tours'
            ),

            array(
                'title' => _( 'Акційні пропозиції' ) ,
                'url' => $this->createUrl( 'proposition/index' ),
                'activityMarker' => 'proposition'
            ),

            array(
                'title' => _( 'Пошук квитків' ) ,
                'url' => $this->createUrl( 'tickets/index' ),
                'activityMarker' => 'tour',
                'items' => array(
                    array(
                        'title' => _( 'Авіаквитки' ),
                        'url' => $this->createUrl( 'tickets/air' ),
                        'activityMarker' => 'air'
                    ),
                    array(
                        'title' => _( 'Ж/д квитки' ),
                        'url' => $this->createUrl( 'tickets/train' ),
                        'activityMarker' => 'train'
                    ),
                )
            ),

            array(
                'title' => _( 'Візи і посольства' ) ,
                'url' => $this->createUrl( 'embassies/index' ),
                'activityMarker' => 'embassies',
                'items' => array(
                    array(
                        'title' => _( 'Візові' ),
                        'url' => $this->createUrl( 'embassies/withvisa' ),
                        'activityMarker' => 'withvisa'
                    ),
                    array(
                        'title' => _( 'Безвізові' ),
                        'url' => $this->createUrl( 'embassies/withoutvisa' ),
                        'activityMarker' => 'withoutvisa'
                    ),
                )
            ),

            array(
                'title' => _( 'Робота за кордоном' ) ,
                'url' => $this->createUrl( 'site/work' ),
                'activityMarker' => 'work'
            ),

            array(
                'title' => _( 'Перевезення' ) ,
                'url' => $this->createUrl( 'site/passenger' ),
                'activityMarker' => 'site'
            ),

            array(
                'title' => _( 'Контакти' ) ,
                'url' => $this->createUrl( 'site/contact' ),
                'activityMarker' => 'site'
            ),
        );


        return $menuItems;
    }

    public function getDatingMenu()
    {
        $currentAction = strtolower( $this->action->id );

        $menuItems = array(
            array(
                'title' => _( 'Головна' ) ,
                'url' => $this->createUrl( 'site/index' ),
                'activityMarker' => 'site'
            ),

            array(
                'title' => _( 'Знайомства' ) ,
                'url' => $this->createUrl( 'touristDating/index' ),
                'activityMarker' => 'touristDating'
            ),

            array(
                'title' => _( 'Пошук туру' ) ,
                'url' => $this->createUrl( 'tours/index' ),
                'activityMarker' => 'tours'
            ),

            array(
                'title' => _( 'Акційні пропозиції' ) ,
                'url' => $this->createUrl( 'proposition/index' ),
                'activityMarker' => 'proposition'
            ),

            array(
                'title' => _( 'Пошук квитків' ) ,
                'url' => $this->createUrl( 'tickets/index' ),
                'activityMarker' => 'tour',
                'items' => array(
                    array(
                        'title' => _( 'Авіаквитки' ),
                        'url' => $this->createUrl( 'tickets/air' ),
                        'activityMarker' => 'air'
                    ),
                    array(
                        'title' => _( 'Ж/д квитки' ),
                        'url' => $this->createUrl( 'tickets/train' ),
                        'activityMarker' => 'train'
                    ),
                )
            ),

            array(
                'title' => _( 'Контакти' ) ,
                'url' => $this->createUrl( 'site/contact' ),
                'activityMarker' => 'site'
            ),
        );

        return $menuItems;
    }
}