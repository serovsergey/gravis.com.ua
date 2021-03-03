<?php

require_once '../inc/calc_forms.inc';
require_once '../inc/prices.inc';

class calc extends apiBaseClass {
	
    function getVersion() {
        $retJSON = $this->createDefaultJson();
        $retJSON->version = '1.1';
        return $retJSON;
    }
	
	function getFormsList() {
        $retJSON = $this->createDefaultJson();
        $retJSON->forms = '';
        return $retJSON;
    }

	function makeLevel($controls){
		$input_form = ''; 
		foreach($controls as $cid=>$item) 
		{
			if($cid[0]=='.') continue;
			if($item['type']=='group'){
				if(isset($item['closed']) && ($item['closed']==1)) $closed=" closed"; else $closed = '';
				$input_block='
				<div id="'.$cid.'" class="input_group'.$closed.'">
					<div class="group_caption">'.$item['caption'].'</div>
					<div class="group_content'.$closed.'">'.$this->makeLevel($item['controls']).'</div>
				</div>
				';
				$input_form = $input_form.$input_block;
			}
			else {
				$singleline = $item['singleline']==1 ? ' class="singleline"' : '';
				if($item['required']==1) $label_style='style="font-weight: bold;"'; else $label_style='';
				$input_block='<label'.$singleline.'><span '.$label_style.'>'.$item['caption'].'</span>';
				if($item['type']=='combobox'){
					$input_block = $input_block.'<select id="_'.$cid.'" size="1" name="'.$cid.'">';
					if(isset($item["allow_null"]) && $item["allow_null"]=="true"){
						$input_block = $input_block.'<option value="">Нет</option>';
					}
					$def = $GLOBALS[$item["default"]];
					
					foreach($GLOBALS[$item['source']] as $sid=>$source){
						if(($sid[0]=='.') || ($sid == 'default')) continue;
						if((isset($item["strict"]) && $item["strict"]==1) && isset($source['hidden'])) continue;
						$extra_text = "";
						if(isset($item["extra"]))
						{
							$extra = $source[$item["extra"]];
							if($extra!=""){
								if (is_array($extra)) { 
									foreach($extra as $cur) {
										if ($extra_text!="") $extra_text = $extra_text.'; ';
										$extra_text=$extra_text.strval($cur);
									}
								}
								else $extra_text=$extra;
								if(isset($item["suffix"])) $extra_text = $extra_text . $item["suffix"];
								$extra_text = ' ('.$extra_text.')';
							}
						}
						$selected = $sid == $def ? ' selected="selected" ' : '';
						$input_block = $input_block.'<option value="'.$sid.'"'.$selected.'>'.$source['title'].$extra_text.'</option>';
					}
					$input_block = $input_block.'</select>';
					
				}else if($item['type']=='number'){
					$required = $item['required']==1 ? ' required' : '';
					$min_val = isset($item['min']) ? ' min="'.$item['min'].'"' : '';
					$max_val = isset($item['max']) ? ' max="'.$item['max'].'"' : '';
					$step = isset($item['step']) ? ' step="'.$item['step'].'"' : '';
					$input_block = $input_block.'<input id="_'.$cid.'" type="number" name="'.$cid.'"'.$required.$min_val.$max_val.$step.'></input>';
					if(isset($item['measure'])) $input_block = $input_block.'<div style="margin: auto 0px;">'.$item['measure'].'</div>';
				}else if($item['type']=='checkbox'){
					$input_block = $input_block.'<input id="_'.$cid.'" type="checkbox" name="'.$cid.'"></input>';
				}
				$input_block = $input_block.'</label>';
				$input_form = $input_form.$input_block;
			}
		}
		return $input_form;
	}

	function makeContent($form_id){
		$html='';
		$input_form = '';
		$calc_forms = $GLOBALS['calc_forms'];
		$controls = $calc_forms[$form_id]['controls'];
		$input_form = $input_form.$this->makeLevel($controls);
		$input_form = $input_form.'<button class="ui-button" id="calc_start" name="calc_start">Рассчитать</button>';
		$input_form = '<form id="calc_form" onsubmit="calcStart(); return false;">'.$input_form.'</form>';
		$html = '<div id="input_form">
	<div class="table_button_group height24">
	'.($form_id != "custom" ? '<img class="translateToCustom" src="/img/toHexagon.svg" alt="Преобразовать в произвольный" title="Преобразовать в произвольный">' : '').'
		<img class="resetForm" src="/img/delete.svg" alt="Очистить форму" title="Очистить форму">
	</div>
	'.$input_form.'</div>';
		return $html;
	}
	
