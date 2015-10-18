<?php
/**
 * @author Andriy Tolstokorov
 */

class SliderModel extends CModel
{
    protected $sliderImagesSrc;
    protected $sliderImagesPath;

    public $response;

    public function attributeNames()
    {
        return array();
    }

    /**
     * Init variables
     */
    public function __construct()
    {
        $src = Yii::app()->params[ 'src' ][ 'slides' ];

        $this->sliderImagesSrc = array(
            '1' => $src . '1.jpg',
            '2' => $src . '2.jpg',
            '3' => $src . '3.jpg',
            '4' => $src . '4.jpg',
        );

        $path = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'slides' ];

        $this->sliderImagesPath = array(
            '1' => $path . '1.jpg',
            '2' => $path . '2.jpg',
            '3' => $path . '3.jpg',
            '4' => $path . '4.jpg',
        );
    }

    public function getsliderImagesPath()
    {
        return $this->sliderImagesPath;
    }

    /**
     * @return array array with slides 'name' => 'path'
     */
    public function getSliderImages()
    {
        return $this->sliderImagesSrc;
    }

    /**
     * Get path to slider image file
     * @param string $fileName
     * @return string
     * @throws CException
     */
    public function getSliderImagePath( $fileName )
    {
        if ( isset( $this->sliderImagesPath[ $fileName ] ) )
        {
            return $this->sliderImagesPath[ $fileName ];
        }
        else
        {
            throw new CException( 'File with such name does not uses by slider' );
        }
    }

    /**
     * Get path to slider image file
     * @param string $fileName
     * @return string
     * @throws CException
     */
    public function getSliderImageSrc( $fileName )
    {
        if ( isset( $this->sliderImagesSrc[ $fileName ] ) )
        {
            return $this->sliderImagesSrc[ $fileName ];
        }
        else
        {
            throw new CException( 'File with such name does not uses by slider' );
        }
    }

    public function changeSlide( $fileName )
    {
        // folder for uploaded files
        $tempFolder = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[ 'folders' ][ 'temp' ];

        if (!is_writable( $tempFolder ) )
        {
            throw new CException( 'temporary folder is not exists or not writable. Path:' . $tempFolder );
        }

        $uploader = new FileUploader(
            Yii::app()->params[ 'uploader' ][ 'allowedFileExtensions' ],
            Yii::app()->params[ 'uploader' ][ 'sizeLimit' ]
        );

        $result = $uploader->handleUpload( $tempFolder );

        if ( !isset( $result['error'] ) )
        {
            $imageHandler = new CImageHandler();
            $imageHandler->load( $tempFolder . $result['filename'] );

            try
            {
                $imageHandler->cropAndScaleFromCenter( 1040, 380 );
                $imageHandler->save( $this->getSliderImagePath( $fileName ) );

                $this->response = array(
                    'fileName' => $fileName,
                    'imageSrc' => $this->getSliderImageSrc( $fileName )
                );

                return TRUE;
            }
            catch ( CException $e )
            {
                $this->response = array(
                    'errorMessage' => $fileName . $e->getMessage()
                );

                return FALSE;
            }
        }
        else
        {
            $this->response = array(
                'errorMessage' => $result[ 'error' ]
            );

            return FALSE;
        }
    }

    /**
     * @return mixed array with response
     */
    public function getResponse()
    {
        return $this->response;
    }
}