	<div class="footer">
		<div class="row-fluid">
			<div id="mainmenu" class="span12 footermenu">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Главная', 'url'=>array('/site/index')),
						array('label'=>'Продукция', 'url'=>array('/site/index')),
						array('label'=>'Контакты', 'url'=>array('/site/contact')),
					
						//array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
				)); ?>
			</div><!-- mainmenu -->
		
		<div ="span12 social">
			<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/icons/facebook.png" width="30px;" class="clack" /></a>
			<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/icons/Instagram.png" width="30px;" class="clack" /></a>
			<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/icons/twitter.png" width="30px;" class="clack" /></a>
			<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/icons/vkontakte.png" width="30px;" class="clack" /></a>
		</div>
		<div class="span12 contacts">
			<p>тел.099-00-11-900</p>
			<p>e-mail: works.format@gmail.com</p>
		</div>
	</div>
</div>

	</div>
</div><!-- page -->


</body>
</html>
