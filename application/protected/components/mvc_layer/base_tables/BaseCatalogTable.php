<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is the base model class for monolingual catalog
 *
 * The followings are the available columns in any catalog table:
 * @property integer $id
 * @property integer $parent_id
 * @property string $value
 */
class BaseCatalogTable extends BaseTable
{

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array( 'value', 'required' ),
            array( 'value', 'length', 'max'=>255 ),

            array('id,  value', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'value' => _( 'Значення' )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('parent_id',$this->parent_id);
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
        return $this->prepareForUrl( $this->value, TRUE );
    }

    //              Static

    /**
     * Retrieves a list of categories as $catalog_id => $value array
     * @static
     * @return array
     */
    public static function getOptions( $firstItem = NULL, $isNested = FALSE )
    {
        // get array with data. Through DAO this will be a bit of quicker.
        $query = 'SELECT id, value, parent_id FROM ' . static::tableName();
        $records = Yii::app()
            ->db
            ->createCommand( $query )
            ->queryAll();

        // prepare result array
        $data = array();
        if ( $isNested ) {
            $tempRecords = $records;
            $data = static::getTree( $tempRecords, 0 );
        } else {
            foreach( $records as $record ) {
                $data[ $record[ 'id' ] ] = $record[ 'value' ];
            }
        }

        if ( $firstItem ) {
            $prompt = array( '' => $firstItem );
            return $prompt + $data;
        } else {
            return $data;
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public static function getValueById( $id )
    {
        $query = 'SELECT value FROM ' . static::tableName() .' WHERE id = :id';
        $command = Yii::app()->db->cache( 600 )->createCommand( $query );
        $command->bindParam( ':id', $id, PDO::PARAM_INT );
        $result = $command->queryScalar();

        return $result;
    }

}