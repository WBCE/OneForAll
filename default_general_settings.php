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




// *****************************************
// DEFAULT VALUES OF GENERAL SETTINGS
// *****************************************


// GENERAL SETTINGS
// ****************

// Display settings to admin group only (GROUP_ID == 1)
$general_settings['settings_admin_only'] = true;

// Order items by position ascending (true) or descending (false)
$general_settings['order_by_position_asc'] = true;

// Allow moving and/or duplicating an item from one section to another
// Set to false if there is for example just one module section
$general_settings['show_item_mover'] = true;

// If moving/duplicating is disabled you can still allow duplicating an item
// This setting is overwritten by the setting above
$general_settings['show_item_duplicator'] = true;

// Backend item wysiwyg and code editor width
// Both columns = 100% (true) or right column = 80% (false)
$general_settings['wysiwyg_full_width'] = false;

// Group headers (only invoked if the group field is defined)
// Show group headers on overview page
$general_settings['show_group_headers'] = true;
// Order groups ascending (true) or descending (false)
$general_settings['order_by_group_asc'] = true;

// Show additional field meta description on the modify item page
// This will only take effect if item detail pages are enabled
// For SEO optimization use module html5head or SimplePageHead to insert item title
// and a meta description into the html head of every item detail page
$general_settings['field_meta_desc'] = true;

// Set extensions accepted by the media field as csv
// Default: image extensions like jpg, png, gif, svg, webp
$general_settings['media_extensions'] = 'jpg,png,gif,svg,webp';

// Set extensions accepted by the upload field as csv
// Default: text doc extensions like txt, rtf, doc, docx, odt and pdf
$general_settings['upload_extensions'] = 'txt,rtf,doc,docx,odt,pdf';

// Generate item detail pages and corresponding access files
// WARNING: Changing this setting after adding items may cause problems!
// Item access files and their corresponding links will not be updated automatically
// After changing you might have to resave all items manually to be up-to-date
$general_settings['view_detail_pages'] = true;

// Allow the field type code which makes use of the language construct eval()
// CAUTION: eval() is dangerous because it allows execution of arbitrary PHP code
// Any user provided php code is not validated by the module OneForAll!
$general_settings['field_type_code'] = false;



// ****************************************
// IMAGES AND THUMBNAILS DEFAULTS (BACKEND)
// PLUPLOAD, A MULTI RUNTIME FILE UPLOADER
// ****************************************

// Selectable thumbnail default sizes (modify page settings)
$general_settings['thumb_resize_smallest'] = 40;
$general_settings['thumb_resize_largest'] = 200;
$general_settings['thumb_resize_steps'] = 20;

// Accepted max lenght of image filenames (modify item)
$general_settings['filename_max_length'] = 40;

// For item images set image resize default values (modify item)
$general_settings['imgresize'] = false;  // true = selected by default
$general_settings['resize_quality'] = 75;
$general_settings['resize_maxwidth'] = 400;
$general_settings['resize_maxheight'] = 300;

// Plupload max file size in MB
$general_settings['max_file_size'] = 2;



// ***************
// ITEM SCHEDULING
// ***************

// This feature enables / disables items automatically against a start and end time.
// It is not possible to enable / disable a scheduled item manually since scheduling is prioritized.

// Enable scheduling
$general_settings['set_scheduling'] = true;

// Enable scheduling debug mode
$general_settings['scheduling_debug'] = false;

// If this format is set, it will overwrite the datetime format given by the jquery ui datepicker language file
// Important! Format must match your datetime format
// eg. 'd#m#Y * H#i'
// See http://php.net/manual/en/datetime.createfromformat.php
$general_settings['scheduling_format'] = '';

// Set your timezone adjustment explicitly if the wb constant DEFAULT_TIMEZONE returns unexpected values
// eg. GMT + 1 hour  => $general_settings['scheduling_timezone'] = 1;
// eg. GMT - 4 hours => $general_settings['scheduling_timezone'] = -4;
$general_settings['scheduling_timezone'] = '';

