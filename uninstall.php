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


// Prevent this file from being accessed directly
if (defined('WB_PATH') == false) {
	exit('Cannot access this file directly'); 
}

// Include path
$inc_path = dirname(__FILE__);
// Get module name
require_once($inc_path.'/info.php');

// Include WB functions
require_once(WB_PATH.'/framework/functions.php');

// No need to delete item access directory or files
// since all module pages have to be deleted manually before uninstall

// Delete module image directory
$directory = WB_PATH.MEDIA_DIRECTORY.'/'.$mod_name;
if (is_dir($directory)) {
	rm_full_dir($directory);
}

// Drop module tables
$database->query("DROP TABLE `".TABLE_PREFIX."mod_".$mod_name."_fields`");
$database->query("DROP TABLE `".TABLE_PREFIX."mod_".$mod_name."_images`");
$database->query("DROP TABLE `".TABLE_PREFIX."mod_".$mod_name."_items`");
$database->query("DROP TABLE `".TABLE_PREFIX."mod_".$mod_name."_item_fields`");
$database->query("DROP TABLE `".TABLE_PREFIX."mod_".$mod_name."_page_settings`");
$database->query("DROP TABLE `".TABLE_PREFIX."mod_".$mod_name."_general_settings`");

?>