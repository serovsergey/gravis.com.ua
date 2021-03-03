<?
function calc_price_area($mat, $area, $perim, $corners, $profile_id = 0, $curve=0, $lamps=0, $spots=0, $pipes=0, $center=0, $comb=0, $vst=0, $bvst=0, $cvst=0, $cord=0, $perehod=0, $perehod_c=0)
{
	global $films, $profiles, $def_profile, $p_corner, $p_curve, $p_lamp, $p_spot, $p_pipe, $p_vst, $p_bvst, $p_cvst, $p_cord, $p_perehod, $p_perehod_c, $k_center, $k_comb, $k_zp, $min_zp;
	
	if($profile_id == 0) 
		$profile_id = $def_profile;
	if(!isset($profiles[$profile_id])) die("No default profile!");
	$p_perim = $profiles[$profile_id]["price"];
	
	$sum_area    = $films[$mat]["price"] * $area;
	$sum_perim   = $p_perim * $perim;
	$sum_corners = $p_corner * $corners;
	$sum_curve   = $p_curve * $curve;
	$sum_lamps   = $p_lamp * $lamps;
	$sum_spots   = $p_spot * $spots;
	$sum_pipes   = $p_pipe * $pipes;
	if($center!=0) {$sum_center = $sum_area * $k_center;} else $sum_center = 0;
	if($comb!=0) {$sum_comb = $sum_area * $k_comb;} else $sum_comb = 0;
	$sum_vst     = $p_vst * $vst;
	$sum_bvst    = $p_bvst * $bvst;
	$sum_cvst    = $p_cvst * $cvst;
	$sum_cord    = $p_cord * $cord;
	$sum_perehod = $p_perehod * $perehod;
	$sum_perehod_c = $p_perehod_c * $perehod_c;
	$sum_total=  $sum_area + $sum_perim + $sum_corners + $sum_curve + $sum_lamps + $sum_spots + $sum_pipes + $sum_center + $sum_comb + $sum_vst + $sum_bvst + $sum_cvst + $sum_cord + $sum_perehod + $sum_perehod_c;
	//$sum_total += max($sum_total*$k_zp, $min_zp);
	return $sum_total;  
};

function calc_price_len($mat, $length, $width, $corners, $profile_id = 0, $curve=0, $lamps=0, $spots=0, $pipes=0, $center=0, $comb=0, $vst=0, $bvst=0, $cvst=0, $cord=0, $perehod=0, $perehod_c=0)
{
	return calc_price_area($mat, $length*$width, ($length+$width)*2, $corners, $profile_id, $curve, $lamps, $spots, $pipes, $center, $comb, $vst, $bvst, $cvst, $cord);
};
?>