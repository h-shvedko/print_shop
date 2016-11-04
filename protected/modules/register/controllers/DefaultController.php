<?php

class DefaultController extends Controller
{
	public $layout = '//layouts/main';
	
	public function actionIndex()
	{
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect('/');
		}
		$users = new Users();
		$profile = new Profile();
		
		$errors = array();
		
		if(isset($_POST) && array_key_exists('btn_reg',$_POST))
		{
		
			$roleUser = UserRole::model()->find('name = :name', array(':name' => 'User'));
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
						throw new CException('Пользователь не зарегистрирован ошибка в таблице Users', E_USER_ERROR);
					}
					$profile->users__id = $users->id;
					$validate = $profile->validate();
					
					if($validate)
					{
						if(!$profile->save())
						{
							throw new CException('Пользователь не зарегистрирован ошибка в таблице Profile', E_USER_ERROR);
						}
						$profileTransaction->commit();
						$users->login();
						$this->redirect('/');
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
	
		$this->render('index', array(
				'users' => $users, 
				'profile' => $profile, 
				'errors' => $errors
			));
	}
}