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
$export_fields           = isset($_POST['export_fields'])           ? true : false;
$export_page_settings    = isset($_POST['export_page_settings'])    ? true : false;
$export_general_settings = isset($_POST['export_general_settings']) ? true : false;

// Includes
require('../../config.php');
$inc_path = dirname(__FILE__);
require($inc_path.'/info.php');

// Load admin class
require_once(WB_PATH.'/framework/class.admin.php');
$admin = new admin('Modules', 'module_view', false, false);

// Check if module name in file info.php and post array match
if ($mod_name != $_POST['mod_name']) {
	die();
}

// Validate module name
$sql = "SELECT 1 FROM `".TABLE_PREFIX."sections` WHERE `section_id` = $section_id AND `page_id` = $page_id AND `module` = '$mod_name'";
if (empty($database->get_one($sql))) {
	die('ERROR: No module found with given module name &quot;'.$mod_name.'&quot;.');
}

// Check if user has permissions to access this module
if (!($admin->is_authenticated() && $admin->get_permission($mod_name, 'module'))) {
	die('ERROR: '.$MESSAGE['ADMIN_INSUFFICIENT_PRIVELLIGES'].'.');
}

// Initialize vars
$output = array();

// Header information about the module
$output['export_module'] = array(
	'default_mod_name' => 'oneforall',
	'mod_name'         => $mod_name,
	'module_version'   => $module_version,
	'comment'          => 'Export module settings to JSON. Use this file to import settings or as a preset.'
);


// Export the fields table
if ($export_fields) {
	$name = 'fields';
	$sql_table = TABLE_PREFIX.'mod_'.$mod_name.'_'.$name;

	$sql = "SELECT * FROM `".$sql_table."` ORDER BY `field_id`";
	$fields_array = $database->get_array($sql);

	$output['export_fields'] = array(
		'name'  => $name,
		'table' => $sql_table,
		'data'  => $fields_array
	);
}

// Export the page settings table
if ($export_page_settings) {
	$name = 'page_settings';
	$sql_table = TABLE_PREFIX.'mod_'.$mod_name.'_'.$name;

	// Only export page settings of the current section_id
	$sql = "SELECT * FROM `".$sql_table."` WHERE `section_id` = $section_id";
	$page_settings_array = $database->get_array($sql);

	$output['export_page_settings'] = array(
		'name'  => $name,
		'table' => $sql_table,
		'data'  => $page_settings_array
	);
}

// Export the general settings table
if ($export_general_settings) {
	$name = 'general_settings';
	$sql_table = TABLE_PREFIX.'mod_'.$mod_name.'_'.$name;

	$sql = "SELECT * FROM `".$sql_table."` ORDER BY `id`";
	$general_settings_array = $database->get_array($sql);

	$output['export_general_settings'] = array(
		'name'  => $name,
		'table' => $sql_table,
		'data'  => $general_settings_array
	);
}


// Create json download stream
if (count($output) > 1) {

	// Filename
	$filename = date('Y-m-d').'_'.$mod_name.'_export';

	// Send http header
	#header("Content-Type: text/csv; charset=utf-8"); // not sure what's best
	header("Content-Type: application/json");
	header("Content-Disposition: attachment; filename=$filename.json");
	// Disable caching
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
	header("Pragma: no-cache"); // HTTP 1.0
	header("Expires: 0"); // Proxies

	// Convert php array to json
	$json = json_encode($output); 

	// Open stream
	$fp = fopen('php://output', 'w');
	// Write json to the outputstream
	fputs($fp, $json);
	// Close stream
	fclose($fp);
}
else {
	// Error message if no data
	$return_url = WB_URL.'/modules/'.$mod_name.'/modify_general_settings.php?page_id='.$page_id.'&section_id='.$section_id;
	$admin->print_header();
	$admin->print_error($TEXT['NONE_FOUND'].'<br>'.$MESSAGE['GENERIC_FORGOT_OPTIONS'], $return_url);
	$admin->print_footer();
}

?>