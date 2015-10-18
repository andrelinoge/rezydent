<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class TicketsController extends FrontendController
{

    public function actionIndex()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::TICKETS )->find();

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

    public function actionAir()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::TICKETS_AIR )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Пошук квитків' => $this->createUrl( 'index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'air',
            array(
                'pageModel' => $pageModel
            )
        );
    }

    public function actionTrain()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::TICKETS_TRAIN )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Пошук квитків' => $this->createUrl( 'index' ),
            $pageModel->getTitle()
        );

        $this->render(
            'train',
            array(
                'pageModel' => $pageModel
            )
        );
    }
}