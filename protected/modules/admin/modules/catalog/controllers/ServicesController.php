<?php

class ServicesController extends Controller
{
	public $layout = '//layouts/admin';
	
	public function actionIndex()
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$services = Services::model()->findAll();
		
		$this->render('index', array('catalog' => $services));
	}
	
	public function actionEdit($id)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		if(empty($id))
		{
			$this->redirect('/admin/catalog/services');
		}
		
		$services = Services::model()->findByPk($id);
		if(!empty($_POST) && array_key_exists('btn_edit', $_POST))
		{
	
			$services->name = $_POST['Services']['name'];
			$services->alias = $_POST['Services']['alias'];
			$services->level = $_POST['Services']['level'];
			$services->is_visible = $_POST['Services']['is_visible'];
			$services->url = strstr($_POST['Services']['url'], '/page');
			
			if($services->validate())
			{
				if(!$services->save())
				{
					var_dump($services->getErrors());
					throw new CException('ошибка сохранения таблицы для услуг', E_USER_ERROR);
					
				}
				
				$services->image = CUploadedFile::getInstance($services,'image');
				if(!empty($services->image))
				{
					$path = Yii::getPathOfAlias('webroot').'/upload/'.$services->image->getName();
					if(file_exists($path)) 
					{
						unlink($path);
					}
					$services->image->saveAs($path);
					$services->image = $services->image->getName();
					$services->save();
				}
				$this->redirect('/admin/catalog/services');
			}
			
		}
		
		
		$this->render('edit', array('catalog' => $services));
	}
	
	public function actionCreate()
	{
	if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$services = new Services();
		
		if(!empty($_POST) && array_key_exists('btn_create', $_POST))
		{
		
			$services->attributes = $_POST['Services'];
			$services->image=CUploadedFile::getInstance($services,'image');
			if($services->validate())
			{
				if(!$services->save())
				{
					
					var_dump($services->getErrors());
					throw new CException('ошибка сохранения таблицы для услуг', E_USER_ERROR);
					
				}
				$path=Yii::getPathOfAlias('webroot').'/upload/'.$services->image->getName();
                $services->image->saveAs($path);
				$this->redirect('/admin/catalog/services');
			}
			else
			{
					var_dump($services->getErrors());
					throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
			
			}
			
		}
		
		
		$this->render('create', array('catalog' => $services));
	}
	
	public function actionDelete($id)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		if(empty($id))
		{
			$this->redirect('/admin/catalog/services');
		}
		
		$services = Services::model()->findByPk($id);
		if($services->is_visible == (int)FALSE)
		{
			$services->is_visible = (int)TRUE;
		}
		else
		{
			$services->is_visible = (int)FALSE;
		}
			
		if($services->validate())
		{
			if(!$services->save())
			{
				var_dump($services->getErrors());
				throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
				
			}
			$this->redirect('/admin/catalog/services');
		}
		
		$this->redirect('/admin/catalog/services');
	}
}