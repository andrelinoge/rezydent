<?php
/**
 * @author: Andriy Tolstokorov
 *
 * This is the base model class for monolingual tags (keywords)
 *
 * The followings are the available columns in any table with tags (keywords):
 * @property integer $id
 * @property string $value
 */
class BaseTagTable extends BaseTable
{
    const FORM_ID = 'tags-form';
    const ATTENDANCE_MODEL_CLASS = '';
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
    public static function getOptions( $firstItem = NULL )
    {
        // get array with data. Through DAO this will be a bit of quicker.
        $query = 'SELECT id, value FROM ' . static::tableName();
        $records = Yii::app()
            ->db
            ->createCommand( $query )
            ->queryAll();

        // prepare result array
        $data = array();
        foreach( $records as $record )
        {
            $data[ $record[ 'id' ] ] = $record[ 'value' ];
        }

        if ( $firstItem )
        {
            $prompt = array( '' => $firstItem );
            return $prompt + $data;
        }
        else
        {
            return $data;
        }
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

    public function afterSave()
    {
        if ( $this->getIsNewRecord() )
        {
            if ( !empty( $attendanceModelClass ) )
            {
                /** @var $attendance CActiveRecord */
                $attendance = new $attendanceModelClass;
                $attendance->tag_id = $this->id;
                $attendance->count = 0;
                $attendance->save( FALSE );
            }
        }
    }
}