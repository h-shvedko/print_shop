<script>
$(function(){
		
		var templ = $('#templ').html();
		$('#selected').click(function(){
				$('.selected').fadeIn(500);
				$('.fill').fadeOut(100);
				$('.btn-primary').fadeIn(500);
				$('#filled').append(templ);
				$('#fill-add').html('');
				
			});
			
			$('#fill').click(function(){
				$('.btn-primary').fadeIn(500);
				$('.selected').fadeOut(100);
				$('.fill').fadeIn(500);
				$('#fill-add').append(templ);
				$('#filled').html('');
				
			});
			
			$('#deliveries').change(function(){
				$('#filled').fadeIn(500);
			});
			
			<?if(Yii::app()->user->isGuest):?>
				$('#filled').html('');
				$('#fill-add').html('');
				$('.btn-primary').fadeIn(500);
			<?else:?>
				$('.fill-guest').html('');
			<?endif;?>
		
		$('#deliveries').change(function(){
			
			var id = $(this).val();
			$.ajax({
				url	: '/store/order/AjaxDeliveries',
				error	: function ()
				{
					alert('Ошибка запроса');
				},
				success	: function(data)
				{
					$('.country').val(data.country);
					$('.region').val(data.region);
					$('.city').val(data.city);
					$('.adress').val(data.adress);
				},
				data	:
				{   
					id: id
				},
				async		: false,
				cache		: false,
				type        : "POST",
				dataType : "JSON"
			});
				
		});
	});
	
</script>
<style>
.btn
{
	background-color: #C9DCEB;
	background-image: none;
}
.control-label
{
	text-align: left !important;
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
 a.btn
 {
	 height: 32px !important;
	  font-size: 14px !important;
 }
 
  a.btn:active
  {
	  background-color: #e6e6e6 !important;
  }
  #templ{display: none;}
  
  .fileinput-button
  {
	padding-left: 4px;
  }
  .fileinput-button, .start, .delete, .cancel
  {
	width: 30px !important;
  }
  
  .fileinput-button:hover, .start:hover, .delete:hover, .cancel:hover
  {
    opacity: 0.5;
  }
  
</style>
<div class="span12"><h1 class="title">Ваш заказ</h1></div>

<?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false,'htmlOptions'=>array('enctype'=>'multipart/form-data', 'novalidate' => 'novalidate'))); ?>
<?if(count($horders->getErrors())> (int)FALSE):?>
<div class="span12" style="background-color: #f490ab; border-radius: 5px; padding: 10px 0 10px 50px; margin-bottom: 10px; font-weight: bold; text-align:left;">
	Обнаружены ошибки:<br>
	<?php foreach ($horders->getErrors() as $error): ?>
			<?=current($error);?><br/>
		<?php endforeach; ?>
	<br>
	Исправте ошибки!!!
</div>
<?endif;?>
<div class="row-fluid">
	<?if($user->is_blocked):?>
		<div class="span12" style="background-color: rgb(204, 51, 51); border-radius: 5px; padding: 20px; margin-bottom: 10px;">
			<h4 style="text-transform: uppercase;">Ваш аккаунт заблокирован.</h4>
			<h4>Вы не можете оформлять заказы.</h4>
			<b>Для выяснения причин обратитесь к администратору или по телефону указанному на сайте.</b>
		</div>
	<?endif;?>
	<div class="span12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Срок</th>
					<th>Продукт</th>
					<th>Тираж</th>
					<th>Файлы</th>
					<th>Сумма</th>
					<th></th>
				</tr>
			</thead>
			<tbody ng-controller="StoreController as store">
				<tr>
					<td><?=$basket->product->sroki?></td>
					<td><?=$basket->product->name?></td>
					<td><?=$basket->product->tirazh?></td>
					<td>
						<?$this->widget( 'xupload.XUpload', array(
								'url' => Yii::app( )->createUrl( "/store/order/upload"),
								//our XUploadForm
								'model' => $photos,
								//We set this for the widget to be able to target our own form
								'htmlOptions' => array('id'=>'users-form'),
								'attribute' => 'file',
								'multiple' => true,
								//Note that we are using a custom view for our widget
								//Thats becase the default widget includes the 'form' 
								//which we don't want here
								//'formView' => 'application.modules.store.view.order._form',
								)    
							);
							?>
					</td>
					<td>
						<?if(Yii::app()->user->checkAccess('Agency')):?>
							<?=$basket->product->price_agency?>
						<?else:?>
							<?=$basket->product->price_client?>
						<?endif;?>
					</td>
					<td class="actions" data-title="удалить"><a  ng-click="basketDelete(<?=$basket->id?>)" class="delete"><i class="fa fa-trash fa-2x"></i></a></td>
				</tr>
			</tbody>

		</table>
		
		
	</div>
</div><hr>
<div class="span12" style="text-align: left !important;"><h3 class="title">Заполните Ваши данные</h3></div>
<div class="row-fluid">
	<div class="span6 form-horizontal">
		<div class="row-fluid">
			<div class="form-group">
				<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите e-mail*')?></label >
				<div class="col-sm-8">
					<?=$form->textField($horders, 'email', array('type' => 'email', 'required' => 'required', 'placeholder' => 'adres@gmail.com', 'class' => 'form-control input-lg'))?>
				</div>
			</div><hr>
		</div>
	</div>
	<div class="span6 form-horizontal">
		<div class="row-fluid">
			<div class="form-group">
				<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите телефон*')?></label >
				<div class="col-sm-8">
					<?=$form->textField($horders, 'phone', array('pattern' => '[0-9]{9,12}', 'required' => 'required', 'placeholder' => '0990010101', 'class' => 'form-control input-lg'))?>
				</div>
			</div><hr>
			
		</div>
	</div>
