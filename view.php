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

// Look for language file
if (LANGUAGE_LOADED) {
    include($inc_path.'/languages/EN.php');
    if (file_exists($inc_path.'/languages/'.LANGUAGE.'.php')) {
        include($inc_path.'/languages/'.LANGUAGE.'.php');
    }
}

// Get the general settings from db
$sql = "SELECT `name`, `value` FROM `".TABLE_PREFIX."mod_".$mod_name."_general_settings`";
$query_settings = $database->query($sql);
while ($setting = $query_settings->fetchRow(MYSQLI_ASSOC)) {
	// Convert setting_name to a var like $media_extensions
	$var  = $setting['name'];
	$$var = $setting['value'];
	// Convert strings to boolean
	if ($setting['value'] === 'true') {
		$$var = true;
	} else if ($setting['value'] === 'false') {
		$$var = false;
	} else if ($setting['value'] === 'null') {
		$$var = null;
	}		
}

// Check if there is a start point defined
if (isset($_GET['p']) AND is_numeric($_GET['p']) AND $_GET['p'] >= 0) {
	$position = $_GET['p'];
} else {
	$position = 0;
}

// Get user's username, display name, email, and id - needed for insertion into item info
$users = array();
$query_users = $database->query("SELECT user_id, username, display_name, email FROM `".TABLE_PREFIX."users`");
if ($query_users->numRows() > 0) {
	while ($user = $query_users->fetchRow()) {
		// Insert user info into users array
		$user_id = $user['user_id'];
		$users[$user_id]['username'] = $user['username'];
		$users[$user_id]['display_name'] = $user['display_name'];
		$users[$user_id]['email'] = $user['email'];
	}
}



// ITEM SCHEDULING
// ***************

// Enable / disable items automatically against a start and end time
if ($set_scheduling && file_exists($inc_path.'/scheduling.php')) {
	include('scheduling.php');
}


// SHOW OVERVIEW PAGE
// ******************

// Add a module wrapper to help with layout
$wrapper_start = "\n".'<div id="mod_'.$mod_name.'_wrapper_'.$section_id.'_f">'."\n";
$wrapper_end   = "\n".'</div> <!-- End of #mod_'.$mod_name.'_wrapper_'.$section_id.'_f -->'."\n";

if (!defined('ITEM_ID') OR !is_numeric(ITEM_ID)) {
	echo $wrapper_start;
	include('view_overview.php');
	echo $wrapper_end;
}



// SHOW ITEM DETAIL PAGE
// *********************

if (defined('ITEM_ID') AND is_numeric(ITEM_ID) AND defined('ITEM_SID') AND $section_id == ITEM_SID) {
	echo $wrapper_start;
	include('view_item.php');
	echo $wrapper_end;
}

?>