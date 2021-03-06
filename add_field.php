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


//Prevent this file from being accessed directly
if (defined('WB_PATH') == false) {
	exit('Cannot access this file directly'); 
}

// Include path
$inc_path = dirname(__FILE__);

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



// Field types
$field_types['disabled']                 = $MOD_ONEFORALL[$mod_name]['TXT_DISABLED'];
$field_types['text']                     = $MOD_ONEFORALL[$mod_name]['TXT_TEXT'];
$field_types['textarea']                 = $MOD_ONEFORALL[$mod_name]['TXT_TEXTAREA'];
$field_types['wysiwyg']                  = $MOD_ONEFORALL[$mod_name]['TXT_WYSIWYG'];
$field_types['code']                     = $MOD_ONEFORALL[$mod_name]['TXT_CODE'];
$field_types['wb_link']                  = $MOD_ONEFORALL[$mod_name]['TXT_WB_LINK'];
$field_types['oneforall_link']           = $MOD_ONEFORALL[$mod_name]['TXT_ONEFORALL_LINK'];
$field_types['foldergallery_link']       = $MOD_ONEFORALL[$mod_name]['TXT_FOLDERGALLERY_LINK'];
$field_types['url']                      = $MOD_ONEFORALL[$mod_name]['TXT_URL'];
$field_types['email']                    = $MOD_ONEFORALL[$mod_name]['TXT_EMAIL'];
$field_types['media']                    = $MOD_ONEFORALL[$mod_name]['TXT_MEDIA'];
$field_types['upload']                   = $MOD_ONEFORALL[$mod_name]['TXT_UPLOAD'];
$field_types['datepicker']               = $MOD_ONEFORALL[$mod_name]['TXT_DATEPICKER'];
$field_types['datepicker_start_end']     = $MOD_ONEFORALL[$mod_name]['TXT_DATEPICKER_START_END'];
$field_types['datetimepicker']           = $MOD_ONEFORALL[$mod_name]['TXT_DATETIMEPICKER'];
$field_types['datetimepicker_start_end'] = $MOD_ONEFORALL[$mod_name]['TXT_DATETIMEPICKER_START_END'];
$field_types['droplet']                  = $MOD_ONEFORALL[$mod_name]['TXT_DROPLET'];
$field_types['select']                   = $MOD_ONEFORALL[$mod_name]['TXT_SELECT'];
$field_types['multiselect']              = $MOD_ONEFORALL[$mod_name]['TXT_MULTISELECT'];
$field_types['checkbox']                 = $MOD_ONEFORALL[$mod_name]['TXT_CHECKBOX'];
$field_types['switch']                   = $MOD_ONEFORALL[$mod_name]['TXT_SWITCH'];
$field_types['radio']                    = $MOD_ONEFORALL[$mod_name]['TXT_RADIO'];
$field_types['group']                    = $MOD_ONEFORALL[$mod_name]['TXT_GROUP'];
$field_types['delete']                   = $MOD_ONEFORALL[$mod_name]['TXT_DELETE_FIELD'];

// Exclude field type code if not allowed in general settings
$field_type_code = $database->get_one("SELECT `value` FROM `".TABLE_PREFIX."mod_".$mod_name."_general_settings` WHERE `name` = 'field_type_code';");
$field_type_code = $field_type_code === 'true' ? true : false;
if (!$field_type_code) {
	unset($field_types['code']);
} 



// Default field templates
$field_template['text'] = '
<div class="mod_'.$mod_name.'_text_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['textarea'] = '
<div class="mod_'.$mod_name.'_textarea_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['wysiwyg'] = '
<div class="mod_'.$mod_name.'_wysiwyg_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['code'] = '
<div class="mod_'.$mod_name.'_code_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['wb_link'] = '
<div class="mod_'.$mod_name.'_wb_link_f">
	<div class="mod_'.$mod_name.'_field_content_f">
		<a href="[CUSTOM_CONTENT]">[CUSTOM_LABEL]</a>
	</div>
</div>';

$field_template['oneforall_link'] = '
<div class="mod_'.$mod_name.'_oneforall_link_f">
	<div class="mod_'.$mod_name.'_field_content_f">
		<a href="[CUSTOM_CONTENT]">[CUSTOM_LABEL]</a>
	</div>
</div>';

$field_template['foldergallery_link'] = '
<div class="mod_'.$mod_name.'_foldergallery_link_f">
	<div class="mod_'.$mod_name.'_field_content_f">
		<a href="[CUSTOM_CONTENT]">[CUSTOM_LABEL]</a>
	</div>
</div>';

$field_template['url'] = '
<div class="mod_'.$mod_name.'_url_f">
	<div class="mod_'.$mod_name.'_field_content_f">
		<a href="[CUSTOM_CONTENT]" target="_blank">[CUSTOM_LABEL]</a>
	</div>
</div>';

$field_template['email'] = '
<div class="mod_'.$mod_name.'_email_f">
	<div class="mod_'.$mod_name.'_field_content_f">
		<a href="mailto:[CUSTOM_CONTENT]">[CUSTOM_CONTENT]</a>
	</div>
</div>';

$field_template['media'] = '
<div class="mod_'.$mod_name.'_media_f">
	<div class="mod_'.$mod_name.'_field_content_f">
		<a href="[CUSTOM_CONTENT]" target="_blank">[CUSTOM_LABEL]</a>
	</div>
</div>';

$field_template['upload'] = '
<div class="mod_'.$mod_name.'_upload_f">
	<div class="mod_'.$mod_name.'_field_content_f">
		<a href="[CUSTOM_CONTENT]" target="_blank">[CUSTOM_LABEL]</a>
	</div>
</div>';

$field_template['datepicker'] = '
<div class="mod_'.$mod_name.'_datepicker_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['datepicker_start_end'] = '
<div class="mod_'.$mod_name.'_datepicker_start_end_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['datetimepicker'] = '
<div class="mod_'.$mod_name.'_datetimepicker_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['datetimepicker_start_end'] = '
<div class="mod_'.$mod_name.'_datetimepicker_start_end_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['droplet'] = '
<div class="mod_'.$mod_name.'_droplet_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['select'] = '
<div class="mod_'.$mod_name.'_select_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['multiselect'] = '
<div class="mod_'.$mod_name.'_multiselect_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['checkbox'] = '
<div class="mod_'.$mod_name.'_checkbox_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['switch'] = '
<div class="mod_'.$mod_name.'_switch_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['radio'] = '
<div class="mod_'.$mod_name.'_radio_f">
	<div class="mod_'.$mod_name.'_field_label_f">[CUSTOM_LABEL]</div>
	<div class="mod_'.$mod_name.'_field_content_f">[CUSTOM_CONTENT]</div>
</div>';

$field_template['group'] = '
<h2 class="mod_'.$mod_name.'_group_f">[CUSTOM_LABEL]: [GROUP_NAME]</h2>';

?>