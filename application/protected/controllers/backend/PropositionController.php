<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class PropositionController extends BackendController
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
        $model = new Propositions();
        return array(
            'index' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $model,
                'listHeaders'       => Propositions::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Гарячі пропозиції' ),
                'listTitle'         => _( 'Список пропозицій' ),
                'actionCreateUrl'   => $this->createUrl( 'add' ),
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'add' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $model,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Нова пропозиція' ),
                'formId'        => Propositions::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'index' ),
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Embassies::getInnerLinks( 'embassies', 'show' )
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => Propositions::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування пропозиції' ),
                'formId'        => Propositions::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' )
            ),

            'delete' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => new Propositions(),
                'deleteCriteria'=> 'id = :Id',
                'deleteParams'  => array( ':Id' => getParam( 'id' ) ),
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
                'tableModelClass'   => 'Propositions'
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
                    _( 'Гарячі пропозиції' )
                );
                break;

            case 'add' :
                $result = array(
                    _( 'Гарячі пропозиції' ) => $this->createUrl( 'index' ),
                    _( 'Додати нову пропозицію' )
                );
                break;

            case 'edit':
                $result = array(
                    _( 'Гарячі пропозиції' ) => $this->createUrl( 'index' ),
                    _( 'Редагувати пропозиції' )
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
                    'PartialUpdate', 'uploadImageHandler'
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