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
		$pages = Pages::model()->findAll();
		$this->render('index',array('pages' => $pages));
	}
	
	
	public function actionCreate()
	{
	if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$pages = new Pages();
		
		if(isset($_POST) && array_key_exists('btn_crt', $_POST))
		{
			$pages->attributes = $_POST['Pages'];
			
			if(!$pages->save())
			{
				$pages->validate();
				var_dump($pages->getErrors());
				throw new CException('ошибка сохранения таблицы контентных страниц', E_USER_ERROR);
			}
			$this->redirect('/admin/pages');
		}
		$this->render('create',array('pages' => $pages));
	}
	
	public function actionEdit($id)
	{
	if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$pages = Pages::model()->findByPk($id);
		
		if(isset($_POST) && array_key_exists('btn_save', $_POST))
		{
			$pages->attributes = $_POST['Pages'];
			
			if(!$pages->save())
			{
				$pages->validate();
				var_dump($pages->getErrors());
				throw new CException('ошибка сохранения таблицы контентных страниц', E_USER_ERROR);
			}
			$this->redirect('/admin/pages');
		}
		$this->render('edit',array('pages' => $pages));
	}
	
	public function actionDelete($id)
	{
	
	if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		if(empty($id))
		{
			$this->redirect('/admin/pages');
		}
		
		$pages = Pages::model()->findByPk($id);
		if($pages->is_visible == (int)FALSE)
		{
			$pages->is_visible = (int)TRUE;
		}
		else
		{
			$pages->is_visible = (int)FALSE;
		}
			
		if($pages->validate())
		{
			if(!$pages->save())
			{
				var_dump($pages->getErrors());
				throw new CException('ошибка сохранения таблицы для контентных страниц', E_USER_ERROR);
				
			}
			$this->redirect('/admin/pages');
		}
		
		$this->redirect('/admin/pages');
	}
	
	public function actionView($id)
	{
	
	if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		if(empty($id))
		{
			$this->redirect('/admin/pages');
		}
	
		$pages = Pages::model()->findByPk($id);
		$this->render('view',array('pages' => $pages));
	}
}