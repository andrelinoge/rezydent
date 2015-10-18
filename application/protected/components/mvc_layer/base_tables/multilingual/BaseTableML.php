<?php
/**
 * This is the base model class for multilingual article
 *
 * The followings are the available columns in any catalog table:
 * @property integer $id
 * @property integer $catalog_id
 * @property string $lang
 * @property string $value
 */

class BaseTableML extends BaseTable
{
    /** get current language
     * @return mixed
     */
    public static function getCurrentLanguage()
    {
        $lang = Yii::app()->getLanguage();
        if ( empty( $lang) ) {
            $lang = Yii::app()->params->defaultLocale;
        }
        return $lang;
    }

    /**
     * @param array $list array with nodes
     * @param integer $parent id of parent node
     * @return array
     */
    public static function getTree( &$list, $parent )
    {
        $tree = array();
        foreach( $list as $key => $record ) {
            if ( $record[ 'parent_id' ] == $parent ) {
                $tree[ $record[ 'catalog_id' ] ] = $record[ 'value' ] ;
                unset( $list[$key] );
            }
        }

        foreach( $tree as $catalogId => $value ) {
            $subTree = self::getTree( $list, $catalogId );

            if ( $subTree !== array() ) {
                $tree[ $value ] = $subTree;
            }
        }

        return $tree;
    }

    //      Scopes
    /**
     * @param null|string $language
     * @return BaseTableML
     */
    public function byLanguage( $language = NULL )
    {
        if ( $language ) {
            $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 'lang = :lang',
                    'params'=> array(
                        ':lang' => $language
                    ),
                )
            );
        } else {
            $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 'lang = :lang',
                    'params'=> array(
                        ':lang' => self::getCurrentLanguage()
                    ),
                )
            );
        }

        return $this;
    }
}