<?php

class DefaultController extends Controller
{
	public $layout = '//layouts/pages';
	
	public function actionIndex($id)
	{
		if(empty($id))
		{
			$this->redirect('/');
		}
		Yii::import('application.modules.admin.modules.pages.models.*');
		
		$catalog = Catalog::model()->with('products')->findByPk($id);
		
		$pages = Catalog::model()->with('pages')->findByPk($id);
		
		$catalogs = Catalog::model()->findAll(array(
									'condition' => 'is_visible = :is_visible and id != :id', 
									'params' =>array(':is_visible' => (int)TRUE, ':id' => $id),
									'limit' => round(count($catalog)*1.5,0)));
									
		$products = Products::getProductsByCatalog($id);
		
		$this->render('page',
			array(
				'catalog' => $catalog,
				'catalogs' => $catalogs,
				'pages' => $pages,
				'id' => $id,
				'products' => $products,
			));
	}
	
	
	public function actionServices()
	{
		
		$services = Services::model()->findAll('is_visible = :is_visible', array(':is_visible' => (int)TRUE));
	
		$this->render('services',
			array(
				'catalog' => $services,
			));
	
	}
	
	public function actionTurnicats()
	{
		
		$this->render('turnicats');
	
	}
	
	public function actionWall()
	{
		
		$this->render('wall');
	
	}
	public function actionLift()
	{
		
		$this->render('lift');
	
	}
	
	public function actionTransport()
	{
		
		$this->render('transport');
	
	}
	
	public function actionBigboard()
	{
		
		$this->render('bigboard');
	
	}
	
	public function actionAjaxAddBasket($id)
	{
		Yii::import('application.modules.store.models.*');
		
		Basket::model()->addProduct($id);
		
		$basketWidget = Basket::countProduct();
		
		echo  CJSON::encode(array(
			'content' => $basketWidget 
		));
	}
	
	public function actionAjaxGetBasket()
	{
		Yii::import('application.modules.store.models.*');
		
		if (!isset($_COOKIE['user_basket']))
		{
			Basket::getUserCookie();
		}
		
		$basketWidget = Basket::countProduct();
		
		echo  CJSON::encode(array(
			'content' => $basketWidget 
		));
	}

	
}