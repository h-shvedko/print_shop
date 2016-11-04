<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $price
 * @property string $price_client
 * @property string $price_agency
 * @property integer $sides
 * @property string $material
 * @property string $pokritie
 * @property integer $sroki
 * @property integer $tirazh
 */
class Products extends CActiveRecord
{

	const PERSENT_FOR_CLIENT = 0.2;
	const PERSENT_FOR_AGENCY = 0.1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('name, alias, price, price_client', 'required'),
			//array('sroki', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>250),
			array('alias, material, pokritie', 'length', 'max'=>255),
			array('price, price_client, price_agency', 'length', 'max'=>19),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, alias, price, price_client, price_agency, sides, material, pokritie, sroki, tirazh, is_used', 'safe', 'on'=>'search'),
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
			'side' => array(self::BELONGS_TO, 'Sides', 'sides'),
			'catalog' => array(self::MANY_MANY, 'Catalog', 'catalog_products(product__id, catalog__id)'),
			'weights' => array(self::HAS_ONE, 'ProductsWeight', 'products__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'alias' => 'Alias',
			'price' => 'Цена',
			'price_client' => 'Цена для клиентов',
			'price_agency' => 'Цена для агенств',
			'sides' => 'Стороны',
			'material' => 'Материал',
			'pokritie' => 'Покрытие',
			'sroki' => 'Сроки',
			'tirazh' => 'Тираж',
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
		$criteria->compare('sides',$this->sides);
		$criteria->compare('material',$this->material,true);
		$criteria->compare('pokritie',$this->pokritie,true);
		$criteria->compare('sroki',$this->sroki);
		$criteria->compare('tirazh',$this->tirazh);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Products the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function findByAlias($alias)
	{
		$model = $this->find('alias = :alias', array(':alias' => $alias));
		
		return $model;
	}
	
	public function findAllByAlias($alias)
	{
		$model = $this->findAll('alias = :alias', array(':alias' => $alias));
		
		return $model;
	}
	
	public function finbByLikeAlias($alias)
	{
		$criteria = new CDBCriteria();
		$criteria->condition = 'alias LIKE :alias';
		$criteria->params = array(':alias' => $alias.'%');
		
		$model = $this->findAll($criteria);
		
		return $model;
	}
	
	public static function getSide($name)
	{
		$side = Sides::model()->findByName($name);
		
		return $side->id;
	}
	
	public static function getNames()
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'distinct name as name';
		
		$model = Products::model()->findAll($criteria);
		
		$result = array();
		
		foreach($model as $value)
		{
			$result[] = $value->name;
		}
		
		return $result;
	}
	
	public static function getPokritie()
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'distinct pokritie as pokritie';
		
		$model = Products::model()->findAll($criteria);
		
		$result = array();
		
		foreach($model as $value)
		{
			$result[] = $value->pokritie;
		}
		
		return $result;
	}
	
	public static function getMaterial()
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'distinct material as material';
		
		$model = Products::model()->findAll($criteria);
		
		$result = array();
		
		foreach($model as $value)
		{
			$result[] = $value->material;
		}
		
		return $result;
	}
	
	public static function getTirazh($alias = FALSE)
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'distinct tirazh as tirazh';
		if($alias !== FALSE)
		{
			$criteria->condition = 'alias = :alias';
			$criteria->params = array(':alias' => $alias);		
		}
		
		$model = Products::model()->findAll($criteria);
		
		$result = array();
		
		foreach($model as $value)
		{
			$result[] = $value->tirazh;
		}
		
		return $result;
	}
	
	public static function getSroki($alias)
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'distinct sroki as sroki';
		$criteria->condition = 'alias = :alias';
		$criteria->params = array(':alias' => $alias);
	
		$model = Products::model()->findAll($criteria);
		
		$result = array();
		
		foreach($model as $value)
		{
			$result[] = $value->sroki;
		}
		
		return $result;
	}
	
	public static function getPrice($alias, $tirazh, $sroki)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'alias = :alias and tirazh = :tirazh and sroki = :sroki';
		$criteria->params = array(':alias' => $alias, 'tirazh' => $tirazh, 'sroki' => $sroki);
		
		$model = Products::model()->find($criteria);
		
		$result = array();
		
		if($model instanceof Products)
		{
			$result['id'] = $model->id;
			if(Yii::app()->user->checkAccess('agency'))
			{
				$result['price'] = $model->price_agency;
			}
			else
			{
				$result['price'] = $model->price_client;
			}
		}
		
		return $result;
	}
	public static function getProductsByCatalog($catalog)
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'distinct t.name as name, t.alias as alias';
		$criteria->condition = 'is_used = 0';
		$criteria->with = array(
			'catalog' => array(
				'condition' => 'catalog.id = :id',
				'params' => array(':id' => $catalog),
			),
		);
		$model = Products::model()->findAll($criteria);
		
		$result = array();
		
		foreach($model as $value)
		{
			if(!in_array(array('alias' => $value->alias, 'name' => $value->name), $result))
			{
				$result[] = array('alias' => $value->alias, 'name' => $value->name);
			}
		}
	
		return $result;
	}
	
	public static function disableProduct($id = FALSE)
	{
		if($id == FALSE)
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$model = Products::model()->findByPk($id);
		
		if($model instanceof Products)
		{
			$model->is_used = (int)TRUE;
			$model->save();
		}
		else
		{
			throw new CHttpException(404,'Not Found');
		}
	}
	
	public static function enableProduct($id = FALSE)
	{
		if($id == FALSE)
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$model = Products::model()->findByPk($id);
		
		if($model instanceof Products)
		{
			$model->is_used = (int)FALSE;
			$model->save();
		}
		else
		{
			throw new CHttpException(404,'Not Found');
		}
	}
	
	public static function removeProduct($id = FALSE)
	{
		if($id == FALSE)
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$model = Products::model()->findByPk($id);
		
		if($model instanceof Products)
		{
			Products::model()->deleteByPk($id);
		}
		else
		{
			throw new CHttpException(404,'Not Found');
		}
	}
	
	
}
