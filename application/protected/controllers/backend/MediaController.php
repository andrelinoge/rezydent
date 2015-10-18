<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class MediaController extends BackendController
{
    const GROUP_IDS_VARIABLE = 'ids';

    public function beforeAction()
    {
        $this->breadcrumbs = $this->getBreadCrumbs(
            $this->getAction()->getId()
        );

        return TRUE;
    }

    public function actions()
    {
        $model = new Media();

        return array(
            'index' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $model,
                'listHeaders'       => $model::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Фото та відео' ),
                'listTitle'         => _( 'Список' ),
                'actionCreateUrl'   => $this->createUrl( 'add' ),
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'add' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $model,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Нова стаття' ),
                'formId'        => $model::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'index' ),
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Propositions::getInnerLinks( 'proposition', 'show' )
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => $model::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування статті' ),
                'formId'        => $model::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Propositions::getInnerLinks( 'proposition', 'show' )
            ),

            'delete' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => $model,
                'deleteCriteria'=> 'id = :Id',
                'deleteParams'  => array( ':Id' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'index' ),
                'isMultilingual'=> FALSE
            ),

            'groupDelete' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'index' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( 'Статтю видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'News'
            ),

            'uploadImageHandler' => array(
                'class'         => 'application.actions.backend.UploadImageAction'
            )
        );
    }

    protected function getBreadCrumbs( $actionId )
    {
        $result = array();

        switch ( $actionId )
        {
            case 'index' :
                $result = array(
                    _( 'Фото та відео' )
                );
                break;

            case 'add' :
                $result = array(
                    _( 'Фото та відео' ) => $this->createUrl( 'index' ),
                    _( 'Додати нову статтю' )
                );
                break;

            case 'edit':
                $result = array(
                    _( 'Фото та відео' ) => $this->createUrl( 'index' ),
                    _( 'Редагувати статтю' )
                );
                break;

            case 'groupEdit':
                $result = array(
                    _( 'Фото та відео' ) => $this->createUrl( 'index' ),
                    _( 'Редагування групи статтей' )
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
                    'index', 'add', 'edit', 'delete', 'GroupDelete', 'GroupEdit',
                    'PartialUpdate',
                    'uploadImageHandler'
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