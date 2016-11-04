<div style="margin-top: 50px;"></div>
<h3>Список контентных страниц</h3>
<a href="/admin/pages/default/create">Создать новую</a>
<div>
<? if (empty($pages)) : ?>
Нет ни одной страницы
<? else : ?>
<table class="table table-striped table-hover">
<thead>
	<tr>
		<th>Название</th>
		
		<th>Действия</th>
	</tr>
</thead>
<tbody>
<? foreach ($pages as $product) : ?>
	<tr>
		<td>
			<?=$product->name?>
		</td>
		
		<td>
			<a href="<?=$this->createUrl('/admin/pages/default/view/id/'.$product->id)?>">Просмотр</a>
			<a href="<?=$this->createUrl('/admin/pages/default/edit/id/'.$product->id)?>">Редактировать</a>
			<? if ($product->is_visible == (int)TRUE) : ?>
				<a href="<?=$this->createUrl('/admin/pages/default/delete/id/'.$product->id)?>">Удалить</a>
			<? else : ?>
				<a href="<?=$this->createUrl('/admin/pages/default/delete/id/'.$product->id)?>">Восстановить</a>
			<? endif; ?>
		</td>
	</tr>
<? endforeach; ?>
</tbody>
</table>
<? endif;?>
</div>