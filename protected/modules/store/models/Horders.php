<?php

/**
 * This is the model class for table "horders".
 *
 * The followings are the available columns in table 'horders':
 * @property integer $id
 * @property string $num
 * @property integer $users__id
 * @property integer $pay_types__id
 * @property integer $delivery_types__id
 * @property string $is_paid
 * @property string $amount
 * @property string $date_horder
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $adress
 * @property string $phone
 * @property string $email
 */
class Horders extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'horders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('num, users__id, pay_types__id, delivery_types__id, amount, date_horder, phone, email', 'required'),
			array('users__id, amount, date_horder', 'required'),
			array('phone', 'required', 'message' => 'Вы не заполнили поле "Телефон"'),
			array('country', 'required', 'message' => 'Вы не заполнили поле "Страна"'),
			array('region', 'required', 'message' => 'Вы не заполнили поле "Область"'),
			array('city', 'required', 'message' => 'Вы не заполнили поле "Город"'),
			array('adress', 'required', 'message' => 'Вы не заполнили поле "Улица и дом"'),
			array('email', 'required', 'message' => 'Вы не заполнили поле "e-mail"'),
			array('users__id, pay_types__id, delivery_types__id', 'numerical', 'integerOnly'=>true),
			array('num, is_paid, country, region, city, adress, phone', 'length', 'max'=>255, 'message' => 'Слишком много символов'),
			array('amount', 'length', 'max'=>8),
			array('email', 'length', 'max'=>50, 'message' => 'Слишком много символов'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, num, users__id, pay_types__id, delivery_types__id, is_paid, amount, date_horder, country, region, city, adress, phone, email, status__id', 'safe', 'on'=>'search'),
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
			'deliveryType' => array(self::BELONGS_TO, 'DeliveryTypes', 'delivery_types__id'),
			'payType' => array(self::BELONGS_TO, 'PayTypes', 'pay_types__id'),
			'orders' => array(self::HAS_MANY, 'Orders', 'horders__id'),
			'products' => array(self::HAS_MANY, 'Products', 'catalog_product__id', 'through' => 'orders'),
			'user' => array(self::BELONGS_TO, 'Users', 'users__id'),
			'statuses' => array(self::BELONGS_TO, 'HordersStatuses', 'status__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'num' => 'Num',
			'users__id' => 'Users',
			'pay_types__id' => 'Pay Types',
			'delivery_types__id' => 'Delivery Types',
			'is_paid' => 'Is Paid',
			'amount' => 'Amount',
			'date_horder' => 'Date Horder',
			'country' => 'Country',
			'region' => 'Region',
			'city' => 'City',
			'adress' => 'Adress',
			'phone' => 'Phone',
			'email' => 'Email',
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
		$criteria->compare('num',$this->num,true);
		$criteria->compare('users__id',$this->users__id);
		$criteria->compare('pay_types__id',$this->pay_types__id);
		$criteria->compare('delivery_types__id',$this->delivery_types__id);
		$criteria->compare('is_paid',$this->is_paid,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('date_horder',$this->date_horder,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('adress',$this->adress,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Horders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getNum($id)
	{
		return ($id+1000);
	}
	
	public static function getTotalPrice($id)
	{
		$models = Horders::model()->findByPk($id);
		$totalPrice = (int)FALSE;
		
		foreach($models->orders as $model)
		{
			$totalPrice += $model->price;
		}
		
		return $totalPrice;
	}
	
}
