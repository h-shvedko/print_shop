<?php

class OrderController extends Controller
{
	 public function actions()
    {
        return array(
            'upload'=>array(
                'class'=>'xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
            ),
        );
    }
	
	public $layout = '//layouts/pages';
	
	public function actionIndex()
	{
		if(isset($_COOKIE['user_basket']))
		{
			$basket = Basket::model()->findAllBySession($_COOKIE['user_basket']);
			if(empty($basket))
			{
				$this->redirect('/');
			}
		}
		else
		{
			$this->redirect('/');
		}
				
		$deliveries = UsersDeliveries::getDeliveries(Yii::app()->user->id);
		
		$horders = new Horders();
		
		Yii::import( "xupload.models.XUploadForm" );
		
		$photos = new XUploadForm;
		
		if(isset($_POST) && array_key_exists('btn_buy', $_POST))
		{
			if(Yii::app()->user->isGuest)
			{
				$horders->users__id = (int)FALSE;
			}
			else
			{
				$horders->users__id = Yii::app()->user->id;
			}
			if(empty($_POST['pay_type']))
			{
				$horders->addError('pay_types__id', "Выберите способ оплаты");
			}
			if(empty($_POST['delivery_type']))
			{
				$horders->addError('delivery_type', "Выберите способ доставки");
			}
			if(empty($_POST['Horders']['email']))
			{
				$horders->addError('email', "Укажите e-mail");
			}
			
			if(empty($_POST['Horders']['phone']))
			{
				$horders->addError('email', "Укажите телефон");
			}
						
			$horders->pay_types__id = $_POST['pay_type'];
			$horders->delivery_types__id = $_POST['delivery_type'];
			$horders->is_paid = (int)FALSE;
			$horders->amount = Basket::getTotalPrice();
			$horders->date_horder = date("Y-m-d H:m:i");
			$horders->phone = $_POST['Horders']['phone'];
			$horders->email = $_POST['Horders']['email'];
			$horders->country = $_POST['Horders']['country'];
			$horders->region = $_POST['Horders']['region'];
			$horders->city = $_POST['Horders']['city'];
			$horders->adress = $_POST['Horders']['adress'];
			$horders->status__id = HordersStatuses::getStatus(HordersStatuses::STATUS_NEW);
			
			if($horders->validate())
			{
				$orderTransaction = Yii::app()->db->beginTransaction();
					try
					{
						if(!$horders->save())
						{
							
							var_dump($horders->getErrors());
							throw new CException('ошибка сохранения заказа', E_USER_ERROR);
						}
						
						$horders->num = Horders::getNum($horders->id);
						$horders->save();
						
						$orders = new Orders();
						$orders->horders__id = $horders->id;
						$orders->catalog_product__id = $basket->product->id;
						$orders->price = $basket->product->price_client;
						$orders->cnt = $basket->cnt;
							
						if(!$orders->save())
						{
							$orders->validate();
							var_dump($orders->getErrors());
							throw new CException('ошибка сохранения заказа', E_USER_ERROR);
						}
						
						$basket->status = Basket::STATUS_CLOSE;
						$basket->save();
						
						$result = Message::model()->addMessage($horders, MessageType::ORDER);
						
						$orderTransaction->commit();
						
						$this->redirect(array('complete', 'num' => $horders->num));

					}
					catch (Exception $e)
					{
						
						if ($orderTransaction->getActive())
						{
							$orderTransaction->rollback();
						}
						throw new CException($e->getMessage());
					}
					
					
					
			}
			
		}
		
		$user = Users::model()->findByPk(Yii::app()->user->id);
		
		$this->render('order',
			array(
				'basket' => $basket,
				'horders' => $horders,
				'user' => $user,
				'deliveries' => $deliveries,
				'photos' => $photos,
			));
	}
	
	public function actionComplete($num)
	{
		
		$this->render('complete',
			array(
				'num' => $num
			));
	
	}
	
	public function actionAjaxDeleteOrder($id)
	{
		if(isset($_COOKIE['user_basket']))
		{
			$basket = Basket::model()->findAllBySession($_COOKIE['user_basket']);
			if(empty($basket))
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
		
		Basket::model()->deleteByPk($basket->id);
			
		echo  CJSON::encode($result);
		
	}
	
	
	public function actionAjaxGetOrder()
	{
		if(isset($_COOKIE['user_basket']))
		{
			$basket = Basket::model()->findAllBySession($_COOKIE['user_basket']);
			if(empty($basket))
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
		
		$result = array();
		$i = (int)TRUE;
		foreach($basket as $value)
		{
			$result[] = array(
					'id' => $value->id,
					'npp' => $i,
					'srok' => $value->product->sroki,
					'product' => $value->product->name,
					'tirazh' => $value->product->tirazh,
					'material' => $value->product->material,
					'pokritie' => $value->product->pokritie,
					'amount' => $value->product->price_client,
				);
			$i++;
		}
		
		echo  CJSON::encode($result);
	}
	
	public function actionAjaxDeliveries()
	{
		$result = array();
		if(isset($_POST) && array_key_exists('id', $_POST))
		{
			$id = $_POST['id'];
			$userDelivery = UsersDeliveries::model()->findByPk($id);
			if(!($userDelivery instanceof UsersDeliveries))
			{
				echo  CJSON::encode($result);
				exit;
			}
			$result = array(
				'country' => $userDelivery->country,
				'region' => $userDelivery->region,
				'city' => $userDelivery->city,
				'adress' => $userDelivery->adress,
			);
		}
		echo  CJSON::encode($result);
	}
	
}