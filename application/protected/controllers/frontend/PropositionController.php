<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class PropositionController extends FrontendController
{

    public function actionIndex()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::HOT_PROPOSITION )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();

        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        /** @var $dataProvider CDataProvider */
        $dataProvider = Propositions::model()->frontendSearch();

        $models = $dataProvider->getData();
        /** @var $pagination CPagination */
        $pagination = $dataProvider->getPagination();

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Акційні пропозиції'
        );

        $this->render(
            'index',
            array(
                'pageModel' => $pageModel,
                'models' => $models,
                'pagination' => $pagination
            )
        );
    }

    public function actionShow( $key, $id )
    {
        $pageModel = Propositions::model()->findByPk( $id );

        if ( !$pageModel )
        {
            throw new CHttpException( '404' );
        }

        $this->pageTitle .= ' - Акційні пропозиції - ' . $pageModel->getTitle();

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Акційні пропозиції' => $this->createUrl( 'index' ),
            $pageModel->getTitle()
        );

        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $models = Propositions::model()
            ->last( Yii::app()->params[ 'frontend'][ 'itemsPerPage' ] )
            ->notIn( array( $id ) )
            ->findAllByAttributes( array( 'is_visible' => TRUE ) );

        $this->render(
            'show',
            array(
                'pageModel' => $pageModel,
                'models' => $models
            )
        );
    }
}