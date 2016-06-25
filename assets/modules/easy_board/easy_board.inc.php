<?php
#######################
# Easy Board v 1.05
#######################
function br2nl($str) {
	     return preg_replace('#<br\s*/?>#i', "\n", $str);
}
function genOptionList($parentID, $currentID, $recursion = true, $sort = "pagetitle", $level = -2){
        global $modx;
        $level = $level+1;
        $spacer = "&nbsp;&nbsp;&nbsp;";
        if ($level >= 0) {
        $indent = str_repeat($spacer,$level);
        }

        $childrens = array();
        $childrens = $modx->getAllChildren($parentID, $sort, "ASC", "id, menutitle, pagetitle, isfolder");
        $tmp = "";
        foreach ($childrens as $value){
                $title = ($value['menutitle'] != "") ? $value['menutitle'] : $value['pagetitle'];
                if ($level ==-1) $tmp .="<optgroup label=\"".$title."\">";
                if ($level !=-1) {
                        $tmp .= "<option value=".$value['id'];
                        if ($value['isfolder'] == 1) $tmp .= " class='ul'";
                        if ( $value['id']==$currentID ) $tmp .= " selected";
                        $tmp .= ">". $indent .$title."</option>\n";
                }
                if ( $value['isfolder'] == 1 AND $recursion ) $tmp .= genOptionList($value['id'], $currentID,$recursion,$sort,$level);
                if ( $value['isfolder'] == 1 AND $recursion AND $level ==-1) $tmp .="</optgroup>";
    }
        return $tmp;
	}

function genOptionListContext($contexts = array(), $currentKey){
	$tmp = "";
	foreach ($contexts as $key => $value){
		$selected = ($currentKey == $key) ? " selected" : "";
		$tmp .= '<option value="'.$key.'"'.$selected.'>'.$key.'</option>';
	}
	return $tmp;
}
	
function getListChildsOrParent($parentID){
	global $modx;
	
	$childrens = array();
	$childrens = $modx->getAllChildren($parentID, "menuindex", "ASC", "id, pagetitle, longtitle");
	if (count($childrens) == 0) {
		$childrens = $modx->getDocument($id, "id, pagetitle, longtitle");
		}
	return $childrens;
}

function searchCategory ($txt, $cats = array() ){
	$parent = $cats[0][id];
	foreach ($cats as $value){
		if (trim($value[pagetitle]) != "" ) {
			$pos1 = stripos( $txt, trim( $value[pagetitle] ) );
			if ($pos1 !== false) return $value[id];
			}
		if (trim($value[longtitle]) != "" ) {
			$pos2 = stripos( $txt, trim( $value[longtitle] ) );
			if ($pos2 !== false) return $value[id];
			}
		
	}
	return $parent;
}

function genCheckbox ($i){
	$checkbox = ($i == 0) ? "": "checked";
	return $checkbox;
}

function getPagetitle ($id){
	global $modx;
	
	$txt = $modx->getDocument($id, "pagetitle");
	$tmp = $txt['pagetitle'];
	return $tmp;
}
function getWebUsename ($id){
	global $modx;
	
	$txt = $modx->getWebUserInfo($id);
	$tmp = $txt['username'];
	return $tmp;
}

function genImageForm($image, $id) {
	global $modx;
	$tmp = "<div id=\"picdel$id\"><p>Фотография:</p>";
	if ( $image == "" ) {
		$tmp .= "<input name=\"image\" type=\"file\" />";
		} else if ( is_file($modx->config['base_path'].$image) ){
		$tmp .= "<table border=\"0\"><tr>";
		$tmp .= "<td><img src=\"".$modx->config['site_url'].$modx->runSnippet('phpthumb', array( 'input' => $image, 'options' => "w=150,h=120,far=R,zc=1,bg=FFFFFF" ))."\"/></td>";
		$img = getimagesize($modx->config['base_path'].$image);
		$tmp .= "<td>$img[0]px x $img[1]px<br/>".(ceil( filesize( $modx->config['base_path'].$image ) / 1024) )." Kb<br/>";
		$tmp .= '<ul class="actionButtons">
		  <li id="Button1" style="margin-top:7px;">
			<a href="#" title="Удалить" onclick="ItemAjax(\'delpic\', \''.$id.'\', \'picdel\');return false">Удалить фотографию</a>
		  </li>
		</ul>';
		$tmp .= "</td></tr></table>";
		} else $tmp .= "Фотография $image не найдена!<br/> <input name=\"image\" type=\"file\" />";
	$tmp .= "</div>";
	return $tmp;
}

function loadImage($imageDir, $size = 1048576){
	$newname = "";
	if ( isset($_FILES['image']) AND trim( $_FILES['image']['name'] ) != "" AND $_FILES['image']['size'] <= $size AND is_image($_FILES['image']['tmp_name'])){
		$newname = time();

		if (substr($_FILES['image']['name'], -4) === ".jpg"){
			$newname = $newname.".jpg";
			copy($_FILES['image']['tmp_name'], $imageDir.$newname);
			return IMAGEPATH.$newname;
		}
		if (substr($_FILES['image']['name'], -4) === ".gif"){
			$newname = $newname.".gif";
			copy($_FILES['image']['tmp_name'], $imageDir.$newname);
			return IMAGEPATH.$newname;
		}
		if (substr($_FILES['image']['name'], -4) === ".png"){
			$newname = $newname.".png";
			copy($_FILES['image']['tmp_name'], $imageDir.$newname);
			return IMAGEPATH.$newname;
		}
	}
	return $newname;
}
function delImage($id, $mod_table){
	global $modx;
	$res = $modx->db->select("image", $mod_table,  "id='$id'");
	if($modx->db->getRecordCount($res)) {  
        $image = $modx->db->getValue($res);
	if ( is_file($modx->config['base_path'].$image) ) unlink ($modx->config['base_path'].$image);
    }	
}
function is_image($filename) {
	$is = @getimagesize($filename);
	if ( !$is ) return false;
	elseif ( !in_array($is[2], array(1,2,3)) ) return false;
	else return true;
}
?>
