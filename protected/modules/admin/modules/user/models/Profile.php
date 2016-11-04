<?php

/**
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
 * @property integer $id
 * @property integer $users__id
 * @property string $first_name
 * @property string $second_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $city
 * @property string $country
 * @property string $region
 * @property string $adress
 * @property integer $sex
 * @property string $birthday
 */
class Profile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users__id', 'required'),
			array('users__id, sex', 'numerical', 'integerOnly'=>true),
			array('phone', 'numerical', 'integerOnly'=>true, 'message' => Yii::t('app', 'Телефон содержит недопустимые символы. Введите только цифры. Длинна телефона не может быть меньше 10 символов и боьлше 15.')),
			array('first_name, second_name, last_name, email', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>15),
			array('phone', 'match', 'pattern' => '/^[0-9]{10,15}+$/ui', 'message' => Yii::t('app', 'Телефон содержит недопустимые символы. Введите только цифры. Длинна телефона не может быть меньше 10 символов и боьлше 15.')),
			array('phone', 'unique', 'message'=>'Такой телефон уже существует'),
			array('email', 'unique', 'message'=>'Такой e-mail уже существует'),
			array('email', 'email', 'message'=>'Проверьте правильность введенного e-mail'),
			array('city, country, region, adress', 'length', 'max'=>255),
			array('birthday', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, users__id, first_name, second_name, last_name, phone, email, city, country, region, adress, sex, birthday', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'users__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'users__id' => 'Users',
			'first_name' => 'First Name',
			'second_name' => 'Second Name',
			'last_name' => 'Last Name',
			'phone' => 'Phone',
			'email' => 'Email',
			'city' => 'City',
			'country' => 'Country',
			'region' => 'Region',
			'adress' => 'Adress',
			'sex' => 'Sex',
			'birthday' => 'Birthday',
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
		$criteria->compare('users__id',$this->users__id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('second_name',$this->second_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('adress',$this->adress,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('birthday',$this->birthday,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Profile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getFullName($users__id)
	{
		$fullName = '';
		if($users__id < (int)TRUE)
		{
			return $fullName;
		}
		
		$model = Profile::model()->find('users__id = :users__id', array(':users__id' => $users__id));
		
		$fullName = "".$model->last_name." ".$model->first_name." ".$model->second_name."";
		
		return $fullName;
	}
}
