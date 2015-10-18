<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is example of CRUD-controller for multilingual catalog
 */

class TestArticlesController extends BackendController
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
        $parentId = getParam( 'parent_id', 0 );
        $modelForIndex = new TestCatalog();
        $modelForIndex->parent_id = $parentId;

        $newCatalogModel = new TestCatalog();
        $newCatalogModel->parent_id = $parentId;
        $redirectAfter = $this->createUrl( 'index' );
        $createNewCatalogUrl = $this->createUrl( 'add' );

        if ( $parentId )
        {
            $redirectAfter = $this->createUrl( 'index', array( 'parent_id' => $parentId ) );
            $createNewCatalogUrl = $this->createUrl( 'add', array( 'parent_id' => $parentId ) );
        }

        // catalog articles list
        $catalogId = getParam( 'catalog_id', NULL );
        $modelForArticles = new TestCatalogArticle( 'search' );
        $modelForArticles->catalog_id = $catalogId;
        $modelForArticles->loadFilters();

        // Catalog Article Form
        $newCatalogArticleModel = new TestCatalogArticle();
        $newCatalogArticleModel->catalog_id = $catalogId;

        $createNewCatalogArticleUrl = $this->createUrl(
            'addArticle',
            array(
                'catalog_id' => $modelForArticles->catalog_id
            )
        );

        $articleRedirectAfter = $this->createUrl(
            'articles',
            array(
                'catalog_id' => $modelForArticles->catalog_id
            )
        );

        return array(
            'index' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $modelForIndex,
                'listHeaders'       => TestCatalog::getHeadersForListGrid(),
                'primaryField'      => 'id', // primary field for multilingual models
                'view'              => 'list',
                'partialView'       => '_list',
                'widgetWrapperId'   => 'pageHolder',
                'widgetFormId'      => 'table-form',
                'pageTitle'         => _( 'Test catalog' ),
                'listTitle'         => _( 'Test catalog list' ),
                'actionCreateUrl'   => $createNewCatalogUrl,
                'groupingCheckboxName' => static::GROUP_IDS_VARIABLE
            ),

            'add' => array(
                'class'         => 'application.actions.backend.CreateAction',
                'model'         => $newCatalogModel,
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'New catalog value' ),
                'formId'        => TestCatalog::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $redirectAfter,
            ),

            'edit' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => TestCatalog::model()->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit',
                'formView'      => '_form',
                'pageTitle'     => _( 'Edit test catalog value' ),
                'formId'        => TestCatalog::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
            ),

            'delete' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => new TestCatalog(),
                'deleteCriteria'=> 'id = :catalogId',
                'deleteParams'  => array( ':catalogId' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $redirectAfter,
                'isMultilingual'=> FALSE
            ),

            /**
             * Using views and models from "Edit" action, create group of update forms
             */
            'groupEdit' => array(
                'class'         => 'application.actions.backend.GroupEditAction',
                'redirectUrl'   => $this->createUrl( 'index' ),
                'pageTitle'     => _( 'Edit group of test catalog records' ),
                'view'          => 'group-edit',
                'formView'      => '_form',
                'partialEditView'   => 'add-edit',
                'tableModelClass'   => 'TestCatalog',
                'groupingCheckboxName' => self::GROUP_IDS_VARIABLE,
                'isMultilingual'=> FALSE
            ),

            /**
             * Validate and save catalog record. Pair ajax action for group edit action
             */
            'partialUpdate' => array(
                'class'             => 'application.actions.backend.PartialUpdateAction',
                'tableModelClass'   => 'TestCatalog',
                'nonAjaxRedirectUrl' => $this->createUrl( 'index' ),
                'updateRecordId'     => getParam( 'id' ),
                'isMultilingual'    => FALSE
            ),

            'groupDelete' => array(
                'class'             => 'application.actions.backend.GroupDeleteAction',
                'isMultilingual'    => FALSE,
                'redirectUrl'       => $this->createUrl( 'index' ),
                'groupingCheckboxName'  => self::GROUP_IDS_VARIABLE,
                'flashSuccessMessage'   => _( 'items deleted!'),
                'flashWarningNoItems'   => _( 'No items selected!'),
                'primaryId'         => 'id',
                'tableModelClass'   => 'TestCatalog'
            ),

            'articles' => array(
                'class'             => 'application.actions.backend.ListAction',
                'model'             => $modelForArticles,
                'listHeaders'       => TestCatalogArticle::getHeadersForListGrid(),
                'listFilters'       => TestCatalogArticle::getFiltersForListGrid(),
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
                'pageTitle'     => _( 'New catalog article' ),
                'formId'        => TestCatalogArticle::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'redirectUrl'   => $articleRedirectAfter,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' )
            ),

            'editArticle' => array(
                'class'         => 'application.actions.backend.UpdateAction',
                'model'         => TestCatalogArticle::model()->with( 'tags' )->findByPk( getParam( 'id' ) ),
                'view'          => 'add-edit-article',
                'formView'      => '_form-article',
                'pageTitle'     => _( 'Edit test catalog article' ),
                'formId'        => TestCatalogArticle::FORM_ID,
                'formAction'    => '',
                'isMultilingual'=> FALSE,
                'imageUploadHandlerUrl' => $this->createUrl( 'uploadImageHandler' )
            ),

            'deleteArticle' => array(
                'class'         => 'application.actions.backend.DeleteAction',
                'model'         => new TestCatalogArticle(),
                'deleteCriteria'=> 'id = :articleId',
                'deleteParams'  => array( ':articleId' => getParam( 'id' ) ),
                'nonAjaxRedirect' => $articleRedirectAfter,
                'isMultilingual'=> FALSE
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
                $parentId = getParam( 'parent_id', NULL );
                // build bread crumbs using parent nodes
                if ( $parentId )
                {
                    $result = array(
                        _( 'Test catalog' ) => $this->createUrl( 'index' ),
                    );
                    $titles = array();
                    $urls = array();

                    $gotRoot = FALSE;
                    while ( !$gotRoot )
                    {
                        $model = TestCatalogMl::model()
                            ->byLanguage()
                            ->find(
                            'catalog_id = :value',
                            array(
                                ':value' => $parentId
                            )
                        );

                        if ( $model )
                        {
                            $parentId = (int)$model->parent_id;
                            $titles[] = $model->getValue();
                            $urls[] = $this->createUrl( 'index', array( 'parent_id' => $model->catalog_id ) );

                            if ( $parentId == 0 )
                            {
                                $gotRoot = TRUE;
                            }

                        }
                        else
                        {
                            $gotRoot = TRUE;
                        }
                    }

                    if ( $titles !== array() )
                    {
                        while( $titles !== array() )
                        {
                            $result[ array_pop( $titles ) ] = array_pop( $urls );
                        }
                    }
                }
                else
                {
                    $result = array(
                        _( 'Test catalog' )
                    );
                }
                break;

            case 'add' :
                $parentNodeModel = TestCatalogMl::model()
                    ->byLanguage()
                    ->find(
                    'catalog_id = :value',
                    array(
                        ':value' => getParam( 'parent_id' )
                    )
                );

                if ( $parentNodeModel )
                {
                    $result = array(
                        _( 'Test catalog' ) => $this->createUrl( 'index' )
                    );

                    $parentId = $parentNodeModel->parent_id;
                    if ( $parentId )
                    {

                        $titles = array();
                        $urls = array();

                        $gotRoot = FALSE;
                        while ( !$gotRoot ) {
                            $model = TestCatalogMl::model()
                                ->byLanguage()
                                ->find(
                                'catalog_id = :value',
                                array(
                                    ':value' => $parentId
                                )
                            );

                            if ( $model )
                            {
                                $parentId = (int)$model->parent_id;

                                $titles[] = $model->getValue();
                                $urls[] = $this->createUrl( 'index', array( 'parent_id' => $model->catalog_id ) );
                                if ( $parentId == 0 ) {
                                    $gotRoot = TRUE;
                                }
                            }
                            else
                            {
                                $gotRoot = TRUE;
                            }
                        }

                        if ( $titles !== array() )
                        {
                            while( $titles !== array() )
                            {
                                $title = array_pop( $titles );
                                $url = array_pop( $urls );
                                $result[ $title ] = $url;
                            }
                        }
                    }

                    $result[ $parentNodeModel->getValue() ] = $this->createUrl(
                        'index',
                        array( 'parent_id' => $parentNodeModel->catalog_id )
                    );

                    $result[] = _( 'Creating a new record' );
                }
                else
                {
                    $result = array(
                        _( 'Test catalog' ) => $this->createUrl( 'index' ),
                        _( 'Creating a new record' )
                    );
                }
                break;

            case 'edit':
                $model = TestCatalogMl::model()
                    ->byLanguage()
                    ->find(
                    'catalog_id = :value',
                    array(
                        ':value' => getParam( 'id' )
                    )
                );

                $parentId = $model->parent_id;

                if ( $parentId )
                {
                    $result = array(
                        _( 'Test catalog' ) => $this->createUrl( 'index' ),
                    );
                    $titles = array();
                    $urls = array();

                    $gotRoot = FALSE;
                    while ( !$gotRoot )
                    {
                        $model = TestCatalogMl::model()
                            ->byLanguage()
                            ->find(
                            'catalog_id = :value',
                            array(
                                ':value' => $parentId
                            )
                        );

                        if ( $model )
                        {
                            $parentId = (int)$model->parent_id;

                            $titles[] = $model->getValue();
                            $urls[] = $this->createUrl( 'index', array( 'parent_id' => $model->catalog_id ) );

                            if ( $parentId == 0 )
                            {
                                $gotRoot = TRUE;
                            }
                        }
                        else
                        {
                            $gotRoot = TRUE;
                        }
                    }

                    if ( $titles !== array() ) {
                        while( $titles !== array() ) {
                            $title = array_pop( $titles );
                            $url = array_pop( $urls );
                            $result[ $title ] = $url;
                        }
                    }

                    $result[] = _( 'Editing a record' );
                }
                else
                {
                    $result = array(
                        _( 'Test catalog' ) => $this->createUrl( 'index' ),
                        _( 'Editing a record' )
                    );
                }
                break;

            case 'groupEdit':
                $result = array(
                    _( 'Test catalog' ) => $this->createUrl( 'index' ),
                    _( 'Edit records' )
                );
                break;

            case 'articles':
                $result = array(
                    _( 'Test catalog articles' )
                );
                break;

            case 'addArticle':
                $result = array(
                    _( 'Test catalog articles' ) => $this->createUrl( 'articles' ),
                    _( 'Add catalog article' )
                );
                break;

            case 'editArticle':
                $result = array(
                    _( 'Test catalog articles' ) => $this->createUrl( 'articles' ),
                    _( 'Edit catalog article' )
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
                    'PartialUpdate', 'articles', 'addArticle', 'editArticle', 'deleteArticle',
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