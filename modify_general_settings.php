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
	// Prepare the checked for the radio buttons
	if ($$var === true) {
		${$var.'_checked_1'} = ' checked="checked"';
		${$var.'_checked_0'} = '';
	} else {
		${$var.'_checked_1'} = '';
		${$var.'_checked_0'} = ' checked="checked"';
	}
}

// Check if user has permission to modify the general settings
if ($settings_admin_only && !$admin->isAdmin()) {
	$admin->print_error($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}
?>



<h2><?php echo $MOD_ONEFORALL[$mod_name]['TXT_EXPORT_IMPORT']; ?></h2>

<form name="json_export" action="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/json_export.php" method="post">
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
<input type="hidden" name="mod_name" value="<?php echo $mod_name; ?>">
<table id="mod_<?php echo $mod_name; ?>_export_settings_b">
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_EXPORT']; ?>:</td>
		<td>
			<input type="checkbox" name="export_fields" id="fields" value="true">
			<label for="fields"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_FIELDS']; ?></label>
			<input type="checkbox" name="export_page_settings" id="page_settings" value="true">
			<label for="page_settings"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_PAGE_SETTINGS']; ?></label>
			<input type="checkbox" name="export_general_settings" id="general_settings" value="true">
			<label for="general_settings"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_GENERAL_SETTINGS']; ?></label>
		</td>
		<td>
			<input type="submit" name="export" value="<?php echo $MOD_ONEFORALL[$mod_name]['TXT_EXPORT']; ?>">
		</td>
	</tr>
</table>
</form>



<form name="json_import" action="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/json_import.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
<input type="hidden" name="mod_name" value="<?php echo $mod_name; ?>">
<table id="mod_<?php echo $mod_name; ?>_import_settings_b">
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_IMPORT']; ?>:</td>
		<td>
			<label for="import_settings"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_IMPORT_MODULE_SETTINGS']; ?></label>
			<input type="file" name="json_file" id="import_settings" value="true">
		</td>
		<td>
			<input type="submit" name="import" value="<?php echo $MOD_ONEFORALL[$mod_name]['TXT_IMPORT']; ?>"  onclick="javascript: return confirm('<?php echo sprintf($MOD_ONEFORALL[$mod_name]['WARN_IMPORT_MODULE_SETTINGS'], $page_id); ?>')">
		</td>
	</tr>
</table>
</form>



<form name="modify" action="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/save_general_settings.php" method="post">
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">

<h2><?php echo $MOD_ONEFORALL[$mod_name]['TXT_GENERAL_SETTINGS']; ?></h2>
<table id="mod_<?php echo $mod_name; ?>_general_settings_b">
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_SETTINGS_ADMIN_ONLY']; ?>:</td>
		<td>
			<input type="radio" name="settings_admin_only" id="settings_admin_only_1" value="true"<?php echo $settings_admin_only_checked_1 ?>>
			<label for="settings_admin_only_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="settings_admin_only" id="settings_admin_only_0" value="false"<?php echo $settings_admin_only_checked_0 ?>>
			<label for="settings_admin_only_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_SETTINGS_ADMIN_ONLY']; ?>
			<p class="warning"><?php echo $MOD_ONEFORALL[$mod_name]['WARN_SETTINGS_ADMIN_ONLY']; ?></p>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_ORDER_BY_POSITION_ASC']; ?>:</td>
		<td>
			<input type="radio" name="order_by_position_asc" id="order_by_position_asc_1" value="true"<?php echo $order_by_position_asc_checked_1; ?>>
			<label for="order_by_position_asc_1"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_ASCENDING']; ?></label>
			<input type="radio" name="order_by_position_asc" id="order_by_position_asc_0" value="false"<?php echo $order_by_position_asc_checked_0; ?>>
			<label for="order_by_position_asc_0"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_DESCENDING']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_ORDER_BY_POSITION_ASC']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_SHOW_ITEM_MOVER']; ?>:</td>
		<td>
			<input type="radio" name="show_item_mover" id="show_item_mover_1" value="true"<?php echo $show_item_mover_checked_1; ?>>
			<label for="show_item_mover_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="show_item_mover" id="show_item_mover_0" value="false"<?php echo $show_item_mover_checked_0; ?>>
			<label for="show_item_mover_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_SHOW_ITEM_MOVER']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_SHOW_ITEM_DUPLICATOR']; ?>:</td>
		<td>
			<input type="radio" name="show_item_duplicator" id="show_item_duplicator_1" value="true"<?php echo $show_item_duplicator_checked_1; ?>>
			<label for="show_item_duplicator_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="show_item_duplicator" id="show_item_duplicator_0" value="false"<?php echo $show_item_duplicator_checked_0; ?>>
			<label for="show_item_duplicator_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_SHOW_ITEM_DUPLICATOR']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_WYSIWYG_FULL_WIDTH']; ?>:</td>
		<td>
			<input type="radio" name="wysiwyg_full_width" id="wysiwyg_full_width_1" value="true"<?php echo $wysiwyg_full_width_checked_1; ?>>
			<label for="wysiwyg_full_width_1">100%</label>
			<input type="radio" name="wysiwyg_full_width" id="wysiwyg_full_width_0" value="false"<?php echo $wysiwyg_full_width_checked_0; ?>>
			<label for="wysiwyg_full_width_0">80%</label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_WYSIWYG_FULL_WIDTH']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_SHOW_GROUP_HEADERS']; ?>:</td>
		<td>
			<input type="radio" name="show_group_headers" id="show_group_headers_1" value="true"<?php echo $show_group_headers_checked_1; ?>>
			<label for="show_group_headers_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="show_group_headers" id="show_group_headers_0" value="false"<?php echo $show_group_headers_checked_0; ?>>
			<label for="show_group_headers_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_SHOW_GROUP_HEADERS']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_ORDER_BY_GROUP_ASC']; ?>:</td>
		<td>
			<input type="radio" name="order_by_group_asc" id="order_by_group_asc_1" value="true"<?php echo $order_by_group_asc_checked_1; ?>>
			<label for="order_by_group_asc_1"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_ASCENDING']; ?></label>
			<input type="radio" name="order_by_group_asc" id="order_by_group_asc_0" value="false"<?php echo $order_by_group_asc_checked_0; ?>>
			<label for="order_by_group_asc_0"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_DESCENDING']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_ORDER_BY_GROUP_ASC']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_FIELD_META_DESC']; ?>:</td>
		<td>
			<input type="radio" name="field_meta_desc" id="field_meta_desc_1" value="true"<?php echo $field_meta_desc_checked_1; ?>>
			<label for="field_meta_desc_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="field_meta_desc" id="field_meta_desc_0" value="false"<?php echo $field_meta_desc_checked_0; ?>>
			<label for="field_meta_desc_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php
			$mod_html5head = '<a href="https://addons.wbce.org/pages/addons.php?do=item&item=127" target="_blank">HTML5Head</a>';
			$mod_simplepagehead = '<a href="https://addons.wbce.org/pages/addons.php?do=item&item_id=29" target="_blank">SimplePageHead</a>';
			?>
			<?php echo sprintf($MOD_ONEFORALL[$mod_name]['HINT_FIELD_META_DESC'], $mod_html5head, $mod_simplepagehead); ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_MEDIA_EXTENSIONS']; ?>:</td>
		<td>
			<input type="text" name="media_extensions" value="<?php echo htmlspecialchars($media_extensions); ?>"><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_MEDIA_EXTENSIONS']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_UPLOAD_EXTENSIONS']; ?>:</td>
		<td>
			<input type="text" name="upload_extensions" value="<?php echo htmlspecialchars($upload_extensions); ?>"><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_UPLOAD_EXTENSIONS']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_VIEW_DETAIL_PAGES']; ?>:</td>
		<td>
			<input type="radio" name="view_detail_pages" id="view_detail_pages_1" value="true"<?php echo $view_detail_pages_checked_1; ?>"">
			<label for="view_detail_pages_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="view_detail_pages" id="view_detail_pages_0" value="false"<?php echo $view_detail_pages_checked_0; ?>>
			<label for="view_detail_pages_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_VIEW_DETAIL_PAGES']; ?>
			<p class="warning"><?php echo $MOD_ONEFORALL[$mod_name]['WARN_VIEW_DETAIL_PAGES']; ?></p>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_FIELD_TYPE_CODE']; ?>:</td>
		<td>
			<input type="radio" name="field_type_code" id="field_type_code_1" value="true"<?php echo $field_type_code_checked_1; ?>>
			<label for="field_type_code_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="field_type_code" id="field_type_code_0" value="false"<?php echo $field_type_code_checked_0; ?>>
			<label for="field_type_code_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_FIELD_TYPE_CODE']; ?>
			<p class="warning"><?php echo $MOD_ONEFORALL[$mod_name]['WARN_FIELD_TYPE_CODE']; ?></p>
		</td>
	</tr>
