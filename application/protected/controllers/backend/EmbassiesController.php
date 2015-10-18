<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class EmbassiesController extends BackendController
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
        $model = new Embassies();
        return array(
            'index' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $model,
                'listHeaders'       => Embassies::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Візи та посольства' ),
                'listTitle'         => _( 'Список статтей' ),
                'actionCreateUrl'   => $this->createUrl( 'add' ),
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'add' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $model,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Нова стаття' ),
                'formId'        => Embassies::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'index' ),
                'innerLinks'    => Propositions::getInnerLinks( 'proposition', 'show' )
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => Embassies::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування статті' ),
                'formId'        => Embassies::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'innerLinks'    => Propositions::getInnerLinks( 'proposition', 'show' )
            ),

            'delete' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => new Embassies(),
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
                'tableModelClass'   => 'Embassies'
            ),

            'uploadImageHandler' => array(
                'class'         => 'application.actions.backend.UploadImageAction',
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
                    _( 'Візи та посольства' )
                );
                break;

            case 'add' :
                $result = array(
                    _( 'Візи та посольства' ) => $this->createUrl( 'index' ),
                    _( 'Додати нову статтю' )
                );
                break;

            case 'edit':
                $result = array(
                    _( 'Часті запитання' ) => $this->createUrl( 'index' ),
                    _( 'Редагувати статтю' )
                );
                break;

            case 'groupEdit':
                $result = array(
                    _( 'Візи та посольства' ) => $this->createUrl( 'index' ),
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