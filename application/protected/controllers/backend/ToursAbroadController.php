<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class ToursAbroadController extends BackendController
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
        $model = new ToursAbroad();

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
                'pageTitle'         => _( 'Екскурсійні тури за кордон' ),
                'listTitle'         => _( 'Перелік країн' ),
                'actionCreateUrl'   => $this->createUrl( 'add' ),
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'add' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $model,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Нова країна' ),
                'formId'        => $model::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'index' ),
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Embassies::getInnerLinks( 'embassies', 'show' )
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => $model->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування країни' ),
                'formId'        => $model::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Embassies::getInnerLinks( 'embassies', 'show' )
            ),

            'delete' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => $model,
                'deleteCriteria'=> 'id = :catalogId',
                'deleteParams'  => array( ':catalogId' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'index' ),
                'isMultilingual'=> FALSE
            ),

            'groupDeleteArticles' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'index' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( 'Статтю видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'ToursAbroad'
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
                    _( 'Екскурсійні тури за кордон' )
                );
            break;

            case 'add' :
                $result = array(
                    _( 'Екскурсійні тури за кордон' ) => $this->createUrl( 'index' ),
                    _( 'Нова країна' )
                );
            break;

            case 'edit':
                $result = array(
                    _( 'Екскурсійні тури за кордон' ) => $this->createUrl( 'index' ),
                    _( 'Редагувати країну' )
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
                    'index', 'add', 'edit', 'delete', 'groupDeleteArticles',
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