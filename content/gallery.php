<?
$curself=$_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
$pos=strrpos($curself, '.');if ($pos!=0) $curself=substr($curself, 0, $pos);
$pos=strrpos(__FILE__, '.');if ($pos!=0) $curfile=substr(__FILE__, 0, $pos);
if($curfile == $curself) {
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");echo "404 Not Found";exit();}

if(isset($menu[$cur_item]["root"])) $dir=$menu[$cur_item]["root"];
else $dir = "gal/content";

$folder_img="img/folder-img.png";
$img_error="img/error.png";
$icons_root="/img/icons";
$img_h = 128;
$img_w = 160;
$perpage = 60;/*$cols*$rows;*/
$files_exts = array("zip", "rar", "txt", "pdf", "xls", "xlsx", "doc", "docx", "ytb", "psd");
$pictures_exts = array("jpg", "jpeg", "gif", "png", "bmp");

$page = isset($_GET['page']) ? $_GET['page'] : 1; 

if($header==1) { 		// ----------- выполняется в начале страницы (при первом включении файла) - инициализация
	function get_dir_info($dir)
	{
		$info_file=$dir."/.nfo";
		if(file_exists($info_file)) return parse_ini_file($info_file);
		return 0;
	}
	
	//------------------------------------
	
	$subtitle='';
	$gal_path="";

	for($i=1;$i<sizeof($_URL);$i++) {
	  $gal_path .= "/" . $_URL[$i];
	  $info=get_dir_info($dir.$gal_path);
	  if(isset($info['title'])) $cur_title=$info['title'];
	  else $cur_title=$_URL[$i];
	  $subtitle .=$cur_title;
	  if($i!=sizeof($_URL)-1) $subtitle .='/';
	}
}
else {				// ----------- выполняется в разделе контента (при втором включении файла)
?>
<?
	function allowed_ext($_ext) {
		global $files_exts, $pictures_exts;
		$ext=strtolower($_ext);
		if(in_array($ext, $files_exts)) return 1;
		if(in_array($ext, $pictures_exts)) return 2;
		return 0;
	}

	function FileSizeEx($file, $setup = null)	{
		$FZ = ($file && @is_file($file)) ? filesize($file) : NULL;
		$FS = array("Б","КБ","МБ","ГБ","ТБ","PB","EB","ZB","YB");
		
		if($FZ==0) return "Пустой";
		if(!$setup && $setup !== 0)	{
			return number_format($FZ/pow(1024, $I=floor(log($FZ, 1024))), ($i >= 1) ? 2 : 0) . ' ' . $FS[$I];
		} elseif ($setup == 'INT') return number_format($FZ);
		else return number_format($FZ/pow(1024, $setup), ($setup >= 1) ? 2 : 0 ). ' ' . $FS[$setup];
	}
	
	function create_img_tn($dir, $file)	{
		global $img_h, $img_w,$root;
		$nw = $img_w;    // Ширина миниатюр
		$nh = $img_h;    // Высота миниатюр

		$source = $root.$dir.$file; 
		$dest_dir=$root.$dir.'.cache/'; 
		$dest = $dest_dir.$file; 
		
		if(!is_dir($dest_dir)) mkdir($dest_dir, 0755);
		
		$stype = explode(".", $source);
		$stype = strtolower($stype[count($stype)-1]);

		$size = getimagesize($source);
		if(!$size) return 0;
		$w = $size[0];    // Ширина изображения 
		$h = $size[1];    // Высота изображения
		//echo $w*$h;
		if($w*$h>512*1024*1024/3) return 0;		
		 ini_set('display_errors','On');//ini_set('display_errors',0);
		try {
			switch($stype) {
			case 'gif': $simg = imagecreatefromgif($source);
						break;
			case 'jpg': $simg = imagecreatefromjpeg($source);
						break;
			case 'png': $simg = imagecreatefrompng($source);
						break;
			}
		}
		catch (Exception $e){
			return 0;
		}
		//ini_set('display_errors',1);
		if (!$simg) {return 0;}		
		$dimg = imagecreatetruecolor($nw, $nh);
		if(!dimg) return 0;

		if($w > $h) {												// если ширина больше высоты (альбомная)
			$k = $w / $nw;
			$new_h = $h / $k;
			if(!imagecopyresampled($dimg,$simg,0,($nh-$new_h)/2,0,0,$nw,$new_h,$w,$h)) return 0;
		} elseif(($w < $h) || ($w == $h)) {     								// иначе если высота больше длины (портретная) или квадрат
				$k = $w / $nh; 
				$new_w = $w / $k; 
				if(!imagecopyresampled($dimg,$simg,($nw-$new_w)/2,0,0,0,$nh,$new_w,$w,$h)) return 0;
			 } else {     
				if(!imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h)) return 0; 
			 }      

/*		if($w > $h) {
			$adjusted_width = $w / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			if(!imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h)) return 0;
		} elseif(($w < $h) || ($w == $h)) {     
				$adjusted_height = $h / $wm;
				$half_height = $adjusted_height / 2;
				$int_height = $half_height - $h_height;
				if(!imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h)) return 0;
			 } else {     
				if(!imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h)) return 0; 
			 }     */
		if(!imagejpeg($dimg,$dest,100)) {return 0;}
		return 1;
	}

	function get_img_tn($dir, $file) {
		global $img_error,$root, $img_w, $img_h;
		$img=$dir.$file;
		$img_tn=$dir.".cache/".$file;
		if(!is_file($root.$img_tn)) {
			if(!create_img_tn($dir, $file)) { // создание tn
				return $img_error;
			}
		}
		$size = getimagesize($root.$img_tn);
		if(!$size) return 0;
		$w = $size[0];    // Ширина изображения 
		$h = $size[1];    // Высота изображения
		if((filectime($root.$img)>filectime($root.$img_tn)) || ($w!=$img_w) || ($h!=$img_h)) {
			if(!create_img_tn($dir, $file)) { // обновление tn
				
				return $img_error;
			}
		}
		return $img_tn;
	}

	function scan_content($dir, &$content_info)	{
		global $files_exts;
		$fc=0;$pc=0;$dc=0;$content_info=array();
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if(($file==".")||($file=="..")) continue;
				if(substr($file, 0, 1)==".") continue;
				$fullpath=$dir.'/'.$file;
				$ext = strtolower(substr(strrchr($file,'.'), 1));
				//if(($ext!="jpg")&&(!is_dir($fullpath))) continue;	// пропускаем все, что не картинка или не папка
				if((allowed_ext($ext)==0)&&(!is_dir($fullpath))) continue;	// пропускаем все, что не картинка или не папка
				if($ext=="cache") continue;						// пропускаем папки с миниатюрами
				if(is_dir($fullpath)) $dc++;						// наращиваем счетчик папок
				else {
					if(in_array($ext, $files_exts)) $fc++;			// наращиваем счетчик файлов
					else $pc++;							// наращиваем счетчик картинок
				}
			}
			closedir($dh);
		}
		$content_info['fc']=$fc;
		$content_info['pc']=$pc;
		$content_info['dc']=$dc;
		return $fc+$pc+$dc;
	}
	
