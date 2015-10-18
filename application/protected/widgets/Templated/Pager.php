<?php
/**
 * User: andrelinoge
 * Date: 12/4/12
 */

class Pager extends CBasePager
{
    /** @var string folder with template */
    public $viewFolder = 'pager';
    /**
     * @var string template file
     */
    public $viewFile = 'default';

    /** @var CPagination */
    public $pagination;
    /**
     * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
     */
    public $maxButtonCount=10;
    /**
     * @var string the text label for the next page button. Defaults to 'Next &gt;'.
     */
    public $nextPageLabel;
    /**
     * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
     */
    public $prevPageLabel;
    /**
     * @var string the text label for the first page button. Defaults to '&lt;&lt; First'.
     */
    public $firstPageLabel;
    /**
     * @var string the text label for the last page button. Defaults to 'Last &gt;&gt;'.
     */
    public $lastPageLabel;

    /** @var string id for div block, that wraps widget content. Used in AJAX operations. */
    public $widgetWrapperId = 'pageHolder';

    /** @var array */
    protected $_pageButtons;
    /** @var array */
    protected $_firstPageButton = NULL;
    /** @var array */
    protected $_prevPageButton = NULL;
    /** @var array */
    protected $_nextPageButton = NULL;
    /** @var array */
    protected $_lastPageButton = NULL;

    /**
     * Initializes the pager by setting some default property values.
     */
    public function init()
    {
        if ( !( $this->pagination instanceof CPagination ) ) {
            return;
            throw new CException( 'missed parameter pagination or his type is not CPagination');
        }

        $this->setPages( $this->pagination );

        if( $this->nextPageLabel === NULL ) {
            $this->nextPageLabel = Yii::t('yii','Next &gt;');
        }

        if( $this->prevPageLabel === NULL ) {
            $this->prevPageLabel = Yii::t('yii','&lt; Previous');
        }


        if( $this->firstPageLabel === NULL ) {
            $this->firstPageLabel=Yii::t('yii','&lt;&lt; First');
        }

        if( $this->lastPageLabel === NULL ) {
            $this->lastPageLabel=Yii::t('yii','Last &gt;&gt;');
        }
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        if ( !( $this->pagination instanceof CPagination ) ) {
            return;
        }

        $this->createPageButtons();
        if( empty( $this->_pageButtons ) ) {
            return;
        }

        $this->render(
            $this->getView(),
            array(
                'buttons' => $this->_pageButtons,
                'firstPageButton' => $this->_firstPageButton,
                'prevPageButton' => $this->_prevPageButton,
                'nextPageButton' => $this->_nextPageButton,
                'lastPageButton' => $this->_lastPageButton,
                'pagination' => $this->getPages(), // just in case
                'widgetWrapperId' => $this->widgetWrapperId
            )
        );
    }

    /**
     * Creates the page buttons.
     * @return array a list of page buttons as array with params: label, url, isHidden, isSelected
     */
    protected function createPageButtons()
    {
        if( ($pageCount = $this->getPageCount() ) <= 1 ) {
            return array();
        }

        list( $beginPage, $endPage ) = $this->getPageRange();
        $currentPage = $this->getCurrentPage( FALSE ); // currentPage is calculated in getPageRange()
        $this->_pageButtons = array();

        // first page
        if ( $this->firstPageLabel ) {
            $this->_firstPageButton = $this->createPageButton(
                $this->firstPageLabel,
                0,
                $currentPage <= 0,  // if this is first page - don't show "first" button
                FALSE               // this button can't be selected
            );
        }


        // prev page
        if ( $this->prevPageLabel ) {
            if( ( $page = $currentPage-1 ) < 0 ) {
                $page = 0;
            }

            $this->_prevPageButton = $this->createPageButton(
                $this->prevPageLabel,
                $page,
                $currentPage <= 0,  // if this is first page - don't show "prev" button
                FALSE               // this button can't be selected
            );
        }


        // internal pages
        for( $page = $beginPage; $page <= $endPage; $page++ ) {
            $this->_pageButtons[] = $this->createPageButton(
                $page + 1,
                $page,
                FALSE,
                $page == $currentPage
            );
        }

        // next page
        if ( $this->nextPageLabel ) {
            if( ($page = $currentPage + 1 ) >= $pageCount-1 ) {
                $page = $pageCount-1;
            }

            $this->_nextPageButton = $this->createPageButton(
                $this->nextPageLabel,
                $page,
                $currentPage >= $pageCount - 1, // if this is last page - don't show "next" button
                FALSE   // this button can't be selected
            );
        }

        // last page
        if ( $this->lastPageLabel ) {
            $this->_lastPageButton = $this->createPageButton(
                $this->lastPageLabel,
                $pageCount - 1,
                $currentPage >= $pageCount - 1,
                FALSE
            );
        }
    }

    /**
     * Creates a page button.
     * You may override this method to customize the page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param boolean $hidden whether this page button is visible
     * @param boolean $selected whether this page button is selected
     * @return array the generated button
     */
    protected function createPageButton( $label, $page, $hidden, $selected)
    {
        $button = array(
            'label'         => $label,
            'url'           => $this->createPageUrl($page),
            'isHidden'      => $hidden,
            'isSelected'    => $selected
        );

        return $button;
    }

    /**
     * @return array the begin and end pages that need to be displayed.
     */
    protected function getPageRange()
    {
        $currentPage = $this->getCurrentPage();
        $pageCount = $this->getPageCount();

        $beginPage = max(0, $currentPage - (int)( $this->maxButtonCount / 2 ) );

        if( ( $endPage = $beginPage + $this->maxButtonCount - 1 ) >= $pageCount ) {
            $endPage = $pageCount - 1;
            $beginPage = max( 0, $endPage - $this->maxButtonCount + 1 );
        }

        return array( $beginPage, $endPage );
    }

    /**
     * @return string path to template file
     */
    protected function getView()
    {
        return $this->viewFolder . '/' . $this->viewFile;
    }

}