<? foreach ($catalog->products as $product) : ?>
	<tr>
		<td>
			<?=CHtml::encode($product->name)?>
		</td>
		<td>
			<?=$product->tirazh?>
		</td>
		<td>
			<?=$product->price?>
		</td>
		<td>
			<?=$product->price_client?>
		</td>
		<td>
			<?=$product->price_agency?>
		</td>
		<td>
			<?=CHtml::dropDownList($product->id,'sides',$sides, array('class' => 'sides','empty'=>'выберите кол-во сторон'))?>
		</td>
	</tr>
<? endforeach; ?>