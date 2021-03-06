<?php

/**
 * This is the model class for table "horders_statuses".
 *
 * The followings are the available columns in table 'horders_statuses':
 * @property integer $id
 * @property string $alias
 * @property string $name
 */
class HordersStatuses extends CActiveRecord
{

	const PAY_STATUS_OPEN = 0;
	const PAY_STATUS_CLOSE = 1;

	const STATUS_NEW = 'new';
	const STATUS_PROCESSING = 'processing';
	const STATUS_DELIVERING = 'delivering';
	const STATUS_CLOSED = 'closed';
	const STATUS_DECLINED = 'declined';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'horders_statuses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias', 'length', 'max'=>255),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, alias, name', 'safe', 'on'=>'search'),
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
			'alias' => 'Alias',
			'name' => 'Name',
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
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HordersStatuses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getStatus($alias)
	{
		$model = HordersStatuses::model()->find('alias = :alias', array(':alias' => $alias));
		
		return $model->id;
	}

}
