<?
$_URL = preg_replace("/^(.*?)index.php$/", "$1", $_SERVER['SCRIPT_NAME']);
$_URL = preg_replace("/^".preg_quote($_URL, "/")."/", "", urldecode($_SERVER['REQUEST_URI']));
$_URL = preg_replace("/(\/?)(\?.*)?$/", "", $_URL);
$_URL = preg_replace("/[^0-9A-Za-zА-Яа-я._\\-\\/]/i", "", $_URL); // вырезаем ненужные символы (не обязательно это делать)
$_URL = explode("/", $_URL);
if (preg_match("/^index\.(?:html|php)$/i", $_URL[count($_URL) - 1])) unset($_URL[count($_URL) - 1]);

header('Content-type: text/html; charset=utf-8');

$site_name="https://gravis.com.ua";
$current_url=$site_name.$_SERVER['REQUEST_URI'];
$site_name=$site_name.'/';
$root=$_SERVER['DOCUMENT_ROOT'];
require_once "inc/func.inc";
require_once "inc/consts.inc";
if(isset($_GET['use_price'])) {
	$price_file = $_GET['use_price'];
	require_once "inc/".$price_file.".inc";
} else require_once "inc/prices.inc";
if(isset($_GET['no_min_zp'])) {
	$min_zp = 0;
}
require_once "inc/mainmenu.inc";
$cur_item=$_URL[0];
if($cur_item=="") $cur_item="main";

$error404=0;
$header=1;
if (!in_array($cur_item,array_keys($menu)))
{
 header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
 $error404=1;
}
else include $menu[$cur_item]["file"];
$header=0;

$path = "inc/scroogefrog_udp_tcp.php";
include_once($path);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns#" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="google-site-verification" content="1ONVgfU0ZkVKIGfkrBbIxS6WBmLQXgzBQwnqT5MgI74" />
	<meta name="wot-verification" content="48de70b72c275465490b"/>
	<!-- Global site tag (gtag.js) - AdWords: 1014164448 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1014164448"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-1014164448');
</script>
	<title>
		<?
			if((isset($subtitle)) && ($subtitle!='')) $temp_subtitle=' ('.$subtitle.')'; else $temp_subtitle='';
			$tmp_title=$menu[$cur_item]["title"].$temp_subtitle;
			if($tmp_title!='') $tmp_title=$tmp_title.' · ';
			echo $tmp_title."Натяжные потолки · Херсон · Компания Гравис\n";
		?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=0.8"/>
	<meta name="description" content="<? echo $menu[$cur_item]["hint"] ?>"/>
	<meta name="Keywords" content="натяжные потолки, натяжные потолки херсон, потолки, цена, фото, херсон, гравис, форум, фотогалерея, гипсокартон, подвесные, дизайн, люстры, светильники"/>
	<meta name="ROBOTS" content="ALL"/>
	
  <meta property="og:url" content="https://gravis.com.ua" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Компания ГРАВИС" />
  <meta property="og:description" content="Натяжные потолки" />
  <meta property="og:image" content="https://gravis.com.ua/img/logo_big.png" />

	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<link rel="stylesheet" type="text/css" href="/css/main.css"  media="all"/>
	
	<link rel="stylesheet" type="text/css" href="/css/loading.css"  media="all"/>
	<link rel="stylesheet" type="text/css" href="/css/palette.css"  media="all"/>
	<link rel="stylesheet" type="text/css" href="/css/print.css"  media="print"/>
	
	<link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox.min.css" media="all"/>
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22701481-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name": "Компания \"Гравис\"",
  "telephone": "+380(95)287-10-97",
  "url": "https://gravis.com.ua",
  "logo": "https://gravis.com.ua/img/logo_64.png",
  "image": "https://gravis.com.ua/img/logo_big.png",
  "description": "Натяжные потолки в Херсоне и области",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+380(95)287-10-97",
    "contactType": "sales"
  }
}
 </script>
</head>

