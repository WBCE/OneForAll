<?php

/**
 *
 * @category		modules
 * @package			oneforall
 * @author			WBCE Community
 * @copyright		2004-2009, Ryan Djurovich
 * @copyright		2009-2010, Website Baker Org. e.V.
 * @copyright		2019-, WBCE Community
 * @link			https://www.wbce.org/
 * @license			http://www.gnu.org/licenses/gpl.html
 * @platform		WBCE
 *
 */


//Prevent this file from being accessed directly
if (defined('WB_PATH') == false) {
	exit('Cannot access this file directly'); 
}

/* stupid PHP 8.1 fixes by florian -- BEGIN -- */

function lazystrip($val) {
	if ($val!==null) {
		$val = stripslashes($val);
	}
	return $val;
}

function lazystriptags($val) {
	if ($val!==null) {
		$val = strip_tags($val);
	}
	return $val;
}

function lazyspecial($val) {
	if ($val!==null) {
		$val = htmlspecialchars($val);
	}
	return $val;
}

function lazyexplode($x,$y) {
	if ($y!==null) {
		$val = explode($x,$y);
	} else {
		$val = array();
	}
	return $val;
}

/* stupid PHP 8.1 fixes by florian -- END -- */


/* ---------- adapted from OfA for WebsiteBaker --------------- */

function is_serialized($data){
    return (is_string($data) && preg_match("#^((N;)|((a|O|s):[0-9]+:.*[;}])|((b|i|d):[0-9.E-]+;))$#um", $data));
}

function __unserialize($data) {  // found in php manual :-)
    $aRetval = $data;
    if (is_serialized($data)){
        $_ret = preg_replace_callback(
                        '!s:(\d+):"(.*?)";!',
                        function($matches) {return 's:'.strlen($matches[2]).':"'.$matches[2].'";';},
                        $data
                 );
        if ($_ret) {$aRetval = @unserialize($_ret);}
    }
    return $aRetval;
}

/* ------ end adaption ----- */


// FIELD SPECIFIC FUNCTIONS
// ************************

