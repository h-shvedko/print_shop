<h3>Редактирование каталога наименований продуктов</h3>
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false,'htmlOptions'=>array('enctype'=>'multipart/form-data'))); ?>
<style>
.table
{
	width: 50% !important;
}
</style>
<table class="table table-striped table-hover">
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'name') ?></td>
		<td style="width: 355px;"><?= $form->textField($catalog, 'name', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'name'); ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'alias') ?></td>
		<td style="width: 355px;"><?= $form->textField($catalog, 'alias', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'alias'); ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'level') ?></td>
		<td style="width: 355px;"><?= $form->textField($catalog, 'level', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'level'); ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'is_visible') ?></td>
		<td style="width: 355px;"><?= $form->checkBox($catalog, 'is_visible', array('class' => 'form-control')) ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'is_visible'); ?></td>
	</tr>
	
	
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'image') ?></td>
		<td style="width: 355px;"><?php echo CHtml::image(
                   '/upload/'.$catalog->image,
                    $catalog->image,
                    array("style"=>"width:150px;")
                )?></td>
		<td style="width: 355px;"></td>
	</tr>
	<tr>
		<td style="width: 215px;"></td>
		<td style="width: 215px;"><?= $form->fileField($catalog, 'image'); ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'image'); ?></td>
	</tr>
	
	

	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'tirazh1') ?></td>
		<td style="width: 355px;"><?= $form->textField($catalog, 'tirazh1', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'tirazh1'); ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'price1') ?></td>
		<td style="width: 355px;"><?= $form->textField($catalog, 'price1', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'price1'); ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'tirazh2') ?></td>
		<td style="width: 355px;"><?= $form->textField($catalog, 'tirazh2', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'tirazh2'); ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($catalog, 'price2') ?></td>
		<td style="width: 355px;"><?= $form->textField($catalog, 'price2', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
		<td style="width: 355px;"><?= $form->error($catalog,'price2'); ?></td>
	</tr>
	
	
	
</table>


<?= CHtml::submitButton(Yii::t('app', 'Сохранить'), array('name' => 'btn_edit', 'class' => 'btn btn-default')); ?>
<?php $this->endWidget(); ?>