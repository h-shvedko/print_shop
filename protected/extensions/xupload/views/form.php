<!-- The file upload form used as target for the file upload widget -->
<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="row fileupload-buttonbar">
	<div class="span12">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn-success fileinput-button">
            
            <span><?php echo $this->t('1#Add files|0#Choose file', $this->multiple); ?></span>
			<?php
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
        <?php if ($this->multiple) { ?>
		<button	 type="submit" class="btn-primary start">
			
			<span><i class="fa fa-upload fa-2x"></i></span>
		</button>
		<button type="reset" class="btn-warning cancel">
			
			<span><i class="fa fa-power-off fa-2x"></i></span>
		</button>
		<button type="button" class="btn-danger delete">
			
			<span><i class="fa fa-times fa-2x"></i></span>
		</button>
		<?//<input type="checkbox" class="toggle">?>
        <?php } ?>
	</div>
	<?/*<div class="span4">
		<!-- The global progress bar -->
		<div class="progress progress-success progress-striped active fade">
			<div class="bar" style="width:0%;"></div>
		</div>
	</div>
	*/?>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<!-- The table listing the files available for upload/download -->
<table class="table table-striped">
	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
</table>
<?php if ($this->showForm) echo CHtml::endForm();?>
