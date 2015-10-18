<?php

class SiteController extends BackendController
{

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
            {
                echo $error['message'];
            }
			else
            {
                $this->render('error', $error);
            }
		}
	}

    public function actionAddDefAdmin( $email = NULL )
    {
        $admin = new User();
        $admin->role = WebUser::ROLE_ADMIN;
        $admin->password = '1111';
        $admin->first_name = 'admin';
        $admin->last_name = 'admin';
        $admin->salt = '1111';
        $admin->sex = User::SEX_MALE;

        $admin->email = ( empty( $email ) ) ? 'def.admin@mail.com' : $email;

        try
        {
            $admin->save();
            echo 'login: ' . $admin->email . '<br> pass: 1111';
        }
        catch(Exception $e )
        {

        }
    }

    public function actionRemoveDefAdmin( $email = NULL )
    {
        $model = User::model()->findAllByAttributes( array( 'email' => ( empty( $email ) ) ? 'def.admin@mail.com' : $email ) );
        if ( $model )
        {
            $model->delete();
        }
    }

	public function actionLogin()
	{
		$model = $this->createModel( 'LoginForm' );

        if ( isPostOrAjaxRequest() ) {
            if ( isset( $_POST[ 'LoginForm' ] ) ) {
                $model->attributes = $_POST[ 'LoginForm' ];

                if ( $model->validate() ) {
                    $model->login();
                }

                if ( isAjax() ) {
                    if ( $model->hasErrors() ) { // was validation errors
                        $this->validationErrorsAjaxResponse(
                            $model,
                            FALSE
                        );
                    } else { // success
                        if ( Yii::app()->user->returnUrl ) {
                            $response[ 'redirect' ] = Yii::app()->user->returnUrl;
                        } else {
                            $response[ 'redirect' ] = $this->createUrl( 'index' );
                        }
                        $this->successfulAjaxResponse( $response );
                    }
                } else {
                    $this->setModel( $model );
                }
            }
        }

        $this->setLayout( 'login-backend' );
		$this->render(
            'login',
            array(
                'model' => $this->getModel()
            )
        );
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

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
                    'index'
                ),
                'roles' => array( 'admin' )
            ),

	        array(
                'allow',
                'actions' => array( 'logout' ),
                'users' => array( '@' ),
            ),

            array(
                'allow',
                'actions' => array( 'changeLocale', 'error', 'login', 'AddDefAdmin' ),
                'users' => array( '*' ),
            ),

            array(
                'deny',
                'users' => array( '*' ),
            ),
        );
    }
}
