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

// Include path
$inc_path = dirname(__FILE__);
// Get module name
require_once($inc_path.'/info.php');

// Get id
if (!isset($_GET['img_id']) OR !is_numeric($_GET['img_id']) OR !isset($_GET['item_id']) OR !is_numeric($_GET['item_id'])) {
	header("Location: index.php");
} else {
	$id       = $_GET['img_id'];
	$item_id  = $_GET['item_id'];
	$id_field = 'img_id';
	$table    = TABLE_PREFIX.'mod_'.$mod_name.'_images';
}

// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

// Include the ordering class
require(WB_PATH.'/framework/class.order.php');

// Create new order object and reorder
$order = new order($table, 'position', $id_field, 'item_id');
if ($order->move_down($id)) {
	$admin->print_success($TEXT['SUCCESS'], WB_URL.'/modules/'.$mod_name.'/modify_item.php?page_id='.$page_id.'&section_id='.$section_id.'&item_id='.$item_id.'#images');
} else {
	$admin->print_error($TEXT['ERROR'], WB_URL.'/modules/'.$mod_name.'/modify_item.php?page_id='.$page_id.'&section_id='.$section_id.'&item_id='.$item_id.'#images');
}

// Print admin footer
$admin->print_footer();
