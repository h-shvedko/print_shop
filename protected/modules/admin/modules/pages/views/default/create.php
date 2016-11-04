<div style="margin-top: 50px;"></div>
<h3>Создание контентной страницы</h3>
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'users-form', 'enableAjaxValidation' => false)); ?>
<style>
.table
{
	width: 75% !important;
}
</style>
<table class="table table-striped table-hover">
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($pages, 'title') ?></td>
		<td style="width: 355px;"><?= $form->textField($pages, 'title', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($pages, 'alias') ?></td>
		<td style="width: 355px;"><?= $form->textField($pages, 'alias', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($pages, 'name') ?></td>
		<td style="width: 355px;"><?= $form->textField($pages, 'name', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($pages, 'is_visible') ?></td>
		<td style="width: 355px;"><?= $form->checkBox($pages, 'is_visible', array('class' => 'form-control')) ?></td>
	</tr>
	<tr>
		<td style="width: 215px;"><?= $form->labelEx($pages, 'content') ?></td>
		<td style="width: 355px;">
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
                'model'=>$pages,
                'attribute'=>'content',
				'language'=>'ru',
				'editorTemplate'=>'full',
                )); ?>

		</td>
	</tr>
	
</table>


<?= CHtml::submitButton(Yii::t('app', 'Создать'), array('name' => 'btn_crt', 'class' => 'btn btn-default')); ?>
<?php $this->endWidget(); ?>