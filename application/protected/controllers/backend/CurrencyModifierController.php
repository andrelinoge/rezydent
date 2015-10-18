<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class CurrencyModifierController extends BackendController
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
        $model = new CurrencyModifier();

        return array(
            'index' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $model,
                'listHeaders'       => CurrencyModifier::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Націнка до валют відносно курсу НБУ' ),
                'listTitle'         => _( 'Поточна націнка' ),
                'actionCreateUrl'   => NULL,
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => CurrencyModifier::getInstance(),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування' ),
                'formId'        => CurrencyModifier::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
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
                    _( 'Націнка до валют відносно курсу НБУ' )
                );
                break;

            case 'edit':
                $result = array(
                    _( 'Націнка до валют відносно курсу НБУ' ) => $this->createUrl( 'index' ),
                    _( 'Редагування' )
                );
                break;
        }

        return $result;
    }

    /**                                     FILTERS                                **/


    public function filters()
    {
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
                    'index', 'edit'
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