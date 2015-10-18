<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class TestCatalogArticleMlForm extends BaseCatalogArticleFormML
{
    const FORM_ID = 'test-article-form';

    const USE_IMAGE = TRUE;

    public function init()
    {
        if ( static::USE_IMAGE )
        {
            $this->setTempFolder( '/public/uploads/temp/' );
            $this->setImagesFolder( '/public/uploads/catalog_articles_ml/' );
            $this->setThumbsSettings(
                array(
                    static::THUMB_PREFIX_MEDIUM => array( 640, 480 ),
                    static::THUMB_PREFIX_SMALL => array( 320, 200 ),
                )
            );
        }
        parent::init();
    }

    public function getCatalogOptions()
    {
        return TestCatalogMl::getOptions( _( 'Select category' ), NULL, TRUE );
    }
}