	function formContent($apiMethodParams) {
        $retJSON = $this->createDefaultJson();
        if (isset($apiMethodParams->id)){
            $retJSON->content = $this->makeContent($apiMethodParams->id);
        }else{
            $retJSON->errorno = APIConstants::$ERROR_PARAMS;
        }
        return $retJSON;
    }
	
	function checkParams($param_set){
		return true;
	}
	
	static function roundTo($arg, $precision){
		$strPrec = strval($precision);
		$decimals = strlen(substr($strPrec, strpos($strPrec, "."))) - 1;
		//error_log($decimals);
		return number_format(round($arg / $precision) * $precision, $decimals); 
	}
	
	function translateToCustom($apiMethodParams){
		$retJSON = $this->createDefaultJson();
		$param_set = json_decode(json_encode($apiMethodParams), true);
		
		$length = isset($param_set["length"]) ? $param_set["length"] : 0;
		$width = isset($param_set["width"]) ? $param_set["width"] : 0;
		$cut_length = isset($param_set["cut_length"]) ? $param_set["cut_length"] : 0;
		$cut_width = isset($param_set["cut_width"]) ? $param_set["cut_width"] : 0;
		$diameter = isset($param_set["diameter"]) ? $param_set["diameter"] : 0;
		switch($param_set['id']){
			case 'rect': 				
				$param_set["area"] = $this->roundTo($length * $width, 0.01); 
				$param_set["perimeter"] = $this->roundTo(($length + $width) * 2, 0.01); 
				$param_set["corners"] = 4; 
				break;
			case 'lshaped': 
				if(($length <= $cut_length) || ($width <= $cut_width)) {
					$retJSON->errorno = APIConstants::$ERROR_PARAMS; 
					return $retJSON;
				}
				$param_set["area"] = $this->roundTo($length * $width - $cut_length * $cut_width, 0.01); 
				$param_set["perimeter"] = $this->roundTo(($length + $width) * 2, 0.01); 
				$param_set["corners"] = 6; 
				break;
			case 'circle': 
				$param_set["area"] = $this->roundTo(round(pi()*($diameter*$diameter/4),1), 0.01); 
				$param_set["perimeter"] = $this->roundTo(round(pi()*($diameter),1), 0.01); 
				$param_set["curve"] = $param_set["perimeter"];
				break;
			default: 
				$retJSON->errorno = APIConstants::$ERROR_PARAMS; 
				return $retJSON;
		}
		if($param_set["area"] * $param_set["perimeter"] > 0 ){
			$retJSON->result = json_encode($param_set);
		} else {
			$retJSON->errorno = APIConstants::$ERROR_PARAMS; 
		}
		return $retJSON;
	}
	
