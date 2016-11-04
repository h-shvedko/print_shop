<?php

class ProductsStats extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public static function getMaterial($id)
	{
		$catalogs = Catalog::model()->with('products')->findByPk($id);
		
		$material = array();
		foreach($catalogs->products as $product)
		{
			if(!in_array($product->material, $material))
			{
				$material[] = $product->material;
			}
		}
		
		return $material;
		
	}
	
	public static function getTirazh($catalog, $material)
	{
		$catalogs = Catalog::model()->with(array('products' => array(
												'condition' => 'material = :material', 
												'params' => array(
														':material' => $material,
														)
													)
											))->findByPk($catalog->id);
		
		$tirazh = array();
		foreach($catalogs->products as $product)
		{
			if(!in_array($product->tirazh, $tirazh))
			{
				$tirazh[] = $product->tirazh;
			}
		}
		
		return $tirazh;
	}
	
	
	public static function getName($catalog, $material)
	{
		$catalogs = Catalog::model()->with(array('products' => array(
												'condition' => 'material = :material', 
												'params' => array(
														':material' => $material,
														)
													)
											))->findByPk($catalog->id);
		
		$names = array();
		$pokrities = array();
		
		foreach($catalogs->products as $product)
		{
			if(!in_array($product->name, $names))
			{
				$names[] = $product->name;
			}
			if(!in_array($product->pokritie, $pokrities))
			{
				$pokrities[] = $product->pokritie;
			}
		}
		
		$result = array();
		foreach($names as $name)
		{
			foreach($pokrities as $pokritie)
			{
				$result[] = array(
					'name' => $name,
					'pokritie' => $pokritie,
				);
			}
		}
		
		return $result;
		
	}
	
	public static function getSides($catalog, $material, $name)
	{
		$catalogs = Catalog::model()->with(array('products' => array(
												'condition' => 'products.material = :material and products.name = :name', 
												'params' => array(
														':material' => $material,
														':name' => $name,
														)
													)
											))->findByPk($catalog->id);
		
		$sides = array();
		foreach($catalogs->products as $product)
		{
			if(!in_array($product->sides, $sides))
			{
				$sides[] = $product->sides;
			}
		}
		$result = array();
		foreach($sides as $side)
		{
			$result[] = array(
				'id' => Sides::model()->findByPk($side)->id,
				'sides' => Sides::model()->findByPk($side)->sides,
				);
		}
		
		return $result;
		
	}
	
	public static function getPrice($catalog, $material, $name, $pokritie, $side, $tirazh)
	{
	
		$catalogs = Catalog::model()->with(array('products' => array(
												'condition' => 'products.material = :material 
																and products.name = :name 
																and products.pokritie = :pokritie
																and products.sides = :sides
																and products.tirazh = :tirazh', 
												'params' => array(
														':material' => $material,
														':name' => $name,
														':tirazh' => $tirazh,
														':sides' => $side,
														':pokritie' => $pokritie,
														)
													)
											))->findByPk($catalog->id);
		$result = array();				
		if(Yii::app()->user->isGuest)
		{
			$result = array(
				'id' => $catalogs->products[0]->id,
				'price' => $catalogs->products[0]->price_client,
				);
			return $result;
		}
		else
		{
			$result = array(
				'id' => $catalogs->products[0]->id,
				'price' => $catalogs->products[0]->price_client,
				);
			return $result;
		}
	}
	
	
	
	
}
