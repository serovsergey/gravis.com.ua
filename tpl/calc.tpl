<?
	switch($section){
case 'calc_header': 
	echo '
	<div style="margin: auto; text-align: center; padding: 4px;">
		Площадь: <b>'.$area.' м<sup>2</sup></b><br/>
		Периметр: <b>'.$perimeter.' м</b>
	</div>
';
	break;
case 'spec_header': 
	echo '
	<div style="margin: auto; text-align: center; padding: 4px;">
		<div style="display:inline-block;"><h2>Специфікація</h2></div>
		<div class="table_button_group height24">
			<img class="copySpecToClipboard" src="/img/copy.svg" alt="Копировать" title="Копировать">
			<img class="printSpec" src="/img/print.svg" alt="Печатать" title="Печатать">
		<span class="button_divider"></span>
			<img class="loadSpec" src="/img/open-file.svg" alt="Открыть с диска..." title="Открыть с диска...">
			<input id="specFile" type="file" style="display:none;" accept=".json,application/json">
			<img class="saveSpec" src="/img/save.svg" alt="Сохранить на диск..." title="Сохранить на диск...">
		<span class="button_divider"></span>
			<img class="deleteSpec" src="/img/delete.svg" alt="Удалить" title="Удалить">
		</div>
	</div>
';
	break;
case 'table_header_tag':
	echo '
	<table data-id="'.$id.'" data-timestamp="'.$stamp.'" class="calc_details">
';
	break;
case 'caption':
	echo '
		<caption><div>
			<div class = "'.(isset($caption_left) ? 'spec_caption' : 'single_caption').'">'.$caption.'</div>
			<div class="table_button_group">';
			if($is_spec) { 
				echo '
				<img class="editTable" src="/img/edit.svg" alt="Изменить" title="Изменить">
				<img class="copyToClipboard" src="/img/copy.svg" alt="Копировать" title="Копировать">
			<span class="button_divider"></span>
				<img class="moveUp" src="/img/move-up.svg" alt="Вверх" title="Вверх">
				<img class="moveDown" src="/img/move-down.svg" alt="Вниз" title="Вниз">
			<span class="button_divider"></span>
				<img class="deleteTable" src="/img/delete.svg" alt="Удалить" title="Удалить">
			';} 
			else {
				echo '
				<img class="copyToClipboard" src="/img/copy.svg" alt="Копировать" title="Копировать">';
				if($editing) { echo '
				<img class="addToSpec" src="/img/save.svg" alt="Сохранить в спецификацию" title="Сохранить в спецификацию">';				
				}
				else { echo '
				<img class="addToSpec" src="/img/add.svg" alt="Добавить в спецификацию" title="Добавить в спецификацию">';
				}
			}
			echo '
			</div>
		</div></caption>
';
	break;
case 'table_header':
	echo '
		<tr>
			<th>Наименование</th>
			<th>Ед. изм.</th>
			<th>Кол-во</th>
			<th>Цена</th>
			<th>Сумма</th>
		</tr>
';
	break;
case 'table_header_ukr':
	echo '
		<tr>
			<th>Найменування</th>
			<th>Од. вим.</th>
			<th>Кіль-сть</th>
			<th>Ціна</th>
			<th>Сума</th>
		</tr>
';
	break;
case 'table_item':
	echo '
		<tr>
			<td class="left">'.$item.'</th>
			<td class="center">'.$measure.'</th>
			<td class="center">'.str_replace('.', ",", $count).'</th>
			<td class="right">'.str_replace('.', ",", $price).'</th>
			<td class="right">'.number_format($sum, 1, ",", " ").'</th>
		</tr>
';		
	break;
case 'table_footer': 
	echo '
		<tr>
			<th class="right" colspan="4">'.($is_spec ? 'Разом' : 'Итого').'</th>
			<th class="right">'.number_format($table_sum, 0, ",", " ").'</th>
		</tr>
	</table>
';		
	break;
case 'total_sum': 
	echo '

		<h3 style="margin: auto; text-align: right; padding: 4px;">Всього: '.number_format($total_sum, 0, ",", " ").'</h3>

';
	break;
case 'discount': 
	$curdisc=0; $sum_disc=0;
	foreach($GLOBALS['discounts'] as $dsum=>$disc){
		if($total_sum>=$dsum) {
			$curdisc=$disc;
		}
	}
	$sum_disc = $total_sum * $curdisc / 100;
	if($sum_disc != 0){
		$discounts = '
		<div style=&quot;margin: auto;text-align:center;font-weight:bold;&quot;>
		Дисконтная программа
		<table style=&quot;margin:auto;text-indent:0;text-align:center;font-weight:normal;border-collapse: collapse;&quot;>
		<tr style=&quot;font-weight:bold;&quot;>
			<td style=&quot;border: 1px solid maroon;&quot;>&nbsp;Сумма, грн.&nbsp;</td>
			<td style=&quot;border: 1px solid maroon;&quot;>&nbsp;% скидки&nbsp;</td>
		</tr>';
		foreach($GLOBALS['discounts'] as $dsum=>$disc){
			if($disc == $curdisc) $style_mod = "background-color:#edc26b;font-weight:bold;"; else $style_mod = "";
			$discounts = $discounts.'<tr> <td style=&quot;border: 1px solid maroon;'.$style_mod.';&quot;>'.$dsum.'</td>';
			$discounts = $discounts.'<td style=&quot;border: 1px solid maroon;'.$style_mod.'&quot;>'.$disc.'</td></tr>';
		}
		$discounts = $discounts.'
		</table>
		</div>';
		echo '
		<div style="text-align: right; font-size: 1.2em;">
			'.($is_spec ? 'Знижка' : 'Скидка').' <span data-tooltip="'.$discounts.'" style="text-decoration: underline;cursor: help;">'.$curdisc.'%</span>: '.number_format($sum_disc, 0, ",", " ").' грн.</br>
			<h2 style="text-align:right;">'.($is_spec ? 'Сума зі знижкою' : 'Сумма со скидкой').': <b>'.number_format(($total_sum-$sum_disc), 0, ",", " ").'</b> грн.</h2>
		</div>
';
	}
	break;
	case 'info':
		//echo '<div style="text-align: right;padding:2px;">'.number_format(($total_sum-$sum_disc)/$total_area, 1, ",", " ").' грн/м<sup>2</sup></div>
		echo '<div style="text-align: right;padding:2px;">Загальна площа: '.number_format($total_area, 1, ",", " ").' м<sup>2</sup></div>
';		
		$min_order = $GLOBALS['others']['min_order'];
		if($total_sum - $sum_disc < $min_order) echo '
			<p>Обращаем Ваше внимание, что минимальная сумма заказа <b>'.number_format($min_order, 0, ",", " ").'</b> грн.</p>
';
	break;
	}
?>