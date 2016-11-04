<hr>
<div class="row-fluid">
	<div class="span12">
		<h1 class="title" style="font-size: 19px;">кабинет</h1>
	</div>
</div>
<hr>
<div class="row-fluid">	
	<div class="span8">
	<h4 class="title">Ваши заказы:</h4>
		<table class="tbl_price table">
			<thead>
				<tr>
					<th>№пп</th>
					<th>Номер заказа</th>
					<th>дата заказа</th>
					<th>сумма заказа</th>
					<th>Статус</th>
					<th>Оплата</th>
					<th colspan="2" style="text-align: center;">Действия</th>
				</tr>
			</thead>
			<tbody>
				<?foreach($horders as $key => $horder):?>
				<tr>
					<td><?=$key+1+$pages->pageSize*$pages->currentPage?></td>
					<td><?=$horder->num?></td>
					<td><?=date("d.m.Y", strtotime($horder->date_horder))?></td>
					<td><?=$horder->amount?></td>
					<td><?=$horder->statuses->name?></td>
					<td><?=$horder->is_paid == 0 ? 'Нет' : 'Да'; ?></td>
					<td><a href="/office/horders/view/id/<?=$horder->id?>">Просмотр</a></td>
					<td>
					<? if($horder->statuses->alias !== 'declined'):?>
						<a href="/office/horders/cancel/id/<?=$horder->id?>">Отменить</a>
					<?endif;?>
					</td>
				</tr>
				<?endforeach;?>
			</tbody>
		</table>
		<? $this->widget('CLinkPager', array('pages' => $pages))?>
	</div>
	<div class="span4">
		<?if(!Yii::app()->user->checkAccess('Agency')):?>
			<a href="/office/agency" class="btn btn-default">Подать заявку для рекламного агенства</a>
			<hr>
		<?endif;?>
		<h4 class="title">Новости:</h4>
	</div>
</div>
<hr>
<br><br>