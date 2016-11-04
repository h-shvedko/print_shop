<?php
	Yii::import('application.modules.admin.modules.price.components.*');
	Yii::import('application.modules.admin.modules.catalog.models.*');
	require_once('simple_html_dom.php');
	require_once('reader.php');
	
class DefaultController extends Controller
{
	public $layout = '//layouts/admin';
	
	private $_data = array();
	
	public function vg($var, $depth = 3)
	{
		CVarDumper::dump($var, $depth, true);
	}
	public function actionIndex()
	{
		if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		ini_set('max_execution_time', "600");
		$max_file_size = 5; 
		$errors = array();
		$catalogs = Catalog::getCatalog();
		
		if(array_key_exists('btn_edit',$_POST))
		{
			ProductsTemp::model()->deleteAll();
			
			if($_FILES["filename"]["size"] > $max_file_size*1024*1024)
			{
				$errors[] = 'Размер файла превышает '.$max_file_size.' Мб!';
			}
			else
			{
			
				if(!copy($_FILES["filename"]["tmp_name"],$path.$_FILES["filename"]["name"]))
				{
					$errors[] = 'Ошибка загрузки файла xls';
				}
			}
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding("UTF-8");
			$data->read($_FILES["filename"]["name"]);
			
			$startCellRow = $_POST['startRow'];
			$startCellCol = $_POST['startCol'];
			$endCellRow = $_POST['endRow'] < $data->sheets[0]["numRows"]? $_POST['endRow']: $data->sheets[0]["numRows"];
			$endCellCol = $_POST['endCol'] < $data->sheets[0]["numCols"]? $_POST['endCol']: $data->sheets[0]["numCols"];
			$priceClient = array_key_exists('client', $_POST)? $_POST['client']: 0;
			$priceAgency = array_key_exists('agency', $_POST)? $_POST['agency']: 0;
			
			$name = array_key_exists('name', $_POST)? $_POST['name']: '';
			$catalog = Catalog::model()->findByPk($_POST['catalog']);
			$result = array();
			$resultClient = array();
			$resultAgency = array();
			for ($i=$startCellRow; $i<=$endCellRow; $i++)
			{
				if($i == $endCellRow)
				{
					for($j=$startCellCol; $j<=$endCellCol; $j++)
					{
						$weightTemp = new ProductsWeightTemp();
						$weightTemp->tirazh = (int)$result[1][$j];
						$weightTemp->weight = (float)addslashes(trim($data->sheets[0]["cells"][$i][$j]));
						$weightTemp->save();
					}
				}
				else
				{
					for($j=$startCellCol; $j<=$endCellCol; $j++)
					{
						if($j == $startCellCol || $i == $startCellRow)
						{
							$result[$i][$j] = addslashes(trim($data->sheets[0]["cells"][$i][$j])); 
							$resultClient[$i][$j] = addslashes(trim($data->sheets[0]["cells"][$i][$j])); 
							$resultAgency[$i][$j] = addslashes(trim($data->sheets[0]["cells"][$i][$j])); 
							continue;
						}
					
						$result[$i][$j] = ceil(addslashes(trim($data->sheets[0]["cells"][$i][$j]))); 
						$resultClient[$i][$j] = ceil($result[$i][$j] + $result[$i][$j] * $priceClient / 100); 
						$resultAgency[$i][$j] = ceil($result[$i][$j] + $result[$i][$j] * $priceAgency / 100);
						
						$temp = new ProductsTemp();
						$temp->name = $name;
						$temp->catalog__id = $_POST['catalog'];
						$temp->alias = Catalog::model()->rus2translit($name);
						$temp->price = (int)ceil($result[$i][$j]);
						$temp->price_client = (int)ceil($temp->price + $temp->price * $priceClient / 100);
						$temp->price_agency = (int)ceil($temp->price + $temp->price * $priceAgency / 100);
						$temp->sroki = $result[$i][1];
						$temp->tirazh = (int)$result[1][$j];
						
						if($temp->validate())
						{
							if(!$temp->save())
							{
								var_dump($temp->getErrors());
								throw new CException('ошибка сохранения временной таблицы для прайсов', E_USER_ERROR);
							}
						}
						else
						{
							$errors[] = $temp->getErrors();
							$this->render('index',array(
									'errors' => $errors,
									'catalogs' => $catalogs,
								)); exit;
						}
						
					}
				}
			}
			
		}
		
		if(array_key_exists('btn_load',$_POST))
		{
			$transaction =Yii::app()->db->beginTransaction();
				try
				{
					$temps = ProductsTemp::model()->findAll();
					
					foreach($temps as $temp)
					{
						$product = new Products();
						$product->attributes = $temp->attributes;
						$product->sroki = $temp->sroki;
						$product->tirazh = $temp->tirazh;
						
						if(!$product->save())
						{
							$product->validate();
							var_dump($product->getErrors());
							throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
						}
						
						$weight = new ProductsWeight();
						$weight->tirazh = $product->tirazh;
						$tempWeight = ProductsWeightTemp::model()->getTempWeight($product->tirazh);
						$weight->weight = ($tempWeight instanceof ProductsWeightTemp) ? $tempWeight->weight : '';
						$weight->products__id = $product->id;
						$weight->save();
						
						$catalog_products = new CatalogProducts();
						$catalog_products->catalog__id = $temp->catalog__id;
						$catalog_products->product__id = $product->id;
						
						if($catalog_products->validate())
						{
							if(!$catalog_products->save())
							{
								var_dump($catalog_products->getErrors());
								throw new CException('ошибка сохранения таблицы catalog_products для прайсов', E_USER_ERROR);
							}
						}
						else
						{
							$errors[] = $catalog_products->getErrors();
							$this->render('index',array(
									'errors' => $errors,
									'catalogs' => $catalogs,
								)); exit;
						}
					}
					

					
					ProductsTemp::model()->deleteAll();
					ProductsWeightTemp::model()->deleteAll();
					
					if(count($errors) < (int)TRUE)
					{
						$transaction->commit();
					}
		
				}
				catch(Exception $e)
				{
					$transaction->rollback();
					throw $e;
				}
		}
		$this->render('index',array(
				'errors' => $errors,
				'result' => $result,
				'resultClient' => $resultClient,
				'resultAgency' => $resultAgency,
				'catalogs' => $catalogs,
				'name' => $name,
				'catalog' => $catalog,
			));
	}
	
