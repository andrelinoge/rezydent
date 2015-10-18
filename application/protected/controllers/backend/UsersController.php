<?php
/**
 * @author Andriy Tolstokorov
 */

class UsersController extends BackendController
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
        $model = new User( 'search' );

        $tripModel = new Trip( 'search' );

        $messagesModel = new Messages( 'search' );

        $complaintsModel = new UserComplaints( 'search' );

        if ( $userId = getParam( 'userId', FALSE ) )
        {
            $tripModel->owner_id = $userId;
            $messagesModel->userId = $userId; // id of target user ( sender or receiver - no matter )
            $complaintsModel->on_id = $userId;
        }

        return array(
            'admins'=>array(
                'class'         =>'application.actions.backend.ListAction',
                'model'         => $model,
                'listHeaders'   => $model::getHeadersForListGrid(),
                'primaryField'  => 'id',
                'view'          => 'list',
                'partialView'   => '_list',
                'widgetFormId'  => 'table-form',
                'pageTitle'     => _( 'Адміністрація сайту' ),
                'listTitle'     => _( 'Всі адміністратори' ),
                'widgetWrapperId'       => 'pageHolder',
                'groupingCheckboxName'  => static::GROUP_IDS_VARIABLE,
                'dataProviderGetterMethod' => 'backendSearch',
                'actionCreate'   => 'addAdmin',
                'actionEdit'   => 'editAdmin',
                'actionDelete' => 'deleteAdmin',
                'actionGroupDeleteUrl' => $this->createUrl( 'groupDeleteAdmins' )
            ),

            'addAdmin' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => AdminUserForm::getInstance(),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Новий адміністратор' ),
                'formId'        => AdminUserForm::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'admins' ),
            ),

            'editAdmin' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => AdminUserForm::getInstance( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування даних адміністратора' ),
                'formId'        => AdminUserForm::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'deleteAdmin' => array(
                'class'             => 'application.actions.backend.DeleteAction',
                'model'             => $model,
                'deleteCriteria'    => 'id = :itemId',
                'deleteParams'      => array( ':itemId' => getParam( 'id' ) ),
                'nonAjaxRedirect'   => $this->createUrl( 'index' ),
                'isMultilingual'    => FALSE
            ),

            'groupDeleteAdmins' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'admins' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( 'Статтю видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'User'
            ),

            'users'=>array(
                'class'         =>'application.actions.backend.ListAction',
                'model'         => $model,
                'listHeaders'   => $model::getUserHeadersForListGrid(),
                'listFilters'   => $model::getUsersFiltersForListGrid(),
                'primaryField'  => 'id',
                'view'          => 'list-users',
                'partialView'   => '_list-users',
                'widgetFormId'  => 'table-form',
                'pageTitle'     => _( 'Користувачі сайту' ),
                'listTitle'     => _( 'Всі користувачі' ),
                'widgetWrapperId'       => 'pageHolder',
                'groupingCheckboxName'  => static::GROUP_IDS_VARIABLE,
                'actionEdit'   => 'editUser',
                'actionDelete' => 'deleteUser',
                'actionGroupDeleteUrl' => $this->createUrl( 'groupDeleteUsers' )
            ),

            'deleteUser' => array(
                'class'             => 'application.actions.backend.DeleteAction',
                'model'             => $model,
                'deleteCriteria'    => 'id = :itemId',
                'deleteParams'      => array( ':itemId' => getParam( 'id' ) ),
                'nonAjaxRedirect'   => $this->createUrl( 'users' ),
                'isMultilingual'    => FALSE
            ),

            'groupDeleteUsers' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'users' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( ' користувача видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'User'
            ),

            //      Trips
            'trips' => array(
                'class'         =>'application.actions.backend.ListAction',
                'model'         => $tripModel,
                'listHeaders'   => $tripModel::getHeadersForListGrid(),
                'listFilters'   => $tripModel::getFiltersForListGrid(),
                'primaryField'  => 'id',
                'view'          => 'trips',
                'partialView'   => '_trips',
                'widgetFormId'  => 'table-form',
                'pageTitle'     => _( 'Оголошення користувача' ),
                'listTitle'     => _( 'Всі оголошення' ),
                'widgetWrapperId'       => 'pageHolder',
                'groupingCheckboxName'  => static::GROUP_IDS_VARIABLE,
                'dataProviderGetterMethod' => 'getUserTrips',
                'actionEdit'   => '',
                'actionDelete' => 'deleteTrip',
                'actionGroupDeleteUrl' => $this->createUrl( 'groupDeleteTrips' )
            ),

            'deleteTrip' => array(
                'class'             => 'application.actions.backend.DeleteAction',
                'model'             => $tripModel,
                'deleteCriteria'    => 'id = :itemId',
                'deleteParams'      => array( ':itemId' => getParam( 'id' ) ),
                'nonAjaxRedirect'   => $this->createUrl( 'trips', array( 'userId' => $userId ) ),
                'isMultilingual'    => FALSE
            ),

            'groupDeleteTrips' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'trips', array( 'userId' => $userId ) ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( ' оголошення видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'Trip'
            ),

            // Messages
            'messages' => array(
                'class'         =>'application.actions.backend.ListAction',
                'model'         => $messagesModel,
                'listHeaders'   => $messagesModel::getHeadersForListGrid(),
                'listFilters'   => $messagesModel::getFiltersForListGrid(),
                'primaryField'  => 'id',
                'view'          => 'messages',
                'partialView'   => '_messages',
                'widgetFormId'  => 'table-form',
                'pageTitle'     => _( 'Повідомлення користувача' ),
                'listTitle'     => _( 'Всі Повідомлення' ),
                'widgetWrapperId'       => 'pageHolder',
                'groupingCheckboxName'  => static::GROUP_IDS_VARIABLE,
                'dataProviderGetterMethod' => 'getUserMessages',
                'actionEdit'   => '',
                'actionDelete' => '',
                'actionGroupDeleteUrl' => $this->createUrl( 'users' )
            ),

            //      Complaints
            'complaints' => array(
                'class'         =>'application.actions.backend.ListAction',
                'model'         => $complaintsModel,
                'listHeaders'   => $complaintsModel::getHeadersForListGrid(),
                'listFilters'   => $complaintsModel::getFiltersForListGrid(),
                'primaryField'  => 'id',
                'view'          => 'complaints',
                'partialView'   => '_complaints',
                'widgetFormId'  => 'table-form',
                'pageTitle'     => _( 'Скарги на користувача' ),
                'listTitle'     => _( 'Всі сарги' ),
                'widgetWrapperId'       => 'pageHolder',
                'groupingCheckboxName'  => static::GROUP_IDS_VARIABLE,
                'dataProviderGetterMethod' => 'retrieveComplaints',
                'actionEdit'   => '',
                'actionDelete' => 'deleteComplaint',
                'actionGroupDeleteUrl' => $this->createUrl( 'groupDeleteComplaints' )
            ),

            'deleteComplaint' => array(
                'class'             => 'application.actions.backend.DeleteAction',
                'model'             => $complaintsModel,
                'deleteCriteria'    => 'id = :itemId',
                'deleteParams'      => array( ':itemId' => getParam( 'id' ) ),
                'nonAjaxRedirect'   => $this->createUrl( 'complaints', array( 'userId' => $userId ) ),
                'isMultilingual'    => FALSE
            ),

            'groupDeleteComplaints' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'complaints', array( 'userId' => $userId ) ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( 'Скарги видалені!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'UserComplaints'
            ),
        );
    }

    public function actionEditUser()
    {
        $userId = getParam( 'id', FALSE );

        $user = User::model()->findByPk( $userId );

        if ( !$user )
        {
            throw new CHttpException( 404 );
        }

        $form = UserForm::getInstance( $userId );
        $this->setModel( $form );
        if ( isPostOrAjaxRequest() )
        {
            $this->processUpdate();
        }

        $this->render(
            'edit-user',
            array(
                'model'         => $this->getModel(),
                'pageTitle'     => 'Редагуання користувача',
                'formId'        => $form::FORM_ID,
                'formView'      => '_user-form',
                'formAction'    => '',
                'innerLinks'    => NULL,
                'changeUserAvatarHandlerUrl'
                    => $this->createAbsoluteUrl( 'changeUserAvatarHandler', array( 'userId' => $user->id ) ),
                'user' => $user
            )
        );
    }

    public function actionMessage( $id )
    {
        $message = Messages::model()->with( 'sender', 'receiver' )->findByPk( $id );

        $this->breadcrumbs = array(
            _( 'Користувачі' ) => $this->createUrl( 'users' ),
            'Перегляд повідомлення'
        );

        $this->render(
            'message',
            array(
                'message' => $message
            )
        );
    }

    public function actionView( $userId )
    {
        /** @var $user User */
        if ( !( $user = User::model()->findByPk( $userId ) ) )
        {
            throw new CHttpException( 404 );
        }

        /** @var $trip Trip */
        $photos = Photos::getUserPhotos( $userId );

        $this->breadcrumbs = array(
            _( 'Користувачі' ) => $this->createUrl( 'users' ),
            $user->getFirstName() . ' - профайл'
        );

        $this->render(
            'view',
            array(
                'photos' => $photos,
                'user' => $user,
                'lastTrips' => Trip::model()
                    ->byOwner( $userId )
                    ->last( Yii::app()->params[ 'backend' ][ 'lastTripsInView' ] )
                    ->findAll(),
                'lastComplaints' => UserComplaints::model()
                    ->with( 'fromUser' )
                    ->onUser( $userId )
                    ->last( Yii::app()->params[ 'backend' ][ 'lastComplaintsInView' ] )
                    ->findAll()
            )
        );
    }

    public function actionTrip( $id )
    {
        /** @var $trip Trip */
        $trip = Trip::model()->findByPk( $id );

        /** @var $user User */
        $user = User::model()->findByPk( $trip->owner_id );

        $this->breadcrumbs = array(
            _( 'Користувачі' ) => $this->createUrl( 'users' ),
            $user->getFirstName() . ' - подорожі' => $this->createUrl( 'trips', array( 'userId' => $user->id ) ),
            'Перегляд подорожі'
        );

        $this->render(
            'trip',
            array(
                'trip' => $trip,
                'user' => $user
            )
        );
    }

    public function actionComplaint( $id )
    {
        /** @var $model UserComplaints */
        $complaint = UserComplaints::model()->with( 'fromUser' )->findByPk( $id );

        /** @var $user User */
        $user = User::model()->findByPk( $complaint->on_id );

        $this->breadcrumbs = array(
            _( 'Користувачі' ) => $this->createUrl( 'users' ),
            $user->getFirstName() . ' - скарги' => $this->createUrl( 'complaints', array( 'userId' => $user->id ) ),
            'Перегляд скарги'
        );

        $this->render(
            'complaint',
            array(
                'complaint' => $complaint,
                'user' => $user
            )
        );
    }

    public function actionChangeUserAvatarHandler()
    {
        $userId = getParam( 'userId' );

        if ( $user = User::model()->findByPk( $userId ) )
        {
            if ( $user->changeAvatar() )
            {
                $this->successfulAjaxResponse(
                    $user->getResponse()
                );
            }
            else
            {
                $this->unsuccessfulAjaxResponse(
                    $user->getResponse()
                );
            }
        }
    }

    public function actionChangeCurrentPassword()
    {
        $formModel = new ChangePasswordForm();
        $formModel->setUserModel( User::getCurrentUser() );

        $this->setModel( $formModel );

        if ( isPostOrAjaxRequest() )
        {
            $this->setAjaxResponseSuccessMessage( 'Пароль змінено' );
            $this->setAjaxResponseErrorMessage( 'Дані введено не вірно!' );

            $this->process();
        }

        $this->render(
            'change-password',
            array(
                'pageTitle' => _( 'Зміна паролю для поточного користувача'),
                'model' => $this->getModel(),
                'formId' => $formModel::FORM_ID
            )
        );
    }

    public function actionDeletePhotoHandler()
    {
        if ( $model = Photos::model()->findByPk( getParam( 'id' ) ) )
        {
            $model->delete();

            $this->successfulAjaxResponse();
        }
        else
        {
            $this->unsuccessfulAjaxResponse();
        }
    }

    public function actionChangeBanStatusHandler()
    {
        $newStatus = '';
        /** @var $user User */
        if ( $user = User::model()->findByPk( getParam( 'id', 0 ) ) )
        {
            if ( $user->is_banned )
            {
                $user->is_banned = FALSE;
                $newStatus = 'розблокований';
                $user->save();
            }
            else
            {
                $user->is_banned = TRUE;
                $newStatus = 'заблокований';
                $user->save();
            }

            $this->successfulAjaxResponse(
                array(
                    'newUserStatus' => $newStatus
                )
            );
        }
    }

    protected function getBreadCrumbs( $actionId )
    {
        $result = array();

        switch ( $actionId )
        {
            case 'admins' :
                $result = array(
                    _( 'Адміністратори' )
                );
            break;

            case 'addAdmin' :
                $result = array(
                    _( 'Адміністратори' ) => $this->createUrl( 'admins' ),
                    _( 'Новий адміністратор' )
                );
            break;

            case 'editAdmin' :
                $result = array(
                    _( 'Адміністратори' ) => $this->createUrl( 'admins' ),
                    _( 'Редагування адміністратора' )
                );
                break;

            case 'ChangeCurrentPassword':
                $result = array(
                    _( 'Адміністратори' ) => $this->createUrl( 'admins' ),
                    _( 'Зміна поточного паролю' )
                );
                break;

            case 'users' :
                $result = array(
                    _( 'Користувачі' )
                );
            break;

            case 'editUser' :
                $result = array(
                    _( 'Користувачі' ) => $this->createUrl( 'users' ),
                    _( 'Редагування користувача' )
                );
            break;

            case 'trips' :
                if ( $user = User::model()->findByPk( getParam( 'userId', 0 ) ) )
                {
                    $result = array(
                        _( 'Користувачі' ) => $this->createUrl( 'users' ),
                        $user->getFirstName() => $this->createUrl( 'view', array( 'userId' => $user->id ) ),
                        _( 'Оголошення користувача' )
                    );
                }
                else
                {
                    $result = array(
                        _( 'Користувачі' ) => $this->createUrl( 'users' ),
                        _( 'Оголошення користувача' )
                    );
                }

            break;

            case 'complaints' :
                if ( $user = User::model()->findByPk( getParam( 'userId', 0 ) ) )
                {
                    $result = array(
                        _( 'Користувачі' ) => $this->createUrl( 'users' ),
                        $user->getFirstName() => $this->createUrl( 'view', array( 'userId' => $user->id ) ),
                        _( 'Скарги на користувача' )
                    );
                }
                else
                {
                    $result = array(
                        _( 'Користувачі' ) => $this->createUrl( 'users' ),
                        _( 'Скарги на користувача' )
                    );
                }

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
                    'admins', 'addAdmin', 'editAdmin', 'deleteAdmin', 'ChangeCurrentPassword',
                    'users', 'editUser', 'deleteUser', 'groupDeleteUsers', 'groupDeleteAdmins', 'ChangeUserAvatarHandler',
                    'trips', 'trip', 'deleteTrip', 'groupDeleteTrips', 'view', 'DeletePhotoHandler', 'messages',
                    'message', 'complaints', 'deleteComplaint', 'groupDeleteComplaints', 'complaint', 'changeBanStatusHandler'
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