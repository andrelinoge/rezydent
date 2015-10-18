<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class Slider extends CWidget
{
    protected $propositions;
    protected $animations;
    protected $coords;
    protected $slides;

    public function init()
    {
        $model = new SliderModel();

        $this->slides = $model->getSliderImages();

        $this->animations = array(
            'lft', 'lfl', 'lfb', 'lfr'
        );

        $this->coords = array(
            array(
                'x' => rand( 30, 300 ),
                'y' => rand( 10, 10 )
            ),

            array(
                'x' => rand( 50, 150 ),
                'y' => rand( 250, 240 )
            ),

            array(
                'x' => rand( 600, 800 ),
                'y' => rand( 10, 10 )
            ),

            array(
                'x' => rand( 500, 700 ),
                'y' => rand( 250, 240 )
            )
        );

        $this->propositions = Propositions::model()
            ->limit( 4 )
            ->findAllByAttributes( array( 'show_in_slider' => TRUE ) );

        parent::init();
    }

    public function run()
    {
        $this->render(
            'slider',
            array(
                'animations' => $this->animations,
                'coords' => $this->coords,
                'propositions' => $this->propositions,
                'slides' => $this->slides,
            )
        );
    }
}