    function start($apiMethodParams) {
//error_log("start");
        $retJSON = $this->createDefaultJson();
		$template = '../tpl/calc.tpl';
		$editing = false;
		if(isset($apiMethodParams->stamp)) {
			$param_set = array();
			$param_set[$apiMethodParams->stamp] = json_decode(json_encode($apiMethodParams), true);
			$is_spec = false;
			if(isset($apiMethodParams->editing)) 
				$editing = true;
		}
		else {
			$param_set = json_decode(json_encode($apiMethodParams), true);
			$is_spec = true;
		}
		if ($this->checkParams($param_set)){
			ob_start();
			
			if($is_spec) {
				$section = 'spec_header';
				include $template;
			}
			$total_sum = 0;
			$total_area = 0;
			foreach($param_set as $stamp => $params){
				$table_sum = 0;
				$summat = 0;
				if(isset($params['id'])) $id = $params['id']; else $id = "";
				if(isset($params['material'])) $film_id = $params['material']; else $film_id = 0;
				if(isset($params['area'])) $area = $params['area']; else $area = 0;
				if(isset($params['perimeter'])) $perimeter = $params['perimeter']; else $perimeter = 0;
				if(isset($params['length'])) $length = $params['length']; else $length = 0;
				if(isset($params['width'])) $width = $params['width']; else $width = 0;
				if(isset($params['cut_length'])) $cut_length = $params['cut_length']; else $cut_length = 0;
				if(isset($params['cut_width'])) $cut_width = $params['cut_width']; else $cut_width = 0;
				if(isset($params['diameter'])) $diameter = $params['diameter']; else $diameter = 0;
				if(isset($params['profile'])) $profile_id = $params['profile']; else $profile_id = 0;
				if(isset($params['corners'])) $corners = $params['corners']; else $corners = 0;
				if(isset($params['curve'])) $curve = $params['curve']; else $curve = 0;
				if(isset($params['decor'])) $decor = $params['decor']; else $decor = "0";
				if(isset($params['decor_length'])) $decor_length = $params['decor_length']; else $decor_length = 0;			
				if(isset($params['lamp'])) $lamp = $params['lamp']; else $lamp = 0;
				if(isset($params['spot'])) $spot = $params['spot']; else $spot = 0;
				if(isset($params['pipe'])) $pipe = $params['pipe']; else $pipe = 0;
				if(isset($params['center'])) $center = $params['center']; else $center = 0;
				if(isset($params['comb'])) $comb = $params['comb']; else $comb = 0;
				if(isset($params['high_height'])) $high_height = $params['high_height']; else $high_height = 0;
				if(isset($params['hard_surface'])) $hard_surface = $params['hard_surface']; else $hard_surface = 0;
				if(isset($params['surface_length'])) $surface_length = $params['surface_length']; else $surface_length = 0;
				
				if(isset($params['curtain'])) $curtain = $params['curtain']; else $curtain = 0;
				if(isset($params['recess_curtain'])) $recess_curtain = $params['recess_curtain']; else $recess_curtain = 0;
				if(isset($params['recess'])) $recess = $params['recess']; else $recess = 0;
				if(isset($params['recess_decor'])) $recess_decor = $params['recess_decor']; else $recess_decor = 0;
				
				if(isset($params['lcross_direct'])) $lcross_direct = $params['lcross_direct']; else $lcross_direct = 0;
				if(isset($params['lcross_curve'])) $lcross_curve = $params['lcross_curve']; else $lcross_curve = 0;
				if(isset($params['complex_corner'])) $complex_corner = $params['complex_corner']; else $complex_corner = 0;
				if(isset($params['cond'])) $cond = $params['cond']; else $cond = 0;
				if(isset($params['inner_cut'])) $inner_cut = $params['inner_cut']; else $inner_cut = 0;
				
				if(isset($params['material2'])) $film_id2 = $params['material2']; else $film_id2 = 0;
				if(isset($params['area2'])) $area2 = $params['area2']; else $area2 = 0;
				if(isset($params['profile2'])) $profile_id2 = $params['profile2']; else $profile_id2 = 0;
				if(isset($params['profile2_count'])) $profile2_count = $params['profile2_count']; else $profile2_count = 0;
				if(isset($params['decor2'])) $decor2 = $params['decor2']; else $decor2 = "0";
				if(isset($params['decor2_count'])) $decor2_count = $params['decor2_count']; else $decor2_count = "0";			

				switch($params['id']){
					case 'rect': 
						$area = $length * $width; 
						$perimeter = ($length + $width) * 2; 
						$corners = 4; 
						$curve = 0;
						break;
					case 'lshaped': 
						$area = $length * $width - $cut_length * $cut_width;
						$perimeter = ($length + $width) * 2; 
						$corners = 6; 
						$curve = 0;
						if(($length <= $cut_length) || ($width <= $cut_width)) $area = 0;
						break;
					case 'circle': 
						$area = round(pi()*($diameter*$diameter/4),1); 
						$perimeter = round(pi()*($diameter),1); 
						$corners = 0; 
						$curve = $perimeter;
						break;
				}
				if($decor_length==0) $decor_length = $perimeter;
				if($surface_length==0) $surface_length = $perimeter;
				
				$result="";
				$area = round($area, 2);
				$perimeter = round($perimeter, 2);
				/*if(($area * $perimeter <= 0) ) {
					echo '<div style="text-align: center;">Недостаточно данных для расчета!</div>';
					continue;
				}
				else*/{
					if(!$is_spec){
						$section = 'calc_header';
						include $template;
					}
					$section = 'table_header_tag';
					include $template;
					
					if($is_spec){
						if(isset($params['caption'])){
							$caption_left = true;
							$caption = $params['caption'];
							$section = 'caption';
							include $template;
						}
					}
					else {
						$caption = 'Подробный расчет';
						$section = 'caption';
						include $template;
					}
					$section = 'table_header'.($is_spec ? '_ukr' : '');
					include $template;					
					
					$section = 'table_item';
					
					$film = $GLOBALS['films'][$film_id];
					$width_text = '';
					$mwidth = $film['width'];
					if (is_array($mwidth)) { 
						foreach($mwidth as $cur) {
							if ($width_text!="") $width_text = $width_text.'; ';
							$width_text = $width_text.strval($cur);
						}
					} else $width_text=$mwidth;
					$tmp_mat = ($is_spec ? 'Матеріал' : 'Материал');
					$item = $tmp_mat.' '.$film['title'.($is_spec ? '_ukr' : '')].' ('.$width_text.' м.)';
					$measure = 'м<sup>2</sup>';
					$count = $area;
					$total_area += $area;
					$price = $film['price'];
					$sum = $count * $price;
					$summat = $sum;
					$table_sum = $table_sum + $sum;
					include $template;
					
					//$item = var_dump($area2);include $template;
					if($area2 != 0) {
						//$item = "hit";include $template;
						$film2 = $GLOBALS['films'][$film_id2];
						$width_text = '';
						$mwidth = $film2['width'];
						if (is_array($mwidth)) { 
							foreach($mwidth as $cur) {
								if ($width_text!="") $width_text = $width_text.'; ';
								$width_text = $width_text.strval($cur);
							}
						} else $width_text=$mwidth;
						$tmp_mat = ($is_spec ? 'Матеріал' : 'Материал');
						$item = $tmp_mat.' '.$film2['title'.($is_spec ? '_ukr' : '')].' ('.$width_text.' м.)';
						$measure = 'м<sup>2</sup>';
						$count = $area2;
						$total_area += $area2;
						$price = $film2['price'];
						$sum = $count * $price;
						//$summat += $sum;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					$profile = $GLOBALS['profiles'][$profile_id];
					$item = 'Профиль '.$profile['title'.($is_spec ? '_ukr' : '')];
					if(isset($profile['hint']) && $profile['hint'] !='') $item = $item . ' ('.$profile['hint'].')';
					$measure = 'м.';
					$count = $perimeter;
					$price = $profile['price'];
					$sum = $perimeter * $price;
					$table_sum = $table_sum + $sum;
					include $template;
					
					if($profile2_count != 0) {
						$profile2 = $GLOBALS['profiles'][$profile_id2];
						$item = 'Профиль '.$profile2['title'.($is_spec ? '_ukr' : '')];
						if(isset($profile2['hint']) && $profile2['hint'] !='') $item = $item . ' ('.$profile2['hint'].')';
						$measure = 'м.';
						$count = $profile2_count;
						$price = $profile2['price'];
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($corners != 0){
						$item = $GLOBALS['elements']['corner']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['corner']['measure'];
						$price = $GLOBALS['elements']['corner']['price'];
						$count = $corners;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($decor != "0"){
						$decor = $GLOBALS['decors'][$decor];
						$item = $decor['title'.($is_spec ? '_ukr' : '')];
						if(isset($decor['hint']) && $decor['hint'] !='') $item = $item . ' ('.$decor['hint'].')';
						$measure = 'м.';
						$price = $decor['price'];
						$count = $decor_length;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}

					if($decor2_count != 0){
						$decor2 = $GLOBALS['decors'][$decor2];
						$item = $decor2['title'.($is_spec ? '_ukr' : '')];
						if(isset($decor2['hint']) && $decor2['hint'] !='') $item = $item . ' ('.$decor2['hint'].')';
						$measure = 'м.';
						$price = $decor2['price'];
						$count = $decor2_count;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($curve != 0){
						$item = $GLOBALS['elements']['curve']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['curve']['measure'];
						$price = $GLOBALS['elements']['curve']['price'];
						$count = $curve;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($lamp != 0) {
						$item = $GLOBALS['elements']['lamp']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['lamp']['measure'];
						$price = $GLOBALS['elements']['lamp']['price'];
						$count = $lamp;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					if($pipe != 0) {
						$item = $GLOBALS['elements']['pipe']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['pipe']['measure'];
						$price = $GLOBALS['elements']['pipe']['price'];
						$count = $pipe;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($hard_surface != "0"){
						$surface = $GLOBALS['surfaces'][$hard_surface];
						$item = 'Монтаж профиля по '.$surface['title_alt'.($is_spec ? '_ukr' : '')];
						if(isset($surface['hint']) && $surface['hint'] !='') $item = $item . ' ('.$surface['hint'].')';
						$measure = 'м.';
						$price = $surface['price'];
						$count = $surface_length;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($curtain != 0) {
						$item = $GLOBALS['elements']['curtain']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['curtain']['measure'];
						$price = $GLOBALS['elements']['curtain']['price'];
						$count = $curtain;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($recess_curtain != 0) {
						$item = $GLOBALS['elements']['recess_curtain']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['recess_curtain']['measure'];
						$price = $GLOBALS['elements']['recess_curtain']['price'];
						$count = $recess_curtain;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($recess != 0) {
						$item = $GLOBALS['elements']['recess']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['recess']['measure'];
						$price = $GLOBALS['elements']['recess']['price'];
						$count = $recess;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($recess_decor != 0) {
						$item = $GLOBALS['elements']['recess_decor']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['recess_decor']['measure'];
						$price = $GLOBALS['elements']['recess_decor']['price'];
						$count = $recess_decor;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($lcross_direct != 0) {
						$item = $GLOBALS['elements']['lcross_direct']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['lcross_direct']['measure'];
						$price = $GLOBALS['elements']['lcross_direct']['price'];
						$count = $lcross_direct;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($lcross_curve != 0) {
						$item = $GLOBALS['elements']['lcross_curve']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['lcross_curve']['measure'];
						$price = $GLOBALS['elements']['lcross_curve']['price'];
						$count = $lcross_curve;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($complex_corner != 0) {
						$item = $GLOBALS['elements']['complex_corner']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['complex_corner']['measure'];
						$price = $GLOBALS['elements']['complex_corner']['price'];
						$count = $complex_corner;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}

					if($cond != 0) {
						$item = $GLOBALS['elements']['cond']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['cond']['measure'];
						$price = $GLOBALS['elements']['cond']['price'];
						$count = $cond;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($inner_cut != 0) {
						$item = $GLOBALS['elements']['inner_cut']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['inner_cut']['measure'];
						$price = $GLOBALS['elements']['inner_cut']['price'];
						$count = $inner_cut;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					if($center != 0) {
						$item = $GLOBALS['elements']['center']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['center']['measure'];
						$price = $GLOBALS['elements']['center']['price']/100;
						$count = $summat;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}
					
					if($comb != 0) {
						$item = $GLOBALS['elements']['combination']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['combination']['measure'];
						$price = $GLOBALS['elements']['combination']['price']/100;
						$count = $summat;
						$sum = $count * $price;
						$table_sum = $table_sum + $sum;
						include $template;					
					}			
					if($high_height != 0){
						$item = $GLOBALS['elements']['high_height']['title'.($is_spec ? '_ukr' : '')];
						$measure = $GLOBALS['elements']['high_height']['measure'];
						$price = $GLOBALS['elements']['high_height']['price']/100;
						$count = $table_sum;
						$sum = $table_sum * $price;
						$table_sum = $table_sum + $sum;
						include $template;
					}					
					$section = 'table_footer';
					include $template;
				}
				$total_sum += $table_sum;
			}
			if($total_sum > 0 ){
				if($is_spec){
					$section = 'total_sum';
					include $template;								
				}
				$section = 'discount';
				include $template;				
				$section = 'info';
				include $template;
			}
			$retJSON->result = ob_get_clean();
			//error_log($retJSON->result);
        }else{
            $retJSON->errorno=  APIConstants::$ERROR_PARAMS;
        }
        return $retJSON;
    }
    
    //http://www.example.com/api/?apitest.helloAPIResponseBinary={"responseBinary":1}
    /*function helloAPIResponseBinary($apiMethodParams){
        header('Content-type: image/png');
        echo file_get_contents("http://habrahabr.ru/i/error-404-monster.jpg");
    }*/

}

?>