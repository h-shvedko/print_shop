<hr>
<div class="row-fluid">
	<div class="span12">
		<h1 class="title" style="font-size: 19px;">профиль</h1>
	</div>
</div>
<hr>
<div class="row-fluid">	
	<div class="span8">
	<h4 class="title">личные данные:</h4>
		<table class="table table-hover">
			<tbody>
				<tr>
					<th>Логин: </th>
					<td><?=$users->username?></td>
				</tr>
				<tr>
					<th>ФИО: </th>
					<td><?=Profile::getFullName($users->id)?></td>
				</tr>
				<tr>
					<th>Телефон: </th>
					<td><?=$users->profile->phone?></td>
				</tr>
				<tr>
					<th>E-mail: </th>
					<td><?=$users->profile->email?></td>
				</tr>
				<tr>
					<th>Страна: </th>
					<td><?=$users->profile->country?></td>
				</tr>
				<tr>
					<th>Регион: </th>
					<td><?=$users->profile->region?></td>
				</tr>
				<tr>
					<th>Город: </th>
					<td><?=$users->profile->city?></td>
				</tr>
				<tr>
					<th>Дата рождения: </th>
					<td>
						<?if(strtotime($users->profile->birthday) > (int)FALSE):?>
						<?=date("d.m.Y", strtotime($users->profile->birthday))?>
						<?endif;?>
					</td>
				</tr>
			</tbody>
		</table>
		<div><a href="/office/profile/edit/id/<?=$users->id?>" class="btn btn-default">Редактировать</a></div>
	</div>
	<div class="span4">
		<?if(!Yii::app()->user->checkAccess('Agency')):?>
			<a href="/office/agency" class="btn btn-default">Подать заявку для рекламного агенства</a>
			<hr>
		<?endif;?>
		<h4 class="title">Загрузить фото:</h4>
	</div>
</div>
<hr>
<div class="row-fluid">	
	<div class="span8">
	<h4 class="title">типы доставки:</h4>
	<?if(count($users->deliveries) > (int)FALSE):?>
		<div style="height: 200px !important; overflow-y: scroll;">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>№пп</th>
					<th>Место доставки</th>
					<th>Действия</th>
				</tr>
			</thead>
			<tbody>
			<?foreach($users->deliveries as $key => $delivery):?>
				<tr>
					<td><?=$key+1?></td>
					<td><?=$delivery->name?></td>
					<td><a href="/office/profile/deliveryDel/id/<?=$delivery->id?>">Удалить</a></td>
				</tr>
			<?endforeach;?>
			</tbody>
		</table>
		</div>
	<?else:?>
		<p>У вас не создано ни одного типа доставки.</p>
	<?endif;?>
		<div><a href="/office/profile/delivery" class="btn btn-default">Добавить способ доставки</a></div>
	</div>
	<div class="span4">
	</div>
</div>
<br><br>