//---------------------------------------- НАЧАЛО РАБОТЫ СКРИПТА ----------------------

	$gal_path="";
	if(sizeof($_URL)>1) echo '<a href="'.$site_name.$cur_item.'">Начало</a>';
	for($i=1;$i<sizeof($_URL);$i++) {
	  $gal_path .= "/" . $_URL[$i];
	  $info=get_dir_info($dir.$gal_path);
	  if(isset($info['title'])) $cur_title=$info['title'];
	  else $cur_title=$_URL[$i];
	  if(isset($info['hint'])) $cur_hint=$info['hint'];
	  else $cur_hint=$cur_title;
	  if($i==sizeof($_URL)-1) echo " » ".$cur_title;
	  else {
		echo ' » <a href="'.$site_name.$cur_item.$gal_path.'" title="'.$cur_hint.'">'.$cur_title."</a>";
		$prev_link=$site_name.$cur_item.$gal_path;
		$prev_title=$cur_title;
	  }
	}
	$dir .= $gal_path."/";

	//phpinfo(); /////////////////////////////////////////////////////////////////
	echo '
	<h2 align="center"><b>'.$cur_hint.'</b></h2>';
	$files=array();
	$folders=array();
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			$fc=0;$cur_col=1;
			while (($file = readdir($dh)) !== false) {
				if(($file==".")||($file=="..")) continue;
				if(substr($file, 0, 1)==".") continue;
				$fullpath=$dir.$file;
				$ext = strtolower(substr(strrchr($file,'.'), 1));
				//if(($ext!="jpg")&&(!is_dir($fullpath))) continue;	// пропускаем все, что не картинка или не папка
				if((allowed_ext($ext)==0)&&(!is_dir($fullpath))) continue;	// пропускаем все, что не картинка или не папка
				if($ext=="cache") continue;							// пропускаем папки с миниатюрами
				if(is_dir($fullpath)) $folders["*".$file] = filemtime($dir.$file); 	// заносим в массив папок дату/время папки
				else $files["_".$file] = filemtime($dir.$file); 			// заносим в массив файлов дату/время файла
			}
			closedir($dh);
		}
	}
	else {
		echo "Нет такой папки!";
		return;
	}

