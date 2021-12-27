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


// Includes
require('../../config.php');
// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

// Include path
$inc_path = dirname(__FILE__);
// Get module name
require_once($inc_path.'/info.php');

// Check page and section id
if (empty($_REQUEST['page_id']) OR !is_numeric($_REQUEST['page_id']) OR empty($_POST['section_id']) OR !is_numeric($_POST['section_id'])) {
	header("Location: ".ADMIN_URL."/pages/index.php");
} else {
	$page_id    = $_REQUEST['page_id'];
	$section_id = $_POST['section_id'];
}

// Get post and validate values
$errors = array();
foreach ($_POST as $key => $value) {

	// Skip some values we do not want to save
	if (in_array($key, array('section_id', 'page_id', 'save'))) {
		continue;
	}

	// Escape and strip tags
	$settings[$key] = strip_tags($admin->get_post_escaped($value));

	// Validate (pseudo) boolean
	if (in_array($key, array('settings_admin_only', 'order_by_position_asc', 'show_item_mover', 'show_item_duplicator', 'wysiwyg_full_width', 'show_group_headers', 'order_by_group_asc', 'field_meta_desc', 'view_detail_pages', 'field_type_code', 'imgresize', 'set_scheduling', 'scheduling_debug'))) {
		$value = in_array($value, array('true', 'false', '')) ? $value : '';
	}

	// Validate numeric
	if (in_array($key, array('thumb_resize_smallest', 'thumb_resize_largest', 'thumb_resize_steps', 'max_file_size', 'filename_max_length', 'resize_quality', 'resize_maxwidth', 'resize_maxheight', 'scheduling_timezone'))) {
		$value = is_numeric($value) ? $value : '';
	}

	// Clean csv
	if (in_array($key, array('media_extensions', 'upload_extensions'))) {
		if (is_string($value) && strpos($value, ',') !== false) {
			$value = strtolower(preg_replace('/\s/', '', $value));
			$value = trim($value, ',');
		} else {
			$value = '';
		}
	}

	// Update the settings in the db one by one
	$sql = "UPDATE `".TABLE_PREFIX."mod_".$mod_name."_general_settings` SET `value` = '$value' WHERE `name` = '$key';";
	$database->query($sql);

	// Check if there was a db error
	if ($database->is_error()) {
		$errors[] = $database->get_error();
	}
}

// Print error or success message and return
$return_url = ADMIN_URL.'/pages/modify.php?page_id='.$page_id;
if (!empty($errors)) {
	$error_msg = implode('<br>', $errors);
	$admin->print_error($error_msg, $return_url);
}
else {
	$admin->print_success($TEXT['SUCCESS'], $return_url);
}

// Print admin footer
$admin->print_footer();

?>