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
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');

// Include path
$inc_path = dirname(__FILE__);
// Get module name
require_once($inc_path.'/info.php');
require_once($inc_path.'/functions.php');

// Look for language file
if (LANGUAGE_LOADED) {
    require_once($inc_path.'/languages/EN.php');
    if (file_exists($inc_path.'/languages/'.LANGUAGE.'.php')) {
        require_once($inc_path.'/languages/'.LANGUAGE.'.php');
    }
}

// Get field default values
require_once($inc_path.'/add_field.php');

// Save $sync_type_template in the session
$_SESSION[$mod_name]['sync_type_template'] = isset($_POST['sync_type_template']) ? ' checked="checked"' : '';
// Sanitize post var
$new_fields = is_numeric($_POST['new_fields']) ? $_POST['new_fields'] : 0;
$save       = isset($_POST['save'])            ? 1 : 0;
$add_fields = isset($_POST['add_fields'])      ? 1 : 0;


// Update fields
if (!empty($_POST['fields'])) {
	foreach ($_POST['fields'] as $field_id => $fields) {

		// Add slashes and remove any tags
		$field_id = $admin->add_slashes(lazystriptags($field_id));
		$type     = $admin->add_slashes(lazystriptags($fields['type']));
		$extra    = $admin->add_slashes(lazystriptags($fields['extra']));
		$name     = $admin->add_slashes(lazystriptags($fields['name']));
		$label    = $admin->add_slashes(lazystriptags($fields['label']));
		$template = $admin->add_slashes($fields['template']);

		// First delete field if requested
		if ($type == 'delete') {
			$database->query("DELETE FROM `".TABLE_PREFIX."mod_".$mod_name."_fields` WHERE field_id = '$field_id'");
			$database->query("DELETE FROM `".TABLE_PREFIX."mod_".$mod_name."_item_fields` WHERE field_id = '$field_id'");
			// Field has been deleted, no need to do more
			continue;
		}

		// Just one group field allowed
		// Get group field id to check if there is already existing a group field
		$first_group_field_id = $database->get_one("SELECT field_id FROM `".TABLE_PREFIX."mod_".$mod_name."_fields` WHERE type = 'group'");
		// Error message and continue
		if ($type == 'group' && $first_group_field_id != null && $field_id != $first_group_field_id) {
			$errors[] = sprintf($MOD_ONEFORALL[$mod_name]['ERR_ONLY_ONE_GROUP_FIELD'], lazyspecial($name));
			continue;
		}

		// Check if field name is blank
		if (empty($name) && !isset($error_blank_field)) {
			// Set flag to show error message only once
			$error_blank_field = true;
			$errors[]  = $MOD_ONEFORALL[$mod_name]['ERR_BLANK_FIELD_NAME'];
			continue;
		}

		// Prevent conflicts between customized field names and general placeholders
		$reserved_names = array('BACK', 'DATE', 'DISPLAY_NAME', 'DISPLAY_PREVIOUS_NEXT_LINKS', 'USER_EMAIL', 'FIELD_NAME', 'IMAGE', 'IMAGES', 'ITEM_ID', 'LINK', 'NEXT', 'NEXT_LINK', 'NEXT_PAGE_LINK', 'OF', 'OUT_OF', 'PAGE_TITLE', 'PREVIOUS', 'PREVIOUS_LINK', 'PREVIOUS_PAGE_LINK', 'TEXT_OF', 'TEXT_OUT_OF', 'TEXT_READ_MORE', 'TXT_BACK', 'TXT_DESCRIPTION', 'TXT_ITEM', 'THUMB', 'THUMBS', 'TIME', 'TITLE', 'USERNAME', 'USER_ID');
		if (in_array(strtoupper($name), $reserved_names)) {
			$errors[] = sprintf($MOD_ONEFORALL[$mod_name]['ERR_CONFLICT_WITH_RESERVED_NAME'], lazyspecial($name));
			continue;
		}

		// Check field name for invalid chars
		if (!preg_match('#^[a-zA-Z0-9._-]*$#', $name)) {
			$errors[] = sprintf($MOD_ONEFORALL[$mod_name]['ERR_INVALID_FIELD_NAME'], lazyspecial($name));
			continue;
		}

		// If template is blank use the default one
		if (empty($template)) {
			$template = $field_template[$type];
		}

		// If field type oneforall_link convert the module name and verify the module
		if ($type == 'oneforall_link') {
			$extra = trim($extra);
			$extra = str_replace(' ', '_', strtolower($extra));
			$extra = empty($extra) ? 'oneforall' : $extra;
			// Verify if the module name is a oneforall module (or renamed one)
			$check4ofa_1 = $database->get_one("SELECT EXISTS (SELECT 1 FROM `".TABLE_PREFIX."addons` WHERE type = 'module' AND function = 'page' AND directory = '".$extra."' AND description LIKE '%OneForAll%')");
			// Verify if the module is installed
			$check4ofa_2 = $database->get_one("SELECT EXISTS (SELECT 1 FROM `".TABLE_PREFIX."sections` WHERE module = '".$extra."')");
			if (!$check4ofa_1 || !$check4ofa_2) {
				$errors[] = sprintf($MOD_ONEFORALL[$mod_name]['ERR_INSTALL_MODULE'], $MOD_ONEFORALL[$mod_name]['TXT_ONEFORALL_LINK'], $extra.' (OneForAll)', $extra);
				continue;
			}
		}

		// If no error occurred, update existing field
		if (is_numeric($field_id)) {
			$update_string = "type = '$type', extra = '$extra', name = '$name', label = '$label', template = '$template'";
			$database->query("UPDATE `".TABLE_PREFIX."mod_".$mod_name."_fields` SET $update_string WHERE field_id = '$field_id'");
		}

		// Check if field name is unique
		if ($database->is_error()) {
			if (false !== strpos($database->get_error(), 'Duplicate entry')) {
				if (!empty($name)) {
					$errors[] = sprintf($MOD_ONEFORALL[$mod_name]['ERR_FIELD_NAME_EXISTS'], lazyspecial($name));
				}
			}
			// ...or get any other db error
			else {
				$errors[] = $database->get_error();
			}
		}
	}
}

