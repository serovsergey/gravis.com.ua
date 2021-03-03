<?
$curself=$_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
$pos=strrpos($curself, '.');if ($pos!=0) $curself=substr($curself, 0, $pos);
$pos=strrpos(__FILE__, '.');if ($pos!=0) $curfile=substr(__FILE__, 0, $pos);
if($curfile == $curself) {
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");echo "404 Not Found";exit();}
if($header==1) { 

}
else {
?>
<p>Сложно точно назвать <a href="#calc_table">цену за 1 кв. м.</a> <strong>натяжного потолка</strong> <b>любой</b> сложности, как например нельзя посчитать цену за 1 кв.м. металлопластикового окна.</p>
<p>Цена на <strong>натяжной потолок</strong>, как на готовое изделие, складывается из нескольких составляющих, выражающих его сложность: 
  <ul>
    <li>В первую очередь это стоимость ПВХ пленки. Она измеряется в квадратных метрах.</li>
    <li>Во-вторых, цена всего потолка зависит от периметра – тут имеется в виду профиль (багет) для крепления полотна.</li>
    <li>В-третьих, на цену влияет количество углов – они выражают сложность раскроя.</li>
    <li>Так же цена зависит от длины криволинейных участков – тут также выражена сложность раскроя, компенсация отходов пленки, к тому же и сложность 
      крепления профиля увеличивается.</li>
    <li>Цену готового потолка также формируют дополнительные элементы, такие как люстра (установка термокольца), точечный 
      светильник (установка платформы-стойки, термокольца и работы по выставлению всех светильников на полотне в одну плоскость), обходы коммуникации (труб отопления и т.п. – специальная обводная фурнитура, декоративные элементы) и декор, закрывающий технологическую щель между стеной и полотном (ПВХ-вставка, шнур, багет и т.п.). </li>
    <li>К тому же на цену влияют дополнительные условия, такие как центровка швов/полотна, сварка пленки разных 
      цветов, срочность изготовления полотна.</LI>
    <li>Если Ваш объект находится за пределами города, дополнительно транспортные расходы составят <?=$p_transport?>&nbspгрн./км. пути (обычно необходимо как минимум 2 выезда - на замер и на монтаж).</LI>
  </ul
</p>
<p>Обращаем Ваше внимание, что минимальная сумма заказа <b>
<?php 
$min_order = $GLOBALS['others']['min_order'];
echo number_format($min_order, 0, ",", " ");
?>
</b> грн.</p>
<h2>Прайс-лист</h2>
<div style="padding-bottom: 1em;">
<table class="price">
	<tr>
		<th>Наименование</th>
		<th>Ед. изм.</th>
		<th>Цена, грн.<!--<a href="#kurs">*</a>--></th>
	</tr>
	<tr>
		<th colspan=3 class="section_header">Материал полотна</th>
	</tr>
<?php
      foreach($films as $film=>$item) 
      {
	if($film[0]=='.') continue;
        $_w=$item["width"]; $_sw="";
		if (is_array($_w)) { 
			foreach($_w as $curw) {
				if ($_sw!="") $_sw=$_sw."; ";
				$_sw=$_sw.strval($curw);
			}
		} else $_sw=$_w;
		echo "\t<tr>";
		echo "\n\t\t<td>".$item["hint"].'<i> - ширина '.$_sw.' м.</i></td>';
		echo "\n\t\t<td class=\"center\">м<sup>2</sup></td>";
		echo "\n\t\t<td class=\"center\">".$item["price"].'</td>';
		echo "\n\t</tr>\n";
      }		
?>

	<tr>
		<th colspan=3 class="section_header">Профиля</th>
	</tr>
<?php
      foreach($profiles as $profile=>$item) 
      {
	if($profile[0]=='.') continue;
	echo "\t<tr>";
	echo "\n\t\t<td>".$item["title"];
	if (isset($item["hint"]) && $item["hint"] !== '')
			echo ' ('.$item["hint"].")";
	if (isset($item["weight"]) && $item["weight"] !== 0)
		echo '<i> - вес '.$item["weight"].' г/м.</i>';
	echo "</td>";
	echo "\n\t\t<td class=\"center\">м.</td>";
	echo "\n\t\t<td class=\"center\">".$item["price"]."</td>";
	echo "\n\t</tr>\n";
      }	
?>

	<tr>
		<th colspan=3 class="section_header">Декор</th>
	</tr>
<?php
      foreach($decors as $decor=>$item) 
      {
	if($decor[0]=='.') continue;
	echo "\t<tr>";
	echo "\n\t\t<td>".$item["title"];
	if (isset($item["hint"]) && $item["hint"] !== '')
			echo ' ('.$item["hint"].")";
	echo "\n\t\t<td class=\"center\">м.</td>";
	echo "\n\t\t<td class=\"center\">".$item["price"]."</td>";
	echo "\n\t</tr>\n";
      }	

?>

	<tr>
		<th colspan=3 class="section_header">Дополнительные элементы</th>
	</tr>
<?php
      foreach($elements as $element=>$item) 
      {
	if($element[0]=='.') continue;
	echo "\t<tr>";
	echo "\n\t\t<td>".$item["title"];
	if (isset($item["hint"]) && $item["hint"] !== '')
			echo ' ('.$item["hint"].")";
	echo "</td>";
	echo "\n\t\t<td class=\"center\">".$item["measure"]."</td>";
	echo "\n\t\t<td class=\"center\">".$item["price"]."</td>";
	echo "\n\t</tr>\n";
      }	

?>
<tr>
		<th colspan=3 class="section_header">Доплата за монтаж в сложную поверхность</th>
	</tr>
<?php
      foreach($surfaces as $surface=>$item) 
      {
	if($surface[0]=='.') continue;
	echo "\t<tr>";
	echo "\n\t\t<td>".$item["title"];
	if (isset($item["hint"]) && $item["hint"] !== '')
			echo ' ('.$item["hint"].")";
	echo "</td>";
	echo "\n\t\t<td class=\"center\">м.</td>";
	echo "\n\t\t<td class=\"center\">".$item["price"]."</td>";
	echo "\n\t</tr>\n";
      }	

?>
</table>
</div>
<p>Также Вы можете воспользоваться <a href="<? echo $site_name?>calculator">калькулятором</a>.</p>
<p>Кроме того, действует <strong>гибкая система скидок</strong>:</p>
<? require "discount.php"; ?>
<div id="calc_table">
<? /*require "p_calc_table.php"*/ ?>
</div>
<!--
<a name="kurs"></a><p class="note">* Курс у.е. соответствует коммерческому курсу доллара США и равен на данный момент <? require_once "inc/consts.inc"; echo number_format($kurs, 2) ?> грн.
</p>-->
<?}?>