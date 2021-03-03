<?
$curself=$_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
$pos=strrpos($curself, '.');if ($pos!=0) $curself=substr($curself, 0, $pos);
$pos=strrpos(__FILE__, '.');if ($pos!=0) $curfile=substr(__FILE__, 0, $pos);
if($curfile == $curself) {
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");echo "404 Not Found";exit();}
require "inc/palette.inc";
$sub_item=$_URL[1];
if($sub_item=="") $sub_item=key($palette);
$sub_sub_item=$_URL[2];
if($sub_sub_item=="") $sub_sub_item=key($palette[$sub_item]["content"]);

if($header==1) { 
	$subtitle="";
}
else {

?>
<ul id="navlist">
<? 
      foreach($palette as $cid=>$item) 
      {
			if(substr($cid, 0, 1)==".") continue;
			if($sub_item==$cid) {echo '<li id="current">';}
			else echo '<li>';
			echo '<a href="'.$site_name.$cur_item.'/'.$cid.'/'.key($item[content]).'" title="'.strip_tags($item["hint"]).'">'.$item["title"].'</a></li>
';
      };
?>
</ul>
<div style="border-left:1px solid #996600;border-right:1px solid #996600;border-bottom:1px solid #996600;background-color:#FFFFCC;">


  <h2>
<?
echo $palette[$sub_item]["hint"];
?>
  </h2>
  <div style="padding:5px;">
	<ul id="sub_navlist">
	<? 
		foreach($palette[$sub_item]["content"] as $cid=>$item) 
		{
				if(substr($cid, 0, 1)==".") continue;
				if($sub_sub_item==$cid) {echo '<li id="current">';}
				else echo '<li>';
				echo '<a href="'.$site_name.$cur_item.'/'.$sub_item.'/'.$cid.'" title="'.strip_tags($item["hint"]).'">'.$item["title"].'</a></li>
	';
		};
	?>
	</ul>
	<div style="text-align:center;border-left:1px solid #996600;border-right:1px solid #996600;border-bottom:1px solid #996600;background-color:#ffe3a7;">
	<br/>
	<strong>
	<?
	$pal=$palette[$sub_item]["content"][$sub_sub_item]["content"];
	echo $palette[$sub_item]["content"][$sub_sub_item]["hint"].' ('.count($pal).' '.okonchanie(count($pal), 'цветов', 'цвет', 'цвета').')';
	?>
	</strong>
	<p>
	<br/>
	<?
	$war=array();
	foreach($pal as $cid=>$cl) {
		foreach($cl["width"] as $wid=>$w) {
			$strw=(string) $w;
			if(array_key_exists($strw, $war)){
				$war[$strw]=$war[$strw]+1;
			} else {
				$war[$strw]=1;
			}
		}
	}
	ksort($war);
	foreach($war as $wid=>$cnt) {
		echo '<img src="/img/pal/'.$wid.'.png">  '.$wid.' м. ('.$cnt.' шт.)&nbsp;&nbsp;&nbsp;';
	}
	echo '<br/><br/>'.chr(10);
	$cnt=0;
	foreach($pal as $cid=>$item) 
		{
				echo '<div class="pal_color">';
				if(isset($item["img"])) $img=$item["img"]; else $img="";
				if(isset($item["tn"])) {$tn=$item["tn"]; if($img=="") $img=$tn; } else $tn=$img;
				if($img!="") {
					//echo '<div class="clbox" style="background-image: ('.$item["img"].');"></div>';
					echo '<div class="clbox"><a class="image_single" href="'.$img.'"><img src="'.$tn.'"></a></div>';
				} else {
					echo '<div class="clbox" style="background: '.$item["color"].';"></div>';
				}
				echo '<div class="clinfo">';
				$arw=$item["width"];
				foreach($arw as $wid=>$w){
					echo '<img src="/img/pal/'.$w.'.png" title="'.$w.'">';
				};
				echo "<br/><b>".$cid.'</b>';
				echo '</div>';
				echo '</div>';
				$cnt++; if($cnt==3){$cnt=0; echo '<br/>'.chr(10);};
		};
?>
	</p>
</div>
</div>

</div>
<p>
Каталог размещен в ознакомительных целях. Цвет, отображаемый монитором, может не соответствовать реальному цвету в каталоге. Поэтому рекомендуем все же ознакомиться с реальным каталогом у нас в офисе.
</p>
<?}?>