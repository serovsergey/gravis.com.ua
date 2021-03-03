<div style="margin: auto;text-align:center;font-weight:bold;">
Дисконтная программа
<table style="margin:auto;text-indent:0;text-align:center;font-weight:normal;border-collapse: collapse;">
<tr style="font-weight:bold;">
	<td style="border: 1px solid maroon;">&nbsp;Сумма, грн.&nbsp;</td>
	<td style="border: 1px solid maroon;">&nbsp;% скидки&nbsp;</td>
</tr>
<?
$cursum=0;
foreach($discounts as $dsum=>$disc){
	if(isset($summ)){
		if($summ>=$dsum) $cursum = $dsum;
	}
}
foreach($discounts as $dsum=>$disc){
	if($dsum == $cursum) $style_mod = "background-color:#edc26b;font-weight:bold;"; else $style_mod = "";
	echo '<tr> <td style="border: 1px solid maroon;'.$style_mod.';">'.$dsum.'</td>';
	echo '<td style="border: 1px solid maroon;'.$style_mod.'">'.$disc.'</td></tr>';
	if(isset($summ)){
		if($summ>=$dsum) $curdisc=$disc;
	}
}
?>
</table>
</div>