<div style="margin-top: 50px;"></div>
<h3>Список пользователей</h3>
<a href="/admin/user/default/create">Создать нового</a>
<div>
<? if (empty($model)) : ?>
Нет ни одного пользователя
<? else : ?>
<bR>
<hr>
<div class="row-fluid">
	<div class="span12">
		<div style="display: inline-block;"><?=Yii::t('app','Отображать на странице: ')?></div>
		<a style="padding: 5px;" href='<?=$this->createUrl('/admin/user/default/index/unit/10')?>'>10</a>
		<a style="padding: 5px;" href='<?=$this->createUrl('/admin/user/default/index/unit/25')?>'>25</a>
		<a style="padding: 5px;" href='<?=$this->createUrl('/admin/user/default/index/unit/50')?>'>50</a>

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
</div>
<hr>
<table class="table table-striped table-hover">
<thead>
	<tr>
		<th>Логин</th>
		<th>ФИО</th>
		<th>Телефон</th>
		<th>e-mail</th>
		<th>Страна</th>
		<th>Регион</th>
		<th>Город</th>
		<th>Адрес</th>
		<th>День рождения</th>
		<th>Действия</th>
	</tr>
</thead>
<tbody>
<? foreach ($model as $value) : ?>
	<tr>
		<td>
			<?=$value->username?>
		</td>
		<? if(!empty($value->profile)):?>
		<td>
			<?= Profile::getFullName($value->id)?>
		</td>
		<td>
			<?=$value->profile->phone?>
		</td>
		<?else:?>
			<td></td>
			<td></td>
		<?endif;?>
		<td>
			<?=$value->email?>
		</td>
		<? if(!empty($value->profile)):?>
		<td>
			<?=$value->profile->country?>
		</td>
		<td>
			<?=$value->profile->region?>
		</td>
		<td>
			<?=$value->profile->city?>
		</td>
		<td>
			<?=$value->profile->adress?>
		</td>
		<td>
			<?if(strtotime($value->profile->birthday) > 0):?>
				<?=date("d.m.Y", strtotime($value->profile->birthday))?>
			<?endif;?>
		</td>
		<?else:?>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		<?endif;?>
		<td>
			<a href="<?=$this->createUrl('/admin/user/default/edit/id/'.$value->id)?>">Редактировать</a>
			<? if ($value->is_blocked == (int)FALSE) : ?>
				<a href="<?=$this->createUrl('/admin/user/default/block/id/'.$value->id)?>">Блокировать</a>
			<? else : ?>
				<a href="<?=$this->createUrl('/admin/user/default/block/id/'.$value->id)?>">Разблокировать</a>
			<? endif; ?>
		</td>
	</tr>
<? endforeach; ?>
</tbody>
</table>
<? $this->widget('CLinkPager', array('pages' => $pages))?>
<? endif;?>
</div>