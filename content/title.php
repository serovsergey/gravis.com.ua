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
<!------
<div style="font-weight:bold;text-align: center; color: red;">
	<div style="position:relative; top: 0">
		<h2 style="color: red">Уважаемые Клиенты!</h2>
		<p>Наш офис закрывается на ремонт чтобы стать лучше! Приносим извинения за неудобства. Мы продолжаем работать в "телефонном" режиме.</p>
	</div>
</div>
<img class="img_border center_block" style="filter: grayscale(100%) blur(0px)" src="/img/office.jpg" alt="Фото офиса">
--->
<p align="justify"><font size="+1"><strong>ЧП «Гравис Люкс»</strong></font> - стабильно развивающаяся, отлично зарекомендовавшая себя на рынке г. Херсона и области компания, основанная весной 2008 года и по сей день неустанно радующая своих клиентов высочайшим качеством материалов, монтажа и сервиса. Мы стремимся сделать Ваше с нами сотрудничество максимально удобным!
 </p>
<p align="justify">К Вашим услугам:</p>
<ul>
  <li><strong>Натяжные потолки</strong> европейских и азиатских производителей, <strong>многоуровневые натяжные потолки</strong></li>
  <li><strong>Разработка <a href="http://www.gravis.com.ua/gallery/projects">дизайна</a></strong> Ваших потолков</li>
  <li>Комплексное изготовление потолков – <strong>гипсокартонные конструкции</strong> в сочетании с натяжными потолками «под ключ»</li>
  <li><strong>Лепной декор</strong> - полиуретановые багеты и элементы декора, гибкие багеты, декоративные балки "под дерево"</li>
  <li><a href="http://www.gravis.com.ua/lights"><strong>Светильники и люстры</strong></a> европейских и китайских производителей – неотъемлемая часть любого потолка.</li>
  <li><strong>Светодиодная продукция</strong> для подсветки и декоративного оснащения интерьера (светодиодные светильники, лампы, <strong>светодиодная лента</strong>)</li>
  <li><strong>Ремонтно-отделочные работы</strong> в комплексе – от штукатурки до декоративной отделки, от пола до потолка, от электропроводки до коммуникаций – будь то комната в квартире или особняк – наши мастера-профессионалы к Вашим услугам и под нашим надзором. По Вашему желанию предоставляются сметы, заключается договор. </li>
</ul> 

<?php

/*$filename = 'files/price_remont.zip';
if (file_exists($filename)) {
    echo '<p style="text-align:center;"><strong><a href="'.$filename.'" title="Скачать"><img src="img/icons/zip16.gif" alt="ZIP"/>&nbsp;Прайс-лист на отделочные работы ZIP</a></strong> (от '.date ("d.m.Y", filemtime($filename)).')</p>';
}*/
$filename = 'files/price_remont.pdf';
if (file_exists($filename)) {
    echo '<p style="text-align:center;"><strong><a href="'.$filename.'" title="Скачать"><img src="img/icons/pdf16.gif" alt="PDF"/>&nbsp;Прайс-лист на отделочные работы PDF</a></strong> (от '.date ("d.m.Y", filemtime($filename)).')</p>';
}
$filename = 'files/price_remont.xls';
if (file_exists($filename)) {
    echo '<p style="text-align:center;"><strong><a href="'.$filename.'" title="Скачать"><img src="img/icons/xls16.png" alt="XLS"/>&nbsp;Прайс-лист на отделочные работы XLS</a></strong> (от '.date("d.m.Y", filemtime($filename)).')</p>';
}?>

<?}?>