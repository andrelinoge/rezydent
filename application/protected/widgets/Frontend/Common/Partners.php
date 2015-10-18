<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class Partners extends CWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->render(
            'partners'
        );
    }
}