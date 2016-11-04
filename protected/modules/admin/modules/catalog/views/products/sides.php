<style>
/* Tabs */
ul,li {list-style:none;}
#tabs {border: 1px solid #ccc; border-radius: 8px}
#tabs .tabs {overflow: hidden; border-bottom: 1px solid #ccc}
#tabs .tabs li {float: left;}
#tabs .tabs li + li {border-left: 1px solid #ccc}
#tabs .tabs li a {display: block; padding: 8px 16px; font-size: 18px; line-height: 21px; color: #999;}
#tabs .tabs li a.active,
#tabs .tabs li a:hover {color: #369;}

#tabs .tabs-content {padding: 20px; font-size: 16px; line-height: 21px;}
</style>
<script>
$(document).ready(function(){
	var tabs = $('#tabs');
    $('.tabs-content > div', tabs).each(function(i){
        if ( i != 0 ) $(this).hide(0);
    });
    tabs.on('click', '.tabs a', function(e){
        /* Предотвращаем стандартную обработку клика по ссылке */
        e.preventDefault();

        /* Узнаем значения ID блока, который нужно отобразить */
        var tabId = $(this).attr('href');

        /* Удаляем все классы у якорей и ставим active текущей вкладке */
        $('.tabs a',tabs).removeClass();
        $(this).addClass('active');

        /* Прячем содержимое всех вкладок и отображаем содержимое нажатой */
        $('.tabs-content > div', tabs).hide(0);
        $(tabId).show();
    });

$('#catalogs').change(function() {
	
	var value = $('#catalogs').val();
	$.ajax({
        url	: '/admin/catalog/products/Ajaxlistproducts/id/'+value,
        error	: function ()
        {
            alert('Ошибка запроса');
        },
        success	: function(data)
        {
		
			$('#product_list').html('');
			$('#product_list').html(data.content);
        },
        data	:
        {   
            value : value,
        },
        async		: false,
        cache		: false,
        type        : "POST",
		dataType: "json",
    });

})

$('.sides').change(function() {
	
	var side = $(this).val();
	var product = $(this).attr('name');
	
	$.ajax({
        url	: '/admin/catalog/products/Ajaxsidesproducts',
        error	: function ()
        {
            alert('Ошибка запроса');
        },
        success	: function(data)
        {
			alert('Изменения сохранены');
			location = '/admin/catalog/products/sides';
		
        },
        data	:
        {   
            id : product,
			sides : side,
			
        },
        async		: false,
        cache		: false,
        type        : "POST",
		
    });

})

$('.checkall').click(function() {
	if($(".checkall").is(":checked"))	
	{
		$(".check").attr("checked","checked");
	}
})
})
</script>
<div style="margin-top: 50px;"></div>
<h3>Редактирование сторон для продуктов</h3>

<? /*=CHtml::dropDownList('catalogs','name',$catalog, array('style' => 'margin-right: 25px;')) */?>

<div>
<? if (empty($products)) : ?>
Прайс пустой
<? else : ?>

<div id="tabs">
  <ul class="tabs">
  <? $i == (int)TRUE?>
  <? foreach ($catalogs as $value) : ?>
	<? if ($i == (int)TRUE) : ?>
		<li class="tab active"><a href="#<?=$value->alias?>" class="active"><?=$value->name?></a></li>
	<? else : ?>
		<li class="tab"><a href="#<?=$value->alias?>"><?=$value->name?></a></li>
	<? endif;?>
  <? endforeach;?>
  </ul>
  <!-- Содержимое каждой вкладки имеет id в соответствии с якорной ссылкой -->
  <div class="tabs-content">
    <? foreach ($catalogs as $value) : ?>
		<div id="<?=$value->alias?>">
		  <h3><?=$value->name?></h3>
			<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Название</th>
					<th>Покрытие</th>
					<th>Материал</th>
					<th>кол-во сторон</th>
					<th>Тираж</th>
					<th>Цена</th>
					<th>Цена для клиентов</th>
					<th>Цена для агенств</th>
					<th>Действия</th>
				</tr>
			</thead>
			<tbody id="product_list">

			<? foreach ($value->products as $product) : ?>
				<tr>
					<td>
						<?=$product->name?>
					</td>
					<td>
						<?=$product->pokritie?>
					</td>
					<td>
						<?=$product->material?>
					</td>
					<td>
						<?=$product->side->sides?>
					</td>
					<td>
						<?=$product->tirazh?>
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
						<?=CHtml::dropDownList($product->id,'sides',$sides, array('class' => 'sides','empty'=>'выберите кол-во сторон'))?>
					</td>
				</tr>
			<? endforeach; ?>

			</tbody>
			</table>
		</div>
  <? endforeach;?>
</div>



<? endif;?>
</div>