</table>



<h2><?php echo $MOD_ONEFORALL[$mod_name]['TXT_IMG_AND_THUMB_DEFAULTS']; ?></h2>
<table id="mod_<?php echo $mod_name; ?>_general_settings_b">
	<tr>
		<td colspan="2"><?php echo $MOD_ONEFORALL[$mod_name]['HINT_THUMB_RESIZE']; ?></td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_THUMB_RESIZE_SMALLEST']; ?>:</td>
		<td>
			<input type="text" name="thumb_resize_smallest" value="<?php echo htmlspecialchars($thumb_resize_smallest); ?>"> px
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_THUMB_RESIZE_LARGEST']; ?>:</td>
		<td>
			<input type="text" name="thumb_resize_largest" value="<?php echo htmlspecialchars($thumb_resize_largest); ?>"> px
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_THUMB_RESIZE_STEPS']; ?>:</td>
		<td>
			<input type="text" name="thumb_resize_steps" value="<?php echo htmlspecialchars($thumb_resize_steps); ?>"> px
		</td>
	</tr>


	<tr>
		<td colspan="2"><?php echo $MOD_ONEFORALL[$mod_name]['HINT_IMG_RESIZE']; ?></td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_MAX_FILE_SIZE']; ?>:</td>
		<td>
			<input type="text" name="max_file_size" value="<?php echo htmlspecialchars($max_file_size); ?>"> MB<br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_MAX_FILE_SIZE']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_FILENAME_MAX_LENGTH']; ?>:</td>
		<td>
			<input type="text" name="filename_max_length" value="<?php echo htmlspecialchars($filename_max_length); ?>"> <?php echo $TEXT['CHARACTERS']; ?><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_FILENAME_MAX_LENGTH']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_IMGRESIZE']; ?>:</td>
		<td>
			<input type="radio" name="imgresize" id="imgresize_1" value="true"<?php echo $imgresize_checked_1; ?>>
			<label for="imgresize_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="imgresize" id="imgresize_0" value="false"<?php echo $imgresize_checked_0; ?>>
			<label for="imgresize_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_IMGRESIZE']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_RESIZE_QUALITY']; ?>:</td>
		<td>
			<input type="text" name="resize_quality" value="<?php echo htmlspecialchars($resize_quality); ?>"><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_RESIZE_QUALITY']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_RESIZE_MAXWIDTH']; ?>:</td>
		<td>
			<input type="text" name="resize_maxwidth" value="<?php echo htmlspecialchars($resize_maxwidth); ?>"> px<br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_RESIZE_MAXWIDTH']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_RESIZE_MAXHEIGHT']; ?>:</td>
		<td>
			<input type="text" name="resize_maxheight" value="<?php echo htmlspecialchars($resize_maxheight); ?>"> px<br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_RESIZE_MAXHEIGHT']; ?>
		</td>
	</tr>
