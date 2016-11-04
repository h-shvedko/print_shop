<?php

class CatalogController extends Controller
{
	public $layout = '//layouts/admin';
	
	public function actionIndex()
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$catalog = Catalog::model()->findAll();
		
		$this->render('index', array('catalog' => $catalog));
	}
	
	public function actionEdit($id)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		if(empty($id))
		{
			$this->redirect('/admin/catalog/catalog');
		}
		
		$catalog = Catalog::model()->findByPk($id);
		if(!empty($_POST) && array_key_exists('btn_edit', $_POST))
		{
	
			$catalog->attributes = $_POST['Catalog'];
			$catalog->tirazh1 = $_POST['Catalog']['tirazh1'];
			$catalog->tirazh2 = $_POST['Catalog']['tirazh2'];
			$catalog->price1 = $_POST['Catalog']['price1'];
			$catalog->price2 = $_POST['Catalog']['price2'];
			
			
			if($catalog->validate())
			{
				if(!$catalog->save())
				{
					var_dump($catalog->getErrors());
					throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
					
				}
				
				$catalog->image = CUploadedFile::getInstance($catalog,'image');
				if(!empty($catalog->image))
				{
					$path = Yii::getPathOfAlias('webroot').'/upload/'.$catalog->image->getName();
					if(file_exists($path)) 
					{
						unlink($path);
					}
					$catalog->image->saveAs($path);
					$catalog->image = $catalog->image->getName();
					$catalog->save();
				}
				$this->redirect('/admin/catalog/catalog');
			}
			
		}
		
		
		$this->render('edit', array('catalog' => $catalog));
	}
	
	public function actionCreate()
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$catalog = new Catalog();
		
		if(!empty($_POST) && array_key_exists('btn_create', $_POST))
		{
			$catalog->attributes = $_POST['Catalog'];
			$catalog->image=CUploadedFile::getInstance($catalog,'image');
			if($catalog->validate())
			{
				if(!$catalog->save())
				{
					
					var_dump($catalog->getErrors());
					throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
					
				}
				$path=Yii::getPathOfAlias('webroot').'/upload/'.$catalog->image->getName();
                $catalog->image->saveAs($path);
				$this->redirect('/admin/catalog/catalog');
			}
			else
			{
					var_dump($catalog->getErrors());
					throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
			
			}
			
		}
		
		
		$this->render('create', array('catalog' => $catalog));
	}
	
	public function actionDelete($id)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		if(empty($id))
		{
			$this->redirect('/admin/catalog/catalog');
		}
		
		$catalog = Catalog::model()->findByPk($id);
		if($catalog->is_visible == (int)FALSE)
		{
			$catalog->is_visible = (int)TRUE;
		}
		else
		{
			$catalog->is_visible = (int)FALSE;
		}
			
		if($catalog->validate())
		{
			if(!$catalog->save())
			{
				var_dump($catalog->getErrors());
				throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
				
			}
			$this->redirect('/admin/catalog/catalog');
		}
		
		$this->redirect('/admin/catalog/catalog');
	}
}