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


require('../../config.php');

// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

// Include path
$inc_path = dirname(__FILE__);
// Get module name
require_once($inc_path.'/info.php');

// Look for language File
if (LANGUAGE_LOADED) {
    require_once($inc_path.'/languages/EN.php');
    if (file_exists($inc_path.'/languages/'.LANGUAGE.'.php')) {
        require_once($inc_path.'/languages/'.LANGUAGE.'.php');
    }
}

// Get the general settings from db
$sql = "SELECT `name`, `value` FROM `".TABLE_PREFIX."mod_".$mod_name."_general_settings`";
$query_settings = $database->query($sql);
while ($setting = $query_settings->fetchRow(MYSQLI_ASSOC)) {
	// Convert setting_name to a var like $media_extensions
	$var  = $setting['name'];
	$$var = $setting['value'];
	// Convert strings to boolean
	if ($setting['value'] === 'true') {
		$$var = true;
	} else if ($setting['value'] === 'false') {
		$$var = false;
	} else if ($setting['value'] === 'null') {
		$$var = null;
	}		
}

// Check if user has permission to modify the page settings
if ($settings_admin_only && !$admin->isAdmin()) {
	$admin->print_error($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Get header and footer
$query_page_settings = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_".$mod_name."_page_settings` WHERE section_id = '$section_id'");
$fetch_page_settings = $query_page_settings->fetchRow();

// Set raw html <'s and >'s to be replaced by friendly html code
$raw      = array('<', '>');
$friendly = array('&lt;', '&gt;');

// Hide page detail settings
$hide_setting = $view_detail_pages ? '' : 'display: none;';
?>



<form name="modify" action="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/save_page_settings.php" method="post" style="margin: 0;">

<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">

<h2><?php echo $MOD_ONEFORALL[$mod_name]['TXT_PAGE_SETTINGS']; ?></h2>
<table id="mod_<?php echo $mod_name; ?>_page_settings_b">
	<tr>
	  <td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_LAYOUT'].' '.$MOD_ONEFORALL[$mod_name]['TXT_SETTINGS']; ?>:</td>
	  <td colspan="2"><input type="button" value="<?php echo $MENU['HELP']; ?>" onclick="javascript: window.location = '<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/help.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>';"></td>
    </tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_OVERVIEW'].' ('.$TEXT['HEADER']; ?>):</td>
		<td colspan="2">
			<textarea name="header"><?php echo stripslashes($fetch_page_settings['header']); ?></textarea></td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_OVERVIEW'].' ('.$MOD_ONEFORALL[$mod_name]['TXT_ITEM'].'-'.$TEXT['LOOP']; ?>):</td>
		<td colspan="2">
			<textarea name="item_loop"><?php echo stripslashes($fetch_page_settings['item_loop']); ?></textarea></td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_OVERVIEW'].' ('.$TEXT['FOOTER']; ?>):</td>
		<td colspan="2">
			<textarea name="footer"><?php echo str_replace($raw, $friendly, stripslashes($fetch_page_settings['footer'])); ?></textarea></td>
	</tr>
	<tr style="<?php echo $hide_setting; ?>">
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_DETAIL'].' ('.$TEXT['HEADER']; ?>):</td>
		<td colspan="2">
			<textarea name="item_header"><?php echo str_replace($raw, $friendly, stripslashes($fetch_page_settings['item_header'])); ?></textarea>		</td>
	</tr>
	<tr style="<?php echo $hide_setting; ?>">
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_DETAIL'].' ('.$TEXT['FOOTER']; ?>):</td>
		<td colspan="2">
			<textarea name="item_footer"><?php echo str_replace($raw, $friendly, stripslashes($fetch_page_settings['item_footer'])); ?></textarea>		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_ITEMS_PER_PAGE']; ?>:</td>
		<td colspan="2">
			<input type="text" name="items_per_page" style="width: 35px" value="<?php echo $fetch_page_settings['items_per_page']; ?>"> 0 = <?php echo $TEXT['UNLIMITED']; ?>		</td>
	</tr>
	<?php if (extension_loaded('gd') AND function_exists('imageCreateFromJpeg')) { /* Make's sure GD library is installed */ ?>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_THUMBNAIL'].' '.$TEXT['SIZE']; ?>:</td>
		<td colspan="2">
			<select name="resize">
			<?php
			foreach (range($thumb_resize_smallest,$thumb_resize_largest,$thumb_resize_steps) as $key => $size) {
				$selected = $size == $fetch_page_settings['resize'] ? ' selected="selected"' : '';
				echo '<option value="'.$size.'"'.$selected.'>max. '.$size.'px</option>';
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Lightbox2:</td>
		<td colspan="4">
		  <input type="checkbox" name="lb2_overview" id="lb2_overview" value="overview" <?php if ($fetch_page_settings['lightbox2'] == 'overview' || $fetch_page_settings['lightbox2'] == 'all') { echo "checked='checked'"; } ?>>
		  <label for="lb2_overview"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_OVERVIEW']; ?></label> &nbsp;&nbsp;
		  <span style="<?php echo $hide_setting; ?>">
		    <input type="checkbox" name="lb2_detail" id="lb2_detail" value="detail" <?php if ($fetch_page_settings['lightbox2'] == 'detail' || $fetch_page_settings['lightbox2'] == 'all') { echo "checked='checked'"; } ?>>
		    <label for="lb2_detail"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_DETAIL']; ?></label>
		  </span> 
		  </td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_BACKEND_ITEM_PAGE']; ?>:</td>
		<td colspan="2">
		  <input type="checkbox" name="img_section" id="img_section" value="1" <?php if ($fetch_page_settings['img_section'] == '1') { echo 'checked="checked"'; } ?>>
		  <label for="img_section"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_HIDE_IMG_SECTION']; ?></label> &nbsp;&nbsp;
		</td>
	</tr>
	<?php } ?>
</table>

<?php
// OneForAll page list
$query_pages = "SELECT p.page_id, p.page_title, p.visibility, p.admin_groups, p.admin_users, p.viewing_groups, p.viewing_users, s.section_id FROM `".TABLE_PREFIX."pages` p INNER JOIN `".TABLE_PREFIX."sections` s ON p.page_id = s.page_id WHERE s.module = '".$mod_name."' AND p.visibility != 'deleted' ORDER BY p.level, p.position ASC";
$get_pages = $database->query($query_pages);


// Generate sections select
if ($get_pages->numRows() > 0) {
	$sections_select = '';
	while ($page = $get_pages->fetchRow()) {
		$page = array_map('stripslashes', $page);
		// Only display if visible
		if ($admin->page_is_visible($page) == false)
			continue;
		// Get user perms
		$admin_groups = explode(',', str_replace('_', '', $page['admin_groups']));
		$admin_users = explode(',', str_replace('_', '', $page['admin_users']));
		// Check user perms
		$in_group = FALSE;
		foreach ($admin->get_groups_id() as $cur_gid) {
			if (in_array($cur_gid, $admin_groups)) {
				$in_group = TRUE;
			}
		}
		if (($in_group) OR is_numeric(array_search($admin->get_user_id(), $admin_users))) {
			$can_modify = true;
		} else {
			$can_modify = false;
		}
		// Options
		$sections_select .= "<option value='{$page['section_id']}'";
		if (isset($fetch_item['new_section_id']) && $fetch_item['new_section_id'] == $page['section_id']) {
			$sections_select .= " selected='selected'";
		}
		elseif ($section_id == $page['section_id']) {
			$sections_select .= " selected='selected'";
		}
		$sections_select .= $can_modify == false ? " disabled='disabled' style='color: #aaa;'" : '';
		$sections_select .= ">{$page['page_title']}</option>\n";
	}
}



// Save page settings   ?>
<table class="mod_<?php echo $mod_name; ?>_submit_table_b">
	<tr>
        <td><input type="radio" name="modify" id="modify_current" value="current" checked="checked"></td>
        <td colspan="2"><label for="modify_current"><em><?php echo $MOD_ONEFORALL[$mod_name]['TXT_MODIFY_THIS']; ?></em></label></td>
	</tr>
	<tr>
        <td><input type="radio" name="modify" id="modify_all" value="all"></td>
        <td colspan="2"><label for="modify_all"><em><?php echo $MOD_ONEFORALL[$mod_name]['TXT_MODIFY_ALL']; ?></em></label></td>
	</tr>
	<tr>
        <td><input type="radio" name="modify" id="modify_multiple" value="multiple"></td>
        <td><label for="modify_multiple"><em><?php echo $MOD_ONEFORALL[$mod_name]['TXT_MODIFY_MULTIPLE']; ?></em></label></td>
        <td rowspan="2">
		  <select name="modify_sections[]" multiple="multiple" style="width: 240px; margin: 0 5px 0 0;">
			<?php echo $sections_select; ?>
		  </select>
		</td>
	</tr>
	<tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	<tr>
        <td colspan="2">
		  <input name="save" type="submit" value="<?php echo $TEXT['SAVE']; ?>">
		</td>
        <td>
		  <input type="button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $page_id; ?>';">
		</td>
	</tr>
</table>
</form>

<?php

// Print admin footer
$admin->print_footer();

?>
