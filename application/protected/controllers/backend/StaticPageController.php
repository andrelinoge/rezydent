<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class StaticPageController extends BackendController
{
    public function beforeAction()
    {
        $this->breadcrumbs = $this->getBreadCrumbs(
            $this->getAction()->getId()
        );
        return TRUE;
    }

    public function actions()
    {
        return array(
            'index' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => new StaticPages( 'search' ),
                'listHeaders'       => StaticPages::getHeadersForListGrid(),
                'primaryField'      => 'page_id', // primary field for multilingual models
                'view'              => 'list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Статичні сторінки' ),
                'listTitle'         => _( 'Перелік сторінок' ),
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => StaticPages::model()->findByAttributes( array( 'page_id' => getParam( 'id' ) ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування статичної сторінки' ),
                'formId'        => StaticPages::FORM_ID,
                'formAction'    => '',
                'redirectUrl'   => $this->createUrl( 'index' ),
                //'innerLinks'    => StaticPages::getInnerLinks(),
            ),
        );
    }

    protected function getBreadCrumbs( $actionId )
    {
        $result = array();

        switch ( $actionId ) {
            case 'edit':
                $result = array(
                    _( 'Статичні сторінки' ) => $this->createUrl( 'index' ),
                    _( 'Редагування сторінки' )
                );
                break;
        }

        return $result;
    }

    /**                                     FILTERS                                **/


    public function filters() {
        return array(
            'accessControl'
        );
    }


    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'index',  'edit'
                ),
                'roles' => array( 'admin' )
            ),

            // deny all for all users
            array(
                'deny',
                'users' => array( '*' ),
            ),
        );
    }

}