<body>
<script type="text/javascript">
(function(a,e,c,f,g,h,b,d){var k={ak:"1014164448",cl:"3gp4CP-p7H0Q4NfL4wM",autoreplace:"(095) 287-10-97"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[g]||(a[g]=k.ak);b=e.createElement(h);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(h)[0];d.parentNode.insertBefore(b,d);a[f]=function(b,d,e){a[c](2,b,k,d,null,new Date,e)};a[f]()})(window,document,"_googWcmImpl","_googWcmGet","_googWcmAk","script");
</script>
	<div id="gravis">
		<header>
			<div id="logo">
				<!--<img src="/img/aktsiya2019.png" style="position:fixed; top:400px; right:0px;">-->
				<a id="logo_block" href="<?=$site_name?>" style="margin-left: 8px;">
					<img class="logo_img" src="/img/logow_big.png" alt="GRAVIS"/>
					<div class="logo_text">Компания "Гравис" - Натяжные потолки</div>
				</a>
				<div class="header_pic"><img height="150" width="146" src="/img/worker.png" alt=""/></div>
				<div class="header_info"><b>График работы:</b><br />Пн-Пт: 9:00 - 18:00<br />Сб: 9:00 - 14:00<br />Вс: Выходной<br />Без обеда<br /><!--<a href="<?=$site_name?>how_to_find">Как нас найти</a>--></div>
			</div>
			<div id="tel">
				<b>Телефоны: (095) 287-10-97, (067) 90-75-200</b>
			</div>
		</header>
		<div id="container">
			<nav id="menu" >
				<ul id="leftmenu">
					<?
						$i=0;
						foreach($menu as $cid=>$item) 
						{
							if($cid[0]==".") continue;
							$tmp="";$cur_url=$item["url"];
							$cur_url=str_replace("*",$cid,$cur_url);
							if(strpos($cur_url,$ext_link_tag)!==false) {$extlink=" <img src=\"/img/ext.gif\" alt=\"\" />"; $extlink_hint=" (открывается в новом окне)";}
							else {$extlink=""; $extlink_hint="";}
							$icon_tag = '';
							if(isset($item["icon"])) {
								$icon_tag = '<img src="/img/menu/'.$item["icon"].'" alt="·"/>';
							}
							$item_block = ''.$icon_tag./*'<div class="menu_caption">'.*/$item["caption"]/*.'</div>'*/;
							echo "
					<li";
							$cur_url = str_replace($site_name, "/", $cur_url);
							if($cid==$cur_item)	echo " class=\"current\">".$item_block;
							else echo '><a href="'.$cur_url.'" title="'.$item["hint"].$extlink_hint.'">'.$item_block.$extlink.'</a>';
							echo "</li>"; 
							$i++;
						};
					?>
				</ul>
				<aside id="left_banners">
					<?
						require 'inc/banners.inc';
					?>
				</aside>
			</nav>
			<section id="content" itemscope itemtype="http://schema.org/Article">
				<h1 itemprop="name">
					<?
						if($error404==1) echo "Ошибка";
						else echo $menu[$cur_item]["desc"]; 
					?>						
				</h1>
				<div id="include">
				<?
					if($error404==1) echo "Выбранный раздел \"".$cur_item."\" не существует.";
					else {
						include $menu[$cur_item]["file"];
					}
				?>
				</div>
			</section>
<? if((!$error404) && (isset($menu[$cur_item]["right"]))) { ?>
			<div id="right"> <?
	$right = $menu[$cur_item]["right"];
	foreach($right as $id=>$item) {
		if($id[0]==".") continue;
		echo '<div>';
		include $item;
		echo '</div>';
	}
?>
			</div> 
<?
}?>
		</div>
		<footer>
			&copy; ЧП &quot;Гравис Люкс&quot; &nbsp;&nbsp;&nbsp;Разработка: Серов С.А. 2008-2019&nbsp;&nbsp;&nbsp;
			<img src="/img/email.png" alt="E-Mail" />
		</footer>
		<!--<p style="border-top:solid 1px;">*При заказе свыше 20м<sup>2</sup>. Акция действует с 01.03.19 по 30.06.19. Дисконтная система на акционное предложение не распространяется.</p>-->
	</div>
	<div id="counters">
		<?
			//require 'inc/counters.inc';
		?>
		
		<p align="center" style="font-size:10px;">
			<a href="http://www.freetorg.com/lead/natyazhnye-potolki,3767505.html">Натяжные потолки</a>
			<a href="http://www.board.com.ua/va1043736574.html">Натяжные потолки херсон</a>
		</p>
	</div>
	<div id="toTop" title="Наверх">&#8593;</div >
	<script type="text/javascript">
	$(function() {
		$(window).scroll(function() {
			if($(this).scrollTop() != 0) {
				$('#toTop').fadeIn();
			} else {
				$('#toTop').fadeOut();
			}
		});
		$('#toTop').click(function() {
			$('body,html').animate({scrollTop:0},400);
		});
	});
</script>
</body>
</html>
