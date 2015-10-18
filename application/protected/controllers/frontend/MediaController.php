<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class MediaController extends FrontendController
{

    public function actionIndex( $year = NULL )
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::MEDIA )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();

        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        /** @var $dataProvider CDataProvider */
        $dataProvider = Media::model()->frontendSearch( $year );

        $models = $dataProvider->getData();
        /** @var $pagination CPagination */
        $pagination = $dataProvider->getPagination();

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Фото та відео'
        );

        $this->render(
            'index',
            array(
                'pageModel' => $pageModel,
                'models' => $models,
                'archiveYears' => Media::getYearsForArchive(),
                'pagination' => $pagination
            )
        );
    }

    public function actionShow( $key, $id )
    {
        $pageModel = Media::model()->findByPk( $id );

        $this->pageTitle .= ' - Фото та відео - ' . $pageModel->getTitle();

        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $lastNews = Media::model()
            ->last( Yii::app()->params[ 'frontend'][ 'itemsPerPage' ] )
            ->notIn( array( $id ) )
            ->findAll();

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Фото та відео' => $this->createUrl( 'index' ),
            $pageModel->getTitle( 100, TRUE )
        );

        $this->render(
            'show',
            array(
                'pageModel' => $pageModel,
                'lastModels' => $lastNews,
                'archiveYears' => Media::getYearsForArchive()
            )
        );
    }

    public function getMonth( $id )
    {
        $monthData = array(
            'Січня',
            'Лютого',
            'Березня',
            'Квітня',
            'Травня',
            'Червня',
            'Липня',
            'Серпня',
            'Вересня',
            'Жовтня',
            'Листопада',
            'Грудня',
        );

        $id -= 1;

        if ( $id > 12 || $id < 0 )
        {
            $id  = 0;
        }

        return $monthData[ $id ];
    }
}