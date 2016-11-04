<hr>
<div class="row-fluid">
	<div class="span12">
		<h1 class="title" style="font-size: 19px;">редактирование профиля</h1>
	</div>
</div>
<hr>
<div class="row-fluid">	
	<div class="span8">
	<h4 class="title">личные данные:</h4>
	<?if(count($errors) > (int)FALSE):?>
		<div style="background-color: #f490ab; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
			<?foreach($errors as $error):?>
			<p><b><?=$error?></b></p>
			<?endforeach;?>
		</div>
	<?else:?>
		<? if ($result):?>
			<div style="background-color:  #87F717; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
				<p><b>Изменения успешно сохранены</b></p>
			</div>
		<?endif;?>
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
					<th>Логин: </th>
					<td><?=$users->username?></td>
				</tr>
				<tr>
					<th>ФИО: </th>
					<td>
					<?=$form->textField($profile, 'last_name', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите фамилию')) ?>
					<?=$form->textField($profile, 'first_name', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите имя')) ?>
					<?=$form->textField($profile, 'second_name', array('class' => 'form-control input-lg', 'placeholder' => 'Введите отчество')) ?>			
					</td>
				</tr>
				<tr>
					<th>Телефон: </th>
					<td>
						<?=$form->textField($profile, 'phone', array('class' => 'form-control input-lg', 'type' => 'tel', 'pattern' => '[0-9]{10,15}', 'required' => 'required', 'placeholder' => 'Введите телефон')) ?>
					</td>
				</tr>
				<tr>
					<th>E-mail: </th>
					<td>
						<?=$form->textField($profile, 'email', array('class' => 'form-control input-lg', 'type' => 'email', 'required' => 'required', 'placeholder' => 'Введите e-mail')) ?>
					</td>
				</tr>
				<tr>
					<th>Страна: </th>
					<td>
						<?=$form->textField($profile, 'country', array('class' => 'form-control input-lg', 'placeholder' => 'Введите страну')) ?>
					</td>
				</tr>
				<tr>
					<th>Регион: </th>
					<td>
						<?=$form->textField($profile, 'region', array('class' => 'form-control input-lg', 'placeholder' => 'Введите регион')) ?>
					</td>
				</tr>
				<tr>
					<th>Город: </th>
					<td>
						<?=$form->textField($profile, 'city', array('class' => 'form-control input-lg', 'placeholder' => 'Введите город')) ?>
					</td>
				</tr>
				<tr>
					<th>Дата рождения: </th>
					<td>
						<?=$form->textField($profile, 'birthday', array('class' => 'form-control input-lg', 'pattern' => '[0-9]{2}.[0-9]{2}.[0-9]{4}','placeholder' => 'В формате 01.01.2000')) ?>
					</td>
				</tr>
			</tbody>
		</table>

		<div><?= CHtml::submitButton($user == NULL ? Yii::t('app', 'Сохранить') : Yii::t('app', 'Сохранить'), array('name' => 'btn_edit', 'class' => 'btn btn-primary')); ?></div>
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