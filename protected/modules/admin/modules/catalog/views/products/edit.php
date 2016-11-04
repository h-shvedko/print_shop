<h3>Редактирование продукта</h3>
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false)); ?>
<style>
.table
{
	width: 50% !important;
}
</style>
<table class="table table-striped table-hover">
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'name') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'name', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'sroki') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'sroki', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'tirazh') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'tirazh', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'price') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'price', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'price_client') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'price_client', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'price_agency') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'price_agency', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($weight, 'weight') ?></td>
		<td style="width: 355px;"><?= $form->textField($weight, 'weight', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
</table>

<input type="hidden" value="<?=$ref?>" name="ref" />

<?= CHtml::submitButton(Yii::t('app', 'Сохранить'), array('name' => 'btn_edit', 'class' => 'btn btn-default')); ?>
<?php $this->endWidget(); ?>