</div>
<input type="hidden" value="" id="form" />
<div class="row-fluid deliveries" <?if(Yii::app()->user->isGuest):?>style="display: none;" <?endif;?>>
	<div class="span12">
		<div class="row-fluid">
			<div class="span12"  style="text-align: left !important;"><h3 class="title">Способ Доставки</h3></div>
		</div>
		<div class="row-fluid" >
			<div class="span4">
				<a class="btn btn-default" id="selected"  ><?=Yii::t('app','Выбрать способ доставки из профиля')?></a>
			</div>
			<div class="span3">
				<a class="btn btn-default" id="fill" ><?=Yii::t('app','Указать другой')?></a>
			</div>
		</div><hr>
	</div>
</div>

<div class="selected" style="display: none;">
	<div class="row-fluid">
		<div class="span3">
			Выберите способ доставки из выпадающего списка
		</div>
		<div class="span3">
			<select id="deliveries" empty="">
				<option selected>Выберите способ доставки</option>
				<?foreach($deliveries as $delivery):?>
					<option id="delivery<?=$delivery->id?>" value="<?=$delivery->id?>"><?=$delivery->name?></option>
				<?endforeach;?>
			</select>
		</div>
	</div><hr>
	<div class="row-fluid" id="filled" style="display: none;">
		
	</div>
</div>

<div class="fill" style="display: none;">
	<div class="span12" style="text-align: left !important;"><h3 class="title">Заполните данные для доставки</h3></div>
	<div class="row-fluid" id="fill-add">
		
	</div>
</div>
<div class="fill-guest" <?if(!Yii::app()->user->isGuest):?>style="display: none;" <?endif;?>>
	<div class="span12" style="text-align: left !important;"><h3 class="title">Заполните данные для доставки</h3></div>
	<div class="row-fluid" id="fill-add">
		<div class="span6 form-horizontal">
		<div class="form-group">
			<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите страну*')?></label >
			<div class="col-sm-8">
				<?=$form->textField($horders, 'country', array('required' => 'required', 'placeholder' => 'Украина', 'class' => 'form-control input-lg'))?>
			</div>
		</div><hr>
		<div class="form-group">
			<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите город*')?></label >
			<div class="col-sm-8">
				<?=$form->textField($horders, 'city', array('required' => 'required', 'placeholder' => 'Николаев', 'class' => 'form-control input-lg'))?>
			</div>
		</div><hr>
	</div>
	<div class="span6 form-horizontal">
		<div class="form-group">
			<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите область*')?></label >
			<div class="col-sm-8">
				<?=$form->textField($horders, 'region', array('required' => 'required', 'placeholder' => 'Николаевская', 'class' => 'form-control input-lg'))?>
			</div>
		</div><hr>
		<div class="form-group">
			<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите улицу и дом*')?></label >
			<div class="col-sm-8">
				<?=$form->textField($horders, 'adress', array('required' => 'required', 'placeholder' => 'ул.Ленина д.1 кв 99', 'class' => 'form-control input-lg'))?>
			</div>
		</div><hr>
	</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<?if($user->is_blocked):?>
			<?= CHtml::button(Yii::t('app', 'Ваш аккаунт заблокирован'), array('name' => 'btn_buy', 'class' => 'btn btn-default')); ?>
		<?else:?>
			<?= CHtml::submitButton(Yii::t('app', 'Офомить заказ'), array('name' => 'btn_buy', 'class' => 'btn btn-primary', 'style' => 'display: none;')); ?>
		<?endif;?>
	</div>
</div>
<?php $this->endWidget(); ?>
<bR><bR><bR>

<div id="templ">
	<div class="span6 form-horizontal">
		<div class="form-group">
			<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите страну*')?></label >
			<div class="col-sm-8">
				<?=$form->textField($horders, 'country', array('required' => 'required', 'placeholder' => 'Украина', 'class' => 'form-control input-lg country', 'data-selection' => 'country'))?>
			</div>
		</div><hr>
		<div class="form-group">
			<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите город*')?></label >
			<div class="col-sm-8">
				<?=$form->textField($horders, 'city', array('required' => 'required', 'placeholder' => 'Николаев', 'class' => 'form-control input-lg city', 'data-selection' => 'city'))?>
			</div>
		</div><hr>
	</div>
	<div class="span6 form-horizontal">
		<div class="form-group">
			<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите область*')?></label >
			<div class="col-sm-8">
				<?=$form->textField($horders, 'region', array('required' => 'required', 'placeholder' => 'Николаевская', 'class' => 'form-control input-lg region', 'data-selection' => 'region'))?>
			</div>
		</div><hr>
		<div class="form-group">
			<label class="col-sm-4 control-label input-lg"><?=Yii::t('app','Укажите улицу и дом*')?></label >
			<div class="col-sm-8">
				<?=$form->textField($horders, 'adress', array('required' => 'required', 'placeholder' => 'ул.Ленина д.1 кв 99', 'class' => 'form-control input-lg adress', 'data-selection' => 'adress'))?>
			</div>
		</div><hr>
	</div>
</div>