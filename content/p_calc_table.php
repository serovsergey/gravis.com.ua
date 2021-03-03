<?
	//$cur_mat='laque_standart';
	$start_width=1;
	$start_len=1;
	$hl_min=160; // подсвечивать цену меньше чем (либо равно)
	
	$width=$start_width;
?>

<div align="center">
<p><h2>Таблица зависимости цены квадратного метра от размеров потолка</h2></p>
	<form method="post" name="tableform" action="">
		Материал:&nbsp;<select style="border: 1px solid;border-color: #996600;" name="mat" size="1" title="Материал пленки" onchange="submit()">
			<?php
				if(isset($_POST['mat'])) $cur_sel=$_POST['mat']; 
				else $cur_sel=$sel_mat;
				foreach($films as $mat_name=>$item) 
				{
					if($mat_name==$cur_sel) $tmp_sel=' selected="selected"';
					else $tmp_sel="";
					$_w=$item["width"]; $_sw="";
					if (is_array($_w)) { 
						foreach($_w as $curw) {
							if ($_sw!="") $_sw=$_sw."; ";
							$_sw=$_sw.strval($curw);
						}
					}
					else $_sw=$_w;
					echo "\n<option value=\"".$mat_name."\"".$tmp_sel.">".$item["title"]." (".$_sw." м.)</option>";	
				}		
			?>
		</select>
		<br/><br/>
		<table class="highlight" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse;" width="95%">
			<tr>
				<td align="center"><b>&#9586;&nbsp;Длина<br />&#9586;<br />Ширина&#9586;</b></td>
				<? 
				for($i=$width;$i<=8;$i+=0.5)
				{
				  echo '	<td style="background-color:#ccc;width:40px;text-align:center"><b>'.$i.'</b></td>
				';
				}
				?>
			</tr>
			<?
			while($width<=8)
			{
			  echo '<tr>
				<td style="background-color:#ccc;text-align:right"><b>'.$width.'</b>&nbsp;</td>
			';
			  $len=$start_len;
			  while($len<=8)
			  {
				$cl="";
				$area=$len*$width;
				if($width>$len) $sum="";
				else {
					$sum=calc_price_len($cur_sel, $len, $width, 4);//*$kurs;
					if((floor(($sum*10)/($len*$width))/10)<=$hl_min) $cl=" color:#03f;";
				}
				if(($len==floor($len)) && ($sum!="")) $bg=' style="background-color:#eee;'.$cl.'"'; else $bg=" style=\"$cl\"";
				if($width==floor($width)) $bg=' style="background-color:#ddd;'.$cl.'"';
				if($sum=="") echo "\t<td$bg align=\"center\"></td>\n";
				else echo "\t<td$bg align=\"center\"><acronym title=\"".(floor($sum*10)/10)." грн.&nbsp;/&nbsp;$area м.кв.\">".(floor(($sum*1)/($len*$width))/1)."</acronym></td>\n";
				$len+=0.5;
			  }
			  $width+=0.5;
			  echo "</tr>\n";
			}
			?>
		</table>		
		
	</form>
</div>

<br/>
<p align="justify">
В расчете приведен потолок прямоугольной формы (4 угла). В цену не включены какие либо дополнительные элементы сложности: 
точки света (<? echo $GLOBALS['elements']['lamp']['price'] ?>&nbsp;грн./шт.), 
обходы труб (<? echo $GLOBALS['elements']['pipe']['price'] ?>&nbsp;грн./шт.), 
криволинейные участки полотна (<? echo $GLOBALS['elements']['curve']['price'] ?>&nbsp;грн./м.), 
дополнительные углы (<? echo $GLOBALS['elements']['corner']['price'] ?>&nbsp;грн./шт.), 
белую маскировочную вставку (<? echo $GLOBALS['decors']['vst_w']['price'] ?>&nbsp;грн./м.).
</p>