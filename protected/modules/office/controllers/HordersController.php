<?php

class HordersController extends Controller
{
	public $layout = '//layouts/main';
	
	public function actionView($id)
	{
		if(!Yii::app()->user->checkAccess('User'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$horders = Horders::model()->findByPk($id);
		
		$this->render('view',array(
				'horders' => $horders,
			));
	}
	
	public function actionCancel($id)
	{
		if(!Yii::app()->user->checkAccess('User'))
		{
			throw new CHttpException(403,'Forbidden');
		}
		
		$horder = Horders::model()->findByPk($id);
		
		$horder->status__id = HordersStatuses::getStatus(HordersStatuses::STATUS_DECLINED);
		
		$horder->save();
		
		$this->redirect('/office');
	}
}