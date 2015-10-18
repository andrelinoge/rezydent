<?php
/**
 * @author Andriy Tolstokorov
 */

class SliderController extends BackendController
{
    public function actionIndex()
    {
        $model = new SliderModel();

        $this->render(
            'index',
            array(
                'slides' => $model->getSliderImages()
            )
        );
    }

    public function actionChange()
    {
        $fileName = getParam( 'fileName', FALSE );

        if ( $fileName )
        {
            $model = new SliderModel();
            if(  $model->changeSlide( $fileName ) )
            {
                $this->successfulAjaxResponse( $model->getResponse() );
            }
            else
            {
                $this->unsuccessfulAjaxResponse( $model->getResponse() );
            }
        }

    }
}