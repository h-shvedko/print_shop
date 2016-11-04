<?php

/**
 * This is the model class for table "basket".
 *
 * The followings are the available columns in table 'basket':
 * @property integer $id
 * @property integer $catalog__product__id
 * @property integer $users__id
 * @property integer $cnt
 * @property string $phpsessid
 */
class Basket extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	const STATUS_OPEN = 1;
	const STATUS_CLOSE = 2;
	 
	public function tableName()
	{
		return 'basket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog__product__id, users__id, cnt, phpsessid', 'required'),
			array('catalog__product__id, users__id, cnt', 'numerical', 'integerOnly'=>true),
			array('phpsessid', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, catalog__product__id, users__id, cnt, phpsessid, status', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Products', 'catalog__product__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'catalog__product__id' => 'Catalog Product',
			'users__id' => 'Users',
			'cnt' => 'Cnt',
			'phpsessid' => 'Phpsessid',
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
		$criteria->compare('catalog__product__id',$this->catalog__product__id);
		$criteria->compare('users__id',$this->users__id);
		$criteria->compare('cnt',$this->cnt);
		$criteria->compare('phpsessid',$this->phpsessid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Basket the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function findAllBySession($sessionId)
	{
		$basket = Basket::model()->find('phpsessid = :phpsessid and status = :status', array(':phpsessid' => $sessionId, ':status' => self::STATUS_OPEN));
		
		return $basket;
	}
	
	
	public static function getUserCookie()
	{
		if (isset($_COOKIE['user_basket']))
		{
			return $_COOKIE['user_basket'];
		}

		$secret = sha1($_SERVER['REMOTE_ADDR'].time());

		setcookie('user_basket', $secret, time() + 86400, '/'); 
		return $secret;
	}
	
	public function addProduct($product, $countIncrease = 1)
	{
		if ((int) $countIncrease < 1)
		{
			throw new CHttpException(500, 'Количество продуктов для добавления в корзину указано не верно');
		}

		$productBasket = self::model()->productOpenBasket($product)->find();

		if ($productBasket instanceof Basket)
		{
			$productBasket->cnt = $productBasket->cnt + $countIncrease;
		}
		else
		{
			$productBasket = new Basket();
			if(Yii::app()->user->isGuest)
			{
				$productBasket->users__id = (int)FALSE;
			}
			else
			{
				$productBasket->users__id = Yii::app()->user->id;
			}
			$productBasket->phpsessid = Basket::getUserCookie();
			$productBasket->catalog__product__id = $product;
			$productBasket->status = self::STATUS_OPEN;
			$productBasket->cnt = $countIncrease;
		}
		
		return $productBasket->save();
	}
	
	public function productOpenBasket($product)
	{
		$this->with('product');
		$criteria = new CDbCriteria();
		$criteria->condition = 'phpsessid = :session_id AND t.status = :status AND catalog__product__id = :product_id AND product.id IS NOT NULL';
		$criteria->params = array(
			':status' => self::STATUS_OPEN,
			':session_id' => Basket::getUserCookie(),
			':product_id' => $product,
		);
		$this->dbCriteria->mergeWith($criteria);
		return $this;
	}
	
	public static function countProduct()
	{
		$session = $_COOKIE;
		
		 $baskets = Basket::model()->findAllBySession($session['user_basket']);
		
		$result = array();
		$cnt = (int)FALSE;
		$amount = (int)FALSE;
		foreach($baskets as $basket)
		{
			$cnt += $basket->cnt;
			$amount += $basket->product->price_client * $basket->cnt;
		}
		
		$result = array(
			'cnt' => $cnt,
			'amount' => $amount,
			);
			
		return $result;
	}
	
	public static function getTotalPrice()
	{
		$session = $_COOKIE;
		
		$baskets = Basket::model()->findAllBySession($session['user_basket']);
		 
		$amount = (int)FALSE;
		
		foreach($baskets as $basket)
		{
			$amount += $basket->product->price_client * $basket->cnt;
		}
		
		return $amount;
	
	}
	
}
