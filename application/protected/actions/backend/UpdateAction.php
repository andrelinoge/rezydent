<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class UpdateAction extends Action
{
    /** @var null|CModel */
    public $model       = NULL;
    /** @var string */
    public $view        = 'add-edit';
    /** @var string */
    public $formView    = '_form';
    /** @var string */
    public $pageTitle   = 'Edit item';
    /** @var null|string */
    public $redirectUrl = NULL;
    /** @var string */
    public $formAction  = 'update';
    /** @var string */
    public $formId      = 'form-id';
    /** @var string */
    public $tableModelClassName = NULL;
    /** @var integer */
    public $updateRecordId = NULL;
    /** @var array  Array with links on inner pages for monolingual sites */
    public $innerLinks = array();
    /** @var string handler for image uploader */
    public $imageUploadHandlerUrl = '';
    /** @var int width of preview of image for article cover  */
    public $coverPreviewWidth = 200;
    /** @var int height of preview of image for article cover  */
    public $coverPreviewHeight = 200;

    /**
     * For monolingual site mode
     */
    public function runMonolingual()
    {
        // check if action is configured
        $this->checkConditions( array( 'model' ) );

        /** @var $controller BackendController */
        $controller = $this->getController();

        if ( $this-> redirectUrl )
        {
            $controller->setRedirectUrl( $this->redirectUrl );
        }

        $controller->setModel( $this->model );
        if ( isPostOrAjaxRequest() )
        {
            $controller->processUpdate();
        }

        $controller->render(
            $this->view,
            array(
                'model'         => $controller->getModel(),
                'pageTitle'     => $this->pageTitle,
                'formId'        => $this->formId,
                'formView'      => $this->formView,
                'formAction'    => $this->formAction,
                'innerLinks'    => $this->innerLinks,
                'imageUploadHandlerUrl' => $this->imageUploadHandlerUrl,
                'coverPreviewWidth' => $this->coverPreviewWidth,
                'coverPreviewHeight' => $this->coverPreviewHeight
            )
        );
    }

    /**
     * For multilingual site mode
     */
    public function runMultilingual()
    {
        // check if action is configured
        $this->checkConditions( array( 'model', 'updateRecordId', 'tableModelClassName' ) );

        /** @var $controller BackendController */
        $controller = $this->getController();

        $this->model->setTableModelClassName( $this->tableModelClassName );
        $this->model->loadData( $this->updateRecordId );

        if ( $this-> redirectUrl )
        {
            $controller->setRedirectUrl( $this->redirectUrl );
        }

        $controller->setModel( $this->model );
        if ( isPostOrAjaxRequest() )
        {
            $controller->processUpdate();
        }

        $controller->render(
            $this->view,
            array(
                'model'         => $controller->getModel(),
                'pageTitle'     => $this->pageTitle,
                'formId'        => $this->formId,
                'formView'      => $this->formView,
                'formAction'    => $this->formAction,
                'imageUploadHandlerUrl' => $this->imageUploadHandlerUrl,
                'coverPreviewWidth' => $this->coverPreviewWidth,
                'coverPreviewHeight' => $this->coverPreviewHeight
            )
        );
    }
}