<?php
/**
 * @author Andre Linoge
 * Date: 11/23/12
 */
/**
 * This is the base model class for multilingual catalog
 *
 * The followings are the available columns in any catalog table:
 * @property integer $id
 * @property integer $catalog_id
 * @property integer $parent_id
 * @property string $lang
 * @property string $value
*/
class BaseCatalogTableML extends BaseTableML
{

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array( 'catalog_id, lang, value', 'required' ),
            array( 'value', 'length', 'max'=>255 ),
            array( 'lang', 'length', 'max'=>2 ),
            array( 'catalog_id', 'numerical', 'integerOnly' => TRUE ),

            array('id, catalog_id, lang, value, parent_id', 'safe', 'on'=>'search'),
        );
    }

     /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'catalog_id' => 'ID',
            'lang' => 'Lang',
            'value' => _( 'Value' )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('catalog_id',$this->catalog_id);
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('lang',$this->lang,true);
        $criteria->compare('value',$this->value,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * return value as URL param
     * @return string
     */
    public function getValueAsUrlParam()
    {
        return $this->prepareForUrl( $this->value );
    }

    //              Static

    /**
     * Retrieves a list of categories as $catalog_id => $value array
     * @static
     * @return array
     */
    public static function getOptions( $firstItem = NULL, $lang = NULL, $isNested = FALSE )
    {
        if ( !$lang ) {
            $lang = self::getCurrentLanguage();
        }

        // get array with data. Through DAO this will be a bit of quicker.
        $query = 'SELECT catalog_id, value, parent_id FROM ' . static::tableName() . ' where lang = :lang';
        $records = Yii::app()
            ->db
            ->createCommand( $query )
            ->bindValue(":lang", $lang, PDO::PARAM_STR )
            ->queryAll();

        // prepare result array
        $data = array();
        if ( $isNested ) {
            $tempRecords = $records;
            $data = static::getTree( $tempRecords, 0 );
        } else {
            foreach( $records as $record ) {
                $data[ $record[ 'catalog_id' ] ] = $record[ 'value' ];
            }
        }

        if ( $firstItem ) {
            $prompt = array( '' => $firstItem );
            return $prompt + $data;
        } else {
            return $data;
        }
    }

    public static function getLastId()
    {
        $query = 'SELECT MAX( catalog_id ) FROM ' . static::tableName();
        return (int)Yii::app()
            ->db
            ->createCommand( $query )
            ->queryScalar();

    }

    public function getValue()
    {
        return $this->value;
    }
}