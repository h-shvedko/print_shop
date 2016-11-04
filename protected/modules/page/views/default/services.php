
<style>
.span6 img
{
	max-width: 85%;
}
</style>
<div class="container">
<? if(count($catalog) % 6 == (int)FALSE) : ?>
<? $j = count($catalog)?>
<? else : ?>
<? $j = count($catalog) + (6 - (count($catalog) % 6 ))?>
<? endif;?>
	<? for($i = (int)FALSE; $i < $j; $i++): ?>
		<? if($i == 0 || $i == 6 || $i == 12 || $i == 18) : ?>
			<div class="row-fluid">
				<div class="span9" style="margin-right: -6px;">
		<? endif;?>
		
		<? if ($i == 0 || $i == 3 || $i == 6 || $i == 9 || $i == 12 || $i == 15 || $i == 18) : ?>
			<div class="row-fluid">
		<? endif;?>
			<? if ($catalog[$i] instanceof Services) : ?>
				<div class="span4 blocks" style="padding-top:45px; " onclick="location.href='<?php echo Yii::app()->request->baseUrl; ?><?=$catalog[$i]->url?>';">
					<div class="row-fluid">
					<div class="span12 blocks-title"><?=CHtml::encode($catalog[$i]->name);?></div>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?=$catalog[$i]->image?>"  style="width: 100px;"/>
						</div>
					</div>
				</div>
			<? else : ?> 
				<div class="span4 blocks empty" style="display:none;">
					<div class="row-fluid">
					<div class="span12 blocks-title"></div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							
						</div>
						<div class="span6">
							<div class="price">
								<p><i class="count"></i></p>
								<p style="margin-bottom: 30px"><i class="amount"></i></p>
								
								<p><i class="count"></i></p>
								<p><i class="amount"></i></p>
							</div>
						</div>
					</div>
				</div>
			<? endif;?>
		<? if ($i == 2 || $i == 5 || $i == 8 || $i == 11 || $i == 14 || $i == 17 || $i == 20) : ?>
			</div>
		<? endif;?>
		
		<? if($i == 5 || $i == 11 || $i == 17 || $i == 22) : ?>
			</div>
			<? if($i == 5 || $i == 11) : ?>
				<div class="span3 store-block " style="hieght: 420px">
				</div>
			<? endif;?>
			</div>
		<? endif;?>
		
	<? endfor;?>

	</div>

	
<div class="block-footer">
	<div class="row-fluid">
		<div class="span12 head-block-footer">
			PRINT SHOP - УДАЧНЫЙ ВЫБОР ЗА УДАЧНУЮ ЦЕНУ
		</div>
	</div>

	<div class="row-fluid">

		<div class="span12">Несмотря на ускоренное развитие высокотехнологичных средств передачи информации, неотъемлемой частью 
		современного мира продолжает оставаться полиграфия. Украина в наши дни предоставляет широчайшие возможности 
		для заказа печатной продукции различных тиражей и степени сложности. Изобилие типографий заставляет заказчика 
		серьезно задуматься, где заказать печать. Одной из ведущих на полиграфическом рынке является типография, 
		обладающая многофункциональным парком оборудования и опытом работы. предоставляет полный
		 спектр полиграфических услуг (деловая и рекламная полиграфия, тиражная печатная продукция), а также внедрила 
		инновационную технологию гибридной печати TWIN-SPOT. Благодаря этой технологии печатный продукт выглядит 
		дороже и вызывает приятные тактильные ощущения. Кроме того, такое решение позволяет заказчику удивлять своих 
		клиентов и располагать их к себе, что сегодня немаловажно.</div>

	</div>

</div>
