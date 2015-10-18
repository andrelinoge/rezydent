<?php
/**
 * @author Andriy Tolstokorov
 */

class TouristDatingController extends FrontendController
{

    public function init()
    {
        parent::init();
        $this->setLayout( 'dating' );
    }

    public function actionIndex()
    {
        $model = new Trip( 'search' );

        if( isset( $_POST[ 'Trip' ] ) )
        {
            $model->attributes = $_POST[ 'Trip' ];
            $_GET += $_POST;
        }
        elseif( isset( $_GET[ 'Trip' ] ) )
        {
            $model->attributes = $_GET[ 'Trip' ];
        }

        $model->frontendSearch();

        if ( isPostOrAjaxRequest() )
        {
            $html = $this->renderPartial(
                '_index',
                array(
                    'trips' => $model->getData(),
                    'pagination' => $model->getPagination(),
                ),
                TRUE
            );

            $this->successfulAjaxResponse( array( 'html' => $html ) );
        }
        else
        {
            $this->breadcrumbs = array(
                'Головна' => $this->createUrl( 'site/index' ),
                'Туристичні знайомства'
            );

            $pageModel = StaticPages::model()->byPageId( StaticPages::TOURIST_DATING )->find();

            $this->pageTitle .= ' - ' . $pageModel->getTitle();

            /** @var $cs CClientScript */
            Yii::app()
                ->getClientScript()
                ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
                ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

            $this->render(
                'index',
                array(
                    'model' => $model,
                    'trips' => $model->getData(),
                    'pageModel' => $pageModel,
                    'pagination' => $model->getPagination(),
                )
            );
        }
    }

    public function actionTripsPaginationHandler()
    {
        $model = new Trip();

        if( isset( $_GET[ 'Trip' ] ) )
        {
            $model->attributes = $_GET[ 'Trip' ];
        }

        $model->frontendSearch();

        $this->renderPartial(
            '_index',
            array(
                'trips' => $model->getData(),
                'pagination' => $model->getPagination(),
            )
        );
    }

    public function actionLoginHandler()
    {
        $model = new LoginForm();

        if ( isPostOrAjaxRequest() )
        {
            if ( isset( $_POST[ 'LoginForm' ] ) )
            {
                $model->attributes = $_POST[ 'LoginForm' ];

                if ( $model->validate() )
                {
                    if ( !$model->isUserBanned() )
                    {
                        $model->login();
                    }
                    else
                    {
                        $response[ 'redirect' ] = $this->createUrl( 'banned' );
                        $this->successfulAjaxResponse( $response );
                    }
                }

                if ( isAjax() )
                {
                    if ( $model->hasErrors() )
                    {
                        $this->validationErrorsAjaxResponse(
                            $model,
                            FALSE
                        );
                    }
                    else
                    {
                        $response[ 'redirect' ] = Yii::app()->getRequest()->getUrlReferrer();
                        $this->successfulAjaxResponse( $response );
                    }
                }
            }
        }
    }

    public function actionRegistrationHandler()
    {
        $this->setModel( new RegistrationForm() );

        if ( isPostOrAjaxRequest() )
        {
            $this->setAjaxResponseSuccessMessage( 'Реєстрація пройдена успішно!' );
            $this->setRedirectUrl( $this->createUrl( 'index' ) );
            $this->process();
        }
    }

    public function actionRestorePasswordHandler()
    {
        $this->setModel( new RestorePasswordForm() );

        if ( isPostOrAjaxRequest() )
        {
            $this->setAjaxResponseSuccessMessage( 'Новий пароль надісланий на ваш email' );
            $this->process();
        }
    }

    public function actionView( $id )
    {
        /** @var $user User */
        if ( !( $user = User::model()->findByPk( $id ) ) )
        {
            throw new CHttpException( 404, 'Сторінка не знайдена' );
        }

        $this->pageTitle .= ' - Туристичні знайомства - ' . $user->getFirstName();

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            $user->getFirstName()
        );

        $messageForm = new MessageForm();
        $messageForm->setReceiverId( $id );

        $complaintForm = new ComplaintForm();
        $complaintForm->setOnId( $id );

