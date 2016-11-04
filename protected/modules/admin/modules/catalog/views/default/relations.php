<script>
$(function () {
$('.pages').change(function() {
	
	var pages = $(this).val();
	var catalog = $(this).attr('id');
	
	$.ajax({
        url	: '/admin/catalog/default/Ajaxpagescatalog',
        error	: function ()
        {
            alert('Ошибка запроса');
        },
        success	: function(data)
        {
			alert('Изменения сохранены');
			location = '/admin/catalog/default/relations';
		
        },
        data	:
        {   
            id : pages,
			catalog : catalog,
			
        },
        async		: false,
        cache		: false,
        type        : "POST",
		
    });

})

})
</script>
<div style="margin-top: 50px;"></div>
<h3>Привязка каталога к контентным страницам</h3>

<div>
<? if (empty($catalogs)) : ?>
Нет ни одного каталога
<? else : ?>

<table class="table table-striped table-hover">
<thead>
	<tr>
		<th>Название каталога</th>
		<th>Название страницы</th>
		<th>Список доступных страниц</th>
	</tr>
</thead>
<tbody id="product_list">

<? foreach ($catalogs as $product) : ?>
	<tr>
		<td>
			<?=$product->name?>
		</td>
		<td>
			<?=$product->pages[0]->name?>
		</td>
		<td>
			<?=CHtml::dropDownList($product->pages->id,'name',$pages, array('class' => 'pages','empty'=>'выберите контентную страницу', 'id' => $product->id))?>
		</td>
	</tr>
<? endforeach; ?>

</tbody>
</table>
<? endif;?>
</div>
