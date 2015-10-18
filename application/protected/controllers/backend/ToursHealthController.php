<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class ToursHealthController extends BackendController
{
    const GROUP_IDS_VARIABLE = 'ids';

    public function beforeAction()
    {
        $this->breadcrumbs = $this->getBreadCrumbs(
            $this->getAction()->getId()
        );

        return TRUE;
    }

    public function actions()
    {
        $catalogModel = new ToursHealthCatalog();

        // catalog articles list
        $catalogId = getParam( 'catalog_id', NULL );
        $articleModel = new ToursHealth( 'search' );
        $articleModel->catalog_id = $catalogId;
        $articleModel->loadFilters();

        // Catalog Article Form
        $newCatalogArticleModel = new ToursHealth();
        $newCatalogArticleModel->catalog_id = $catalogId;

        $createNewCatalogArticleUrl = $this->createUrl(
            'addArticle',
            array(
                'catalog_id' => $articleModel->catalog_id
            )
        );

        $articleRedirectAfter = $this->createUrl(
            'articles',
            array(
                'catalog_id' => $articleModel->catalog_id
            )
        );

        return array(
            'index' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $catalogModel,
                'listHeaders'       => ToursHealthCatalog::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Лікувальні тури' ),
                'listTitle'         => _( 'Перелік категорії' ),
                'actionCreateUrl'   => $this->createUrl( 'add' ),
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'add' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $catalogModel,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Нова категорія' ),
                'formId'        => ToursHealthCatalog::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'index' ),
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => ToursHealthCatalog::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування категрії' ),
                'formId'        => ToursHealthCatalog::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'delete' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => new ToursHealth(),
                'deleteCriteria'=> 'id = :catalogId',
                'deleteParams'  => array( ':catalogId' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'index' ),
                'isMultilingual'=> FALSE
            ),

            'articles' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $articleModel,
                'listHeaders'       => ToursHealth::getHeadersForListGrid(),
                'listFilters'       => ToursHealth::getFiltersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'articles',
                'partialView'       => '_articles',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Лікувальні тури' ),
                'listTitle'         => _( 'Перелік турів' ),
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE,
                'actionCreateUrl'   => $createNewCatalogArticleUrl,
            ),

            'addArticle' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $newCatalogArticleModel,
                'view'          => 'add-edit-article',
                'formView'      => '_form-article',
                'pageTitle'     => _( 'Новий тур' ),
                'formId'        => ToursHealth::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $articleRedirectAfter,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Embassies::getInnerLinks( 'embassies', 'show' )
            ),

            'editArticle' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => ToursHealth::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit-article',
                'formView'      => '_form-article',
                'pageTitle'     => _( 'Редагування туру' ),
                'formId'        => ToursHealth::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Embassies::getInnerLinks( 'embassies', 'show' )
            ),

            'deleteArticle' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => new ToursHealth(),
                'deleteCriteria'=> 'id = :articleId',
                'deleteParams'  => array( ':articleId' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $articleRedirectAfter,
                'isMultilingual'=> FALSE
            ),

            'groupDeleteArticles' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'index' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( 'Статтю видалено!'),
                'flashWarningNoItems'   => _( 'Нічого не вибрано!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'ToursHealth'
            ),

            'uploadImageHandler' => array(
                'class'         => 'application.actions.backend.UploadImageAction',
            )
        );
    }

    protected function getBreadCrumbs( $actionId )
    {
        $result = array();

        switch ( $actionId )
        {
            case 'index' :
                $result = array(
                    _( 'Лікувальні тури - категорії' )
                );
            break;

            case 'add' :
                $result = array(
                    _( 'Лікувальні тури - категорії' ) => $this->createUrl( 'index' ),
                    _( 'Нова категорія' )
                );
            break;

            case 'edit':
                $result = array(
                    _( 'Лікувальні тури - категорії' ) => $this->createUrl( 'index' ),
                    _( 'Редагувати категорії' )
                );
            break;

            case 'articles':
                $result = array(
                    _( 'Лікувальні тури - тури' )
                );
                break;

            case 'addArticle':
                $result = array(
                    _( 'Лікувальні тури - тури' ) => $this->createUrl( 'articles' ),
                    _( 'Додати тур' )
                );
                break;

            case 'editArticle':
                $result = array(
                    _( 'Лікувальні тури - тури' ) => $this->createUrl( 'articles' ),
                    _( 'Редагування туру' )
                );
                break;
        }

        return $result;
    }

    /**                                     FILTERS                                **/


    public function filters() {
        return array(
            'accessControl'
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'index', 'add', 'edit', 'delete', 'GroupDelete', 'GroupEdit',
                    'groupDeleteArticles', 'articles', 'addArticle', 'editArticle', 'deleteArticle',
                    'uploadImageHandler'
                ),
                'roles' => array( 'admin' )
            ),

            // deny all for all users
            array(
                'deny',
                'users' => array( '*' ),
            ),
        );
    }
}