	public function actionWolf()
	{
	if(!Yii::app()->user->checkAccess('Admin'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		ini_set('max_execution_time', "600");
		$product = array();
		$body = array();
		$html = new simple_html_dom();
		$model = new Products();
		
	$transaction=$model->dbConnection->beginTransaction();
	try
	{
		for($i = 1; $i < 15; $i++)
		{
			$result = $this->Post($i);
			
			$html->load($result);
				
			for($j = 0; $j < 300; $j++)
			{
				$body= $html->find('div.about_product_in', $j);
				
				if(($body instanceof simple_html_dom_node) || ($body instanceof simple_html_dom))
				{
					
					$product[] = array(
						'price' => (int)$this->get_cifirki($body->find('div',0)->plaintext),
						'name' => $body->find('div',1)->plaintext,
						'pokritie' => $body->find('div',2)->plaintext,
						'sides' => $body->find('div',3)->plaintext,
						'material' => $body->find('div',4)->plaintext,
						'tirazh' => (int)$this->get_cifirki($body->find('div',5)->plaintext),
						);
						
				}
				
				
			}
			
		} 
		
		$productModel = Products::model()->findAll();
		
		if(count($productModel) > (int)FALSE)
		{
			if(!Products::model()->deleteAll())
			{
				throw new CException('ошибка очистки таблицы для прайсов', E_USER_ERROR);

			}
		}
		
		/*$catalogModel = Catalog::model()->findAll();
		
		if(count($catalogModel) > (int)FALSE)
		{
			if(!Catalog::model()->deleteAll())
			{
				throw new CException('ошибка очистки таблицы для каталога', E_USER_ERROR);

			}
		}*/
		
		$catalog = array();
		
		$matches = explode(' ', $product[0]['name']); 
		$matches = explode(',', $matches[0]); 
		$catalog[0] = $matches[0];
		$i = 1;
		
		foreach($product as $cat)
		{
			$matches = explode(' ', $cat['name']); 
			$matches = explode(',', $matches[0]); 
			
			if(!in_array(trim($matches[0]), $catalog))
			{	
				$catalog[$i] = trim($matches[0]);
				$i++;
			}
		}
	
		for($i = 0; $i < count($catalog); $i++)
		{
			for($j = $i+1; $j <count($catalog); $j++)
			{
			
				if(mb_substr($catalog[$i], 0, 4) == mb_substr($catalog[$j], 0, 4))
				{
					$catalog[$i] = 'abcdefg';
				}
			}
		}
		

		 foreach($catalog as $catl)
		 {
			$catalogModel = Catalog::model()->finbByAlias(Catalog::model()->rus2translit($catl));
				
			if($catl != 'abcdefg')
			{
			
				if($catalogModel instanceof Catalog)
				{
					$catalogModel->name = $catl;
					$catalogModel->alias = Catalog::model()->rus2translit($catl);
					$catalogModel->is_visible = (int)TRUE;
					$catalogModel->level = (int)TRUE;
					
					if(!$catalogModel->save())
					{
						$catalogModel->validate();
						var_dump($catalogModel->getErrors());
						throw new CException('ошибка сохранения обновлений таблицы для прайсов', E_USER_ERROR);
					}
					
				}
				else
				{
					$catModel = new Catalog();
					$catModel->id = $catalogModel->id;
					$catModel->name = $catl;
					$catModel->alias = Catalog::model()->rus2translit($catl);
					$catModel->is_visible = (int)TRUE;
					$catModel->level = (int)TRUE;
					
					if(!$catModel->save())
					{
						$catModel->validate();
						var_dump($catModel->getErrors());
						throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
					}
				}
			}
		 }

		foreach($product as $value)
		{
			$productModel = new Products();
			$productModel->name = $value['name'];
			$productModel->alias = Catalog::model()->rus2translit($value['name']);
			$productModel->price = round($value['price'],0);
			$productModel->price_client = round($value['price'] + $value['price'] * Products::PERSENT_FOR_CLIENT,0);
			$productModel->price_agency = round($value['price'] + $value['price'] * Products::PERSENT_FOR_AGENCY,0);
			$productModel->sides = Products::getSide($value['sides']);
			$productModel->material = $value['material'];
			$productModel->pokritie = $value['pokritie'];
			$productModel->tirazh = $value['tirazh'];
				
			if(!$productModel->save())
			{
				$productModel->validate();
				var_dump($productModel->getErrors());
				throw new CException('ошибка сохранения таблицы для прайсов', E_USER_ERROR);
			}
			
		} 
		
		$catalogModels = Catalog::model()->findAll('is_visible = :is_visible', array(':is_visible' => (int)TRUE));
		
		if(count($catalogModels) > (int)FALSE)
		{
			foreach($catalogModels as $model)
			{
				$productModels = Products::model()->finbByLikeAlias($model->alias);
		
				if(count($productModels) > (int)FALSE)
				{
					foreach($productModels as $pmodel)
					{
						$relayProduct = new CatalogProducts();
						$relayProduct->catalog__id = $model->id;
						$relayProduct->product__id = $pmodel->id;
						if(!$relayProduct->save())
						{
							$relayProduct->validate();
							var_dump($relayProduct->getErrors());
							throw new CException('ошибка сохранения связанной таблицы для прайсов', E_USER_ERROR);
						}
					}
				}
			}
		}
		
		$transaction->commit();
		
	}
	catch(Exception $e)
	{
		$transaction->rollback();
		throw $e;
	}
		
		$products = Products::model()->findAll();
		
		$this->render('index', array('products' => $products));
	}
	
	public function Post($i)
	{
		if( $curl = curl_init() ) 
		{
			curl_setopt($curl, CURLOPT_URL, 'http://zakaz.wolf.ua/price_left/fns/index.php');
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-REQUESTED-WITH: XMLHttpRequest'));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "load_price=load_price&group_id=".$i."&product_id=0&material_id=0&faceback_id=0&urgent_id=5&customer_id=&lng=ru&width=697");
			$out = curl_exec($curl);

			curl_close($curl);
		}
		if(!empty($out))
		{
			return $out;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_cifirki($str)
	{
	   $res='';
	   
	   $valid_char=array('1','2','3','4','5','6','7','8','9','0');

	   for($i=0;$i<strlen($str);$i++){
		  if(in_array($str[$i],$valid_char)){
			 $res.=$str[$i];
		  }
	   }
	   return $res;
	}
}