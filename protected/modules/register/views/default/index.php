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
<div class="row-fluid" >
	<div class="span12">
		<h3 class="titleH3">Регистрация</h3>
	</div>
	<div class="span12" style="background-color: #fcf8e3; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
		Поля помеченные *, обязательны для заполнения
	</div>
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
			'class' => 'form-horizontal register', 
		))); ?>
	<div class="span6 form-horizontal">
		<div class="row-fluid">
			<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Логин*')?></label >
				<div class="col-sm-10">
					<?=$form->textField($users, 'username', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите логин')) ?>
				</div>
			</div><hr>
			<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Имя*')?></label >
				<div class="col-sm-10">
					<?=$form->textField($profile, 'first_name', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите имя')) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Отчество')?></label >
				<div class="col-sm-10">
					<?=$form->textField($profile, 'second_name', array('class' => 'form-control input-lg', 'placeholder' => 'Введите отчество')) ?>
				</div>
			</div><hr>
			<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Телефон*')?></label >
				<div class="col-sm-10">
					<?=$form->textField($profile, 'phone', array('class' => 'form-control input-lg', 'type' => 'tel', 'pattern' => '[0-9]{10,15}', 'required' => 'required', 'placeholder' => 'Введите телефон')) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Страна')?></label >
				<div class="col-sm-10">
					<?=$form->textField($profile, 'country', array('class' => 'form-control input-lg', 'placeholder' => 'Введите страну')) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Город')?></label >
				<div class="col-sm-10">
					<?=$form->textField($profile, 'city', array('class' => 'form-control input-lg', 'placeholder' => 'Введите город')) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="span6 form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Пароль*')?></label >
			<div class="col-sm-10">
				<?=$form->passwordField($users, 'password', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите пароль')) ?>
			</div>
		</div><hr>
		<div class="form-group">
			<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Фамилия*')?></label >
			<div class="col-sm-10">
				<?=$form->textField($profile, 'last_name', array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Введите фамилию')) ?>
			</div>
		</div>
		<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Дата рождения')?></label >
				<div class="col-sm-10">
					<?=$form->textField($profile, 'birthday', array('class' => 'form-control input-lg', 'pattern' => '[0-9]{2}.[0-9]{2}.[0-9]{4}','placeholder' => 'В формате 01.01.2000')) ?>
				</div>
		</div><hr>
		<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','E-mail*')?></label >
				<div class="col-sm-10">
					<?=$form->textField($profile, 'email', array('class' => 'form-control input-lg', 'type' => 'email', 'required' => 'required', 'placeholder' => 'Введите e-mail')) ?>
				</div>
		</div>
		<div class="form-group">
				<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Область')?></label >
				<div class="col-sm-10">
					<?=$form->textField($profile, 'region', array('class' => 'form-control input-lg', 'placeholder' => 'Введите область')) ?>
				</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label input-lg"><?=Yii::t('app','Адрес')?></label >
			<div class="col-sm-10">
				<?=$form->textField($profile, 'adress', array('class' => 'form-control input-lg', 'placeholder' => 'Введите адрес')) ?>
			</div>
		</div>
	</div>
	<div class="row buttons" style="margin-top: 30px;">
        <?= CHtml::submitButton($user == NULL ? Yii::t('app', 'Зарегистрироваться') : Yii::t('app', 'Зарегистрироваться'), array('name' => 'btn_reg', 'class' => 'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><br><br><hr>