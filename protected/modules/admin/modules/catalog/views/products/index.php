<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<script>
$(document).ready(function(){

	 
	$('#filter').click(function() {
		
		var catalog_name = $('#catalog_name option:selected').val();
		var product_name = $('#product_name option:selected').text();
		var product_pokritie = $('#product_pokritie option:selected').text();
		var product_material = $('#product_material option:selected').text();
		var product_sides = $('#product_sides').val();
		var product_tirazh = $('#product_tirazh option:selected').text();
		
		$.ajax({
			url	: '/admin/catalog/products/Ajaxfilterproducts',
			error	: function ()
			{
				alert('Ошибка запроса');
			},
			success	: function(data)
			{
				location.reload();
			},
			data	:
			{   
				catalog_name: catalog_name,
				product_name : product_name,
				product_pokritie : product_pokritie,
				product_material : product_material,
				product_sides : product_sides,
				product_tirazh : product_tirazh,
			},
			async		: false,
			cache		: false,
			type        : "POST",
		});

	});
	
	$('#reset').click(function() {
	
		$.ajax({
			url	: '/admin/catalog/products/Ajaxfilterresetproducts',
			error	: function ()
			{
				alert('Ошибка запроса');
			},
			success	: function(data)
			{
				location.reload();
			},
			data	:
			{   
				
			},
			async		: false,
			cache		: false,
			type        : "POST",
		});

	});
	
	$('.selected-all').change(function(){
		if($('.selected-all').attr('checked') == true)
		{
			$('.selected').attr('checked','checked');
		}
		else
		{
			$('.selected').removeAttr("checked");
		}
	});
	
	$('#remove').click(function(){
		
	});

})
</script>

<div style="margin-top: 50px;"></div>
<h3>Список продуктов</h3>
<div>

<hr>
<div class="row-fluid" id="pannel">
	<div class="span4">
		<div style="display: inline-block;"><?=Yii::t('app','Отображать на странице: ')?></div>
		<a style="padding: 5px;" href='<?=$this->createUrl('/admin/catalog/products/index/unit/10')?>'>10</a>
		<a style="padding: 5px;" href='<?=$this->createUrl('/admin/catalog/products/index/unit/25')?>'>25</a>
		<a style="padding: 5px;" href='<?=$this->createUrl('/admin/catalog/products/index/unit/50')?>'>50</a>

		<div style="margin-top: 20px;">
			<div style="display: inline-block;"><?=Yii::t('app','Введите свое значение: ')?></div>
			<div style="display: inline-block;">
				<?= CHtml::beginForm() ?>
					<?= CHtml::textField('unit', '')?>
					<?php echo CHtml::submitButton('Применить', array('name' => 'btn-unit', 'class' => 'btn btn-default', 'style' => 'float: none;')); ?>
				<?= CHtml::endForm() ?>
			</div>
		</div>
	</div>
	<div class="span8">
		<div class="row-fluid">
			<div class="span4">
				<div>Название каталога</div>
				<?php echo CHtml::dropDownList('catalog_name', $select, Catalog::getCatalog(),array('empty' => ''));?>
			</div>
			<div class="span4">
				<div>Название продукта</div>
				<?php echo CHtml::dropDownList('product_name', $select, Products::getNames(),array('empty' => ''));?>
			</div>
			<div class="span4">
				<div>Тираж</div>
				<?php echo CHtml::dropDownList('product_tirazh', $select, Products::getTirazh(),array('empty' => ''));?>
			</div>
		</div>
		<div  class="row-fluid">
			<div class="span4 offset8">
				<?php echo CHtml::button('Фильтровать', array('name' => 'btn-filter', 'class' => 'btn btn-default', 'id' => 'filter', 'style' => 'margin-top: 5px;')); ?>
				<?php echo CHtml::button('Сбросить фильтр', array('name' => 'btn-reset', 'class' => 'btn btn-default', 'id' => 'reset', 'style' => 'margin-top: 5px;')); ?>
			</div>
		</div>
	</div>
</div>
<hr>
<? if (empty($products)) : ?>
Прайс пустой
<? else : ?>
<?= CHtml::beginForm() ?>
<div>
	<span>Выбрать все:</span> <input class="selected-all" unchecked type="checkbox" style="margin-left:15px;"/>
	<?php echo CHtml::submitButton('Удалить', array('name' => 'btn-remove', 'class' => 'btn btn-default', 'id' => 'remove', 'style' => 'margin-top: 5px; margin-left: 40px;')); ?>
	<?php echo CHtml::submitButton('Выключить', array('name' => 'btn-switch-off', 'class' => 'btn btn-default', 'id' => 'switch-off', 'style' => 'margin-top: 5px; margin-left: 40px;')); ?>
	<?php echo CHtml::submitButton('Включить', array('name' => 'btn-switch-on', 'class' => 'btn btn-default', 'id' => 'switch-on', 'style' => 'margin-top: 5px; margin-left: 40px;')); ?>
</div>
  <div class="tabs-content">
		  <table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Выбрать</th>
					<th>Название</th>
					<th>Тираж</th>
					<th>Сроки</th>
					<th>Цена</th>
					<th>Цена для клиентов</th>
					<th>Цена для агенств</th>
					<th>Вес</th>
					<th>Действия</th>
				</tr>
			</thead>
			<tbody id="product_list">
			
			<? foreach ($products as $product) : ?>	
				<tr>
					<td><i style="<?if($product->is_used == (int)TRUE):?>opacity: 0.5;<?endif;?>" class="fa fa-lightbulb-o fa-lg"></i></td>
					<td>
						<input id="<?=$product->id?>" class="selected" name="products[<?=$product->id?>]" unchecked type="checkbox"/>
					</td>
					<td>
						<?=$product->name?>
					</td>
					<td>
						<?=$product->tirazh?>
					</td>
					<td>
						<?=$product->sroki?>
					</td>
					<td>
						<?=$product->price?>
					</td>
					<td>
						<?=$product->price_client?>
					</td>
					<td>
						<?=$product->price_agency?>
					</td>
					<td>
						<?=$product->weights->weight?>
					</td>
					<td>
						<a href="<?=$this->createUrl('/admin/catalog/products/edit/id/'.$product->id)?>">Редактировать</a>
						<a href="<?=$this->createUrl('/admin/catalog/products/delete/id/'.$product->id)?>">Удалить</a>
					</td>
				</tr>
			  <? endforeach;?>
			</tbody>
			</table>
<?= CHtml::endForm() ?>
  <? $this->widget('CLinkPager', array('pages' => $pages))?>
</div>



<? endif;?>
</div>