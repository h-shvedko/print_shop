<?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false)); ?>

<table>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'name') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'name', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'sides') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'sides', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'material') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'material', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'pokritie') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'pokritie', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'sroki') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'sroki', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'tirazh') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'tirazh', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'price') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'price', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'price_client') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'price_client', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($products, 'price_agency') ?></td>
		<td style="width: 355px;"><?= $form->textField($products, 'price_agency', array('size' => 60, 'maxlength' => 100)) ?></td>
	</tr>
</table>


<?= CHtml::submitButton(Yii::t('app', 'Сохранить'), array('name' => 'btn_edit')); ?>
<?php $this->endWidget(); ?>