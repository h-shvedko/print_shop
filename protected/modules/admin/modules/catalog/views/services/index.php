<div style="margin-top: 50px;"></div>
<h3>Каталог наименований услуг</h3>
<a href="/admin/catalog/services/create">Создать новый</a>
<div>
<? if (empty($catalog)) : ?>
Прайс пустой
<? else : ?>
<table class="table table-striped table-hover">
<thead>
	<tr>
		<th>Название</th>
		
		<th>Действия</th>
	</tr>
</thead>
<tbody>
<? foreach ($catalog as $product) : ?>
	<tr>
		<td>
			<?=$product->name?>
		</td>
		
		<td>
			<a href="<?=$this->createUrl('/admin/catalog/services/edit/id/'.$product->id)?>">Редактировать</a>
			<? if ($product->is_visible == (int)TRUE) : ?>
				<a href="<?=$this->createUrl('/admin/catalog/services/delete/id/'.$product->id)?>">Удалить</a>
			<? else : ?>
				<a href="<?=$this->createUrl('/admin/catalog/services/delete/id/'.$product->id)?>">Восстановить</a>
			<? endif; ?>
		</td>
	</tr>
<? endforeach; ?>
</tbody>
</table>
<? endif;?>
</div>