<?php

/**
 * This is the model class for table "currency_modifier".
 *
 * The followings are the available columns in table 'currency_modifier':
 * @property integer $id
 * @property double $usd
 * @property double $eur
 * @property double $pln
 */
class CurrencyModifier extends BaseTable
{
    const ID = 1;
    const FORM_ID = 'currency-modifier-form';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CurrencyModifier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'currency_modifier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('id', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('usd, eur, pln', 'numerical'),
			array('id, usd, eur, pln', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usd' => 'Націка на долар США',
			'eur' => 'Націнка на євро',
			'pln' => 'Націнка на злотий',
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
		$criteria->compare('usd',$this->usd);
		$criteria->compare('eur',$this->eur);
		$criteria->compare('pln',$this->pln);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @return CActiveRecord
     */
    public static function getInstance()
    {
        return self::model()->findByPk( static::ID );
    }

    /**
     * @return float
     */
    public function getUsdModifier()
    {
        return (float)$this->usd;
    }

    /**
     * @return float
     */
    public function getPlnModifier()
    {
        return (float)$this->pln;
    }

    /**
     * @return float
     */
    public function getEurModifier()
    {
        return (float)$this->eur;
    }

    /**
     * Returns data provider for Templated ListGrid
     * @return CActiveDataProvider
     */
    public function backendSearch()
    {
        $criteria = new CDbCriteria();

        return new CActiveDataProvider(
            __CLASS__,
            array(
                'criteria'      => $criteria,
            )
        );
    }

    /**
     * Returns list of field names which will be used as headers for list grid columns
     * @return array
     */
    public static function getHeadersForListGrid()
    {
        return array(
            'usd',
            'eur',
            'pln'
        );
    }

    /**
     * return array with values for row cells in Templated ListGrid.
     * Note: order and count of fields must be the same as those that returns method for column headers
     * @return array
     */
    public function getRowValues()
    {
        return array(
            $this->getUsdModifier(),
            $this->getEurModifier(),
            $this->getPlnModifier()
        );
    }
}