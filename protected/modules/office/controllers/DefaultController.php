<?php

class DefaultController extends Controller
{
	public $layout = '//layouts/main';
	
	public function actionIndex()
	{
		if(!Yii::app()->user->checkAccess('User'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'users__id = :users__id';
		$criteria->params = array(':users__id' => Yii::app()->user->id);
		
		$count = Horders::model()->count($criteria);
		
        $pages = new CPagination($count);
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);  
		
		$horders = Horders::model()->findAll($criteria);
		
		$this->render('index',array(
				'horders' => $horders,
				'pages' => $pages,
			));
	}
}