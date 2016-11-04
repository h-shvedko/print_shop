<hr>
<div class="row-fluid">
	<div class="span12">
		<h1 class="title" style="font-size: 19px;">редактирование профиля</h1>
	</div>
</div>
<hr>
<div class="row-fluid">	
	<div class="span8">
	<h4 class="title">создание способа доставки:</h4>
	<?if(count($errors) > (int)FALSE):?>
		<div style="background-color: #f490ab; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
			<?foreach($errors as $error):?>
			<p><b><?=$error?></b></p>
			<?endforeach;?>
		</div>
	<?endif;?>
	<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'users-form',
	'enableAjaxValidation' => false,
	'htmlOptions' => array(
		'class' => 'form-horizontal', 
	))); ?>
		<table class="table table-hover">
			<tbody>
				<tr>
					<th>Введите название для доставки: </th>
					<td>
						<?=$form->textField($delivery, 'name', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите способ доставки')) ?>
					</td>
				</tr>
				<tr>
					<th>Введите страну доставки: </th>
					<td>
						<?=$form->textField($delivery, 'country', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите способ доставки')) ?>
					</td>
				</tr>
				<tr>
					<th>Введите регион доставки: </th>
					<td>
						<?=$form->textField($delivery, 'region', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите способ доставки')) ?>
					</td>
				</tr>
				<tr>
					<th>Введите город доставки: </th>
					<td>
						<?=$form->textField($delivery, 'city', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите способ доставки')) ?>
					</td>
				</tr>
				<tr>
					<th>Введите адресс доставки: </th>
					<td>
						<?=$form->textField($delivery, 'adress', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите способ доставки')) ?>
					</td>
				</tr>
			</tbody>
		</table>

		<div><?= CHtml::submitButton($user == NULL ? Yii::t('app', 'Сохранить') : Yii::t('app', 'Сохранить'), array('name' => 'delivery_add', 'class' => 'btn btn-primary')); ?></div>
		<?php $this->endWidget(); ?>
	</div>
	<div class="span4">
		<?if(!Yii::app()->user->checkAccess('Agency')):?>
			<a href="/office/agency" class="btn btn-default">Подать заявку для рекламного агенства</a>
			<hr>
		<?endif;?>
		<h4 class="title">Загрузить фото:</h4>
	</div>
</div>
<hr>
<br><br>