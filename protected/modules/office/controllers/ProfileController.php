<?php

class ProfileController extends Controller
{
	public $layout = '//layouts/main';
	
	public function actionIndex()
	{
		if(!Yii::app()->user->checkAccess('User'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$users = Users::model()->findByPk(Yii::app()->user->id);
		
		$this->render('index',array(
				'users' => $users,
			));
	}
	
	public function actionEdit()
	{
		if(!Yii::app()->user->checkAccess('User'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$users = Users::model()->findByPk(Yii::app()->user->id);
		if($users->profile instanceof Profile)
		{
			$profile = $users->profile;
		}
		else
		{
			$profile = new Profile();
		}
		$errors = array();
		$errorsUsers = array();
		$errorsProfile = array();
		
		$result = false;
		
		if(array_key_exists('btn_edit', $_POST))
		{
			$users->attributes = $_POST['Users'];
			$profile->attributes = $_POST['Profile'];
			
			if($users->validate())
			{
				if(!$users->save())
				{
					throw new CHttpException(500,'Ошибка сохранения профиля');
				}
				
				if($profile->isNewRecord)
				{
					$profile->users__id = $users->id;
				}
				if($profile->validate())
				{
					if(!$profile->save())
					{
						throw new CHttpException(500,'Ошибка сохранения профиля1');
					}
					$result = true;
				}
				else
				{
					$errorsProfile = $profile->getErrors();
				}
			}
			else
			{
				$errorsUsers = $users->getErrors();
			}
			
			$errors = array_merge($errorsUsers, $errorsProfile);
		}

		$this->render('edit',array(
				'users' => $users,
				'profile' => $profile,
				'errors' => $errors,
				'result' => $result,
			));
	}
	
	public function actionDelivery()
	{
		if(!Yii::app()->user->checkAccess('User'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$delivery = new UsersDeliveries();
		$errors = array();
		
		if(isset($_POST) && array_key_exists('delivery_add', $_POST))
		{
			$delivery->name = $_POST['UsersDeliveries']['name'];
			$delivery->users__id = Yii::app()->user->id;
			$delivery->country = $_POST['UsersDeliveries']['country'];
			$delivery->region = $_POST['UsersDeliveries']['region'];
			$delivery->city = $_POST['UsersDeliveries']['city'];
			$delivery->adress = $_POST['UsersDeliveries']['adress'];
			
			if($delivery->validate())
			{
				if(!$delivery->save())
				{
					throw new CHttpException(500,'Ошибка сохранения способа доставки');
				}
				$this->redirect('/office/profile');
			}
			else
			{
				$errors = $delivery->getErrors();
			}
			
		}
		
		$this->render('delivery',array(
				'delivery' => $delivery,
				'errors' => $errors,
			));
	}
	
	public function actionDeliveryDel($id = FALSE)
	{
		if(!Yii::app()->user->checkAccess('User'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		if($id == FALSE)
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$delivery = UsersDeliveries::model()->findByPk($id);
		
		$errors = array();
		
		if($delivery instanceof UsersDeliveries)
		{
			$delivery->delete();
		}
		
		$this->redirect('/office/profile');
	}
}