<script>
$(document).ready(function(){
	
$('#catalogs').change(function() {
	
	var value = $('#catalogs').val();
	$.ajax({
        url	: '/admin/catalog/products/Ajaxproducts/id/'+value,
        error	: function ()
        {
            alert('Ошибка запроса');
        },
        success	: function(data)
        {
			$('#products-list').fadeIn(500);
			$('#weight-list').fadeOut(500);
			$('#tirazh-list').fadeOut(500);
			$('.btn').fadeOut(500);
			
			$('#products').html('');
			$('#products').html(data);
        },
        data	:
        {   
            value : value,
        },
        async		: false,
        cache		: false,
        type        : "POST",
    });

});

$('#products').change(function() {
	
	var value = $('#product').val();
	$.ajax({
        url	: '/admin/catalog/products/Ajaxproductstirazh/id/'+value,
        error	: function ()
        {
            alert('Ошибка запроса');
        },
        success	: function(data)
        {
			$('#weight-list').fadeOut(500);
			$('#tirazh-list').fadeIn(500);
			$('.btn').fadeOut(500);
	
			
			$('#tirazhs').html('');
			$('#tirazhs').html(data);
        },
        data	:
        {   
            value : value,
        },
        async		: false,
        cache		: false,
        type        : "POST",
    });
	
});
$('#tirazh-list').change(function() {
	$('.btn').fadeOut(500);
	$('#weight-list').fadeIn(500);
});
$('#weight').change(function() {
	$('.btn').fadeIn(500);
});
$('.checkall').click(function() {
	if($(".checkall").is(":checked"))	
	{
		$(".check").attr("checked","checked");
	}
})
})
</script>

<div style="margin-top: 50px;"></div>
<h3>Редактирование веса для продуктов</h3>
<div>
<? if (empty($errors) && $result == FALSE) : ?>
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false)); ?>
	<hr>
	<div class="row-fluid" id="catalog-list">
		<div class="span2">
			Выберите каталог
		</div>
		<div class="span10">
			<?=CHtml::dropDownList('catalogs',$catalogs, Catalog::getCatalog(), array('id' => 'catalogs', 'empty' =>''))?>
		</div>
	</div>
	<hr>
	<div class="row-fluid" id="products-list" style="display: none;">
	
		<div class="span2">
			Выберите продукт
		</div>
		<div class="span10" id="products">
			<select name="Products" value="" id="product"></select>
		</div>
	</div>
	<hr>
	<div class="row-fluid" id="tirazh-list" style="display: none;">
	
		<div class="span2">
			Выберите тираж
		</div>
		<div class="span10" id="tirazhs">
			<select name="tirazh" value="" id="tirazh"></select>
		</div>
	</div>
	<hr>
	<div class="row-fluid" id="weight-list" style="display: none;">
		<div class="span2">
			Введите вес продукта
		</div>
		<div class="span3" id="weight">
			<input name="weight" value="" class="form-control" id="weight" type="text" pattern="[0-9]{1,7}" />
		</div>
	</div><hr>
	<?= CHtml::submitButton(Yii::t('app', 'Сохранить'), array('name' => 'save_weight', 'class' => 'btn btn-default', 'style' => 'display: none;')); ?>
<?php $this->endWidget(); ?>
	
<? elseif(empty($errors) && $result == TRUE) : ?>
<div class="span12" style="background-color: #58FA82; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
	Изменения успешно сохранены.
</div><br>
<div class="span12">
	<a href="/admin/catalog/products/weight" class="btn btn-default">Продолжить редактирование веса товара</a>
</div>
<?else:?>


<div class="span12" style="background-color: #f490ab; border-radius: 5px; padding: 20px; margin-bottom: 10px;">
<h4>Ошибка сохранения</h4>
<? foreach($errors as $error):?>
	<?=$error?><br>
<?endforeach;?>
</div>	
<? endif;?>
</div>
