<?php
/**
 * @author Andriy Tolstokorov
 */

class ContactMessagesController extends BackendController
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
            'all'=>array(
                'class'         =>'application.actions.backend.ListAction',
                'model'         => new ContactMessage( 'search' ),
                'listHeaders'   => ContactMessage::getHeadersForListGrid(),
                'primaryField'  => 'id',
                'view'          => 'list',
                'partialView'   => '_list',
                'widgetFormId'  => 'table-form',
                'pageTitle'     => _( 'Повідомлення від користувачів' ),
                'listTitle'     => _( 'Всі повідомлення' ),
                'widgetWrapperId'       => 'pageHolder',
                'groupingCheckboxName'  => static::GROUP_IDS_VARIABLE,
                'dataProviderGetterMethod' => 'backendSearch',
                'actionCreateUrl'   => NULL,
            ),

            'unread' => array(
                'class'         =>'application.actions.backend.ListAction',
                'model'         => new ContactMessage( 'search' ),
                'listHeaders'   => ContactMessage::getHeadersForListGrid(),
                'primaryField'  => 'id',
                'view'          => 'list',
                'partialView'   => '_list',
                'widgetFormId'  => 'table-form',
                'pageTitle'     => _( 'Повідомлення від користувачів' ),
                'listTitle'     => _( 'Не прочитані повідомлення' ),
                'widgetWrapperId'       => 'pageHolder',
                'groupingCheckboxName'  => static::GROUP_IDS_VARIABLE,
                'dataProviderGetterMethod' => 'backendSearchNew',
                'actionCreateUrl'   => NULL,
            ),

            'delete' => array(
                'class'             => 'application.actions.backend.DeleteAction',
                'model'             => new ContactMessage(),
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
                'redirectUrl'   => $this->createUrl( 'all' ),
                'groupingCheckboxName' => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage' => 'Повідомлення видалено!',
                'flashWarningNoItems' => 'Нічого не відмічено!',
                'primaryId' => 'id',
                'tableModelClass' => 'ContactMessage'
            )

        );
    }

    public function actionView()
    {
        /** @var $messageModel ContactMessage */
        $messageModel = ContactMessage::model()->findByPk( getParam( 'id' ) );
        if ( $messageModel->is_new )
        {
            $messageModel->is_new = 0;
            $messageModel->save();
        }

        $this->render(
            'view',
            array(
                'model' => $messageModel
            )
        );
    }

    protected function getBreadCrumbs( $actionId )
    {
        $result = array();

        switch ( $actionId )
        {
            case 'all' :
                $result = array(
                    _( 'Всі повідомлення від користувачів' )
                );
            break;

            case 'new' :
                $result = array(
                    _( 'Нові повідомлення від користувачів' )
                );
            break;

            case 'view':
                $result = array(
                    _( 'Повідомлення від користувачів' ) => $this->createUrl( 'all' ),
                    _( 'Перегляд повідомлення' )
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
                    'all', 'unread', 'view'
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