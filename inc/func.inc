<?
function okonchanie($c, $m, $o, $t)
{
$c = abs($c);
if ($c % 100 == '1' or ($c % 100 > '20') and ($c % 10 == '1')) return $o;
else if ($c % 100 == '2' or ($c % 100 > '20') and ($c % 10 == '2')) return $t;
else if ($c % 100 == '3' or ($c % 100 > '20') and ($c % 10 == '3')) return $t;
else if ($c % 100 == '4' or ($c % 100 > '20') and ($c % 10 == '4')) return $t;
else return $m;
}

function waterMark($original, $watermark, $placement = 'bottom=30,right=30', $destination) {
   $original = urldecode($original);
   $info_o = getImageSize($original); 
   if (!$info_o) {echo 1;
         return false; }
   $info_w = @getImageSize($watermark); 
   if (!$info_w) {echo 2;
         return false; }

   list ($vertical, $horizontal) = split(',', $placement,2); 
   list($vertical, $sy) = split('=', trim($vertical),2); 
   list($horizontal, $sx) = split('=', trim($horizontal),2); 

   switch (trim($vertical)) { 
      case 'bottom': 
         $y = $info_o[1] - $info_w[1] - (int)$sy; 
         break; 
      case 'middle': 
         $y = ceil($info_o[1]/2) - ceil($info_w[1]/2) + (int)$sy; 
         break; 
      default: 
         $y = (int)$sy; 
         break; 
      } 

   switch (trim($horizontal)) { 
      case 'right': 
         $x = $info_o[0] - $info_w[0] - (int)$sx; 
         break; 
      case 'center': 
         $x = ceil($info_o[0]/2) - ceil($info_w[0]/2) + (int)$sx; 
         break; 
      default: 
         $x = (int)$sx; 
         break; 
      } 

   $original = @imageCreateFromString(file_get_contents($original)); 
   $watermark = @imageCreateFromString(file_get_contents($watermark)); 
   $out = imageCreateTrueColor($info_o[0],$info_o[1]); 

   imageCopy($out, $original, 0, 0, 0, 0, $info_o[0], $info_o[1]); 

//Тут задаем размер изображения в которые можно добавлять Watermark
// $info_o[0] > 250 - ширина изображения должна быть больше 250 px
// $info_o[1] > 250 - высота изображения должна быть больше 250 px

	if( ($info_o[0] > 250) && ($info_o[1] > 250) )
	{
		imageCopy($out, $watermark, $x, $y, 0, 0, $info_w[0], $info_w[1]);
	}
	imagejpeg($out,$destination,100);
	

   imageDestroy($out); 
   imageDestroy($original); 
   imageDestroy($watermark); 

   return true; 
   } 
?>