<?php
/**
 * @author Andriy Tolstokorov
 */

class Tours extends CWidget
{
    public function init()
    {

    }

    public function run()
    {
        $model = StaticPages::model()->cache( 1000 )->byPageId( StaticPages::TOURS_ABROAD )->find();
        $titleToursAbroad = $model->getTitle();

        $model = StaticPages::model()->cache( 1000 )->byPageId( StaticPages::TOURS_UKRAINE )->find();
        $titleToursUkraine = $model->getTitle();

        $model = StaticPages::model()->cache( 1000 )->byPageId( StaticPages::TOURS_HEALTH )->find();
        $titleToursHealth = $model->getTitle();

        $model = StaticPages::model()->cache( 1000 )->byPageId( StaticPages::TOURS_CHILDREN )->find();
        $titleToursChildren = $model->getTitle();

        $propositions = Propositions::model()
            ->limit( 4 )
            ->findAllByAttributes( array( 'show_in_slider' => TRUE ) );

        $this->render(
            'tours',
            array(
                'titleToursAbroad' => $titleToursAbroad,
                'titleToursUkraine' => $titleToursUkraine,
                'titleToursHealth' => $titleToursHealth,
                'titleToursChildren' => $titleToursChildren,
                'propositions' => $propositions
            )
        );
    }
}