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
<center>
<P>
<br>
<A href="http://gallery.gravis.com.ua/main.php?g2_itemId=245" target="_blank">Заключение СЭС</A>
<P>
<A href="http://gallery.gravis.com.ua/main.php?g2_itemId=224" target="_blank">Пожарные испытания</A>
</center>
<?}?>