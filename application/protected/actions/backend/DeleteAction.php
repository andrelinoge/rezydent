<?php
/**
 * @author Andriy Tolstokorov
 * @version 1.0
 */

class DeleteAction extends Action
{
    /** @var CModel */
    public $model = NULL;
    /** @var string */
    public $deleteCriteria = '';
    /** @var array */
    public $deleteParams = array();
    /** @var string */
    public $nonAjaxRedirect = '';

    public function runMonolingual()
    {
        // check if action is configured
        $this->checkConditions(
            array( 'model', 'deleteCriteria', 'deleteParams', 'nonAjaxRedirect' )
        );

        $models = $this->model->findAll( $this->deleteCriteria, $this->deleteParams );

        if ( !empty( $models ) )
        {
            foreach( $models as $model )
            {
                $model->delete();
            }
        }

        if ( isAjax() )
        {
            $this->getController()->successfulAjaxResponse();
        }
        else
        {
            $this->getController()->redirect( $this->nonAjaxRedirect );
        }
    }

    public function runMultilingual()
    {
        // check if action is configured
        $this->checkConditions(
            array( 'model', 'deleteCriteria', 'deleteParams', 'nonAjaxRedirect' )
        );

        $models = $this->model->findAll( $this->deleteCriteria, $this->deleteParams );

        if ( !empty( $models ) )
        {
            foreach( $models as $model )
            {
                $model->delete();
            }
        }

        if ( isAjax() )
        {
            $this->getController()->successfulAjaxResponse();
        }
        else
        {
            $this->getController()->redirect( $this->nonAjaxRedirect );
        }
    }
}