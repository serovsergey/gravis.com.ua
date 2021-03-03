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
<form action="http://www.google.com.ua/cse" id="cse-search-box" target="_blank">
  <div>
    <input type="hidden" name="cx" value="partner-pub-8299200742178333:z8hkyi-ipyo" />
    <input type="hidden" name="cof" value="FORID:9" />
    <input type="hidden" name="ie" value="windows-1251" />
    <input type="text" name="q" size="30" />
    <input type="submit" name="sa" value="&#x041f;&#x043e;&#x0438;&#x0441;&#x043a;" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com.ua/cse/brand?form=cse-search-box&amp;lang=ru"></script>
</center>
<?}?>