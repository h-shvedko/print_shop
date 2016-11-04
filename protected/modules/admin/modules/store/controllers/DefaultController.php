<?php

class DefaultController extends Controller
{
	public $layout = '//layouts/admin';
	
	public function actionIndex()
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$horders = Horders::model()->findAll();
		
		$this->render('index', array('horders' => $horders));
	}
	
	public function actionAjaxGetHorder()
	{
	
		$criteria = new CDbCriteria();
		$criteria->order = "id DESC";
		$horders = Horders::model()->findAll($criteria);
		
		$result = array();
		$i = (int)TRUE;
		foreach($horders as $value)
		{
			$orders = array();
			$k = 1;
			foreach($value->orders as $order)
			{
				$orders[] = array(
					'npp' => $k,
					'srok' => $order->product->sroki,
					'product' => $order->product->name,
					'tirazh' => $order->product->tirazh,
					'material' => $order->product->material,
					'pokritie' => $order->product->pokritie,
					'amount' => $order->price,
					'cnt' => $order->cnt,
					);
					$k++;
			}
			$result[] = array(
					'id' => $value->id,
					'npp' => $i,
					'num' => $value->num,
					'user' => $value->user->username,
					'status' => $value->statuses->name,
					'phone' => $value->phone,
					'email' => $value->email,
					'total_price' => Horders::getTotalPrice($value->id),
					'date_horder' => date("d.m.Y H:i", strtotime($value->date_horder)),
					'orders' => $orders,
				);
			$i++;
		}
		
		echo  CJSON::encode($result);
	}
	
	public function actionchangeStatus()
	{
		$params = CJSON::decode(file_get_contents('php://input'), true);

		$horder = Horders::model()->findByPk($params['id']);
		
		$horder->status__id =  $params['status'];
		
		if(!$horder->save())
		{
			throw new CHttpException(500,'Ошибка изменения статуса');
		}
		
		echo  CJSON::encode("OK");
	}
	
	public function actionAjaxGetStatuses()
	{
		$model = HordersStatuses::model()->findAll();
		
		echo  CJSON::encode($model);
	}
}