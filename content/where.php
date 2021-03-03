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
<div class="center">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d684.5858620661797!2d32.6469976365737!3d46.659480020131184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c4101c137c7221%3A0xee2c0bc48cf2857b!2z0J3QsNGC0Y_QttC90YvQtSDQv9C-0YLQvtC70LrQuCDQk9GA0LDQstC40YE!5e0!3m2!1sru!2sua!4v1501054308046" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
<br />
Наш адрес: <strong>г. Херсон, ул. Мира 10</strong></br>(Перекресток ул.Мира/40 Лет Октября (со стороны 40 Лет Октября), за магазином сантехники &quot;PROFI+&quot;)<br/>
Координаты GPS: 46.659585, 32.647945 (46°39'34.5"N 32°38'52.6"E)<br /><br />
<p><b>Добро пожаловать к нам в офис!</b></p>
<p><strong>График работы:</strong><br />
Пн. - Пт.: 9<sup>00</sup> - 18<sup>00</sup><br />
Сб.: 9<sup>00</sup> - 14<sup>00</sup><br />
Вс.: Выходной<br />
Без обеда
</p>
</div>
<?}?>