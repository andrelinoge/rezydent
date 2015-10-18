<?php

class SiteController extends FrontendController
{

	public function actionIndex()
	{
        $this->setLayout( 'home-page' );
        $pageModel = StaticPages::model()->byPageId( StaticPages::HOME )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

		$this->render(
            'index',
            array(
                'pageModel' => $pageModel,

                'formSubscribe' => new SubscribeForm()
            )
        );
	}

    public function actionConsultationHandler()
    {
        if ( isPostOrAjaxRequest() )
        {
            $this->setModel( new ConsultationForm() );
            $this->setAjaxResponseSuccessMessage( 'Ваше повідомлення надіслане!' );
            $this->process();
        }
    }

    public function actionSubscribeHandler()
    {
        if ( isPostOrAjaxRequest() )
        {
            $this->setModel( new SubscribeForm() );
            $this->setAjaxResponseSuccessMessage( 'Ви підписалися на розсилку!' );
            $this->process();
        }
    }

	public function actionError()
	{
        $this->setLayout( 'error' );
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

	public function actionFaq()
    {
        $this->setLayout( 'faq' );
        $pageModel = StaticPages::model()->byPageId( StaticPages::FAQ )->find();
        $models = Faq::model()->findAll();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'faq',
            array(
                'pageModel' => $pageModel,
                'models' => $models,
                'formConsultation' => new ConsultationForm()
            )
        );
    }

    public function actionContact()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::CONTACT )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();

        $this->setModel( new ContactForm() );

        if ( isPostOrAjaxRequest() )
        {
            $this->setAjaxResponseSuccessMessage( 'Ваше повідомлення надіслане!' );
            $this->process();
        }

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'contact',
            array(
                'pageModel' => $pageModel,
                'formModel' => $this->getModel()
            )
        );
    }

    public function actionWork()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::WORK )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'work',
            array(
                'pageModel' => $pageModel
            )
        );
    }

    public function actionPassenger()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::PASSENGER )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'passenger',
            array(
                'pageModel' => $pageModel
            )
        );
    }

    public function actionTest()
    {
        $searcherForm = '';
        $this->render(
            'test',
            array(
            )
        );
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
                'minLength' => 3,
                'maxLength' => 4,
            )
        );
    }
}