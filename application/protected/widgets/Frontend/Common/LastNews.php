<?php
class LastNews extends CWidget
{
    public $titleLimit = 20;
    protected $models;

    public function init()
    {
        $this->models = News::model()
            ->last( Yii::app()->params[ 'frontend'][ 'itemsPerPage' ] )
            ->findAll();
    }

    public function run()
    {
        $this->render(
            'last-news',
            array(
                'models' => $this->models,
                'titleLimit' => $this->titleLimit
            )
        );
    }
}