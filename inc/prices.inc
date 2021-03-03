<?
 $sel_mat  = "lac_eco_320c"; 	// выбранный в списке материалов по умолчанию

$k_zp     = 0.2;				// коэфициент зарплаты монтажников
$p_perehod = 6;					// Переход уровня прямолинейный
$p_perehod_c = 6.8;				// Переход уровня криволинейный
$min_zp	  = 10;                 // мин. зарплата монтажников 

$price_json = file_get_contents(__DIR__.'/price.json');
if($price_json === false) {
	echo 'Ошибка чтения прайс-листа';
}
else {
	$price = json_decode($price_json, TRUE);
  	if($price == NULL) echo 'Ошибка раззбора прайс-листа';
	else {
		$discounts = $price["discounts"];
		ksort($discounts);
		$GLOBALS['discounts'] = $discounts;

		$films = $price["films"];
		$def_film = $films["default"];
		unset($films["default"]);
		$GLOBALS['films']=$films;
		$GLOBALS['def_film']=$def_film;

		$profiles = $price["profiles"];
		$def_profile = $profiles["default"];
		unset($profiles["default"]);
		$GLOBALS['profiles']=$profiles;
		$GLOBALS['def_profile']=$def_profile;

		$decors = $price["decors"];
		$def_decor = $decors["default"];
		unset($decors["default"]);
		$GLOBALS['decors']=$decors;
		$GLOBALS['def_decor']=$def_decor;
		
		$surfaces = $price["surfaces"];
		$def_surface = $surfaces["default"];
		unset($surfaces["default"]);
		$GLOBALS['surfaces'] = $surfaces;
		$GLOBALS['def_surface'] = $def_surface;
		
		$elements = $price["elements"];
		$GLOBALS['elements']=$elements;
		
		$others = $price["others"];
		$GLOBALS['others'] = $others;

		$p_corner	= $price["elements"]["corner"]["price"];
		$p_curve	= $price["elements"]["curve"]["price"];
		$p_lamp		= $price["elements"]["lamp"]["price"];
		$p_spot		= $price["elements"]["spot"]["price"];
		$p_pipe		= $price["elements"]["pipe"]["price"];
		$p_lcross_direct= $price["elements"]["lcross_direct"]["price"];
		$p_perehod = $p_lcross_direct;
		$p_lcross_curve	= $price["elements"]["lcross_curve"]["price"];
		$p_perehod_c = $p_lcross_curve;
		$p_inner_cut	= $price["elements"]["inner_cut"]["price"];
		$p_curve_seam	= $price["elements"]["curve_seam"]["price"];
		$min_salary	= $price["salary"]["min_salary"]["price"];
		$k_salary	= $price["salary"]["salary"]["price"]/100;
		$k_center	= $price["elements"]["center"]["price"]/100;
		$k_comb	= $price["elements"]["combination"]["price"]/100;
		$k_combination	= $price["elements"]["combination"]["price"]/100;
		$p_zamer	= $price["others"]["zamer"];
		$p_transport	= $price["others"]["transport"];
		
		$p_vst		= $decors["vst_w"]["price"];
		$p_bvst   	= $decors["vst_c"]["price"];
		$p_cvst   	= $decors["vst_c"]["price"];
		$p_cvst2  	= $decors["vst_cp"]["price"];
		$p_cord   	= $decors["cord"]["price"];
	}
}
//var_dump($films);

require_once "price_func.inc";
//require_once "discount.inc";
?>