// Insert new fields
if ($add_fields && $new_fields > 0) {
	for ($i = 0; $i < $new_fields; $i++) {
		$name     = $MOD_ONEFORALL[$mod_name]['TXT_NEW_FIELD_NAME'].'_';
		$template = $field_template['text'];

		// Insert new fields into fields table
		$database->query("INSERT INTO `".TABLE_PREFIX."mod_".$mod_name."_fields` (`type`, `template`,`extra`) VALUES ('text', '$template', '')");
		$field_id = $database->getLastInsertId();
		$database->query("UPDATE `".TABLE_PREFIX."mod_".$mod_name."_fields` SET name = CONCAT('$name', '$field_id') WHERE field_id = '$field_id'");
		if ($database->is_error()) {
			$errors[] = $database->get_error();
		}

		// Insert the new fields into the item_fields table as well
		$database->query("INSERT INTO `".TABLE_PREFIX."mod_".$mod_name."_item_fields` (item_id, field_id) SELECT item_id, '$field_id' FROM `".TABLE_PREFIX."mod_".$mod_name."_items`");
		if ($database->is_error()) {
			$errors[] = $database->get_error();
		}
	}
}


// Check if there has been any error, otherwise say successful
if (!empty($errors)) {
	$admin->print_error(implode('<br><br>', $errors), WB_URL.'/modules/'.$mod_name.'/modify_fields.php?page_id='.$page_id.'&section_id='.$section_id.'&new_fields='.$new_fields);
}
else {
	// Inserted new fields
	if ($add_fields) {
		$admin->print_success($TEXT['SUCCESS'], WB_URL.'/modules/'.$mod_name.'/modify_fields.php?page_id='.$page_id.'&section_id='.$section_id);
	}
	// Updated fields
	else {
		$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
}

// Print admin footer
$admin->print_footer();

?>