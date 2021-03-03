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
<center><br/>
<font size=3>
Официльные сайты наших фабрик:
</font>
<font size=2>
<br><br/>
Компания "Labell", г.Харьков<br/>
<a href="http://www.labell.com.ua" target="_blank"><img src="/img/labell.gif" alt="Labell"/></a><br/><br/>
<br/>
</font>
<!--
Один из наших проектов<br>
<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/xPsyUVR1hlA?hl=ru&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/xPsyUVR1hlA?hl=ru&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>
--!>

</center>
<?}?>