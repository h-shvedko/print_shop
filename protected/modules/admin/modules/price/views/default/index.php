<style>
.error_price
{
	font-size: 16px;
}
.errors
{
	height: auto;
	background: #da4f49;
	padding: 10px;
	margin-top: 10px;
}
</style>
<div class="row-fluid">
<h3><b>Обновление прайс-листа</b></h3>

<? if(!empty($errors)):?>
	<div class="errors">
	<h4>Обнаружены ошибки. Исправте их.</h4>
	<?foreach($errors[0] as $error):?>
		<?foreach($error as $err):?>
			<div class="error_price"><?=$err?></div>
		<?endforeach;?>
	<?endforeach;?>
	</div>
<?endif;?>
<hr>
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false, 'htmlOptions' => array(
	'enctype' => 'multipart/form-data'
))); ?>
	<div class="row-fluid">
		<div class="span11">
			<b>Введите название для товара</b><br />
			<input type="text" name="name" size="15" style="width: 100%;" />
		</div>
	</div><hr>
	<div class="row-fluid">
		<div class="span11">
		<b>Выберите каталог</b><br />
		<?=CHtml::dropDownList('catalog', NULL,$catalogs);?>
		</div>
	</div>
	<hr>
	<div class="row-fluid">
		<div class="span3">
		<b>Выберите файл Excel</b><br />
		<input type="file" name="filename" size="15" /><br /><br />
		</div>
		<div class="span3">
		<b>Введите процент для клиентов</b><br />
		<input type="text" name="client" size="15" /><br /><br />
		</div>
		<div class="span3">
		<b>Введите процент для агенств</b><br />
		<input type="text" name="agency" size="15" /><br /><br />
		</div>
	</div>
	<hr>
	<div class="row-fluid">
		<div class="span5">
			<h5>Выберите колонку начала загрузки</h5>
			<select name="startCol">
				<option value="1">A</option>
				<option value="2">B</option>
				<option value="3">C</option>
				<option value="4">D</option>
				<option value="5">E</option>
				<option value="6">F</option>
				<option value="7">G</option>
				<option value="8">H</option>
				<option value="9">I</option>
				<option value="10">J</option>
				<option value="11">K</option>
				<option value="12">L</option>
				<option value="13">M</option>
				<option value="14">N</option>
				<option value="15">O</option>
				<option value="16">P</option>
				<option value="17">Q</option>
				<option value="18">R</option>
				<option value="19">S</option>
				<option value="20">T</option>
				<option value="21">U</option>
				<option value="22">V</option>
				<option value="23">W</option>
				<option value="24">X</option>
				<option value="25">Y</option>
				<option value="26">Z</option>
			</select>
			<bR>
			
			<h5>Выберите строку начала загрузки</h5>
			<select name="startRow">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
			</select>
		</div>
		<div class="span6">
			<h5>Выберите последнюю колонку загрузки</h5>
			<select name="endCol">
				<option value="1">A</option>
				<option value="2">B</option>
				<option value="3">C</option>
				<option value="4">D</option>
				<option value="5">E</option>
				<option value="6">F</option>
				<option value="7">G</option>
				<option value="8">H</option>
				<option value="9">I</option>
				<option value="10">J</option>
				<option value="11">K</option>
				<option value="12">L</option>
				<option value="13">M</option>
				<option value="14">N</option>
				<option value="15">O</option>
				<option value="16">P</option>
				<option value="17">Q</option>
				<option value="18">R</option>
				<option value="19">S</option>
				<option value="20">T</option>
				<option value="21">U</option>
				<option value="22">V</option>
				<option value="23">W</option>
				<option value="24">X</option>
				<option value="25">Y</option>
				<option value="26">Z</option>
			</select>
			<bR>
			<h5>Выберите последнюю строку загрузки</h5>
			<select name="endRow">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
			</select>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?= CHtml::submitButton(Yii::t('app', 'Сохранить'), array('name' => 'btn_edit', 'class' => 'btn btn-default')); ?>
			<?php $this->endWidget(); ?>
		</div>
	</div>
<br>
<? if(empty($errors)):?>
<bR><br><hr>
<? if(!empty($result)):?>
<h3>Результат загрузки</h3>
<hr>
<h4>Название продукта - <?=$name?></h4>
<h4>Выбранный каталог - <?=$catalog->name?></h4>
<table class="table table-hover">
	<tbody>
		<?foreach($result as $value):?>
			<tr>
				<? foreach($value as $kol):?>
					<td>
						<?=$kol?>
					</td>
				<?endforeach;?>
			</tr>
		<?endforeach;?>
	</tbody>
</table>

<?endif;?>
<br><br>
<? if(!empty($resultAgency)):?>
<h3>Результат загрузки для агенств</h3>
<hr>
<h4>Название продукта - <?=$name?></h4>
<h4>Выбранный каталог - <?=$catalog->name?></h4>
<table class="table table-hover">
	<tbody>
		<?foreach($resultAgency as $value):?>
			<tr>
				<? foreach($value as $kol):?>
					<td>
						<?=$kol?>
					</td>
				<?endforeach;?>
			</tr>
		<?endforeach;?>
	</tbody>
</table>
<?endif;?>

<br><br>
<? if(!empty($resultAgency)):?>
<h3>Результат загрузки для клиентов</h3>
<hr>
<h4>Название продукта - <?=$name?></h4>
<h4>Выбранный каталог - <?=$catalog->name?></h4>
<table class="table table-hover">
	<tbody>
		<?foreach($resultClient as $value):?>
			<tr>
				<? foreach($value as $kol):?>
					<td>
						<?=$kol?>
					</td>
				<?endforeach;?>
			</tr>
		<?endforeach;?>
	</tbody>
</table>
<?endif;?>
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false,)); ?>
	<?= CHtml::submitButton(Yii::t('app', 'Загрузить в БД'), array('name' => 'btn_load', 'class' => 'btn btn-default')); ?>
<?php $this->endWidget(); ?>

<?endif;?>

</div>