        $this->render(
            'view',
            array(
                'user' => $user,
                'country' => $user->getCountry(),
                'city' => $user->getCity(),
                'languages' => $user->getLanguages(),
                'contacts' => $user->getContacts(),
                'about' => $user->getAbout(),
                'countOfPhotos' => Photos::getCountOfPhotos( $id ),
                'messageForm' => $messageForm,
                'sendMessageHandlerUrl' => $this->createUrl( 'SendMessageHandler' ),
                'complaintForm' => $complaintForm
            )
        );
    }

    public function actionBanned()
    {
        if ( !Yii::app()->user->isGuest )
        {
            $this->redirect( 'index' );
        }

        $pageModel = StaticPages::model()->byPageId( StaticPages::ACCOUNT_BANNED )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();

        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            'Кабінет'
        );

        $this->setModel( new ContactForm() );

        if ( isPostOrAjaxRequest() )
        {
            $this->setAjaxResponseSuccessMessage( 'Ваше повідомлення надіслане!' );
            $this->process();
        }

        $this->render(
            'banned',
            array(
                'formModel' => $this->getModel(),
                'pageModel' => $pageModel
            )
        );
    }

    public function actionSettings()
    {
        $this->pageTitle .= ' - Туристичні знайомства - Налаштування';

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            'Налаштування'
        );

        $this->render(
            'settings',
            array(
                'changePasswordForm' => new ChangePasswordForm(),
                'changePasswordAction' => $this->createUrl( 'ChangePasswordHandler' ),
                'userModel' => Yii::app()->user->getModel(),
                'updateProfileAction' => $this->createUrl( 'UpdateProfileHandler' ),
                'maritalStatuses' => MaritalStatus::getOptions( 'Ваш сімейний стан' ),
                'sexOptions' => User::getSexOptions()
            )
        );
    }

    public function actionChangePasswordHandler()
    {
        $formModel = new ChangePasswordForm();
        $formModel->setUserModel( User::getCurrentUser() );

        $this->setModel( $formModel );

        $this->setAjaxResponseSuccessMessage( 'Пароль змінено' );
        $this->setAjaxResponseErrorMessage( 'Дані введено не вірно!' );

        $this->process();
    }

    public function actionUpdateProfileHandler()
    {
        if ( Yii::app()->user->isGuest )
        {
            throw new CHttpException( 404 );
        }

        /** @var $model User */
        $model = User::getCurrentUser();
        $model->setScenario( 'edit' );
        $this->setModel( $model );

        $this->setAjaxResponseSuccessMessage( 'Зміни збережені' );

        $this->process();
    }

    public function actionPhotos( $id )
    {
        /** @var $user User */
        $user = User::model()->findByPk( $id );
        if ( !$user )
        {
            throw new CHttpException( 404 );
        }

        $this->pageTitle .= ' - Туристичні знайомства - Фотографії користувача';

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            $user->getFirstName() => $this->createUrl( 'view', array( 'id' => $id ) ),
            'Фотографії'
        );

        $this->render(
            'photos',
            array(
                'photos' => Photos::getUserPhotos( $id )
            )
        );
    }

    public function actionMyPhotos()
    {
        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            'Мої фотографії'
        );

        $this->pageTitle .= ' - Туристичні знайомства - Мої фотографії';

        $this->render(
            'my-photos',
            array(
                'photos' => Photos::getUserPhotos( Yii::app()->user->id ),
                'photosUploadHandlerUrl' => $this->createUrl( 'UploadMyPhotosHandler' )
            )
        );
    }

    public function actionUploadMyPhotosHandler()
    {
        if ( Yii::app()->user->isGuest )
        {
            $this->unsuccessfulAjaxResponse(
                array(
                    'redirect_url' => $this->createUrl( 'index' )
                )
            );
        }
        else
        {
            try
            {
                $response = Photos::uploadPhoto( Yii::app()->user->id );
                $this->successfulAjaxResponse(
                    $response
                );
            }
            catch( Exception $e )
            {
                $this->unsuccessfulAjaxResponse(
                    array(
                        'errorMessage' => $e->getMessage()
                    )
                );
            }
        }
    }

    public function actionDeletePhotoHandler()
    {
        if ( $id = getParam( 'id', FALSE ) )
        {
            if ( $model = Photos::model()->findByPk( $id ) )
            {
                $model->delete();
                $this->successfulAjaxResponse();
            }
            else
            {
                $this->unsuccessfulAjaxResponse();
            }
        }
        else
        {
            $this->unsuccessfulAjaxResponse();
        }
    }

    public function actionMessages()
    {
        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Мої повідомлення'
        );

        $model = new Messages();
        $model->retrieveMessages( Messages::INCOMING );
        $incoming = $model->getData();
        $incomingPagination = $model->getPagination();
        $incomingCount = $model->getTotalItemCount();

        $model->retrieveMessages( Messages::OUTCOMING );
        $outcoming = $model->getData();
        $outcomingPagination = $model->getPagination();
        $outcomingCount = $model->getTotalItemCount();

        $this->render(
            'messages',
            array(
                'countOfNewMessages' => Messages::getCountOfNewMessage( Yii::app()->user->id ),
                'incoming' => $incoming,
                'incomingPagination' => $incomingPagination,
                'incomingCount' => $incomingCount,
                'outcoming' => $outcoming,
                'outcomingPagination' => $outcomingPagination,
                'outcomingCount' => $outcomingCount
            )
        );
    }

    public function actionViewMessage( $id )
    {
        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Мої повідомлення' => $this->createUrl( 'messages' ),
            'Перегляд повідомлення'
        );

        /** @var $model Messages */
        $model = Messages::model()->with( 'sender', 'receiver' )->findByPk( $id );

        if ( !$model )
        {
            throw new CHttpException( 404 );
        }

        $model->markAsRead();

        $user = ( $model->receiver_id == Yii::app()->user->id ) ? $model->getSender() : $model->getReceiver();

        $messageForm = new MessageForm();
        $messageForm->setReceiverId( $user->id );

        $this->render(
            'view-message',
            array(
                'model' => $model,
                'isReceived' => ( $model->receiver_id == Yii::app()->user->id ),
                'user' => $user,
                'messageForm' => $messageForm,
                'sendMessageHandlerUrl' => $this->createUrl( 'SendMessageHandler' )
            )
        );
    }

    public function actionIncomingMessagesPaginationHandler()
    {
        $model = new Messages();
        $model->retrieveMessages( Messages::INCOMING );

        $this->renderPartial(
            '_incoming',
            array(
                'messages' => $model->getData(),
                'pagination' => $model->getPagination()
            )
        );
    }

    public function actionOutcomingMessagesPaginationHandler()
    {
        $model = new Messages();
        $model->retrieveMessages( Messages::OUTCOMING );

        $this->renderPartial(
            '_outcoming',
            array(
                'messages' => $model->getData(),
                'pagination' => $model->getPagination()
            )
        );
    }

    public function actionSendMessageHandler()
    {
        $formModel = new MessageForm();

        $this->setModel( $formModel );

        $this->setAjaxResponseSuccessMessage( 'Повідомлення надіслано' );

        $this->process();
    }

    public function actionDeleteMessageHandler( )
    {
        $id = getParam( 'id' );
        Messages::deleteMessage( $id );

        $this->successfulAjaxResponse();
    }

    public function actionMyTrips()
    {
        $model = new Trip();
        $model->retrieveMyScheduledTrips();
        $scheduledTrips = $model->getData();

        $model->retrieveMyPastTrips();
        $pastTrips = $model->getData();
        $myPastTripsPagination = $model->getPagination();

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            'Мої поїздки'
        );

        $this->render(
            'my-trips',
            array(
                'scheduledTrips' => $scheduledTrips,
                'pastTrips' => $pastTrips,
                'myPastTripsPagination' => $myPastTripsPagination
            )
        );
    }

    public function actionCreateUpdateTrip( $id = NULL )
    {
        $model = new TripForm();

        $this->setAjaxResponseSuccessMessage( 'Поїздка запланована' );
        $this->setRedirectUrl( $this->createUrl( 'myTrips' ) );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            'Мої поїздки' => $this->createUrl( 'myTrips' ),
            'Планування поїздку'
        );

        if ( $id )
        {
            $this->breadcrumbs = array(
                'Головна' => $this->createUrl( 'site/index' ),
                'Туристичні знайомства' => $this->createUrl( 'index' ),
                'Мої поїздки' => $this->createUrl( 'myTrips' ),
                'Редагування поїздки'
            );

            $this->setAjaxResponseSuccessMessage( 'Зміни збережені' );
            $model->load( $id );
        }

        $this->setModel( $model );

        if ( isPostOrAjaxRequest() )
        {
            $this->process();
        }

        $this->render(
            'add-edit-trip',
            array(
                'model' => $this->getModel(),
                'purposeOptions' => TripPurpose::getOptions( 'Для' ),
                'withOptions' => TripWith::getOptions( 'Їду з' ),
                'companionOptions' => TripCompanion::getOptions( 'Шукаю' ),
                'countryOptions' => Country::getOptions( 'Їду в' )
            )
        );
    }

    public function actionDeleteTripHandler( )
    {
        $id = getParam( 'id' );
        Trip::model()->deleteByPk( $id );

        $this->successfulAjaxResponse();
    }

    public function actionMyPastTripsPaginationHandler()
    {
        $model = new Trip();
        $model->retrieveMyPastTrips();

        $this->renderPartial(
            '_my-past-trips',
            array(
                'trips' => $model->getData(),
                'pagination' => $model->getPagination()
            )
        );
    }

    public function actionMyTrip()
    {
        $id = getParam( 'id' );
        if ( !( $model = Trip::model()->findByPk( $id ) ) )
        {
            throw new CHttpException( 404 );
        }

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            'Мої поїздки' => $this->createUrl( 'myTrips' ),
            'Перегляд'
        );

        $model->increaseViews();

        $this->render(
            'my-trip',
            array(
                'model' => $model
            )
        );
    }

    public function actionTrips( $id )
    {
        if ( !Yii::app()->user->isGuest )
        {
            if ( $id == Yii::app()->user->id )
            {
                return $this->actionMyTrips();
            }
        }

        $model = new Trip();
        $model->retrieveScheduledTrips( $id );
        $scheduledTrips = $model->getData();

        $model->retrievePastTrips( $id );
        $pastTrips = $model->getData();
        $pastTripsPagination = $model->getPagination();

        /** @var $user User */
        $user = User::model()->findByPk( $id );

        $messageForm = new MessageForm();
        $messageForm->setReceiverId( $user->id );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            $user->getFirstName() => $this->createUrl( 'view', array( 'id' => $user->id ) ),
            'Поїздки'
        );

        $this->render(
            'trips',
            array(
                'scheduledTrips' => $scheduledTrips,
                'pastTrips' => $pastTrips,
                'pastTripsPagination' => $pastTripsPagination,
                'user' => $user,
                'countOfPhotos' => Photos::getCountOfPhotos( $user->id ),
                'messageForm' => $messageForm,
                'sendMessageHandlerUrl' => $this->createUrl( 'SendMessageHandler' )
            )
        );
    }

    public function actionPastTripsPaginationHandler( $id )
    {
        $model = new Trip();
        $model->retrievePastTrips( $id );

        $this->renderPartial(
            '_past-trips',
            array(
                'trips' => $model->getData(),
                'pagination' => $model->getPagination()
            )
        );
    }

    public function actionUploadAvatarHandler()
    {
        /** @var $user User */
        $user = Yii::app()->user->getModel();

        if ( !$user )
        {
            $this->unsuccessfulAjaxResponse(
                array(
                    'redirect_url' => $this->createUrl( 'index' )
                )
            );
        }
        else
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

    public function actionTrip( $id )
    {
        /** @var $user User */
        /** @var $mode Trip */

        if ( !( $model = Trip::model()->findByPk( $id ) ) )
        {
            throw new CHttpException( 404 );
        }

        $user = User::model()->findByPk( $model->owner_id );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Туристичні знайомства' => $this->createUrl( 'index' ),
            $user->getFirstName() => $this->createUrl( 'view', array( 'id' => $user->id ) ),
            'Поїздка'
        );

        $model->increaseViews();

        $messageForm = new MessageForm();
        $messageForm->setReceiverId( $user->id );

        $this->render(
            'trip',
            array(
                'model' => $model,
                'user' => $user,
                'countOfPhotos' => Photos::getCountOfPhotos( $user->id ),
                'messageForm' => $messageForm,
                'sendMessageHandlerUrl' => $this->createUrl( 'SendMessageHandler' )
            )
        );
    }

    public function actionComplaintHandler()
    {
        $formModel = new ComplaintForm();

        $this->setModel( $formModel );

        $this->setAjaxResponseSuccessMessage( 'Вашу скаргу прийнято!' );

        $this->process();
    }

    /**                                     FILTERS                                **/


    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + UploadAvatarHandler, UpdateProfileHandler, ChangePasswordHandler, RegistrationHandler',
            'ajaxOnly + RestorePasswordHandler, UploadMyPhotosHandler, DeletePhotoHandler, LoginHandler',
            'ajaxOnly + SendMessageHandler, IncomingMessagesPaginationHandler, OutcomingMessagesPaginationHandler',
            'ajaxOnly + DeleteMessageHandler, DeleteTripHandler, MyPastTripsPaginationHandler, PastTripsPaginationHandler',
            'ajaxOnly + ComplaintHandler'
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'index', 'view', 'photos', 'RegistrationHandler', 'RestorePasswordHandler',
                    'trips', 'trip', 'LoginHandler', 'PastTripsPaginationHandler', 'TripsPaginationHandler', 'banned'
                ),
                'users' => array( '*' )
            ),

            array(
                'allow',
                'actions' => array(
                    'settings', 'UploadAvatarHandler', 'UpdateProfileHandler', 'ChangePasswordHandler', 'myPhotos',
                    'UploadMyPhotosHandler', 'DeletePhotoHandler', 'myTrips', 'myTrip', 'SendMessageHandler', 'messages',
                    'IncomingMessagesPaginationHandler', 'OutcomingMessagesPaginationHandler', 'ViewMessage',
                    'DeleteMessageHandler', 'CreateUpdateTrip', 'DeleteTripHandler', 'MyPastTripsPaginationHandler',
                    'ComplaintHandler'
                ),
                'users' => array( '@' )
            ),

            // deny all for all users
            array(
                'deny',
                'users' => array( '*' ),
            ),
        );
    }
}
