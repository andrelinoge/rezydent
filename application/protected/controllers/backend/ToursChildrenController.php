<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class ToursChildrenController extends BackendController
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
        $catalogModel = new ToursChildrenCatalog();

        // catalog articles list
        $catalogId = getParam( 'catalog_id', NULL );
        $articleModel = new ToursChildren( 'search' );
        $articleModel->catalog_id = $catalogId;
        $articleModel->loadFilters();

        // Catalog Article Form
        $newCatalogArticleModel = new ToursChildren();
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
                'listHeaders'       => ToursChildrenCatalog::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Тури для дітей' ),
                'listTitle'         => _( 'Перелік країн' ),
                'actionCreateUrl'   => $this->createUrl( 'add' ),
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'add' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $catalogModel,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Нова країна' ),
                'formId'        => ToursChildrenCatalog::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $this->createUrl( 'index' ),
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => ToursChildrenCatalog::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Редагування країни' ),
                'formId'        => ToursChildrenCatalog::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'delete' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => new TestCatalog(),
                'deleteCriteria'=> 'id = :catalogId',
                'deleteParams'  => array( ':catalogId' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $this->createUrl( 'index' ),
                'isMultilingual'=> FALSE
            ),

            'articles' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $articleModel,
                'listHeaders'       => ToursChildren::getHeadersForListGrid(),
                'listFilters'       => ToursChildren::getFiltersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'articles',
                'partialView'       => '_articles',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Test catalog articles' ),
                'listTitle'         => _( 'Test catalog articles list' ),
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE,
                'actionCreateUrl'   => $createNewCatalogArticleUrl,
            ),

            'addArticle' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $newCatalogArticleModel,
                'view'          => 'add-edit-article',
                'formView'      => '_form-article',
                'pageTitle'     => _( 'Новий тур' ),
                'formId'        => ToursChildren::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $articleRedirectAfter,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Embassies::getInnerLinks( 'embassies', 'show' )
            ),

            'editArticle' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => ToursChildren::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit-article',
                'formView'      => '_form-article',
                'pageTitle'     => _( 'Редагування туру' ),
                'formId'        => ToursChildren::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' ),
                'innerLinks'    => Embassies::getInnerLinks( 'embassies', 'show' )
            ),

            'deleteArticle' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => new ToursChildren(),
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
                'tableModelClass'   => 'ToursChildren'
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
                    _( 'Тури для дітей - країни' )
                );
            break;

            case 'add' :
                $result = array(
                    _( 'Тури для дітей - країни' ) => $this->createUrl( 'index' ),
                    _( 'Нова країна' )
                );
            break;

            case 'edit':
                $result = array(
                    _( 'Тури для дітей - країни' ) => $this->createUrl( 'index' ),
                    _( 'Редагувати країну' )
                );
            break;

            case 'articles':
                $result = array(
                    _( 'Тури для дітей - тури' )
                );
                break;

            case 'addArticle':
                $result = array(
                    _( 'Тури для дітей - тури' ) => $this->createUrl( 'articles' ),
                    _( 'Додати тур' )
                );
                break;

            case 'editArticle':
                $result = array(
                    _( 'Тури для дітей - тури' ) => $this->createUrl( 'articles' ),
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