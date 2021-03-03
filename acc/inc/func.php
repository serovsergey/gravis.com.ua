<?

function print_menu($amenu, $tabs = 0, $path = ""){
	$prefix = str_repeat("\t", $tabs);
	echo $prefix."<ul>\n";
	foreach($amenu as $key => $item){
		$is_group = array_key_exists("sub_menu", $item);
		echo $prefix."\t<li id=\"".$key."\"".($is_group ? " class=\"parent\"" : "").">";
		if($is_group) {
			echo "<a>".$item["caption"]."</a>\n";
			print_menu($item["sub_menu"], $tabs + 2, $path."/".$key);
		}
		else {
			echo "<a href=\"".$path."/".$key."\">".$item["caption"]."</a>";
		}
		echo $prefix."\t</li>\n";
	}
	echo $prefix."</ul>\n";
}
?>