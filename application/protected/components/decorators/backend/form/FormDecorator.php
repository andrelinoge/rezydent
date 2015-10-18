<?php
/**
 * @author: Andriy Tolstokorov
 */

class FormDecorator
{
    /**
     * @param $model CModel
     * @param $attribute string
     * @param array $htmlOptions array
     * @return string
     */
    public static function textField( $model, $attribute, $htmlOptions = array() )
    {
        return CController::renderInternal(
            './application/protected/components/decorators/backend/form/views/text-field.php',
            array(
                'model'         => $model,
                'attribute'     => $attribute,
                'htmlOptions'   => $htmlOptions,
            ),
            TRUE
        );
    }

    /**
     * @param $model CModel
     * @param $attribute string
     * @param array $htmlOptions array
     * @return string
     */
    public static function textArea( $model, $attribute, $htmlOptions = array() )
    {
        return CController::renderInternal(
            './application/protected/components/decorators/backend/form/views/text-area.php',
            array(
                'model'         => $model,
                'attribute'     => $attribute,
                'htmlOptions'   => $htmlOptions
            ),
            TRUE
        );
    }

    /**
     * @param $model CModel
     * @param $attribute string
     * @param array $htmlOptions array
     * @return string
     */
    public static function dropDownList( $model, $attribute, $data, $htmlOptions = array() )
    {
        return CController::renderInternal(
            './application/protected/components/decorators/backend/form/views/drop-down-list.php',
            array(
                'model'         => $model,
                'attribute'     => $attribute,
                'data'          => $data,
                'htmlOptions'   => $htmlOptions
            ),
            TRUE
        );
    }

    /**
     * @param $model CModel
     * @param $attribute string
     * @param array $htmlOptions array
     * @return string
     */
    public static function dateField( $model, $attribute, $htmlOptions = array() )
    {
        return CController::renderInternal(
            './application/protected/components/decorators/backend/form/views/date-field.php',
            array(
                'model'         => $model,
                'attribute'     => $attribute,
                'htmlOptions'   => $htmlOptions,
            ),
            TRUE
        );
    }

    /**
     * @param $model CModel
     * @param $attribute string
     * @param array $htmlOptions array
     * @return string
     */
    public static function multiSelect( $model, $attribute, $data, $htmlOptions = array() )
    {
        return CController::renderInternal(
            './application/protected/components/decorators/backend/form/views/multi-select.php',
            array(
                'model'         => $model,
                'attribute'     => $attribute,
                'data'          => $data,
                'htmlOptions'   => $htmlOptions,
            ),
            TRUE
        );
    }

    /**
     * @param $model CModel
     * @param $attribute string
     * @param array $htmlOptions array
     * @return string
     */
    public static function checkBox( $model, $attribute, $htmlOptions = array() )
    {
        return CController::renderInternal(
            './application/protected/components/decorators/backend/form/views/checkbox.php',
            array(
                'model'         => $model,
                'attribute'     => $attribute,
                'htmlOptions'   => $htmlOptions
            ),
            TRUE
        );
    }
}