// Generate text input
function field_text($field_id, $name, $label = 'Text', $value = '') {
	global $nl, $t1, $t2, $t3, $t4, $t5;
	$html  = $t1.'<tr>'.$nl;
	$html .= $t2.'<td>'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	$html .= $t3.'<input type="text" name="fields['.$field_id.']" id="'.$name.'" maxlength="150" value="'.$value.'">'.$nl;
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate textarea
function field_textarea($field_id, $name, $label = 'Textarea', $content = '') {
	global $nl, $t1, $t2, $t3, $t4, $t5;
	$html  = $t1.'<tr>'.$nl;
	$html .= $t2.'<td class="align_top">'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	$html .= $t3.'<textarea name="fields['.$field_id.']" id="'.$name.'" rows="10">'.$content.'</textarea>'.$nl;
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate wysiwyg editor
function field_wysiwyg($field_id, $name, $label = 'WYSIWYG Editor', $content = '', $wysiwyg_full_width = false) {
	global $nl, $t1, $t2, $t3, $t4, $t5;
	$width  = '99%';
	$height = '300px';
	echo $t1.'<tr>'.$nl;
	echo $t2.'<td class="align_top">'.$label.':</td>'.$nl;
	if ($wysiwyg_full_width) {
		echo $t2.'<td></td>'.$nl;
		echo $t1.'</tr>'.$nl;
		echo $t1.'<tr>'.$nl;
		echo $t2.'<td colspan="2">'.$nl;
	} else {
		echo $t2.'<td>'.$nl;
	}
	if (!defined('WYSIWYG_EDITOR') OR WYSIWYG_EDITOR == 'none' OR !file_exists(WB_PATH.'/modules/'.WYSIWYG_EDITOR.'/include.php')) {
		function show_wysiwyg_editor($name, $field_id, $content, $width, $height) {
			echo '<textarea name="fields['.$field_id.']" id="'.$name.'" style="width: '.$width.'; height: '.$height.';">'.$content.'</textarea>'.$nl;
		}
	} else {
		require_once(WB_PATH.'/modules/'.WYSIWYG_EDITOR.'/include.php');
	}
	show_wysiwyg_editor('fields['.$field_id.']', $name, $content, $width, $height);		
	echo $t2.'</td>'.$nl;
	echo $t1.'</tr>'.$nl;
}



// Generate code editor
function field_code($field_id, $name, $label = 'Code Editor', $content = '', $code_full_width = false) {
	global $nl, $t1, $t2, $t3, $t4, $t5;
	$width  = '99%';
	$height = '300px';
	echo $t1.'<tr>'.$nl;
	echo $t2.'<td class="align_top">'.$label.':</td>'.$nl;
	if ($code_full_width) {
		echo $t2.'<td></td>'.$nl;
		echo $t1.'</tr>'.$nl;
		echo $t1.'<tr>'.$nl;
		echo $t2.'<td colspan="2">'.$nl;
	} else {
		echo $t2.'<td>'.$nl;
	}
	$hint  = '// Call the return statement to pass your value back'.$nl;
	$hint .= '// For example:'.$nl;
	$hint .= "return 'Hello World';";
	$content = empty($content) ? $hint : $content;
	echo '<textarea name="fields['.$field_id.']" id="'.$name.'" style="width: '.$width.'; height: '.$height.';">'.$content.'</textarea>'.$nl;
	if (file_exists(WB_PATH . '/include/editarea/wb_wrapper_edit_area.php')) {
		require_once(WB_PATH . '/include/editarea/wb_wrapper_edit_area.php');
		echo registerEditArea($name, 'php', true, 'both', true, true, 600, 450, 'search, fullscreen, |, undo, redo, |, select_font, |, highlight, reset_highlight, |, help');
	}
	echo $t2.'</td>'.$nl;
	echo $t1.'</tr>'.$nl;
}



// Generate wb_link select
function field_wb_link($field_id, $name, $current, $label = 'WBCE Link', $selected_id = '') {
	global $TEXT, $nl, $t1, $t2, $t3, $t4, $t5;
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td>'.$label.':</td>'.$nl;
	$start .= $t2.'<td>'.$nl;
	$start .= $t3.'<select name="fields['.$field_id.']" id="'.$name.'" size="1">'.$nl;
	$start .= $t4.'<option value="">'.$TEXT['PLEASE_SELECT'].'&#8230;</option>'.$nl;
	$end    = $t3.'</select>'.$nl;
	$end   .= $t2.'</td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	$html   = $start.get_parent_list(0, $selected_id).$end;
	return $html;
}

// Get all wb pages as select options
function get_parent_list($parent, $selected_id) {
	global $admin, $database, $options, $nl, $t1, $t2, $t3, $t4, $t5;
	$query = "SELECT * FROM `".TABLE_PREFIX."pages` WHERE parent = '$parent' AND visibility != 'deleted' ORDER BY position ASC";
	$get_pages = $database->query($query);
	while ($page = $get_pages->fetchRow()) {
		// Jump hidden pages
		if ($admin->page_is_visible($page) == false)
			continue;
		// Stop users from adding pages with a level of more than the set page level limit
		if ($page['level'] > PAGE_LEVEL_LIMIT) {
			continue;
		}
		// Get user permissions
		$admin_groups = explode(',', str_replace('_', '', $page['admin_groups']));
		$admin_users  = explode(',', str_replace('_', '', $page['admin_users']));
		$in_group     = false;
		foreach ($admin->get_groups_id() as $cur_gid) {
			if (in_array($cur_gid, $admin_groups)) {
				$in_group = true;
			}
		}
		// Disable page if user is not allowed
		$can_modify = '';
		if ($in_group || is_numeric(array_search($admin->get_user_id(), $admin_users))) {
			$can_modify = '';
		} else {
			$can_modify = ' disabled="disabled" class="disabled"';
		}
		// Title prefix to indicate levels
		$prefix = '';
		for ($i = 1; $i <= $page['level']; $i++) {
			$prefix .= ' &#8212; ';
		}
		// Selected page
		$selected = '';
		if ($selected_id == $page['page_id']) {
			$selected = ' selected="selected"';
		}

		$title    = htmlspecialchars(stripslashes($page['menu_title']));
		$option   = '<option value="'.$page['page_id'].'"'.$can_modify.$selected.'>'.$prefix.$title.'</option>';
		$options .= $t4.$option.$nl;
		get_parent_list($page['page_id'], $selected_id);
	}
	return $options;
}



// Generate oneforall_link select
function field_oneforall_link($field_id, $name, $module_name, $label = 'OneForAll Link', $selected_id = '') {
	global $TEXT, $MOD_ONEFORALL, $mod_name, $database, $nl, $t1, $t2, $t3, $t4, $t5;
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td>'.$label.':</td>'.$nl;
	$start .= $t2.'<td>'.$nl;
	$end    = $t2.'</td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	// Verify if the entered module name is a oneforall module (or renamed one) and the module is installed
	$check4ofa_1 = $database->get_one("SELECT EXISTS (SELECT 1 FROM `".TABLE_PREFIX."addons` WHERE type = 'module' AND function = 'page' AND directory = '".$module_name."' AND description LIKE '%OneForAll%')");
	$check4ofa_2 = $database->get_one("SELECT EXISTS (SELECT 1 FROM `".TABLE_PREFIX."sections` WHERE module = '".$module_name."')");
	if (!$check4ofa_1 || !$check4ofa_2) {
		$error_msg = $MOD_ONEFORALL[$mod_name]['ERR_INSTALL_MODULE'];
		$error     = $t3.'<span style="color: red;">'.sprintf($error_msg, $MOD_ONEFORALL[$mod_name]['TXT_ONEFORALL_LINK'], $module_name.' (OneForAll)', $module_name).'</span>';
		return $start.$error.$end;
	}
	// The items select
	$start .= $t3.'<select name="fields['.$field_id.']" id="'.$name.'" size="1">'.$nl;
	$start .= $t4.'<option value="">'.$TEXT['PLEASE_SELECT'].'&#8230;</option>'.$nl;
	$end    = $t3.'</select>'.$nl.$end;
	$html   = $start.get_oneforall_list($module_name, $selected_id).$end;
	return $html;
}

// Get all published oneforall items as select options
function get_oneforall_list($module_name, $selected_id) {
	global $admin, $database, $nl, $t1, $t2, $t3, $t4, $t5;
	$options = '';
	$query = "SELECT item_id, title FROM `".TABLE_PREFIX."mod_".$module_name."_items` WHERE active = '1' AND title != '' ORDER BY section_id, position ASC";
	$get_items = $database->query($query);
	while ($item = $get_items->fetchRow()) {
		// Selected job
		$selected = '';
		if ($selected_id == $item['item_id']) {
			$selected = ' selected="selected"';
		}
		$title    = htmlspecialchars(stripslashes($item['title']));
		$option   = '<option value="'.$item['item_id'].'"'.$selected.'>'.$title.'</option>';
		$options .= $t4.$option.$nl;
	}
	return $options;
}



// Generate foldergallery_link select
function field_foldergallery_link($field_id, $name, $sections, $label = 'FolderGallery', $selected_id = '') {
	global $TEXT, $MOD_ONEFORALL, $mod_name, $database, $nl, $t1, $t2, $t3, $t4, $t5;
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td>'.$label.':</td>'.$nl;
	$start .= $t2.'<td>'.$nl;
	$end    = $t2.'</td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	// Verify if the module foldergallery is installed
	$foldergallery = $database->get_one("SELECT EXISTS (SELECT 1 FROM `".TABLE_PREFIX."sections` WHERE module = 'foldergallery')");
	if (!$foldergallery) {
		$error_msg = $MOD_ONEFORALL[$mod_name]['ERR_INSTALL_MODULE'];
		$error     = $t3.'<span style="color: red;">'.sprintf($error_msg, $MOD_ONEFORALL[$mod_name]['TXT_FOLDERGALLERY_LINK'], 'FolderGallery', 'FolderGallery').'</span>';
		$error    .= ' (<a href="https://addons.wbce.org/pages/addons.php?do=item&item_id=66" target="_blank">WBCE Addons</a>)';
		return $start.$error.$end;
	}
	// The gallery select
	$start .= $t3.'<select name="fields['.$field_id.']" id="'.$name.'" size="1">'.$nl;
	$start .= $t4.'<option value="">'.$TEXT['PLEASE_SELECT'].'&#8230;</option>'.$nl;
	$end    = $t3.'</select>'.$nl.$end;
	$html   = $start.get_foldergallery_categories($sections, $selected_id).$end;
	return $html;
}

// Get all foldergallery categories as select options
function get_foldergallery_categories($sections, $selected_id) {
	global $admin, $database, $nl, $t1, $t2, $t3, $t4, $t5;
	$options = '';
	// Sanitize $sections (must be comma separated numeric values)
	$valid      = false;
	$a_sections = explode(',', $sections);
	foreach($a_sections as $section) {
		$section = trim($section);
		if (ctype_digit($section)) {
			$valid .= $section.',';
		}
	}
	if ($valid === false) {
		$section_where_clause = '';
	} else {
		$sections = rtrim($valid, ',');
		$section_where_clause = " section_id IN (".$sections.") AND";
	}
	// Query options
	$query = "SELECT id, cat_name FROM `".TABLE_PREFIX."mod_foldergallery_categories` WHERE".$section_where_clause." active = '1' AND parent > -1 ORDER BY position DESC";
	$get_categories = $database->query($query);
	if ($get_categories->numRows() > 0) {
		while ($cat = $get_categories->fetchRow()) {
			// Selected gallery
			$selected = '';
			if ($selected_id == $cat['id']) {
				$selected = ' selected="selected"';
			}
			$cat_name = htmlspecialchars(stripslashes($cat['cat_name']));
			$option   = '<option value="'.$cat['id'].'"'.$selected.'>'.$cat_name.'</option>';
			$options .= $t4.$option.$nl;
		}
	}
	return $options;
}



// Generate url input
function field_url($field_id, $name, $label = 'URL', $value = '') {
	global $nl, $t1, $t2, $t3, $t4, $t5;
	$html  = $t1.'<tr>'.$nl;
	$html .= $t2.'<td>'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	$html .= $t3.'<input type="text" class="url" name="fields['.$field_id.']" id="'.$name.'" maxlength="150" value="'.$value.'">'.$nl;
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate email input
function field_email($field_id, $name, $label = 'Email', $value = '') {
	global $nl, $t1, $t2, $t3, $t4, $t5;
	$html  = $t1.'<tr>'.$nl;
	$html .= $t2.'<td>'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	$html .= $t3.'<input type="text" class="email" name="fields['.$field_id.']" id="'.$name.'" maxlength="50" value="'.$value.'">'.$nl;
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate media select
function field_media($field_id, $name, $dir, $label, $selected_file, $media_extensions = 'jpg,jpeg,png,gif,svg,webp') {
	global $TEXT, $MESSAGE, $MOD_ONEFORALL, $mod_name, $nl, $t1, $t2, $t3, $t4, $t5;
	$sel       = '';
	$pre       = '';
	$html      = '';
	$files     = array();
	$dir       = trim($dir, '/');
	$dir_path  = '/'.$dir.'/';
	$root_path = WB_PATH.MEDIA_DIRECTORY.$dir_path;
	// Wrapping html
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td class="align_top">'.$label.':</td>'.$nl;
	$start .= $t2.'<td>'.$nl;
	$end    = $t2.'</td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	// Open directory and read files
	if (is_dir($root_path)) {
	    if ($scan = scandir($root_path)) {
	        foreach ($scan as $file) {
	        	$file_ext = pathinfo($file, PATHINFO_EXTENSION);
	            if (empty($file_ext)) {
	            	continue;
	            }
	            // Limit file types
	            if (false !== strpos($media_extensions, $file_ext)) {
	                $files[] = $file;
	            }
	        }
	    }
	}
	else {
		// Directory not existing
		$error = $t3.'<span style="color: red;">'.$TEXT['NOT_FOUND'].': '.$TEXT['FOLDER'].' "'.$dir.'"</span><br>'.$nl;
		return $start.$error.$end;
	}
	// No file found
	if (empty($files)) {
		$ext_list = empty($media_extensions) ? $TEXT['NONE_FOUND'] : '.'.str_replace(',', ' / .', $media_extensions);
		$error    = $t3.'<span style="color: red;">'.$MESSAGE['MEDIA_NONE_FOUND'].'.</span><br>'.$nl;
		$error   .= $t3.'<span style="color: red;">'.$MESSAGE['GENERIC_FILE_TYPES'].' '.$ext_list.'</span><br>'.$nl;
		return $start.$error.$end;
	} else {
		// Natural ordering
		natsort($files);
		// Generate the select
		$sel .= $t3.'<select name="fields['.$field_id.']" id="'.$name.'" class="media" size="1">'.$nl;
		$sel .= $t4.'<option value="">'.$TEXT['PLEASE_SELECT'].'&#8230;</option>'.$nl;
		// Loop through files and generate options and preview images / links
		foreach ($files as $file) {
			// Selected file
			$selected        = '';
			$display_preview = ' hidden';
			$file_path = $dir_path.$file;
			if ($selected_file == $file_path) {
				$selected        = ' selected="selected"';
				$display_preview = '';
			}
			$sel .= $t4.'<option value="'.$file_path.'"'.$selected.'>'.htmlspecialchars($file).'</option>'.$nl;
			// Show preview image or ...
			if (false !== strpos('jpg,jpeg,png,gif,svg,webp', pathinfo($file, PATHINFO_EXTENSION))) {
				$pre .= $t3.'<a href="'.WB_URL.MEDIA_DIRECTORY.$file_path.'" title="'.$MOD_ONEFORALL[$mod_name]['TXT_SHOW_GENUINE_IMAGE'].'" target="_blank" class="media_img'.$display_preview.'">'.$nl;
				$pre .= $t4.'<img src="'.WB_URL.MEDIA_DIRECTORY.$file_path.'" alt="">'.$nl;
				$pre .= $t3.'</a>'.$nl;
			}
			// ... a preview link to the file
			else {
				$pre .= $t3.'<a href="'.WB_URL.MEDIA_DIRECTORY.$file_path.'" title="'.$MOD_ONEFORALL[$mod_name]['TXT_FILE_LINK'].'" target="_blank" class="media_link'.$display_preview.'">'.$MOD_ONEFORALL[$mod_name]['TXT_FILE_LINK'].'</a>'.$nl;
			}
		}
		$sel .= $t3.'</select>'.$nl;
	}
	return $start.$sel.$pre.$end;
}



// Generate upload input
function field_upload($field_id, $name, $path, $label = 'Upload', $value = '', $upload_extensions = null) {
	global $TEXT, $MESSAGE, $MOD_ONEFORALL, $mod_name, $nl, $t1, $t2, $t3, $t4, $t5;
	$html  = $t1.'<tr>'.$nl;
	$html .= $t2.'<td>'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	if (empty($value)) {
		$html .= $t3.'<input type="file" class="upload" name="fields['.$field_id.']" id="'.$name.'">'.$nl;
	} else {
		if (file_exists(WB_PATH.MEDIA_DIRECTORY.$value)) {
			$href  = WB_URL.MEDIA_DIRECTORY.$value;
			$html .= $t3.'<input type="checkbox" class="delete_file" name="fields['.$field_id.']" value="delete" id="'.$name.'"> <label for="'.$name.'">'.$TEXT['DELETE'].'</label>'.$nl;
			$html .= $t3.'<a href="'.$href.'" title="'.$MOD_ONEFORALL[$mod_name]['TXT_FILE_LINK'].'" target="_blank" class="file_link">'.basename($value).'</a>'.$nl;
		} else {
			$html .= $t3.'<span style="color: red;">'.$MESSAGE['MEDIA_NONE_FOUND'].'.</span><br>'.$nl;
		}
	}
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate datepicker
function field_datepicker($field_id, $name, $label = 'Datepicker', $value = '') {
	global $MOD_ONEFORALL, $mod_name, $nl, $t1, $t2, $t3, $t4, $t5;
	$html  = $t1.'<script>'.$nl;
	$html .= $t2.'$(function() {'.$nl;
	$html .= $t3.'$("#datepicker_'.$field_id.'").datepicker({'.$nl;
	$html .= $t4.'showOn: "button",'.$nl;
	$html .= $t4.'buttonImage: "images/calendar.png",'.$nl;
	$html .= $t4.'buttonImageOnly: true,'.$nl;
	$html .= $t4.'buttonText: "'.$MOD_ONEFORALL[$mod_name]['TXT_JS_SELECT_DATE'].'"'.$nl;
	$html .= $t3.'});'.$nl;
	$html .= $t2.'});'.$nl;
	$html .= $t1.'</script>'.$nl;
	$html .= $t1.'<tr>'.$nl;
	$html .= $t2.'<td>'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	$html .= $t3.'<input type="text" class="datepicker" name="fields['.$field_id.']" id="datepicker_'.$field_id.'" maxlength="20" value="'.$value.'">'.$nl;
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate datepicker with start and end date
function field_datepicker_start_end($field_id, $name, $label = 'Datepicker from &#8230; to &#8230;', $value = null) {
	global $MOD_ONEFORALL, $mod_name, $nl, $t1, $t2, $t3, $t4, $t5;
	$value = empty($value) ? array('start' => '', 'end' => '') : $value;
	$html  = $t1.'<script>'.$nl;
	$html .= $t2.'$(function() {'.$nl;
	$html .= $t3.'$("#datepicker_start_'.$field_id.', #datepicker_end_'.$field_id.'").datepicker({'.$nl;
	$html .= $t4.'showOn: "button",'.$nl;
	$html .= $t4.'buttonImage: "images/calendar.png",'.$nl;
	$html .= $t4.'buttonImageOnly: true,'.$nl;
	$html .= $t4.'buttonText: "'.$MOD_ONEFORALL[$mod_name]['TXT_JS_SELECT_DATE'].'"'.$nl;
	$html .= $t3.'});'.$nl;
	$html .= $t2.'});'.$nl;
	$html .= $t1.'</script>'.$nl;
	$html .= $t1.'<tr>'.$nl;
	$html .= $t2.'<td>'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	$html .= $t3.'<input type="text" class="datepicker" name="fields['.$field_id.'][start]" id="datepicker_start_'.$field_id.'" maxlength="20" value="'.$value['start'].'">'.$nl;
	$html .= $t3.'<input type="text" class="datepicker" name="fields['.$field_id.'][end]" id="datepicker_end_'.$field_id.'" maxlength="20" value="'.$value['end'].'">'.$nl;
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate datetimepicker
function field_datetimepicker($field_id, $name, $label = 'Datetimepicker', $value = '') {
	global $MOD_ONEFORALL, $mod_name, $nl, $t1, $t2, $t3, $t4, $t5;
	$html  = $t1.'<script>'.$nl;
	$html .= $t2.'$(function() {'.$nl;
	$html .= $t3.'$("#datetimepicker'.$field_id.'").datetimepicker({'.$nl;
	$html .= $t4.'separator: " '.$MOD_ONEFORALL[$mod_name]['TXT_DATETIME_SEPARATOR'].' ",'.$nl;
	$html .= $t4.'showOn: "button",'.$nl;
	$html .= $t4.'buttonImage: "images/calendar.png",'.$nl;
	$html .= $t4.'buttonImageOnly: true,'.$nl;
	$html .= $t4.'buttonText: "'.$MOD_ONEFORALL[$mod_name]['TXT_JS_SELECT_DATETIME'].'"'.$nl;
	$html .= $t3.'});'.$nl;
	$html .= $t2.'});'.$nl;
	$html .= $t1.'</script>'.$nl;
	$html .= $t1.'<tr>'.$nl;
	$html .= $t2.'<td>'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	$html .= $t3.'<input type="text" class="datetimepicker" name="fields['.$field_id.']" id="datetimepicker'.$field_id.'" maxlength="20" value="'.$value.'">'.$nl;
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate datetimepicker with start and end datetime
function field_datetimepicker_start_end($field_id, $name, $label = 'Datepicker from &#8230; to &#8230;', $value = null) {
	global $MOD_ONEFORALL, $mod_name, $nl, $t1, $t2, $t3, $t4, $t5;
	$value = empty($value) ? array('start' => '', 'end' => '') : $value;
	$html  = $t1.'<script>'.$nl;
	$html .= $t2.'$(function() {'.$nl;
	$html .= $t3.'$("#datetimepicker_start_'.$field_id.', #datetimepicker_end_'.$field_id.'").datetimepicker({'.$nl;
	$html .= $t4.'separator: " '.$MOD_ONEFORALL[$mod_name]['TXT_DATETIME_SEPARATOR'].' ",'.$nl;
	$html .= $t4.'showOn: "button",'.$nl;
	$html .= $t4.'buttonImage: "images/calendar.png",'.$nl;
	$html .= $t4.'buttonImageOnly: true,'.$nl;
	$html .= $t4.'buttonText: "'.$MOD_ONEFORALL[$mod_name]['TXT_JS_SELECT_DATETIME'].'"'.$nl;
	$html .= $t3.'});'.$nl;
	$html .= $t2.'});'.$nl;
	$html .= $t1.'</script>'.$nl;
	$html .= $t1.'<tr>'.$nl;
	$html .= $t2.'<td>'.$label.':</td>'.$nl;
	$html .= $t2.'<td>'.$nl;
	$html .= $t3.'<input type="text" class="datetimepicker" name="fields['.$field_id.'][start]" id="datetimepicker_start_'.$field_id.'" maxlength="30" value="'.$value['start'].'">'.$nl;
	$html .= $t3.'<input type="text" class="datetimepicker" name="fields['.$field_id.'][end]" id="datetimepicker_end_'.$field_id.'" maxlength="30" value="'.$value['end'].'">'.$nl;
	$html .= $t2.'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}



// Generate droplet select
function field_droplet($field_id, $name, $label = 'Droplet', $selected_id = '') {
	global $database, $TEXT, $nl, $t1, $t2, $t3, $t4, $t5;
	$options = '';
	// Wrapping html
	$start   = $t1.'<tr>'.$nl;
	$start  .= $t2.'<td>'.$label.':</td>'.$nl;
	$start  .= $t2.'<td>'.$nl;
	$end     = $t2.'</td>'.$nl;
	$end    .= $t1.'</tr>'.$nl;
	// Get droplets
	$get_droplets = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_droplets` where active = 1 ORDER BY name");
	if ($get_droplets->numRows() > 0) {
		$sel  = $t3.'<select name="fields['.$field_id.']" id="'.$name.'" size="1">'.$nl;
		$sel .= $t4.'<option value="">'.$TEXT['PLEASE_SELECT'].'&#8230;</option>'.$nl;
		// Loop through droplets
		while ($droplet = $get_droplets->fetchRow()) {
			$id    = $droplet['id'];
			$name  = htmlspecialchars(stripslashes($droplet['name']));
			// Selected droplet
			$selected = '';
			if ($selected_id == $id) {
				$selected = ' selected="selected"';
			}
			$sel .= $t4.'<option value="'.$id.'"'.$selected.'>'.$name.'</option>'.$nl;
		}
		$sel .= $t3.'</select>'.$nl;
	} else {
		$error = $t3.'<span style="color: red;">'.$TEXT['NONE_FOUND'].'</span><br>';
		return $start.$error.$end;
	}
	return $start.$sel.$end;
}



// Generate select
// Options as comma separated values, eg: Apple,Microsoft,Adobe
function field_select($field_id, $name, $s_options, $label = 'Select', $selected_option = 0) {
	global $TEXT, $nl, $t1, $t2, $t3, $t4, $t5;
	$options   = '';
	$a_options = explode(',', $s_options);
	array_unshift($a_options, $TEXT['PLEASE_SELECT'].'&#8230;');
	foreach ($a_options as $index => $option) {
		$selected = $selected_option == $index ? ' selected="selected"' : '';
		$options .= $t4.'<option value="'.$index.'"'.$selected.'>'.trim($option).'</option>'.$nl;
	}
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td>'.$label.':</td>'.$nl;
	$start .= $t2.'<td>'.$nl;
	$start .= $t3.'<select name="fields['.$field_id.']" id="'.$name.'" size="1">'.$nl;
	$end    = $t3.'</select>'.$nl;
	$end   .= $t2.'</td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	$html   = $start.$options.$end;
	return $html;
}



// Generate multiselect
// Options as comma separated values, eg: Apple,Microsoft,Adobe
function field_multiselect($field_id, $name, $s_options, $label = 'Multi-Select', $selected_option = array()) {
	global $TEXT, $nl, $t1, $t2, $t3, $t4, $t5;
	if (isset($selected_option[0])) unset($selected_option[0]);
	$options   = '';
	$a_options = explode(',', $s_options);
	foreach ($a_options as $index => $option) {
		$selected = is_array($selected_option) && in_array($index, $selected_option) ? ' selected="selected"' : '';
		$options .= $t4.'<option value="'.$index.'"'.$selected.'>'.trim($option).'</option>'.$nl;
	}
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td class="align_top">'.$label.':</td>'.$nl;
	$start .= $t2.'<td>'.$nl;
	$start .= $t3.'<input type="hidden" name="fields['.$field_id.'][]" value="">'.$nl;
	$start .= $t3.'<select multiple="multiple" name="fields['.$field_id.'][]" id="'.$name.'" size="5">'.$nl;
	$end    = $t3.'</select>'.$nl;
	$end   .= $t2.'</td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	$html   = $start.$options.$end;
	return $html;
}



// Generate checkboxes
// Options as comma separated values, eg: Apple,Microsoft,Adobe
function field_checkbox($field_id, $name, $s_options, $label = 'Checkbox', $selected_option = 0) {
	global $TEXT, $nl, $t1, $t2, $t3, $t4, $t5;
	$options   = '';
	$options  .= $t4.'<input type="hidden" name="fields['.$field_id.'][]" value="">'.$nl;
	$a_options = explode(',', $s_options);
	foreach ($a_options as $index => $option) {
		$checked = empty($selected_option[$index]) ? '' : ' checked="checked"';
		$options .= $t4.'<input type="checkbox" id="checkbox_'.$field_id.'_'.$index.'" name="fields['.$field_id.']['.$index.']" value="1" '.$checked.'><label for="checkbox_'.$field_id.'_'.$index.'">'.trim($option).'</label>'.$nl;
	}
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td>'.$label.':</td>'.$nl;
	$start .= $t2.'<td><div class="checkbox">'.$nl;
	$end    = $t2.'</div></td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	$html   = $start.$options.$end;
	return $html;
}



// Generate switch
// Options as 2 comma separated values, eg: ein,aus
function field_switch($field_id, $name, $s_options, $label = 'Switch', $selected_option = 0) {
	global $TEXT, $nl, $t1, $t2, $t3, $t4, $t5;
	$options   = '';
	$options  .= $t4.'<input type="hidden" name="fields['.$field_id.'][]" value="">'.$nl;
	$a_options = explode(',', $s_options);
	$checked = empty($selected_option[1]) ? '' : ' checked="checked"';
	$options .= $t4.'<label class="switch switch-flat">'.$nl;
	$options .= $t5.'<input type="checkbox" name="fields['.$field_id.'][]" value="1" '.$checked.' class="switch-input">'.$nl;
	$options .= $t5.'<span class="switch-label" data-on="'.$a_options[0].'" data-off="'.$a_options[1].'"></span>'.$nl;
	$options .= $t5.'<span class="switch-handle"></span>'.$nl;
	$options .= $t4.'</label>'.$nl;

	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td>'.$label.':</td>'.$nl;
	$start .= $t2.'<td>'.$nl;
	$end    = $t2.'</td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	$html   = $start.$options.$end;
	return $html;
}



// Generate radio buttons
// Options as comma separated values, eg: Apple,Microsoft,Adobe
function field_radio($field_id, $name, $s_options, $label = 'Radio Buttons', $selected_option = array()) {
	global $TEXT, $nl, $t1, $t2, $t3, $t4, $t5;
	$options   = '';
	$selected_option[1] = empty($selected_option[1]) ? 0 : $selected_option[1];
	$options  .= $t4.'<input type="hidden" name="fields['.$field_id.'][]" value="">'.$nl;
	$a_options = explode(',', $s_options);
	foreach ($a_options as $index => $option) {
		$checked  = $selected_option[1] == $index ? ' checked="checked"' : '';
		$options .= $t4.'<input type="radio" id="checkbox_'.$field_id.'_'.$index.'" name="fields['.$field_id.'][]" value="'.$index.'" '.$checked.'><label for="checkbox_'.$field_id.'_'.$index.'">'.trim($option).'</label>'.$nl;
	}
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td>'.$label.':</td>'.$nl;
	$start .= $t2.'<td><div class="radio">'.$nl;
	$end    = $t2.'</div></td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	$html   = $start.$options.$end;
	return $html;
}



// Generate group select
// Groups as comma separated values, eg: 
function field_group($field_id, $name, $s_groups, $label = 'Group', $selected_group = 0) {
	global $TEXT, $nl, $t1, $t2, $t3, $t4, $t5;
	$groups   = '';
	$a_groups = explode(',', $s_groups);
	array_unshift($a_groups, $TEXT['NONE']);
	foreach ($a_groups as $index => $group) {
		$selected = $selected_group == $index ? ' selected="selected"' : '';
		$groups  .= $t4.'<option value="'.$index.'"'.$selected.'>'.trim($group).'</option>'.$nl;
	}
	$start  = $t1.'<tr>'.$nl;
	$start .= $t2.'<td>'.$label.':</td>'.$nl;
	$start .= $t2.'<td>'.$nl;
	$start .= $t3.'<select name="fields['.$field_id.']" id="'.$name.'" size="1">'.$nl;
	$end    = $t3.'</select>'.$nl;
	$end   .= $t2.'</td>'.$nl;
	$end   .= $t1.'</tr>'.$nl;
	$html   = $start.$groups.$end;
	return $html;
}



// Generate error message if field type does not exist
function field_default() {
	global $MOD_ONEFORALL, $mod_name, $nl, $t1, $t2;
	$html  = $t1.'<tr>'.$nl;
	$html .= $t2.'<td class="align_top"></td>'.$nl;
	$html .= $t2.'<td style="color: red;">'.$MOD_ONEFORALL[$mod_name]['ERR_FIELD_TYPE_NOT_EXIST'].'</td>'.$nl;
	$html .= $t1.'</tr>'.$nl;
	return $html;
}

?>