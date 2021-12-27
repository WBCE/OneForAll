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


if (!isset($_POST['action']) || $_POST['action'] != 'update_active' || !isset($_POST['item_id']) || !is_numeric($_POST['item_id']) || !isset($_POST['value']) || !is_numeric($_POST['item_id']) || !isset($_POST['mod_name'])) {
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

	// Enable/disable the item
	$database->query("UPDATE `".TABLE_PREFIX."mod_".$mod_name."_items` SET active = ".$_POST['value']." WHERE item_id = ".(int)$_POST['item_id']);
}
?>