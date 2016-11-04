<div class="row-fluid">
	
	<h3>Создание пользователя</h3>
	<? if(!$success):?>
	<div class="span12" style="background-color: #fcf8e3; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
		Поля помеченные *, обязательны для заполнения
	</div>
	<?else:?>
	<div class="span12" style="background-color: #58FA82; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
		Изменения успешно сохранены.
	</div>
	<?endif;?>
	<? if(!empty($errors['Users']) || !empty($errors['Profile'])) : ?>
	<div class="span12" style="background-color: #f490ab; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
		<?if(!empty($errors['Users'])):?>
			<?foreach($errors['Users'] as $error):?>
				<b>- <?=$error[0]?></b><br>
			<?endforeach;?>
		<? endif;?>
		<?if(!empty($errors['Profile'])):?>
			<?foreach($errors['Profile'] as $error):?>
				<b>- <?=$error[0]?></b><br>
			<?endforeach;?>
		<?endif;?>
	</div>
	<?endif;?>
	
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'users-form',
		'enableAjaxValidation' => false,
		'htmlOptions' => array(
			'class' => 'form-horizontal', 
		))); ?>
	<div class="span6 form-horizontal">
		<div class="row-fluid">
			<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','Логин*')?></label>
				<div class="col-sm-10">
					<?=$form->textField($users, 'username', array('class' => 'form-control', 'required' => 'required', 'placeholder' => 'Введите логин')) ?>
				</div>
			</div><hr>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','Имя*')?></label>
				<div class="col-sm-10">
					<?=$form->textField($profile, 'first_name', array('class' => 'form-control', 'required' => 'required', 'placeholder' => 'Введите имя')) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','Отчество')?></label>
				<div class="col-sm-10">
					<?=$form->textField($profile, 'second_name', array('class' => 'form-control', 'placeholder' => 'Введите отчество')) ?>
				</div>
			</div><hr>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','Телефон*')?></label>
				<div class="col-sm-10">
					<?=$form->textField($profile, 'phone', array('class' => 'form-control', 'type' => 'tel', 'pattern' => '[0-9]{10,15}', 'required' => 'required', 'placeholder' => 'Введите телефон')) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','Страна')?></label>
				<div class="col-sm-10">
					<?=$form->textField($profile, 'country', array('class' => 'form-control', 'placeholder' => 'Введите страну')) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','Город')?></label>
				<div class="col-sm-10">
					<?=$form->textField($profile, 'city', array('class' => 'form-control', 'placeholder' => 'Введите город')) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="span6 form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label"><?=Yii::t('app','Пароль*')?></label>
			<div class="col-sm-10">
				<?=$form->passwordField($users, 'password', array('class' => 'form-control', 'required' => 'required', 'placeholder' => 'Введите пароль')) ?>
			</div>
		</div><hr>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?=Yii::t('app','Фамилия*')?></label>
			<div class="col-sm-10">
				<?=$form->textField($profile, 'last_name', array('class' => 'form-control', 'required' => 'required', 'placeholder' => 'Введите фамилию')) ?>
			</div>
		</div>
		<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','Дата рождения')?></label>
				<div class="col-sm-10">
					<?=$form->textField($profile, 'birthday', array('class' => 'form-control', 'pattern' => '[0-9]{2}.[0-9]{2}.[0-9]{4}','placeholder' => 'В формате 01.01.2000')) ?>
				</div>
		</div><hr>
		<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','E-mail*')?></label>
				<div class="col-sm-10">
					<?=$form->textField($profile, 'email', array('class' => 'form-control', 'type' => 'email', 'required' => 'required', 'placeholder' => 'Введите e-mail')) ?>
				</div>
		</div>
		<div class="form-group">
				<label class="col-sm-2 control-label"><?=Yii::t('app','Область')?></label>
				<div class="col-sm-10">
					<?=$form->textField($profile, 'region', array('class' => 'form-control', 'placeholder' => 'Введите область')) ?>
				</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?=Yii::t('app','Адрес')?></label>
			<div class="col-sm-10">
				<?=$form->textField($profile, 'adress', array('class' => 'form-control', 'placeholder' => 'Введите адрес')) ?>
			</div>
		</div>
	</div>
	<div class="row buttons" style="margin-top: 30px;">
		<?if(!$success):?>
        <?= CHtml::submitButton($user == NULL ? Yii::t('app', 'Создать') : Yii::t('app', 'Создать'), array('name' => 'btn_reg', 'class' => 'btn btn-default')); ?>
		<?endif;?>
		<a href="/admin/user" class="btn btn-default">Назад</a>
    </div>
<?php $this->endWidget(); ?>
</div><br><br><hr>