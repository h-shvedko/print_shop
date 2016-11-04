<?php

class DefaultController extends Controller
{
	public $layout = '//layouts/admin';
	public function actionIndex($unit = FALSE)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		if($unit == FALSE)
		{
			$unit = 10;
		}
		if(isset($_POST) && array_key_exists('btn-unit', $_POST))
		{
			$unit = $_POST['unit'];
			$this->redirect($this->createUrl('/admin/user/default/index/unit/'.$unit));
		}
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'username != :username';
		$criteria->params = array(':username' => 'admin');
		
		$count = Users::model()->count($criteria);
		
        $pages = new CPagination($count);
        $pages->pageSize = $unit;
        $pages->applyLimit($criteria);  
		
		$model = Users::model()->findAll($criteria);
		
		$this->render('index', 
			array(
				'model' => $model,
				'pages' => $pages
			));
	}
	
	public function actionBlock($id)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		if(empty($id))
		{
			$this->redirect('/admin/user/default/index');
		}
		
		$user = Users::model()->findByPk($id);
		if($user->is_blocked == (int)FALSE)
		{
			$user->is_blocked = (int)TRUE;
		}
		else
		{
			$user->is_blocked = (int)FALSE;
		}
			
		if($user->validate())
		{
			if(!$user->save())
			{
				var_dump($user->getErrors());
				throw new CException('ошибка блокирования/разблокирования пользователя', E_USER_ERROR);
				
			}
			$this->redirect('/admin/user/default/index');
		}
		
		$this->redirect('/admin/user/default/index');
		
	}
	
	public function actionEdit($id)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
	
		$users = Users::model()->findByPk($id);
		$profile = $users->profile;
		
		$errors = array();
		$success = FALSE;
		if(isset($_POST) && array_key_exists('btn_reg',$_POST))
		{
		
			$users->attributes = $_POST['Users'];
			$users->user_role__id = $roleUser->id;
			$profile->attributes = $_POST['Profile'];
			
			$validate = $users->validate();
			
			if($validate)
			{
				$profileTransaction = Yii::app()->db->beginTransaction();
				try 
				{
					if(!$users->save())
					{
						throw new CException('Пользователь не изменен ошибка в таблице Users', E_USER_ERROR);
					}
					$profile->users__id = $users->id;
					$validate = $profile->validate();
					
					if($validate)
					{
						if(!$profile->save())
						{
							throw new CException('Пользователь не изменен ошибка в таблице Profile', E_USER_ERROR);
						}
						$profileTransaction->commit();
						$success = TRUE;
					}
					else
					{
						$errors['Profile'] = $profile->getErrors();
					}
				}
				catch (Exception $e) 
				{
					if ($profileTransaction->getActive()) {
						$profileTransaction->rollback();
					}
					throw new CException($e->getMessage());
				}
			}
			else
			{
				$errors['Users'] = $users->getErrors();
			}
		}
		
		$this->render('edit', 
			array(
				'users' => $users,
				'profile' => $profile,
				'success' => $success,
			));
	}
	
	public function actionCreate()
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
	
		$users = new Users();
		$profile = new Profile();
		
		$errors = array();
		$success = FALSE;
		
		if(isset($_POST) && array_key_exists('btn_reg',$_POST))
		{
		
			$users->attributes = $_POST['Users'];
			$users->user_role__id = $roleUser->id;
			$profile->attributes = $_POST['Profile'];
			
			$validate = $users->validate();
			
			if($validate)
			{
				$profileTransaction = Yii::app()->db->beginTransaction();
				try 
				{
					if(!$users->save())
					{
						throw new CException('Пользователь не зарегистрирован из админки ошибка в таблице Users', E_USER_ERROR);
					}
					$profile->users__id = $users->id;
					$validate = $profile->validate();
					
					if($validate)
					{
						if(!$profile->save())
						{
							throw new CException('Пользователь не зарегистрирован из админки ошибка в таблице Profile', E_USER_ERROR);
						}
						$profileTransaction->commit();
						$success = TRUE;
					}
					else
					{
						$errors['Profile'] = $profile->getErrors();
					}
				}
				catch (Exception $e) 
				{
					if ($profileTransaction->getActive()) {
						$profileTransaction->rollback();
					}
					throw new CException($e->getMessage());
				}
			}
			else
			{
				$errors['Users'] = $users->getErrors();
			}
		}
		
		$this->render('create', 
			array(
				'users' => $users,
				'profile' => $profile,
				'success' => $success,
			));
	}
}