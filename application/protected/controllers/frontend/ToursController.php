<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class ToursController extends FrontendController
{

    public function actionIndex()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::TOURS )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'index',
            array(
                'pageModel' => $pageModel
            )
        );
    }

    public function actionChildren()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::TOURS_CHILDREN )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->render(
            'children',
            array(
                'pageModel' => $pageModel,
                'toursModels' => ToursChildrenCatalog::model()->with( 'tours' )->findAll()
            )
        );
    }

    public function actionChildrenShow( $key, $id )
    {
        $pageModel = ToursChildren::model()->with( 'catalog' )->findByPk( $id );

        $this->pageTitle .= ' - Тури для дітей - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Тури для дітей' => $this->createUrl( 'children' ),
            $pageModel->getCatalog()->getValue()
        );

        $this->render(
            'show',
            array(
                'pageModel' => $pageModel
            )
        );
    }

    public function actionAbroad()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::TOURS_ABROAD )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'abroad',
            array(
                'pageModel' => $pageModel,
                'toursModels' => ToursAbroad::model()->findAll()
            )
        );
    }

    public function actionAbroadShow( $key, $id )
    {
        $pageModel = ToursAbroad::model()->findByPk( $id );

        $this->pageTitle .= ' - Екскурсії за кордон - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Екскурсії за кордон' => $this->createUrl( 'abroad' ),
            $pageModel->getCountry()
        );

        $this->render(
            'show-abroad',
            array(
                'pageModel' => $pageModel,
            )
        );
    }

    public function actionUkraine()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::TOURS_UKRAINE )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'ukraine',
            array(
                'pageModel' => $pageModel,
                'toursModels' => ToursUkraineCatalog::model()->with( 'tours' )->findAll()
            )
        );
    }

    public function actionUkraineShow( $key, $id )
    {
        $pageModel = ToursUkraine::model()->with( 'catalog' )->findByPk( $id  );

        $this->pageTitle .= ' - Відпочинок в Україні - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Відпочинок в Україні' => $this->createUrl( 'ukraine' ),
            $pageModel->getCatalog()->getValue()
        );

        $this->render(
            'show',
            array(
                'pageModel' => $pageModel
            )
        );
    }

    public function actionHealth()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::TOURS_HEALTH )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'health',
            array(
                'pageModel' => $pageModel,
                'toursModels' => ToursHealthCatalog::model()->with( 'tours' )->findAll()
            )
        );
    }

    public function actionHealthShow( $key, $id )
    {
        $pageModel = ToursHealth::model()->with( 'catalog' )->findByPk( $id );

        $this->pageTitle .= ' - Лікувальні тури - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Лікувальні тури' => $this->createUrl( 'health' ),
            $pageModel->getCatalog()->getValue()
        );

        $this->render(
            'show',
            array(
                'pageModel' => $pageModel
            )
        );
    }

}