arsort($folders);				//сортируем массив папок
arsort($files);					//сортируем массив файлов
$folders = array_keys($folders);		//упрощаем массив папок, выбрасывая даты
$files = array_keys($files);			//упрощаем массив файлов, выбрасывая даты
$files=array_merge($folders,$files);		//совмещем массивы в один
if(is_array($files)){
	$pages=ceil(sizeof($files)/$perpage);	// вычисляем количесвто страниц
	if($pages>1) {				// если страниц больше одной, выводим верхнюю навигацию по страницам:
		echo '
<p align="center" style="font-size:11px;text-indent:0;margin-top:4px;margin-bottom:4px;">Страницы:&nbsp;&nbsp;';
		if($page>1) {
			echo '<a href="'.$site_name.$cur_item.$gal_path.'?page=1">Первая</a>&nbsp;&nbsp;';
			echo '<a href="'.$site_name.$cur_item.$gal_path.'?page='.($page-1).'">Предыдущая</a>&nbsp;&nbsp;';
		}
		echo '<span style="font-size:1.25em;">';
		for($i=1;$i<=$pages;$i++) {
			if($i==$page) echo '<b>'.$i.'</b>';
			else echo '<a href="'.$site_name.$cur_item.$gal_path.'?page='.$i.'">'.$i.'</a>';
			echo '&nbsp;&nbsp;';
		}
		echo '</span>';
		if($page<$pages) {
		echo '<a href="'.$site_name.$cur_item.$gal_path.'?page='.($page+1).'">Следующая</a>&nbsp;&nbsp;';
		echo '<a href="'.$site_name.$cur_item.$gal_path.'?page='.$pages.'">Последняя</a>&nbsp;&nbsp;';
		}
		echo '</p>';
	   }
	//natsort($files); ===========================================================================================
		

	$fc=0;/*$cur_col=1; $img_no=0;*/
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo '
<div id="gallery">';
	foreach($files as $n=>$_file) {
		$fc++;
		if(($fc<=($page-1)*$perpage)||($fc>$page*$perpage)) continue;  // пропускаем все, что не с этой страницы
		//$img_no++;
		$file=substr($_file, 1);					// получаем имя текущего файла (отбрасывая первый символ)
		$fullpath=$dir.$file;						// получаем полный путь
		if($_file[0]=="*"){ 										// ЭТО ПАПКА
			$info=get_dir_info($dir."/".$file);
			if(isset($info['title'])) $cur_title=$info['title'];
			else $cur_title=$file;
			if(isset($info['hint'])) $cur_hint=$info['hint'];
			else $cur_hint=$cur_title;
			if(isset($info['img'])) $cur_img=$fullpath.'/'.$info['img'];
			else $cur_img=$folder_img;
			if(!is_readable($root.'/'.$cur_img)) $cur_img=$folder_img;
			$content_info=0;
			$content_msg='';
			$tmp_p='<div class="gal_dir_info"><b>';
			if(scan_content($root.'/'.$dir.$file, $content_info)==0) { // папка пуста
				$content_msg.=$tmp_p.'Папка пуста'.'</div>';
			} else {
				$dc_=$content_info['dc']; $fc_=$content_info['fc']; $pc_=$content_info['pc'];
				if($dc_!=0) $content_msg.=$tmp_p.$dc_.'</b> '.okonchanie($dc_, 'категорий', 'категория', 'категории').'</div>';
				if($pc_!=0) $content_msg.=$tmp_p.$pc_.'</b> фото'.'</div>';
				if($fc_!=0) $content_msg.=$tmp_p.$fc_.'</b> '.okonchanie($fc_, 'файлов', 'файл', 'файла').'</div>';
			}
			echo '
	<figure class="gallery_cell">
		<a href="'.$site_name.$cur_item.$gal_path.'/'.$file.'" title="'.$cur_hint.'">
			<div class="folder_img" style="background-image:url(/'.$cur_img.');">
				<figcaption class="folder_title">'.$cur_title.'</figcaption>
			</div>
		</a>'.$content_msg.'
	</figure>';
		}
		else {			//<img src="/'.$cur_img.'" alt="'.$cur_title.'"/>	// ну тогда это файл
			$ext = strtolower(substr(strrchr($file,'.'), 1));
			if(in_array($ext, $files_exts)) {					// если это файл, а не картинка
				$img_tn=$icons_root.'/'.$ext.'.png';				// формируем путь к конке этого типа файлов
				if(!is_readable($root.$img_tn)) $img_tn=$icons_root.'/file.png';// если такой иконки нет, используем стандартную
				if($ext=="ytb") { 								// если это ссылка на ютюб
					if(file_exists($root."/".$fullpath)) {
						$ytb=parse_ini_file($root."/".$fullpath);
						if(isset($ytb['url'])) $url=$ytb['url'];
						if(isset($ytb['title'])) $comment=$ytb['title']; else $comment="Недоступно";
						if(isset($ytb['tn'])) $img_tn=$ytb['tn'];
					} else {
						$url="/";
						$comment="Недоступно";
						$img_tn='/'.$img_error;
					}
					?>
	<div class="gallery_cell">
<iframe width="<?=$img_w?>" height="<?=$img_h?>" src="<?=$url?>" frameborder="0" allowfullscreen>
</iframe>
</br><?=$comment?>
</div>
	<?
				}
				else {											// нет, это просто файл
					$ftitle=$file;
					if(is_readable($root.'/'.$fullpath.'.nfo'))	{
						$nfo=parse_ini_file($root."/".$fullpath.'.nfo');
						if(isset($nfo['title'])) $ftitle=$nfo['title'];
					}
				$comment=FileSizeEx($root.'/'.$fullpath);
	?>
		<figure class="gallery_cell">
		<a target="_blank" href="<?="/".$fullpath?>" title="Скачать">
			<img src="<?=$img_tn?>" alt="" />
			<br/><?=$ftitle?>
		</a><br/><p class="gal_dir_info"><?=$comment?></p>
		</figure>
	<?
				}
			}
			else {												// это картинка
			$tags='фото';
			//ini_set('display_errors',0);
			//$exif = exif_read_data($fullpath, "COMMENT", true); 
			//ini_set('display_errors',1);
			if($exif) {
				$comment=$exif["COMMENT"][0]; $comment = mb_convert_encoding($comment, "utf-8", "CP1251");
				//$comment = htmlspecialchars($comment, ENT_HTML5);
				$tags1=trim($exif["COMMENT"][1]); /*$tags1=htmlspecialchars($tags1, ENT_HTML5); */if($tags1!='') $tags=$tags1;	
			}
			else $comment="";
			$img_tn=get_img_tn('/'.$dir, $file); 
			if((!$img_tn) ||(!is_readable($root.$img_tn)) ) $img_tn='/'.$img_error;
?>
	<figure class="gallery_cell">
		<a target="_blank" href="<?="/".$fullpath?>" data-fancybox="group" data-caption="<?=$comment?>">
			<img src="<?=$img_tn?>" style="border-top: 1px solid #960;border-left: 1px solid #960;border-right: 1px solid #960;border-bottom:1px solid #960;" alt="<?=$tags.' ('.$file.')'?>" />
		</a>
		<figcaption><?=$comment?></figcaption>
		</figure>	
<? 
			}
		}
	}
echo '
</div>
';
	if($pages>1) {
		echo '<p align="center" style="font-size:11px;text-indent:0;margin-top:4px;margin-bottom:4px;">';
		echo 'Страницы:&nbsp;&nbsp;';
		if($page>1) {
			echo '<a href="'.$site_name.$cur_item.$gal_path.'?page=1">Первая</a>&nbsp;&nbsp;';
			echo '<a href="'.$site_name.$cur_item.$gal_path.'?page='.($page-1).'">Предыдущая</a>&nbsp;&nbsp;';
		}
		echo '<span style="font-size:1.25em;">';
		for($i=1;$i<=$pages;$i++) {
			if($i==$page) echo '<b>'.$i.'</b>';
			else echo '<a href="'.$site_name.$cur_item.$gal_path.'?page='.$i.'">'.$i.'</a>';
			echo '&nbsp;&nbsp;';
		}
		echo '</span>';
		if($page<$pages) {
		echo '<a href="'.$site_name.$cur_item.$gal_path.'?page='.($page+1).'">Следующая</a>&nbsp;&nbsp;';
		echo '<a href="'.$site_name.$cur_item.$gal_path.'?page='.$pages.'">Последняя</a>&nbsp;&nbsp;';
		}
		echo '</p>';
	}
	}
	else
	{
		echo 'Папка пуста.';
	}
	if($gal_path!="") {
		if(!isset($prev_link)) {$prev_link=$site_name.$cur_item; $prev_title="Начало";}
		echo '<p align="center"><a href="'.$prev_link.'" title="Назад к &quot;'.$prev_title.'&quot;">« Назад</a></p>';
	}
	?>
<?}?>