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

// This code removes any php tags and adds slashes
$friendly = array('&lt;', '&gt;', '?php');
$raw      = array('<', '>', '');

$header         = $admin->add_slashes(str_replace($friendly, $raw, $_POST['header']));
$item_loop      = $admin->add_slashes(str_replace($friendly, $raw, $_POST['item_loop']));
$footer         = $admin->add_slashes(str_replace($friendly, $raw, $_POST['footer']));
$item_header    = $admin->add_slashes(str_replace($friendly, $raw, $_POST['item_header']));
$item_footer    = $admin->add_slashes(str_replace($friendly, $raw, $_POST['item_footer']));
$items_per_page = $_POST['items_per_page'];
if (extension_loaded('gd') AND function_exists('imageCreateFromJpeg')) {
	$resize = $_POST['resize'];
} else {
	$resize = '';
}
if (isset($_POST['lb2_overview']) && isset($_POST['lb2_detail'])) {
	$lightbox2 = "all";
} elseif (isset($_POST['lb2_overview'])) {
	$lightbox2 = "overview";
} elseif (isset($_POST['lb2_detail'])) {
	$lightbox2 = "detail";
} else {
	$lightbox2 = '';
}
$img_section = empty($_POST['img_section']) ? 0 : 1;

// Update settings of specified section ids
if ($_POST['modify'] == "multiple") {
	$where_clause = '';
	foreach ($_POST['modify_sections'] as $section_id) {
		if (!is_numeric($section_id)) {
			continue;
		}
		$where_clause .= "section_id = '$section_id' OR ";
	}
	$where_clause = rtrim($where_clause, ' OR ');

	$database->query("UPDATE `".TABLE_PREFIX."mod_".$mod_name."_page_settings` SET header = '$header', item_loop = '$item_loop', footer = '$footer', item_header = '$item_header', item_footer = '$item_footer', items_per_page = '$items_per_page', img_section = '$img_section', resize = '$resize', lightbox2 = '$lightbox2' WHERE $where_clause");
}

// Update settings of all section ids 
elseif ($_POST['modify'] == "all") {
$database->query("UPDATE `".TABLE_PREFIX."mod_".$mod_name."_page_settings` SET header = '$header', item_loop = '$item_loop', footer = '$footer', item_header = '$item_header', item_footer = '$item_footer', items_per_page = '$items_per_page', img_section = '$img_section', resize = '$resize', lightbox2 = '$lightbox2'");
}

// Update settings of current section id only
elseif ($_POST['modify'] == "current") {
$database->query("UPDATE `".TABLE_PREFIX."mod_".$mod_name."_page_settings` SET header = '$header', item_loop = '$item_loop', footer = '$footer', item_header = '$item_header', item_footer = '$item_footer', items_per_page = '$items_per_page', img_section = '$img_section', resize = '$resize', lightbox2 = '$lightbox2' WHERE section_id = '$section_id'");
}

// Check if there is a db error, otherwise say successful
if ($database->is_error()) {
	$admin->print_error($database->get_error(), ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
} else {
	$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer();

?>
