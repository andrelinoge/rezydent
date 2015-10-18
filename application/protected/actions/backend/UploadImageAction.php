<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class UploadImageAction extends CAction
{
    public $tempFolder = '/public/uploads/temp/';
    public $allowedFileExtensions = array( 'jpg', 'jpeg', 'png' );
    public $fileLimit = 10485760;
    public $minimalHeight = 0;
    public $minimalWeight = 0;
    public $maximalHeight = 0;
    public $maximalWeight = 0;

    public function run()
    {

        // folder for uploaded files
        $tempFolder = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . $this->tempFolder;

        if (!is_writable( $tempFolder ) )
        {
            throw new CException( 'temporary folder is not exists or not writable. Path:' . $tempFolder );
        }

        $uploader = new FileUploader(
            $this->allowedFileExtensions,
            $this->fileLimit
        );

        $result = $uploader->handleUpload( $tempFolder );

        if ( !isset( $result['error'] ) ) {
            $imageHandler = new CImageHandler();

            $imageHandler->load( $tempFolder . $result['filename'] );

            try
            {
                // if min/max weight/height are set - check those conditions
                $this->validateImageDimensions(
                    $imageHandler->getWidth(),
                    $imageHandler->getHeight()
                );

                $this->getController()->successfulAjaxResponse(
                    array(
                        'fileName' => $imageHandler->getBaseFileName(),
                        'imageSrc' => '/application' . $this->tempFolder . $imageHandler->getBaseFileName()
                    )
                );
            }
            catch ( CException $e )
            {
                $errorMsg = $imageHandler->getBaseFileName()
                    . ' - ' . $e->getMessage();

                $this->getController()->unsuccessfulAjaxResponse(
                    array(
                        'errorMessage' => $errorMsg
                    )
                );
            }
        }
        else
        {
            $this->getController()->unsuccessfulAjaxResponse(
                array(
                    'errorMessage' => $result[ 'error' ]
                )
            );
        }
    }

    /**
     * If image weight/height limits are set - check those conditions
     * @param int $width
     * @param int $height
     * @throws CException
     */
    protected function validateImageDimensions( $width, $height )
    {
        if ( (int)$this->minimalWeight > 0 )
        {
            if ( $width < $this->minimalWeight )
            {
                throw new CException(
                    _( 'Image weight is too small. Minimal is' ) . $this->minimalWeight . 'px'
                );
            }
        }

        if ( (int)$this->maximalWeight > 0 )
        {
            if ( $width > $this->maximalWeight )
            {
                throw new CException(
                    _( 'Image weight is too big. Maximal is' ) . $this->maximalWeight . 'px'
                );
            }
        }

        if ( (int)$this->minimalHeight > 0 )
        {
            if ( $height < $this->minimalHeight )
            {
                throw new CException(
                    _( 'Image height is too small. Minimal is' ) . $this->minimalHeight . 'px'
                );
            }
        }

        if ( (int)$this->maximalHeight > 0 )
        {
            if ( $height > $this->maximalHeight )
            {
                throw new CException(
                    _( 'Image height is too big. Maximal is' ) . $this->maximalHeight . 'px'
                );
            }
        }
    }

}