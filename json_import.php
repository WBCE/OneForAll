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


// Validate post vars
if (!isset($_POST['section_id']) || !is_numeric($_POST['section_id']) ||
	!isset($_POST['page_id'])    || !is_numeric($_POST['page_id'])    ||
	!isset($_POST['mod_name'])   || !is_string($_POST['mod_name'])) {
	die();
}
$section_id = (int)$_POST['section_id'];
$page_id    = (int)$_POST['page_id'];

// Includes
require('../../config.php');
$inc_path = dirname(__FILE__);
require($inc_path.'/info.php');

// Load admin class
require_once(WB_PATH.'/framework/class.admin.php');
$admin = new admin('Modules', 'module_view', false, false);
$admin->print_header();

// Return url in case an error occurs
$return_url = WB_URL.'/modules/'.$mod_name.'/modify_general_settings.php?page_id='.$page_id.'&section_id='.$section_id;

// Check if the two module names in the file info.php and the post array match
if ($mod_name != $_POST['mod_name']) {
	$admin->print_error('Module name did not match.', $return_url);
}

// Validate module name
$sql = "SELECT 1 FROM `".TABLE_PREFIX."sections` WHERE `section_id` = $section_id AND `page_id` = $page_id AND `module` = '$mod_name'";
if (empty($database->get_one($sql))) {
	$admin->print_error('Failed to find module with name &quot;'.$mod_name.'&quot;.', $return_url);
}

// Check if user has permissions to access this module
if (!($admin->is_authenticated() && $admin->get_permission($mod_name, 'module'))) {
	$admin->print_error($MESSAGE['ADMIN_INSUFFICIENT_PRIVELLIGES'].'.', $return_url);
}

// Get file content and decode it
$import = array();
if (!empty($_FILES) && $_FILES['json_file']['type'] == 'application/json' && is_file($_FILES['json_file']['tmp_name'])) {
	$import = json_decode(file_get_contents($_FILES['json_file']['tmp_name']), true);
	if ($import === null) {
		// Error json decode
		$admin->print_error('JSON error: '.json_last_error_msg(), $return_url);
	}
} else {
	// Error no file uploaded
	$admin->print_error($MESSAGE['GENERIC_INVALID'].'.', $return_url);
}


// Collect errors
$error = array();

// Insert data into db
if (count($import) > 1) {

	// Export and import module names
	$exp_module = 'mod_'.$import['export_module']['mod_name'];
	$imp_module = 'mod_'.$mod_name;

	// The tables we are going to insert the data
	$tables = array('fields', 'page_settings', 'general_settings');

	// Iterate through json data and build insert statements
	foreach ($tables as $table) {

		// Skip table if there is no data to import
		if (empty($import['export_'.$table]['data'])) {
			continue;
		}

		// Create full table name of the table we are going to alter
		$sql_table = TABLE_PREFIX.'mod_'.$mod_name.'_'.$table;

		// Prevent duplicate entries
		if ($table == 'page_settings') {
			// Just delete row of current section_id befor adding new data
			$sql = "DELETE FROM `$sql_table` WHERE `section_id` = $section_id";
			$database->query($sql);
			$error[] = 'Page settings von section id '.$section_id.' gelöscht.'; // TODO
		}
		else {
			// Empty the full table befor adding new data
			$sql = "TRUNCATE `$sql_table`";
			$database->query($sql);
			$error[] = 'Emptied table '.$sql_table; // TODO
		}
		if ($database->is_error()) {
			$error[] = 'Database error: '.$database->get_error();
		}

		// Now prepare the data for inserting
		foreach ($import['export_'.$table]['data'] as $id => $row) {
			$insert_pairs = array();
			foreach ($row as $key => $val) {

				// Replace the imported section_id / page_id by those of the target module
				if ($key == 'section_id') {
					$val = $section_id;
				}
				if ($key == 'page_id') {
					$val = $page_id;
				}

				// If data is imported into a target module with a different name,
				// replace the module name in strings like for example style attributes 
				if ($exp_module != $imp_module && strpos($val, $exp_module) !== false) {
					$val = str_replace($exp_module, $imp_module, $val);
				}

				// Build key / value pairs
				$insert_pairs[$database->escapeString($key)] = $database->escapeString($val);
			}
			$insert_keys = '`'.implode('`, `', array_keys($insert_pairs)).'`';
			$insert_vals = "'".implode("', '", array_values($insert_pairs))."'";

			// Execute the insert statement
			$sql = "INSERT INTO `$sql_table` ($insert_keys) VALUES ($insert_vals);";
			$database->query($sql);
			if ($database->is_error()) {
				$error[] = 'Database error: '.$database->get_error();
			}
		}
	}
}


// Print error or success message and return
if (count($error) > 0) {
	$error_msg = implode('<br>', $error);
	$admin->print_error($error_msg, $return_url);
} else {
	$admin->print_success($TEXT['SUCCESS'], $return_url);
}
$admin->print_footer();
?>