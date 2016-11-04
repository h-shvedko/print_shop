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
}