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


if (!isset($_POST['action']) || $_POST['action'] != 'update_pos' || !isset($_POST['id']) || !isset($_POST['mod_name'])) {
	die();	
}
else {
	// Include
	require('../../../config.php');
	// Include path
	$inc_path = dirname(dirname(__FILE__));
	// Get module name
	require_once($inc_path.'/info.php');

	// Load admin class
	require_once(WB_PATH.'/framework/class.admin.php');
	$admin = new admin('Modules', 'module_view', false, false);

	// Check if module name in file info.php and post array match
	if ($mod_name != $_POST['mod_name']) {
		die();
	}

	// Check if module is registered in the database
	$addon_id = $database->get_one("SELECT addon_id FROM `".TABLE_PREFIX."addons` WHERE type = 'module' AND directory = '".$mod_name."'");
	if (!is_numeric($addon_id)) {
		die();
	}

	// Check if user has permissions to access the module
	if (!($admin->is_authenticated() && $admin->get_permission($mod_name, 'module'))) {
		die();
	}

	// Set the new item positions depending on asc (post array) or desc (post array reverse)
	$positions = $_POST['id'];
	$order_by_position_asc = $database->get_one("SELECT `value` FROM `".TABLE_PREFIX."mod_".$mod_name."_general_settings` WHERE `name` = 'order_by_position_asc';");
	$order_by_position_asc = $order_by_position_asc === 'true' ? true : false;
	if (!$order_by_position_asc) {
		$positions = array_reverse($positions);
	}
	foreach ($positions as $position => $item_id) {
		$database->query("UPDATE `".TABLE_PREFIX."mod_".$mod_name."_items` SET position = ".(int)$position." + 1 WHERE item_id = ".(int)$item_id);
	}
}
?>