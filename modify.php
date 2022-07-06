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
require_once($inc_path.'/functions.php');

// Make use of the skinable backend themes of WB > 2.7
// Check if THEME_URL is supported otherwise use ADMIN_URL
if (!defined('THEME_URL')) {
	define('THEME_URL', ADMIN_URL);
}

//Look for language File
if (LANGUAGE_LOADED) {
    require_once($inc_path.'/languages/EN.php');
    if (file_exists($inc_path.'/languages/'.LANGUAGE.'.php')) {
        require_once($inc_path.'/languages/'.LANGUAGE.'.php');
    }
}

// Include WB functions file
require_once(WB_PATH.'/framework/functions.php');

// Include core functions of WB 2.7 to edit the optional module CSS files (frontend.css, backend.css)
if (file_exists(WB_PATH.'/framework/module.functions.php') && file_exists(WB_PATH.'/modules/edit_module_files.php')) {
	include_once(WB_PATH.'/framework/module.functions.php');
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

// Delete empty Database records
$database->query("DELETE FROM `".TABLE_PREFIX."mod_".$mod_name."_items` WHERE page_id = '$page_id' and section_id = '$section_id' and title = ''");
$database->query("ALTER TABLE `".TABLE_PREFIX."mod_".$mod_name."_items` auto_increment = 1");

// Scheduling: Enable / disable items automatically against a start and end time
if ($set_scheduling && file_exists($inc_path.'/scheduling.php')) {
	include('scheduling.php');
}

// Display setting buttons to admin group only
$display_settings = true;
if ($settings_admin_only && !$admin->isAdmin()) {
	$display_settings = false;
}

// Add space to the text var TXT_SORT_BY2 if it is not empty
if (!empty($MOD_ONEFORALL[$mod_name]['TXT_SORT_BY2'])) {
	$MOD_ONEFORALL[$mod_name]['TXT_SORT_BY2'] = ' '.$MOD_ONEFORALL[$mod_name]['TXT_SORT_BY2'];
}
?>
<script type="text/javascript">
// Load jQuery ui if not loaded yet
jQuery().sortable || document.write('<script src="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/js/jquery/ui/jquery-ui.min.js"><\/script>');
// Load table_sort.js if not loaded yet
if (typeof(table_sort_loaded) === 'undefined') {
	document.write('<script src="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/js/table_sort.js"><\/script>');
	var table_sort_loaded = true;
}
// Define an object with some properties
// We need an object with a unique name (module name) in order to prevent interference between the modules
var mod_<?php echo $mod_name; ?> = {
	mod_name: '<?php echo $mod_name; ?>',
	txt_enable: '<?php echo $MOD_ONEFORALL[$mod_name]['TXT_ENABLE']; ?>',
	txt_disable: '<?php echo $MOD_ONEFORALL[$mod_name]['TXT_DISABLE']; ?>',
	txt_toggle_message: '<?php echo $MOD_ONEFORALL[$mod_name]['TXT_TOGGLE_MESSAGE']; ?>',
	txt_dragdrop_message: '<?php echo $MOD_ONEFORALL[$mod_name]['TXT_DRAGDROP_MESSAGE']; ?>'
};
// Define some localisation vars for TableSort
var txt_sort_table = '<?php echo $MOD_ONEFORALL[$mod_name]['TXT_SORT_TABLE']; ?>',
	txt_sort_by1   = '<?php echo $MOD_ONEFORALL[$mod_name]['TXT_SORT_BY1']; ?>',
	txt_sort_by2   = '<?php echo $MOD_ONEFORALL[$mod_name]['TXT_SORT_BY2']; ?>';
</script>

<div id="mod_<?php echo $mod_name; ?>_modify_b">
<table>
	<tr>
		<td colspan="2" rowspan="3" align="left"><h2 class="mod_<?php echo $mod_name; ?>_section_header_b"><?php echo $TEXT['PAGE_TITLE'].": ".get_page_title($page_id)." <span>".$TEXT['SECTION'].": ".$section_id; ?></span></h2></td>
		<td align="right" valign="bottom">
			<?php
			if ($display_settings) {
				echo '<input type="button" value="'.$MOD_ONEFORALL[$mod_name]['TXT_FIELDS'].'" onclick="javascript: window.location = \''.WB_URL.'/modules/'.$mod_name.'/modify_fields.php?page_id='.$page_id.'&section_id='.$section_id.'\';">';
			};
			?>
		</td>
	</tr>
	<tr>
		<td align="right" valign="top">
			<?php
			if ($display_settings) {
				echo '<input type="button" value="'.$MOD_ONEFORALL[$mod_name]['TXT_PAGE_SETTINGS'].'" onclick="javascript: window.location = \''.WB_URL.'/modules/'.$mod_name.'/modify_page_settings.php?page_id='.$page_id.'&section_id='.$section_id.'\';">';
			};
			?>
		</td>
	</tr>
	<tr>
		<td align="right" valign="bottom">
			<?php
			if ($display_settings) {
				echo '<input type="button" value="'.$MOD_ONEFORALL[$mod_name]['TXT_GENERAL_SETTINGS'].'" onclick="javascript: window.location = \''.WB_URL.'/modules/'.$mod_name.'/modify_general_settings.php?page_id='.$page_id.'&section_id='.$section_id.'\';">';
			};
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" width="66%">
			<input type="button" value="<?php echo $MOD_ONEFORALL[$mod_name]['TXT_ADD_ITEM']; ?>" onclick="javascript: window.location = '<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/add_item.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>';" style="width: 80%;">
		</td>
		<td align="right">
			<?php
			if (function_exists('edit_module_css')) {
				if ($display_settings) {
					edit_module_css($mod_name);
				}
			} else {
				echo '<input type="button" name="edit_module_file" class="mod_'.$mod_name.'_edit_css" value="'.$TEXT['CAP_EDIT_CSS'].'" onclick="javascript: alert(\'To take advantage of this feature please upgrade to WB 2.7 or higher.\')">';
			} ?>
		</td>
	</tr>
</table>

<br>
<h2><?php echo $TEXT['MODIFY'].' / '.$TEXT['DELETE'].' '.$MOD_ONEFORALL[$mod_name]['TXT_ITEM']; ?></h2>

<?php
// Get group names
$query_fields = $database->query("SELECT field_id, extra, label FROM `".TABLE_PREFIX."mod_".$mod_name."_fields` WHERE type = 'group' LIMIT 1");
if ($query_fields->numRows() > 0) {
	$field    = $query_fields->fetchRow();
	$field_id = $field['field_id'];
	$label    = $field['label'];
	$a_groups = explode(',', stripslashes($field['extra']));
	array_unshift($a_groups, '&#8211;');
} else {
	$field_id = false;
}

// Define the up and down arrows depending on ordering
$position_order = $order_by_position_asc ? 'ASC' : 'DESC';
$arrow1       = 'up';
$arrow2       = 'down';
$arrow1_title = $TEXT['MOVE_UP'];
$arrow2_title = $TEXT['MOVE_DOWN'];
if ($position_order == 'DESC') {
	$arrow1       = 'down';
	$arrow2       = 'up';
	$arrow1_title = $TEXT['MOVE_DOWN'];
	$arrow2_title = $TEXT['MOVE_UP'];
}

// Get item data
$position_order = $order_by_position_asc ? 'ASC' : 'DESC';
$query_items    = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_".$mod_name."_items` WHERE section_id = '$section_id' AND title != '' ORDER BY position ".$position_order);

if ($query_items->numRows() > 0) {
	
	?>

	<table id="mod_<?php echo $mod_name; ?>_items_b" class="sortierbar">
	<thead>
		<tr>
			<th class="sortierbar">ID</th>
			<th></th>
			<th class="sortierbar"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_TITLE']; ?></th>
			<th><?php if ($field_id) echo $MOD_ONEFORALL[$mod_name]['TXT_GROUP']; ?></th>
			<th class="sortierbar"><?php echo $MOD_ONEFORALL[$mod_name]['TXT_ENABLED']; ?></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	<?php
	
	$num_items = $query_items->numRows();

	// Loop through existing items
	while ($item = $query_items->fetchRow()) {

		// Get item scheduling
		$scheduling = @unserialize($item['scheduling']);
		// Ignore start and end time if scheduling is disabled
		$scheduling = $set_scheduling === false ? false : $scheduling;

		// Sanitize
		$item = array_map('stripslashes', $item);
		$item = array_map('lazyspecial', $item);

		// Get item group id
		if ($field_id) {
			$group_id = $database->get_one("SELECT value FROM `".TABLE_PREFIX."mod_".$mod_name."_item_fields` WHERE item_id = '".$item['item_id']."' AND field_id = '".$field_id."'");
			$group_id   = empty($group_id) ? 0 : $group_id;
			$group_name = $label.': '.$a_groups[$group_id];
		} else {
			$group_name = '';
		}

		?>
		<tr id="id_<?php echo $item['item_id']; ?>">
			<td class="sortierbar"><?php echo $item['item_id']; ?></td>
			<td>
				<a href="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/modify_item.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&item_id=<?php echo $item['item_id']; ?>" title="<?php echo $TEXT['MODIFY']; ?>">
					<img src="<?php echo THEME_URL; ?>/images/modify_16.png" alt="<?php echo $TEXT['MODIFY']; ?>">
				</a>
			</td>
			<td class="sortierbar">
				<a href="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/modify_item.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&item_id=<?php echo $item['item_id']; ?>">
					<?php echo stripslashes($item['title']); ?>
				</a>
			</td>
			<td>
				<?php echo $group_name; ?>
			</td>
			<td class="sortierbar">
				<?php
				// 
				$scheduling_title = $item['active'] == 1 ? $MOD_ONEFORALL[$mod_name]['TXT_ENABLED'] : $MOD_ONEFORALL[$mod_name]['TXT_DISABLED'];
				$active_title = $item['active'] == 1 ? $MOD_ONEFORALL[$mod_name]['TXT_DISABLE'] : $MOD_ONEFORALL[$mod_name]['TXT_ENABLE'];
				// If scheduling is used, just show a calendar icon to indicate the item status
				if ($scheduling !== false && count(array_filter($scheduling)) > 0) {
					echo '<img src="'.WB_URL.'/modules/'.$mod_name.'/images/scheduled'.$item['active'].'.png" width="16" height="16" alt="'.$scheduling_title.'" title="'.$scheduling_title.' ('.$MOD_ONEFORALL[$mod_name]['TXT_SCHEDULING'].')">';
				}
				// Users can toggle the item manually if scheduling is not used
				else {
					echo '<span class="mod_'.$mod_name.'_active'.$item['active'].'_b" title="'.$active_title.'"><span>'.$item['active'].'</span></span>';
				}
				?>
			</td>
			<td>
			<?php if ($item['position'] != 1) { ?>
				<a href="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/move_up.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&item_id=<?php echo $item['item_id']; ?>" title="<?php echo $arrow1_title; ?>">
					<img src="<?php echo THEME_URL; ?>/images/<?php echo $arrow1; ?>_16.png" alt="<?php echo $arrow1_title; ?>">
				</a>
			<?php } ?>
			</td>
			<td>
			<?php if ($item['position'] != $num_items) { ?>
				<a href="<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/move_down.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&item_id=<?php echo $item['item_id']; ?>" title="<?php echo $arrow2_title; ?>">
					<img src="<?php echo THEME_URL; ?>/images/<?php echo $arrow2; ?>_16.png" alt="<?php echo $arrow2_title; ?>">
				</a>
			<?php } ?>
			</td>
			<td>
				<a href="javascript: confirm_link('<?php echo $TEXT['ARE_YOU_SURE']; ?>', '<?php echo WB_URL; ?>/modules/<?php echo $mod_name; ?>/delete_item.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&item_id=<?php echo $item['item_id']; ?>');" title="<?php echo $TEXT['DELETE']; ?>">
					<img src="<?php echo THEME_URL; ?>/images/delete_16.png" alt="<?php echo $TEXT['DELETE']; ?>">
				</a>
			</td>
		</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	<?php
} else {
	echo $TEXT['NONE_FOUND'];
}
?>
</div> <!-- enddiv #mod_<?php echo $mod_name; ?>_modify_b -->