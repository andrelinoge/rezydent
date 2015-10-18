<?php
/**
 * @author Andriy Tolstokorov
 */

class BaseTable extends CActiveRecord
{
    const CACHE_TTL = 600;

    /** @var CDataProvider */
    protected $_dataProvider;
    /** @var bool */
    protected $_foundData = FALSE;
    /** @var CPagination */
    protected $_pagination;
    /** @var array */
    protected $_response;

    public function getData()
    {
        if ( $this->foundData() )
        {
            return $this->_dataProvider->getData();
        }
        else
        {
            return FALSE;
        }
    }

    public function getPagination()
    {
        if ( $this->foundData() )
        {
            return $this->_dataProvider->getPagination();
        }
        else
        {
            return FALSE;
        }
    }

    public function foundData()
    {
        return (bool)$this->_foundData;
    }

    public function getTotalItemCount()
    {
        return $this->_dataProvider->getTotalItemCount();
    }

    public function getResponse()
    {
        return $this->_response;
    }

    /** Retrieves encoded array with errors for ajax form validation
     * @param bool $encodeForAjax
     * @return array|string
     */
    public function getErrorsForForm( $encodeForAjax = TRUE )
    {
        $result = array();

        foreach( $this->getErrors() as $attribute => $errors ) {
            $result[ CHtml::activeId( $this, $attribute ) ] = $errors;
        }

        if ( $encodeForAjax ) {
            return function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
        } else {
            return $result;
        }
    }

    /**
     * prepare string to use as param in url
     * @param $string string
     * @return mixed
     */
    public function stringToUrlParam( $string )
    {
        return str_replace( ' ', '-', strtolower( $string ) );
    }

    /**
     * prepare string to use as param in url
     * @param $string string
     * @return mixed
     */
    public function prepareForUrl( $string, $toTranslit = FALSE )
    {
        $replace=array(
            "." => "",
            "," => "",
            "!" => "",
            "?" => "",
            ":" => "",
            ";" => "",
            "#" => "",
            "+" => "",
            "-" => '',
            " " => "-",
            "'"=>"",
            "`"=>"",
        );
        $string = strtr( $string, $replace );

        $string = trim( $string);

        if ( $toTranslit )
        {
            return $this->getTranslit( strtolower( $string ) );
        }
        else
        {
            return strtolower( $string ) ;
        }
    }

    public function getTranslit($string)
    {
        $replace=array(
            " " => "-",
            "'"=>"",
            "`"=>"",
            "а"=>"a","А"=>"a",
            "б"=>"b","Б"=>"b",
            "в"=>"v","В"=>"v",
            "г"=>"g","Г"=>"g",
            "д"=>"d","Д"=>"d",
            "е"=>"e","Е"=>"e",
            "ж"=>"zh","Ж"=>"zh",
            "з"=>"z","З"=>"z",
            "и"=>"i","И"=>"i",
            "й"=>"y","Й"=>"y",
            "к"=>"k","К"=>"k",
            "л"=>"l","Л"=>"l",
            "м"=>"m","М"=>"m",
            "н"=>"n","Н"=>"n",
            "о"=>"o","О"=>"o",
            "п"=>"p","П"=>"p",
            "р"=>"r","Р"=>"r",
            "с"=>"s","С"=>"s",
            "т"=>"t","Т"=>"t",
            "у"=>"u","У"=>"u",
            "ф"=>"f","Ф"=>"f",
            "х"=>"h","Х"=>"h",
            "ц"=>"c","Ц"=>"c",
            "ч"=>"ch","Ч"=>"ch",
            "ш"=>"sh","Ш"=>"sh",
            "щ"=>"sch","Щ"=>"sch",
            "ъ"=>"","Ъ"=>"",
            "ы"=>"y","Ы"=>"y",
            "ь"=>"","Ь"=>"",
            "э"=>"e","Э"=>"e",
            "ю"=>"yu","Ю"=>"yu",
            "я"=>"ya","Я"=>"ya",
            "і"=>"i","І"=>"i",
            "ї"=>"yi","Ї"=>"yi",
            "є"=>"e","Є"=>"e"
        );
        return $str=iconv(
            "UTF-8",
            "CP1251//IGNORE",
            strtr(
                $string,
                $replace
            )
        );
    }

    public function loadFilters()
    {
        if ( isset( $_GET[ get_class( $this ) ] ) ) {
            $this->setAttributes( $_GET[ get_class( $this ) ] );
        }
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
                $tree[ $record[ 'id' ] ] = $record[ 'value' ] ;
                unset( $list[$key] );
            }
        }

        foreach( $tree as $catalogId => $value ) {
            $subTree = static::getTree( $list, $catalogId );

            if ( $subTree !== array() ) {
                $tree[ $value ] = $subTree;
            }
        }
        return $tree;
    }

    //      Scopes
    public function last( $limit  )
    {
        $this->getDbCriteria()
            ->mergeWith(
            array(
                'order' => 't.id DESC',
                'limit' => $limit,
            )
        );
        return $this;
    }

    public function reverse()
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'order' => 'id DESC',
                )
            );
        return $this;
    }

    public function limit( $limit )
    {
        $this->getDbCriteria()
            ->mergeWith(
                array(
                    'limit' => $limit
                )
            );
        return $this;
    }

    public function notIn( $array )
    {
        $this->getDbCriteria()
             ->addNotInCondition(
                'id', $array
             );

        return $this;
    }

    public static function getMonthName( $index )
    {
        $months = array(
            'Січеня',
            'Лютого',
            'Березеня',
            'Квітня',
            'Травня',
            'Червня',
            'Липня',
            'Серпня',
            'Вересня',
            'Жовтня',
            'Листопада',
            'Грудня'
        );

        return $months[ $index - 1 ];
    }
}