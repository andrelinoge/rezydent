<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class TouristDatingController extends BackendController
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
        $maritalStatus = new MaritalStatus();
        $tripCompanion = new TripCompanion();
        $tripWith = new TripWith();
        $tripPurpose = new TripPurpose();
        $country = new Country();


        return array(
            'maritalStatus' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $maritalStatus,
                'listHeaders'       => $maritalStatus::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'marital-list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Сімейний статус' ),
                'listTitle'         => _( 'Перелік варіантів' ),
                'actionCreateUrl'   => $this->createUrl( 'addMaritalStatus' ),
                'actionEdit'        => 'editMaritalStatus',
                'actionDelete'        => 'deleteMaritalStatus',
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'addMaritalStatus' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $maritalStatus,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Новий запис' ),
                'formId'        => $maritalStatus::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'maritalStatus' ),
            ),

            'editMaritalStatus' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => $maritalStatus::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування статусу' ),
                'formId'        => $maritalStatus::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'deleteMaritalStatus' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => $maritalStatus,
                'deleteCriteria'=> 'id = :id',
                'deleteParams'  => array( ':id' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'maritalStatus' ),
                'isMultilingual'=> FALSE
            ),

            'groupDeleteMaritalStatus' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'maritalStatus' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( ' запис(ів) видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'MaritalStatus'
            ),

            // Trip purpose

            'tripPurpose' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $tripPurpose,
                'listHeaders'       => $tripPurpose::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'trip-purpose-list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Ціль поїздки' ),
                'listTitle'         => _( 'Перелік варіантів' ),
                'actionCreateUrl'   => $this->createUrl( 'addTripPurpose' ),
                'actionEdit'        => 'editTripPurpose',
                'actionDelete'        => 'deleteTripPurpose',
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'addTripPurpose' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $tripPurpose,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Новий запис' ),
                'formId'        => $tripPurpose::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'tripPurpose' ),
            ),

            'editTripPurpose' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => $tripPurpose::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування запису' ),
                'formId'        => $tripPurpose::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'deleteTripPurpose' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => $tripPurpose,
                'deleteCriteria'=> 'id = :id',
                'deleteParams'  => array( ':id' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'tripPurpose' ),
                'isMultilingual'=> FALSE
            ),

            'groupDeleteTripPurpose' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'tripPurpose' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( ' запис(ів) видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'TripPurpose'
            ),

            // Trip companion

            'tripCompanion' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $tripCompanion,
                'listHeaders'       => $tripCompanion::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'trip-with-list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Кого шукають' ),
                'listTitle'         => _( 'Перелік варіантів' ),
                'actionCreateUrl'   => $this->createUrl( 'addTripCompanion' ),
                'actionEdit'        => 'editTripCompanion',
                'actionDelete'        => 'deleteTripCompanion',
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'addTripCompanion' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $tripCompanion,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Новий запис' ),
                'formId'        => $tripCompanion::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'tripCompanion' ),
            ),

            'editTripCompanion' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => $tripCompanion::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування запису' ),
                'formId'        => $tripCompanion::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'deleteTripCompanion' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => $tripCompanion,
                'deleteCriteria'=> 'id = :id',
                'deleteParams'  => array( ':id' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'tripCompanion' ),
                'isMultilingual'=> FALSE
            ),

            'groupDeleteTripCompanion' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'tripCompanion' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( ' запис(ів) видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'TripCompanion'
            ),

            // Trip with

            'tripWith' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $tripWith,
                'listHeaders'       => $tripWith::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'trip-with-list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'З ким їхати' ),
                'listTitle'         => _( 'Перелік варіантів' ),
                'actionCreateUrl'   => $this->createUrl( 'addTripWith' ),
                'actionEdit'        => 'editTripWith',
                'actionDelete'        => 'deleteTripWith',
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'addTripWith' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $tripWith,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Новий запис' ),
                'formId'        => $tripWith::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'tripWith' ),
            ),

            'editTripWith' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => $tripWith::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування запису' ),
                'formId'        => $tripWith::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'deleteTripWith' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => $tripWith,
                'deleteCriteria'=> 'id = :id',
                'deleteParams'  => array( ':id' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'tripPurpose' ),
                'isMultilingual'=> FALSE
            ),

            'groupDeleteTripWith' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'tripWith' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( ' запис(ів) видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'TripWith'
            ),

            // Country

            'country' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $country,
                'listHeaders'       => $country::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'country-list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Країни' ),
                'listTitle'         => _( 'Перелік варіантів' ),
                'actionCreateUrl'   => $this->createUrl( 'addCountry' ),
                'actionEdit'        => 'editTripWith',
                'actionDelete'        => 'deleteTripWith',
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'addCountry' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $country,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Новий запис' ),
                'formId'        => $country::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'country' ),
            ),

            'editCountry' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => $country::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування запису' ),
                'formId'        => $country::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'deleteCoutry' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => $country,
                'deleteCriteria'=> 'id = :id',
                'deleteParams'  => array( ':id' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'country' ),
                'isMultilingual'=> FALSE
            ),

            'groupDeleteCountry' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'country' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( ' запис(ів) видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'country'
            ),
        );
    }

    protected function getBreadCrumbs( $actionId )
    {
        $result = array();

        switch ( $actionId )
        {
            // Marital status

            case 'maritalStatus' :
                $result = array(
                    _( 'Туристичні знайомства - сімейний статус' )
                );
            break;

            case 'addMaritalStatus' :
                $result = array(
                    _( 'Туристичні знайомства - сімейний статус' ) => $this->createUrl( 'maritalStatus' ),
                    _( 'Новий статус' )
                );
            break;

            case 'editMaritalStatus':
                $result = array(
                    _( 'Туристичні знайомства - сімейний статус' ) => $this->createUrl( 'maritalStatus' ),
                    _( 'Редагувати статус' )
                );
            break;

            // Trip Purpose

            case 'tripPurpose' :
                $result = array(
                    _( 'Туристичні знайомства - ціль поїздки' )
                );
            break;

            case 'addTripPurpose' :
                $result = array(
                    _( 'Туристичні знайомства - ціль поїздки' ) => $this->createUrl( 'tripPurpose' ),
                    _( 'Нова ціль' )
                );
            break;

            case 'editTripPurpose':
                $result = array(
                    _( 'Туристичні знайомства - ціль поїздки' ) => $this->createUrl( 'tripPurpose' ),
                    _( 'Редагувати ціль' )
                );
            break;

            // Trip With

            case 'tripWith' :
                $result = array(
                    _( 'Туристичні знайомства - з ким їхати' )
                );
            break;

            case 'addTripWith' :
                $result = array(
                    _( 'Туристичні знайомства - з ким їхати' ) => $this->createUrl( 'tripWith' ),
                    _( 'Нова ціль' )
                );
            break;

            case 'editTripWith':
                $result = array(
                    _( 'Туристичні знайомства - з ким їхати' ) => $this->createUrl( 'tripWith' ),
                    _( 'Редагувати ціль' )
                );
            break;

            // Trip Company

            case 'tripCompanion' :
                $result = array(
                    _( 'Туристичні знайомства - кого шукають' )
                );
                break;

            case 'addTripCompanion' :
                $result = array(
                    _( 'Туристичні знайомства - кого шукають' ) => $this->createUrl( 'tripCompanion' ),
                    _( 'Нова ціль' )
                );
                break;

            case 'editTripCompanion':
                $result = array(
                    _( 'Туристичні знайомства - кого шукають' ) => $this->createUrl( 'tripCompanion' ),
                    _( 'Редагувати ціль' )
                );
                break;

            // Country

            case 'country' :
                $result = array(
                    _( 'Туристичні знайомства - країни' )
                );
                break;

            case 'addCountry' :
                $result = array(
                    _( 'Туристичні знайомства - країни' ) => $this->createUrl( 'country' ),
                    _( 'Нова ціль' )
                );
                break;

            case 'editCountry':
                $result = array(
                    _( 'Туристичні знайомства - країни' ) => $this->createUrl( 'country' ),
                    _( 'Редагувати ціль' )
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
                    'maritalStatus', 'addMaritalStatus', 'editMaritalStatus', 'deleteMaritalStatus', 'GroupDeleteMaritalStatus',
                    'tripPurpose', 'addTripPurpose', 'editTripPurpose', 'deleteTripPurpose', 'GroupDeleteTripPurpose',
                    'tripWith', 'addTripWith', 'editTripWith', 'deleteTripWith', 'GroupDeleteTripWith',
                    'tripCompanion', 'addTripCompanion', 'editTripCompanion', 'deleteTripCompanion', 'GroupDeleteTripCompanion',
                    'Country', 'addCountry', 'editCountry', 'deleteCountry', 'GroupDeleteCountry',
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