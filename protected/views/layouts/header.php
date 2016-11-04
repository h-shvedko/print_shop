<body ng-app="gemStore"  ng-controller="basketController">
<div class="container" id="page">
	<div class="container">
		<div class="row-fluid">
			<div class="span3" style="padding: 30px 0 0 30px;">
				<div class="row-fluid">
					<div class="span12" style="max-width: 95%;">
						<a href="/"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/logo.png" /> </a>
					</div>
				</div>
			</div>
			<div class="span9">
					<div class="row-fluid">
						<div class="span12" style="text-align: right;">
						<?if(!Yii::app()->user->isGuest):?>
							Добро пожаловать, <?=Profile::getFullName(Yii::app()->user->id)?>
							<?if(Yii::app()->user->name == 'admin'):?>
								<br>
								<a href="/admin">Админ панель</a>
							<?endif;?>
						<?else:?>
							<a href="/register">Регистрация</a>
						<?endif;?>
						</div>
						
					</div>
					<div class="row-fluid">
						<div class="span12">
							<div class="row-fluid">
								<div class="span6" style="text-align: left;">
									<div class="title">Оперативная полиграфия в николаеве</div>
								</div>
							</div>
						</div>
					</div>
				
					<div class="row-fluid">
						<div class="span12 menu" style="text-align: left;">
							<?php $this->widget('zii.widgets.CMenu',array(
								'items'=>array(
									array('label'=>'Главная', 'url'=>array('/site/index')),
									array('label'=>'Продукция', 'url'=>array('/site/index')),
									array('label'=>'Услуги', 'url'=>array('/page/default/services'),
											'items' => array(
												array('label'=>'в лифтах', 'url'=>array('/page/default/lift')),
												array('label'=>'на стенгазете', 'url'=>array('/page/default/wall')),
												array('label'=>'в Театре Чкалова', 'url'=>array('/site/index')),
												array('label'=>'на билетах Зоопарка', 'url'=>array('/site/index')),
												array('label'=>'на турникетах', 'url'=>array('/page/default/turnicats')),
												array('label'=>'на бигбордах', 'url'=>array('/page/default/bigboard')),
												array('label'=>'в транспорте', 'url'=>array('/page/default/transport')),
												array('label'=>'банерная', 'url'=>array('/site/index')),
											)),
									array('label'=>'Контакты', 'url'=>array('/site/contact')),
									array('label'=>'Кабинет', 'url'=>array('/office'), 'visible'=>!Yii::app()->user->isGuest,
										'items' => array(
												array('label'=>'профиль', 'url'=>array('/office/profile')))),
									array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
									array('label'=>'Выход', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
								),
								'htmlOptions'=>array('id'=>'mainmenu'),
							)); ?>
						</div><!-- mainmenu -->
					</div>
			
			
				<div class="row-fluid">
					<div class="span9" style="background: url('<?php echo Yii::app()->request->baseUrl; ?>/css/img/carusel.png'); height: 200px; width: 522px; margin-bottom: 15px;">
						<div class="row-fluid">
							<div class="span12" style="height: 110px;">
							</div>
							<div class="span4 offset8 carosel"> <div class="discount">!!!</div></div>
							<div class="span12" style="height: 0px;">
							</div>
							<div class="span12 carosel">
								<p>рекламным агенствам специальное предложение</p>
							</div>
						</div>
					</div>
					<div class="span3 step" style="width: 32% !important; height: 200px;">
						<div class="row-fluid">
							<div class="span12 steptitle">У нас все просто</div>
						</div>
						<div class="row-fluid">
							<div style="text-align: left; margin-left: 15px; padding-bottom: 13px;" class="span12">
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/clacksmain.png" width="30px;" class="clack" /><div class="list">регистрация</div>
							</div>
						</div>
						<div class="row-fluid">
							<div style="text-align: left; margin-left: 15px; padding-bottom: 13px;" class="span12">
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/clacksmain.png" width="30px;" class="clack" /><div class="list">макет</div>
							</div>
						</div>
						<div class="row-fluid">
							<div style="text-align: left; margin-left: 15px; padding-bottom: 13px;" class="span12">
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/clacksmain.png" width="30px;" class="clack" /><div class="list">оплата</div>
							</div>
						</div>
					<? /*	<div class="row-fluid">
							<div><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/clacksmain.png" width="100px;" style="position: relative; top: -41px; right: -50px;" />
							<p style="position: relative; top: -125px; right: -56px; font-size: 34px; font-family: 'Lucida Sans Unicode'; color: white;">!!!</p></div>
						</div> */ ?>
					</div>
					</div>
				</div>
			</div>
		</div>