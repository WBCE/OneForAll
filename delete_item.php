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

// Get id
if (!isset($_GET['item_id']) OR !is_numeric($_GET['item_id'])) {
	header("Location: ".ADMIN_URL."/pages/index.php");
} else {
	$item_id = $_GET['item_id'];
}

// Include path
$inc_path = dirname(__FILE__);
// Get module name and config
require_once($inc_path.'/info.php');

// Include WB admin wrapper script and WB functions
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');
require_once(WB_PATH.'/framework/functions.php');

// Get item details
$query_details = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_".$mod_name."_items` WHERE item_id = '$item_id'");
if ($query_details->numRows() > 0) {
	$get_details = $query_details->fetchRow();
} else {
	$admin->print_error($TEXT['NOT_FOUND'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Unlink item access file only if the link has initially been stored
if (!empty($get_details['link'])) {
	$item_link = WB_PATH.PAGES_DIRECTORY.$page['link'].$get_details['link'].PAGE_EXTENSION;
	if (is_writable($item_link)) {
		unlink($item_link);
	}
}

// Delete any images if they exists
$image = WB_PATH.MEDIA_DIRECTORY.'/'.$mod_name.'/images/item'.$item_id;
$thumb = WB_PATH.MEDIA_DIRECTORY.'/'.$mod_name.'/thumbs/item'.$item_id;
if (is_dir($image)) { rm_full_dir($image); }
if (is_dir($thumb)) { rm_full_dir($thumb); }

// Delete item, item fields and item images
$database->query("DELETE FROM `".TABLE_PREFIX."mod_".$mod_name."_items` WHERE item_id = '$item_id' LIMIT 1");
$database->query("DELETE FROM `".TABLE_PREFIX."mod_".$mod_name."_item_fields` WHERE item_id = '$item_id'");
$database->query("DELETE FROM `".TABLE_PREFIX."mod_".$mod_name."_images` WHERE item_id = '$item_id'");

// Clean up ordering
require(WB_PATH.'/framework/class.order.php');
$order = new order(TABLE_PREFIX.'mod_'.$mod_name.'_items', 'position', 'item_id', 'section_id');
$order->clean($section_id); 

// Check if there is a db error, otherwise say successful
if ($database->is_error()) {
	$admin->print_error($database->get_error(), WB_URL.'/modules/modify_post.php?page_id='.$page_id.'&item_id='.$item_id);
} else {
	$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer();

?>