<?
$_URL = preg_replace("/^(.*?)index.php$/", "$1", $_SERVER['SCRIPT_NAME']);
$_URL = preg_replace("/^".preg_quote($_URL, "/")."/", "", urldecode($_SERVER['REQUEST_URI']));
$_URL = preg_replace("/(\/?)(\?.*)?$/", "", $_URL);
$_FULL_URL = preg_replace("/[^0-9A-Za-zА-Яа-я._\\-\\/]/i", "", $_URL); // вырезаем ненужные символы (не обязательно это делать)
$_URL = explode("/", $_FULL_URL);
if (preg_match("/^index\.(?:html|php)$/i", $_URL[count($_URL) - 1])) unset($_URL[count($_URL) - 1]);
$_ROOT = "http".(isset($_SERVER["HTTPS"]) ? 's' : '')."://".urldecode($_SERVER['SERVER_NAME']);

require 'auth.php';

//header('Content-type: text/html; charset=utf-8');

require 'inc/func.php';
$menu = array(
	"documents" => array(
		"caption" => "Документы",
		"sub_menu" => array(
			"contracts" => array(
				"caption"=> "Договора",
				"php" =>  "contracts.php",
				"hint" =>  "",
				"icon" =>  ".png"
			)
		)
	),
	"catalogs" => array(
		caption => "Справочники",
		sub_menu => array(
			"clients" => array(
				"caption"=> "Клиенты",
				"php" =>  "clients.php",
				"hint" =>  "",
				"icon" =>  ".png"		
			),
			"discount_cards" => array(
				"caption"=> "Дисконтные карты",
				"php" =>  "discount_cards.php",
				"hint" =>  "",
				"icon" =>  ".png"		
			)
		)
	)
);

if($_URL[0]!=""){
	$cur_item = $menu;
	foreach($_URL as $item){
		if(array_key_exists($item, $cur_item)){
			if(array_key_exists("sub_menu", $cur_item[$item])) $cur_item = $cur_item[$item]["sub_menu"];
			else $cur_item = $cur_item[$item];
		}
		else {
			header("HTTP/1.0 404 Not Found");
			return;		
		}
	}
}
else $cur_item = null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
	<title>
		Учетная система GRAVIS
	</title>
	<meta name="ROBOTS" content="NONE"/>
	
<link rel="stylesheet" type="text/css" media="screen" href="/css/themes/ui-lightness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
 
<script src="/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
<script src="/js/i18n/grid.locale-ru.js" type="text/javascript"></script>
<?
	if($cur_item) {
		$header = true;
		require "inc/".$cur_item["php"];		
	}
?>
</head>
<body>
	<div style="top: 0px; right:0px; text-align: right;">
	<?
	echo "Здравствуйте, ".$_SESSION['user_name']."!";
	?>
	<a href="?action=logout">(Выход)</a>
	</div>
	<nav id="mainmenu" >
<?
	print_menu($menu, 2, $_ROOT);
?>
	</nav>
	<?
	if($cur_item) {
		require "inc/".$cur_item["php"];
	}
	?>

	
</body>
</html>