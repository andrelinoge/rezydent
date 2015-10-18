<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $baseUrl = NULL;
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    /** @var string Url for redirect in CRUD methods */
    protected $_redirectUrl = NULL;

    protected $ajaxResponseSuccessMessage = '';
    protected $ajaxResponseErrorMessage = '';

    /**
     * @var CModel
     */
    protected $_model;

    public function __construct($id,$module)
    {
        parent::__construct($id,$module);

        // set current lang from cookie
        if(isset(Yii::app()->request->cookies['language'])){
            Yii::app()->setLanguage(Yii::app()->request->cookies['language']->value);
        }
    }

    /**
     * Initialize base components, register frequently used packages, etc.
     */
    public function init()
    {
        Yii::app()->clientScript->registerPackage( 'applicationEndController' );
    }

    /**
     * Set current layout
     * @param $layout
     */
    public function setLayout( $layout )
    {
        $this->layout = '/../layouts/' . $layout;
    }

    /**
     * Returns base url depending on current behavior
     * @return string
     */
    public function getBehavioralBaseUrl()
    {
        return getPublicUrl() . '/'. Yii::app()->getEndName();
    }

    /**
     * return response for ajax request with 'status = true' and additional params
     * like successMessage or redirect url
     * @param $response mix
     */
    public function successfulAjaxResponse( $response = array() )
    {
        $status = array( 'status' => TRUE );
        echo CJSON::encode( $status + $response );
        Yii::app()->end();
    }

    /**
     * return response for ajax request with 'status = false' and additional params
     * like errorMessage
     * @param array $response
     */
    public function unsuccessfulAjaxResponse( $response = array() )
    {
        $status = array( 'status' => FALSE );
        echo CJSON::encode( $status + $response );
        Yii::app()->end();
    }
    /**
     * @param $model
     * @param bool $getErrorInYiiFormat if true errors must will be returns
     * as from CForm class if model is instance of ActiveRecord class (look in components)
     * @param bool $errMsg sting with error message (optional)
     */
    public function validationErrorsAjaxResponse( $model,  $errMsg = FALSE )
    {

        $response = array(
            'status' => FALSE,
            'errors' => $model->getErrors()
        );

        if ( $errMsg ) {
            $response[ 'errorMessage' ] = $errMsg;
        }

        echo CJSON::encode( $response );
        Yii::app()->end();
    }

    /**
     * set model
     * @param $model CModel
     */
    public function setModel( $model ) {
        $this->_model = $model;
    }

    /**
     * get model
     * @return CModel
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param $modelName
     * @param bool $scenario
     * @return CActiveRecord
     */
    public function createModel( $modelName, $scenario = FALSE )
    {
        /** @var $model CActiveRecord */
        $model = new $modelName;
        if ( $scenario ) {
            $model->scenario = $scenario;
        }
        $this->setModel( $model );
        return $model;
    }

    /**
     * CRUD Helper
     * creates new record using $this->_model and if success - redirects to page using $this->_redirectUrl
     */
    public function processCreate()
    {
        $this->ajaxResponseErrorMessage = _( 'Пропущені деякі поля або введені не вірно!' );
        $this->ajaxResponseSuccessMessage = _( 'Запис додано успішно!');
        return $this->process();
    }

    /**
     * updates record using $this->_model and if success - redirects to page using $this->_redirectUrl
     */
    public function processUpdate()
    {
        $this->ajaxResponseErrorMessage = _( 'Пропущені деякі поля або введені не вірно!' );
        $this->ajaxResponseSuccessMessage = _( 'Зміни збережено успшіно.');
        return $this->process();
    }

    public function setRedirectUrl( $url )
    {
        $this->_redirectUrl = $url;
    }

    public function getRedirectUrl()
    {
        return $this->_redirectUrl;
    }

    public function isSetRedirectUrl()
    {
        return ( count( $this->_redirectUrl ) > 0 );
    }

    /**
     * Default process of validation and data save
     */
    public function process()
    {
        $model = $this->getModel();
        $modelName = get_class( $model );

        if ( isset( $_POST[ $modelName ] ) )
        {
            //$model->unsetAttributes();
            $model->attributes = $_POST[ $modelName ];

            if ( $model->validate() )
            {
                $model->save( FALSE );
            }

            if ( isAjax() )
            {
                $response = array();

                if ( $model->hasErrors() )
                { // was validation errors
                    $this->validationErrorsAjaxResponse(
                        $model,
                        $this->ajaxResponseErrorMessage
                    );
                }
                else
                { // success
                    if ( !empty( $this->ajaxResponseSuccessMessage ) )
                    {
                        $response[ 'successMessage' ] = $this->ajaxResponseSuccessMessage;
                    }

                    if ( $this->isSetRedirectUrl() )
                    { // redirect to
                        $response[ 'redirect' ] = $this->getRedirectUrl();
                    }

                    $this->successfulAjaxResponse( $response );
                }
            } else {
                $this->setModel( $model );
                return;
            }
        }
    }

    /**
     * set message for ajax response on success
     * @param $message string
     */
    public function setAjaxResponseSuccessMessage( $message )
    {
        $this->ajaxResponseSuccessMessage = $message;
    }

    /**
     * set message for ajax response on error
     * @param $message string
     */
    public function setAjaxResponseErrorMessage( $message )
    {
        $this->ajaxResponseErrorMessage = $message;
    }

    /*          COMMON ACTIONS      */
    public function actionChangeLocale( $locale )
    {
        if ( !in_array( $locale, Yii::app()->params->availableLocalesInShortForm )) {
            $locale = Yii::app()->params->defaultLocale;
        }

        $expirePeriod = 60 * 60 * 24 * 365; // 1 year

        $cookie = new CHttpCookie('language', $locale );
        $cookie->expire = time() + $expirePeriod;

        Yii::app()->request->cookies['language'] = $cookie;

        $this->redirect( Yii::app()->getRequest()->getUrlReferrer() );
    }
}