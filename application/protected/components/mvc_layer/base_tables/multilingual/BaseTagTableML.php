<?php
/**
 * @author Andriy Tolstokorov
 *
 * This is the base model class for multilingual tag (key words)
 *
 * The followings are the available columns in any key words table:
 * @property integer $id
 * @property integer $tag_id
 * @property string $lang
 * @property string $value
 */
class BaseTagTableML extends BaseTableML
{

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array( 'tag_id, lang, value', 'required' ),
            array( 'value', 'length', 'max'=>255 ),
            array( 'lang', 'length', 'max'=>2 ),
            array( 'tag_id', 'numerical', 'integerOnly' => TRUE ),

            array('id, tag_id, lang, value', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'tag_id' => 'ID',
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
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('tag_id',$this->catalog_id);
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
        $query = 'SELECT tag_id, value FROM ' . static::tableName() . ' where lang = :lang';
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
                $data[ $record[ 'tag_id' ] ] = $record[ 'value' ];
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
        $query = 'SELECT MAX( tag_id ) FROM ' . static::tableName();
        return (int)Yii::app()
            ->db
            ->createCommand( $query )
            ->queryScalar();

    }

    public function getValue()
    {
        return $this->value;
    }

    public function getAttendance()
    {
        if ( isset( $this->attendance ) && ( is_object( $this->attendance ) ) )
        {
            return $this->attendance->count;
        }
        else
        {
            return 0;
        }
    }
}