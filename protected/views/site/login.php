<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<style>
.form-group
{
	margin-bottom: 50px;
}

.form-horizontal .control-label {
 
    padding-top: 10px;
	width: 30% !important;
 }
 
 .form-horizontal .col-sm-10 {

	width: 60%!important;
 }
 .btn{
	color: black;
	height: 45px;
	font-size: 16px;
	font-weight: 400;
	text-transform: uppercase;
	transition: color 0.3s ease 0s;
	line-height: 1.3333333;
	border-radius: 6px;
 }
</style>
<h2 class="titleH3">Авторизация</h2>
<div class="row-fluid">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="span12" style="background-color: #fcf8e3; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
		Поля помеченные *, обязательны для заполнения
	</div>
	<div class="span5 form-horizontal">
		<div class="row-fluid">
			<?php echo $form->labelEx($model,'username', array('class' => 'col-sm-2 control-label input-lg')); ?>
			<div class="col-sm-10">
				<?php echo $form->textField($model,'username', array('class' => 'form-control input-lg')); ?>
				<?php echo $form->error($model,'username', array('class' => 'error')); ?>
			</div>
		</div>
	</div>
	<div class="span6 form-horizontal">
		<div class="row-fluid">
			<?php echo $form->labelEx($model,'password', array('class' => 'col-sm-2 control-label input-lg')); ?>
			<div class="col-sm-10">
				<?php echo $form->passwordField($model,'password', array('class' => 'form-control input-lg')); ?>
				<?php echo $form->error($model,'password', array('class' => 'error')); ?>
			</div>
		</div>
	</div>
<? /*
	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
*/?>
	<div class="span12 row buttons" style="margin-top: 30px;">
		<?php echo CHtml::submitButton('Войти', array('class' => 'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
<bR><br><hr>