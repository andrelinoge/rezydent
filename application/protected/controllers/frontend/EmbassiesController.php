<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class EmbassiesController extends FrontendController
{

    public function actionIndex()
    {
        /** @var $pageModel StaticPages */
        $pageModel = StaticPages::model()
            ->byPageId( StaticPages::EMBASSIES )
            ->find();

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

        $countriesWithVisa = Embassies::model()->findAllByAttributes( array( 'catalog_id' => Embassies::WITH_VISA ) );
        $countriesWithoutVisa = Embassies::model()->findAllByAttributes( array( 'catalog_id' => Embassies::WITHOUT_VISA ) );

        $this->render(
            'index',
            array(
                'pageModel' => $pageModel,
                'countriesWithVisa' => $countriesWithVisa,
                'countriesWithoutVisa' => $countriesWithoutVisa
            )
        );
    }

    public function actionWithVisa()
    {
        $pageTitle = 'Візові країни';
        $this->pageTitle .= ' Візи та консульства - ' . $pageTitle;

        $models = Embassies::model()->findAllByAttributes( array( 'catalog_id' => Embassies::WITH_VISA ) );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Візи та посольства' => $this->createUrl( 'index' ),
            $pageTitle
        );

        $this->render(
            'sub-page',
            array(
                'models' => $models,
                'pageTitle' => $pageTitle
            )
        );
    }

    public function actionWithoutVisa()
    {
        $pageTitle = 'Безвізові країни';
        $this->pageTitle .= ' - Візи та консульства - ' . $pageTitle;

        $models = Embassies::model()->findAllByAttributes( array( 'catalog_id' => Embassies::WITHOUT_VISA ) );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Візи та посольства' => $this->createUrl( 'index' ),
            $pageTitle
        );

        $this->render(
            'sub-page',
            array(
                'models' => $models,
                'pageTitle' => $pageTitle
            )
        );
    }

    public function actionShow( $key, $id )
    {
        /** @var $pageModel Embassies */
        $pageModel = Embassies::model()->with( 'catalog' )->findByPk( $id );

        $this->pageTitle .= ' - Візи та консульства - ' . $pageModel->getTitle();
        /** @var $cs CClientScript */
        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Головна' => $this->createUrl( 'site/index' ),
            'Візи та посольства' => $this->createUrl( 'index' ),
            $pageModel->getCountry()
        );

        $this->render(
            'show',
            array(
                'pageModel' => $pageModel
            )
        );
    }
}