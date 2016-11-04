<?php

class ProductsController extends Controller
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
			$this->redirect($this->createUrl('/admin/catalog/products/index/unit/'.$unit));
		}
		
		if(isset($_POST) && array_key_exists('btn-remove', $_POST) && array_key_exists('products',$_POST))
		{
			$products = $_POST['products'];
			foreach($products as $key => $product)
			{
				Products::removeProduct($key);
			}
		}
		
		if(isset($_POST) && array_key_exists('btn-switch-off', $_POST) && array_key_exists('products',$_POST))
		{
			$products = $_POST['products'];
			foreach($products as $key => $product)
			{
				Products::disableProduct($key);
			}
		}
		
		if(isset($_POST) && array_key_exists('btn-switch-on', $_POST) && array_key_exists('products',$_POST))
		{
			$products = $_POST['products'];
			foreach($products as $key => $product)
			{
				Products::enableProduct($key);
			}
		}
		
		session_start();
		
		$criteria = new CDbCriteria();
		$criteria->order = "t.alias";
		if(array_key_exists('filter', $_SESSION))
		{
			$filter = $_SESSION['filter'];
			$criteria->addColumnCondition($filter, 'AND');
		}
		if(array_key_exists('catalog', $_SESSION))
		{
			$catalog = $_SESSION['catalog'];
			$criteria->with = array(
				'catalog' => array(
					'condition' => 'catalog.id = :id',
					'params' => array(
						':id' => $catalog,
					),
					'together' => true,
				),
			);
		}
		

		$count = Products::model()->count($criteria);
		
        $pages = new CPagination($count);
        $pages->pageSize = $unit;
        $pages->applyLimit($criteria);  

		$products = Products::model()->findAll($criteria);
		
		$this->render('index', array('products' => $products, 'pages' => $pages));
	}
	
	public function actionEdit($id)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		if(empty($id))
		{
			$this->redirect('/admin/catalog/products');
		}
		
		$products = Products::model()->findByPk($id);
		$weight = $products->weights;
		if(!($weight instanceof ProductsWeight))
		{
			$weight = new ProductsWeight();
		}
		$sides = Sides::getSides();
		$ref = $_SERVER['HTTP_REFERER'];
		if(!empty($_POST) && array_key_exists('btn_edit', $_POST))
		{
			$products->attributes = $_POST['Products'];
			$products->sides = $_POST['Products']['sides'];
			$products->sroki = $_POST['Products']['sroki'];
			$products->tirazh = $_POST['Products']['tirazh'];
			if($products->validate())
			{
				if(!$products->save())
				{
					var_dump($products->getErrors());
					throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
					
				}
				$weight->products__id = $products->id;
				$weight->tirazh = $products->tirazh;
				$weight->weight = $_POST['ProductsWeight']['weight'];
				$weight->save();
				
				$this->redirect($_POST['ref']);
			}
			
			
			
		}
		
		
		$this->render('edit', array('products' => $products, 'sides' => $sides, 'ref' => $ref, 'weight' => $weight));
	}
	
	public function actionDelete($id)
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		if(empty($id))
		{
			$this->redirect('/admin/catalog/products');
		}
		
		if(!Products::model()->deleteByPk($id))
		{
			throw new CException('ошибка удаления данных из таблицы для прайсов', E_USER_ERROR);
		}
		
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function actionSides()
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		$products = Products::model()->findAll();
		$sides = Sides::getSides();
		$catalog = Catalog::getCatalog();
		if(!empty($_POST) && array_key_exists('btn_edit', $_POST))
		{var_dump($_POST); die;
			foreach($products as $product)
			{
				$product->sides = $_POST['Products']['sides'];
				
				if($product->validate())
				{
					if(!$product->save())
					{
						var_dump($product->getErrors());
						throw new CException('ошибка сохранения таблицы для прайсов (обновление сторон)', E_USER_ERROR);
						
					}
				}
			}
		}
		
		$catalogs =  Catalog::model()->findAll();
				
		$this->render('sides', array(
									'products' => $products, 
									'sides' => $sides,
									'catalog' => $catalog,
									'catalogs' => $catalogs,
									));
	}
	
	
	public function actionAjaxlistproducts($id)
	{
		$catalog = Catalog::model()->with('products')->findByPk($id);
		$sides = Sides::getSides();
		echo  CJSON::encode(array(
			'content' => $this->renderFile($this->getViewFile('_product_list'), array(
				'catalog' => $catalog,
				'sides' => $sides,
			), TRUE),
		));
	}
	
	public function actionAjaxproductstirazh($id)
	{
		$productModel = Products::model()->findByPk($id);
		$catalog = Products::model()->findAllByAlias($productModel->alias);
		
		$result = array();
		foreach($catalog as $key => $value)
		{
			if(!in_array($value->tirazh, $result))
			{
				$result[] = $value->tirazh;
			}
		}
		
		$products = "<select name=\"tirazh\" value=\"\" id=\"tirazh\">";
		$products .= "<option></option>";
		foreach($result as $key => $product)
		{
			$products .= "<option value=\"" . $product . "\">" . $product . "</option>";
		}
		$products .= "</select>";
		
		echo $products;
	}
	
	public function actionAjaxproducts($id)
	{
		$catalog = Catalog::model()->with('products')->findByPk($id);
		
		$products = "<select name=\"Products\" value=\"\" id=\"product\">";
		$products .= "<option></option>";
		foreach($catalog->products as $key => $product)
		{
			$products .= "<option value=\"" . $product->id . "\">" . $product->name . "</option>";
		}
		$products .= "</select>";
		
		echo $products;
	}
	
	public function actionAjaxsidesproducts()
	{
		if(isset($_POST) && array_key_exists('id', $_POST) && array_key_exists('sides', $_POST))
		{
			$id = $_POST['id'];
			$sides = $_POST['sides'];
			$product = Products::model()->findByPk($id);
			$side = Sides::model()->findByPk($sides);
			
			$product->sides = $side->id;
			$product->save();
			echo"OK";
		}
		
	}
	
	public function actionAjaxfilterproducts()
	{
		if(isset($_POST))
		{
			$result = array();
			
			if(array_key_exists('product_name', $_POST) && !empty($_POST['product_name']))
			{
				$name = $_POST['product_name'];
				$result['t.name'] = $name;
			}
			if(array_key_exists('catalog_name', $_POST) && !empty($_POST['catalog_name']))
			{
				$catalog_name = $_POST['catalog_name'];
			}
			if(array_key_exists('product_material', $_POST) && !empty($_POST['product_material']))
			{
				$material = $_POST['product_material'];
				$result['material'] = $material;
			}
			if(array_key_exists('product_sides', $_POST) && !empty($_POST['product_sides']))
			{
				$sides = $_POST['product_sides'];
				$result['sides'] = $sides;
			}
			if(array_key_exists('product_tirazh', $_POST) && !empty($_POST['product_tirazh']))
			{
				$tirazh = $_POST['product_tirazh'];
				$result['tirazh'] = $tirazh;
			}
			session_start();
			
			$_SESSION['filter'] = $result;
			
			if(isset($catalog_name))
			{
				$_SESSION['catalog'] = $catalog_name;
			}
			
			echo"OK";
		}
		
	}
	
	public function actionAjaxfilterresetproducts()
	{
		if(isset($_POST))
		{
			session_start();
			 unset($_SESSION['filter']);
			 session_destroy();
			echo"OK";
		}
		
	}
	
	public function actionWeight()
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$errors = array();
		$result = FALSE;
		
		if(isset($_POST) && array_key_exists('save_weight', $_POST))
		{ 
			$id = $_POST['Products'];
			$tirazh = $_POST['tirazh'];
			$weight = $_POST['weight'];
			
			$products = Products::model()->findByPk($id);
			
			$model = Products::model()->find('name = :name and tirazh = :tirazh', array(':name' => $products->name, ':tirazh' => $tirazh));
			
			if($model instanceof Products)
			{
				$weightModel = ProductsWeight::model()->find('products__id = :products__id and tirazh = :tirazh', array(':products__id' => $model->id, ':tirazh' => $model->tirazh));
				if($weightModel instanceof ProductsWeight)
				{
					$weightModel->weight = $weight;
					if(!$weightModel->save())
					{
						var_dump($weightModel->getErrors());
						throw new CException('ошибка сохранения таблицы для веса товара', E_USER_ERROR);
					}
					else
					{
						$result = TRUE;
					}
				}
				else
				{
					$weightModel = new ProductsWeight();
					$weightModel->products__id = $model->id;
					$weightModel->tirazh = $model->tirazh;
					$weightModel->weight = $weight;
					
					if($weightModel->validate())
					{
						if(!$weightModel->save())
						{
							var_dump($weightModel->getErrors());
							throw new CException('ошибка сохранения таблицы для веса товара', E_USER_ERROR);
						}
						else
						{
							$result = TRUE;
						}
					}
					else
					{
						$errors = $weightModel->getErrors();
						$result = FALSE;
					}
				}
			}
		}
		
		$this->render('weight', array(
				'result' => $result, 
				'errors' => $sides,
				));
	}
	
}