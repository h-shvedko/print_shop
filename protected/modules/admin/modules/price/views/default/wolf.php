<h1>Результат загрузки прайса от <?=date("d-m-Y")?></h1>
<table class="table table-striped table-hover">
<thead>
	<tr>
		<th>Название</th>
		<th>кол-во сторон</th>
		<th>Материал</th>
		<th>Покрытие</th>
		<th>Тираж</th>
		<th>Цена</th>
		<th>Ценадля клиентов</th>
		<th>Цена для агенств</th>
	</tr>
</thead>
<tbody>
<? foreach($products as $value) : ?>
<tr>
	<td><?=$value->name?></td>
	<td><?=$value->sides?></td>
	<td><?=$value->material?></td>
	<td><?=$value->pokritie?></td>
	<td><?=$value->tirazh?></td>
	<td><?=$value->price?></td>
	<td><?=$value->price_client?></td>
	<td><?=$value->price_agency?></td>

</tr>
<?endforeach;?>
</tbody>
<table>