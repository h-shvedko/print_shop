<?php

/**
 * This is the model class for table "products_temp".
 *
 * The followings are the available columns in table 'products_temp':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $price
 * @property string $price_client
 * @property string $price_agency
 * @property string $material
 * @property string $sroki
 * @property integer $tirazh
 */
class ProductsTemp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'products_temp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, alias, price, price_client', 'required'),
			array('name', 'length', 'max'=>250),
			array('alias, material, sroki', 'length', 'max'=>255),
			array('price, price_client, price_agency', 'length', 'max'=>19),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, alias, price, price_client, price_agency, material, sroki, tirazh', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
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
			'name' => 'Name',
			'alias' => 'Alias',
			'price' => 'Price',
			'price_client' => 'Price Client',
			'price_agency' => 'Price Agency',
			'material' => 'Material',
			'sroki' => 'Sroki',
			'tirazh' => 'Tirazh',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('price_client',$this->price_client,true);
		$criteria->compare('price_agency',$this->price_agency,true);
		$criteria->compare('material',$this->material,true);
		$criteria->compare('sroki',$this->sroki,true);
		$criteria->compare('tirazh',$this->tirazh);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductsTemp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
