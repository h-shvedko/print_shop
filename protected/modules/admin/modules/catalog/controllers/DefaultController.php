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
		$this->render('index');
	}
	
	public function actionRelations()
	{
	if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		Yii::import('application.modules.admin.modules.pages.models.*');
		$catalogs = Catalog::model()->findAll('is_visible = :is_visible', array(':is_visible' => (int)TRUE));
		$pages = Pages::getPages();
		
		
		$this->render('relations', array('catalogs' => $catalogs, 'pages' => $pages));
	}
	
	public function actionAjaxpagescatalog()
	{	
	if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
	Yii::import('application.modules.admin.modules.pages.models.*');	
		if(isset($_POST) && array_key_exists('id', $_POST) && array_key_exists('catalog', $_POST))
		{
			$id = $_POST['id'];
			$catalog = $_POST['catalog'];
			$pages = Pages::model()->findByPk($id);
			$catalogs = Catalog::model()->findByPk($catalog);
			
			if(!empty($catalogs->pages))
			{
				$catPage = CatalogPages::model()->find('catalog__id = :catalog__id', array(':catalog__id' => $catalog));
				if($catPage instanceof CatalogPages)
				{
					$catPage->pages__id = $pages->id;
					$catPage->save();
				}
			}
			else
			{
				$catPage = new CatalogPages();
				$catPage->catalog__id = $catalogs->id;
				$catPage->pages__id = $pages->id;

				if(!$catPage->save())
				{
					$catPage->validate();
					var_dump($catPage->getErrors());
					throw new CException('ошибка сохранения таблицы связей каталога и страниц', E_USER_ERROR);
				}
			}
		}
	
	}
}