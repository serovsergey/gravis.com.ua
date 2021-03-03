<?
$curself=$_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
$pos=strrpos($curself, '.');if ($pos!=0) $curself=substr($curself, 0, $pos);
$pos=strrpos(__FILE__, '.');if ($pos!=0) $curfile=substr(__FILE__, 0, $pos);
if($curfile == $curself) {
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");echo "404 Not Found";exit();}

require_once 'inc/calc_forms.inc';
$calc_forms = $GLOBALS['calc_forms'];
$cur_form = $_URL[1];
if($cur_form == '') $cur_form = array_keys($calc_forms)[0];

if($header==1) { 
	//проход во время заголовка
	//$subtitle=$calc_forms[$cur_form]['caption'];
}
else {
?>
<link rel="stylesheet" type="text/css" href="/css/calc.css" media="all"/>
<ul id="forms_list">
<? 
	foreach($calc_forms as $cid=>$item) 
	{
		echo '<li id="'.$cid.'" class="form_tab'; 
		if($cur_form==$cid) echo ' current';
		$title="";
		if(isset($item['hint']) && $item['hint']!="") $title = ' title="'.$item['hint'].'"'; 	
		echo '"'.$title.'>';
		echo '<a href="'.$cid.'">';
		$icon_svg = $item["icon_svg"];
		if(isset($icon_svg)){
			echo '<svg width="16" height="16">'.$icon_svg.'</svg>';
		}
		$icon_img = $item["icon_img"];
		if(isset($icon_img)){
			echo '<img height="16" src="'.$icon_img.'">';
		}
		echo $item["caption"];
		echo '</a></li>
';
    };
	echo '<li id="spec_tab" class="form_tab'.($cur_form=='spec_tab' ? " current" : "").'" title="Спецификация"><a href=""><img height="16" src="/img/spec.svg">Спецификация</a></li>'; 
?>

</ul>
<div id="tab_wrapper">
<div id="tab_content"></div>
<div id="result"></div>
</div>

<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="/js/calc.js"></script>
<?}?>