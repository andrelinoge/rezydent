<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class WeatherController extends FrontendController
{

    const SEA_INFO_URL = 'http://www.meteoinfo.by/sea/';

    public function actionIndex()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::WEATHER )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();

        /** @var $cs CClientScript */

        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Погода на карті світу'
        );

        $this->render(
            'index',
            array(
                'pageModel' => $pageModel,
            )
        );
    }

    public function actionSea()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::WEATHER_SEA )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();

        /** @var $cs CClientScript */

        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );

        $this->breadcrumbs = array(
            'Погода на карті світу' => $this->createUrl( 'index' ),
            'Температура морів'
        );

        $seaTemperature = $this->getSeaTemperature();

        $this->render(
            'sea-temperature',
            array(
                'pageModel' => $pageModel,
                'seaTemperature' => $seaTemperature
            )
        );
    }

    public function actionResort()
    {
        $pageModel = StaticPages::model()->byPageId( StaticPages::WEATHER_RESORT )->find();

        $this->pageTitle .= ' - ' . $pageModel->getTitle();

        /** @var $cs CClientScript */

        Yii::app()
            ->getClientScript()
            ->registerMetaTag( $pageModel->getMetaDescription(), 'description' )
            ->registerMetaTag( $pageModel->getMetaKeyWords(), 'keywords' );


        $this->breadcrumbs = array(
            'Погода на карті світу' => $this->createUrl( 'index' ),
            'Погода на курортах'
        );

        $this->render(
            'resort',
            array(
                'pageModel' => $pageModel,
            )
        );
    }

    protected function getSeaTemperature()
    {
        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::SEA_INFO_URL );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec($ch);

        curl_close($ch);

        $result = substr( $result, strpos( $result, 'NOAA' ) );
        $result = substr( $result, strpos( $result, '<table' ) );
        $result = substr( $result, 0, strpos( $result, '</table>' ) + 8 );
        */

        $html = file_get_contents( self::SEA_INFO_URL );

        $document = phpQuery::newDocument( $html );

        $table = $document->find('table:last' );

        $tableObject = pq( $table ); // Это аналог $ в jQuery

        $tableObject
            ->find('a')
            ->attr('href', '#');


        $unnecessaryElements = $document->find( 'tr' );

        foreach ( $unnecessaryElements as $el )
        {
            pq( $el )->find( ':not(.dat):has(td:eq(4))' )->remove();
        }

        $unnecessaryElements = $document->find( 'tr' );

        foreach ( $unnecessaryElements as $el )
        {
            $pq = pq( $el ); // Это аналог $ в jQuery
            $pq->find( 'td.dat:eq(4)' )
               ->remove();
        }


        /*
        $tableObject->find('div.entry-info')->remove(); // удаляем ненужный элемент
        $tags = $pq->find('ul.tags > li > a');

        $tags->append(': ')->prepend(' :'); // добавляем двоеточия по бокам

        $pq->find('div.content')->prepend('<br />')->prepend($tags); // добавляем контент в начало найденого элемента
*/

        $table = mb_convert_encoding( $table,'UTF8', "CP1251");

        return $table;
    }
}