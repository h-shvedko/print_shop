<hr>
<div class="row-fluid">	
	<div class="span8">
	<h3 class="title">Заказ № <?=$horders->num?></h3>
		<table class="table table-hover">
			<tr>
				<th><?=Yii::t('app','Дата заказа')?></th>
				<td><?=date("d.m.Y", strtotime($horders->date_horder))?></td>
			</tr>
			<tr>
				<th><?=Yii::t('app','Cумма заказа')?></th>
				<td><?=$horders->amount?></td>
			</tr>
			<tr>
				<th><?=Yii::t('app','Статус')?></th>
				<td><?=$horders->statuses->name?></td>
			</tr>
			<tr>
				<th><?=Yii::t('app','Оплата')?></th>
				<td><?=$horders->is_paid == 0 ? 'Нет' : 'Да'; ?></td>
			</tr>
		</table>
		<div><a href="<?=$_SERVER['HTTP_REFERER']?>" class="btn btn-default">Назад</a>
			<? if($horders->statuses->alias !== 'declined'):?>
				<a href="/office/horders/cancel/id/<?=$horders->id?>" class="btn btn-default">Отменить</a>
			<?endif;?>
		</div>
	</div>
	<div class="span4">
		<h4>Новости:</h4>
	</div>
</div>
<hr>
<br><br>