</table>



<h2><?php echo $MOD_ONEFORALL[$mod_name]['TXT_ITEM_SCHEDULING_SETTINGS']; ?></h2>
<table id="mod_<?php echo $mod_name; ?>_general_settings_b">
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_SET_SCHEDULING']; ?>:</td>
		<td>
			<input type="radio" name="set_scheduling" id="set_scheduling_1" value="true"<?php echo $set_scheduling_checked_1; ?>>
			<label for="set_scheduling_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="set_scheduling" id="set_scheduling_0" value="false"<?php echo $set_scheduling_checked_0; ?>>
			<label for="set_scheduling_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_SET_SCHEDULING']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_SCHEDULING_DEBUG']; ?>:</td>
		<td>
			<input type="radio" name="scheduling_debug" id="scheduling_debug_1" value="true"<?php echo $scheduling_debug_checked_1; ?>>
			<label for="scheduling_debug_1"><?php echo $TEXT['ENABLED']; ?></label>
			<input type="radio" name="scheduling_debug" id="scheduling_debug_0" value="false"<?php echo $scheduling_debug_checked_0; ?>>
			<label for="scheduling_debug_0"><?php echo $TEXT['DISABLED']; ?></label><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_SCHEDULING_DEBUG']; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_SCHEDULING_FORMAT']; ?>:</td>
		<td>
			<input type="text" name="scheduling_format" value="<?php echo htmlspecialchars($scheduling_format); ?>"><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_SCHEDULING_FORMAT']; ?>
			<p class="warning"><?php echo $MOD_ONEFORALL[$mod_name]['WARN_SCHEDULING_FORMAT']; ?></p>
		</td>
	</tr>
	<tr>
		<td><?php echo $MOD_ONEFORALL[$mod_name]['TXT_SCHEDULING_TIMEZONE']; ?>:</td>
		<td>
			<input type="text" name="scheduling_timezone" value="<?php echo htmlspecialchars($scheduling_timezone); ?>"><br>
			<?php echo $MOD_ONEFORALL[$mod_name]['HINT_SCHEDULING_TIMEZONE']; ?>
		</td>
	</tr>
</table>
<?php


// Save general settings
?>
<table class="mod_<?php echo $mod_name; ?>_submit_table_b">
	<tr>
		<td>
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
