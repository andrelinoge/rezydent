<?php
/**
 * @author Andriy Tolstokorov
 */

class SubscribersController extends BackendController
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

        return array(
            'index'=>array(
                'class'         =>'application.actions.backend.ListAction',
                'model'         => new Subscribers( 'search' ),
                'listHeaders'   => Subscribers::getHeadersForListGrid(),
                'primaryField'  => 'id',
                'view'          => 'list',
                'partialView'   => '_list',
                'widgetFormId'  => 'table-form',
                'pageTitle'     => _( 'Підписники на розсилку' ),
                'listTitle'     => _( 'Списки' ),
                'widgetWrapperId'       => 'pageHolder',
                'groupingCheckboxName'  => static::GROUP_IDS_VARIABLE,
                'dataProviderGetterMethod' => 'backendSearch',
                'actionCreateUrl'   => NULL,
            ),

            'delete' => array(
                'class'             => 'application.actions.backend.DeleteAction',
                'model'             => new Subscribers(),
                'deleteCriteria'    => 'id = :itemId',
                'deleteParams'      => array( ':itemId' => getParam( 'id' ) ),
                'nonAjaxRedirect'   => $this->createUrl( 'index' ),
                'isMultilingual'    => FALSE
            ),

            /**
             * Delete group of items
             */
            'groupDelete' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => TRUE,
                'redirectUrl'   => $this->createUrl( 'index' ),
                'groupingCheckboxName' => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage' => 'Повідомлення видалено!',
                'flashWarningNoItems' => 'Нічого не відмічено!',
                'primaryId' => 'id',
                'tableModelClass' => 'Subscribers'
            )

        );
    }

    public function actionMassDelivery()
    {
        $this->setModel( new MassDeliveryForm() );
        if ( isPostOrAjaxRequest() )
        {
            /** @var $model MassDeliveryForm */
            $model = $this->getModel();
            $model->receiverEmail = Subscribers::getEmails( Yii::app()->params[ 'emails' ][ 'limitForSend' ] );
            $this->setModel( $model );

            $this->ajaxResponseErrorMessage = _( 'Пропущені деякі необхідні поля.' );
            $this->ajaxResponseSuccessMessage = _( 'Листи відправлені.');

            $this->process();
        }

        $this->render(
            'mass-delivery',
            array(
                'model' => $this->getModel(),
                'formId' => MassDeliveryForm::FORM_ID
            )
        );
    }
    public function actionManualDelivery()
    {
        $this->render(
            'list-for-manual',
            array(
                'pageTitle' => 'Підписники на розсилку',
                'listTitle' => 'для ручної розсилки',
                'text' => Subscribers::getEmailsString(),
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
                    _( 'Перелік підписників' )
                );
                break;

            case 'MassDelivery' :
                $result = array(
                    _( 'Масова розсилка' )
                );
                break;

            case 'manualDelivery':
                $result = array(
                    _( 'Перелік підписників для ручної розсилки' )
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
                    'index', 'MassDelivery', 'manualDelivery', 'delete', 'groupDelete'
                ),
                'roles' => array( 'admin' )
            ),

            array(
                'deny',
                'users' => array( '*' ),
            ),
        );
    }
}