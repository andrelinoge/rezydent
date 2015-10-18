<?php
class LastMedia extends CWidget
{
    public $titleLimit = 20;
    protected $models;

    public function init()
    {
        $this->models = Media::model()
            ->last( Yii::app()->params[ 'frontend'][ 'itemsPerPage' ] )
            ->findAll();
    }

    public function run()
    {
        $this->render(
            'last-media',
            array(
                'models' => $this->models,
                'titleLimit' => $this->titleLimit
            )
        );
    }
}