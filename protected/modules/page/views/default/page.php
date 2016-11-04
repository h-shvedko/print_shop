<style>
.tbl_price
{
	width: 820px !important;
}
.tbl_price th 
{
    background: none repeat scroll 0 0 #C9DCEB;
    padding: 5px;
}

th
{ 
	text-align: left;
}

 td
{ 
	text-align: left;
}
.title
{
	width: 100%;
}
.nav>li>a
{
	font-size: 15.875px;
  font-family: "Lucida Sans Unicode";
  color: rgb(204, 51, 51);
  line-height: 2.667;
  text-align: left;
   display: inline-block;  
   text-transform: uppercase;
 
   text-align: center;
}

.nav>li>a:hover
{
	background: none repeat scroll 0 0 #c9dceb;
}
.nav>li>a:focus
{
	background: none repeat scroll 0 0 #c9dceb;
}
.header-product
{
	text-align: left;
}
</style>
<?php Yii::app()->clientScript->scriptMap['jquery.1.4.min.js'] = false;?>
<ul class="nav nav-tabs" id="myTabs">
  <li><a href="#price" data-toggle="tab">Печать <?=$catalog->name?></a></li>
  <li><a href="#info" data-toggle="tab">информация</a></li>
  <li><a href="#maket" data-toggle="tab">требования к макетам</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="price">
		<div>
			<h3 class="header-product"><?=$catalog->name?></h3>
		</div>
		<div>
			<?=$pages->pages[0]->content?>
		</div>

		<div class="row-fluid">
			<div class="span9">
				<? foreach($products as $product):?>
					<h4 class="header-product"><?=$catalog->name?> <?=$product['name']?></h4 class="header-product">
					<?$tirazh = Products::model()->getTirazh($product['alias']);?>
					<table class="tbl_price table">
						<thead>
							<tr>
								<th></th>
								<?foreach($tirazh as $tirazh_value):?>
									<th>
										<?=$tirazh_value;?>
									</th>
								<?endforeach;?>
							</tr>
						</thead>
						<tbody>
							<?$sroks = Products::model()->getSroki($product['alias']);?>
							<?foreach($sroks as $srok):?>
								<tr>
									<td><?=$srok?></td>
									<?foreach($tirazh as $tirazh_value):?>
										<td>
											<?$product_value = Products::model()->getPrice($product['alias'], $tirazh_value, $srok);?>
											<a class="price" ng-click="basketAdd(<?=$product_value['id']?>)"><?=$product_value['price'];?></a>
										</td>
									<?endforeach;?>
									
								</tr>
							<?endforeach;?>
						</tbody>
					</table>
				<?endforeach;?>
			</div>
			<div class="span3" style="overflow: hidden; height: 100%;">
				<div class="row-fluid">
					<div class="span12">
					<? for($i = (int)FALSE; $i < count($catalogs); $i++): ?>
						<? if ($catalogs[$i] instanceof Catalog) : ?>
						<div class="span4 blocks" style="width: 100%;<?if($i ==(int)FALSE):?>margin-left: 2.12766%;<?endif;?>" onclick="location.href='<?php echo Yii::app()->request->baseUrl; ?>/page/default/index/id/<?=$catalogs[$i]->id?>';">
							<div class="row-fluid">
							<div class="span12 blocks-title"><?=CHtml::encode($catalogs[$i]->name);?></div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/<?=$catalogs[$i]->image?>"  style="width: 100px;"/>
								</div>
								<div class="span6">
									<div class="price">
										<p>Тираж: <i class="count"><?=CHtml::encode($catalogs[$i]->tirazh1);?></i> шт.</p>
										<p style="margin-bottom: 30px">Цена: <i class="amount"><?=CHtml::encode($catalogs[$i]->price1);?></i> грн.</p>
										
										<p>Тираж: <i class="count"><?=CHtml::encode($catalogs[$i]->tirazh2);?></i> шт.</p>
										<p>Цена:  <i class="amount"><?=CHtml::encode($catalogs[$i]->price2);?></i> грн.</p>
									</div>
								</div>
							</div>
						</div>
					<? endif;?>
				<? endfor;?>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	 <div class="tab-pane" id="info">sdgfdsfgsdfgdsf</div>
	 <div class="tab-pane" id="maket">ddddddddddddd</div>
</div>
<hr><br><br>
<script>
	$('#myTabs a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
</script>