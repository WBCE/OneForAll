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



/*
  ***********************
  TRANSLATORS PLEASE NOTE
  ***********************
  
  Thank you for translating OneForAll!
  Include your credits in the header of this file right above the copyright terms.
  Please post your localisation file to the WBCE forum at https://forum.wbce.org
*/


// MODUL DESCRIPTION
$module_description = 'OneForAll is a WBCE module that is versatile like a chameleon. It can be installed more than one time on the same WBCE installation by setting a different module name in the info.php file before upload and installation. Furthermore the module provides a feature to add highly customized pages. On the one hand you can define custom fields in the backend and on the other hand free definable html templates for the frontend output. <br>By default it provides just one title field and  an image upload. Additionally you can add different custom field types. Items can be displayed in an overview and if needed in a corresponding detail page. OneForAll makes use of the Lightbox2 JavaScript to overlay item images on the current page.';

// MODUL ONEFORALL VARIOUS TEXT
$MOD_ONEFORALL[$mod_name]['TXT_SETTINGS'] = 'Settings';
$MOD_ONEFORALL[$mod_name]['TXT_FIELDS'] = 'Fields';
$MOD_ONEFORALL[$mod_name]['TXT_SYNC_TYPE_TEMPLATE'] = 'Adapt field template automatically when selecting field type.';

$MOD_ONEFORALL[$mod_name]['TXT_CUSTOM_FIELD'] = 'Custom field';
$MOD_ONEFORALL[$mod_name]['TXT_FIELD_TYPE'] = 'Type';
$MOD_ONEFORALL[$mod_name]['TXT_FIELD_NAME'] = 'Field name';
$MOD_ONEFORALL[$mod_name]['TXT_FIELD_LABEL'] = 'Field label';
$MOD_ONEFORALL[$mod_name]['TXT_DIRECTORY'] = 'Directory';
$MOD_ONEFORALL[$mod_name]['TXT_FIELD_PLACEHOLDER'] = 'Placeholder';
$MOD_ONEFORALL[$mod_name]['TXT_OR'] = 'or';
$MOD_ONEFORALL[$mod_name]['TXT_FIELD_TEMPLATE'] = 'Field template';
$MOD_ONEFORALL[$mod_name]['TXT_NEW_FIELD_NAME'] = 'field';
$MOD_ONEFORALL[$mod_name]['TXT_ADD_NEW_FIELDS'] = 'Add new fields';
$MOD_ONEFORALL[$mod_name]['TXT_SUCCESS_MESSAGE'] = 'Moved item successfully';
$MOD_ONEFORALL[$mod_name]['TXT_TOGGLE_MESSAGE'] = 'Saved new status successfully.';
$MOD_ONEFORALL[$mod_name]['TXT_DRAGDROP_MESSAGE'] = 'Moved item successfully.';

$MOD_ONEFORALL[$mod_name]['TXT_PAGE_SETTINGS'] = 'Page settings';
$MOD_ONEFORALL[$mod_name]['TXT_GENERAL_SETTINGS'] = 'General settings';
$MOD_ONEFORALL[$mod_name]['TXT_EXPORT_IMPORT'] = 'Export / import fields and module settings';
$MOD_ONEFORALL[$mod_name]['TXT_IMG_AND_THUMB_DEFAULTS'] = 'Image and thumbnail defaults (Backend)';
$MOD_ONEFORALL[$mod_name]['TXT_ITEM_SCHEDULING_SETTINGS'] = 'Item scheduling settings (Item page)';
$MOD_ONEFORALL[$mod_name]['TXT_LAYOUT'] = 'Layout';
$MOD_ONEFORALL[$mod_name]['TXT_OVERVIEW'] = 'Overview';
$MOD_ONEFORALL[$mod_name]['TXT_DETAIL'] = 'Item Detail';

$MOD_ONEFORALL[$mod_name]['TXT_DISABLED'] = 'Disabled';
$MOD_ONEFORALL[$mod_name]['TXT_TEXT'] = 'Short text';
$MOD_ONEFORALL[$mod_name]['TXT_TEXTAREA'] = 'Textarea';
$MOD_ONEFORALL[$mod_name]['TXT_WYSIWYG'] = 'WYSIWYG-Editor';
$MOD_ONEFORALL[$mod_name]['TXT_CODE'] = 'PHP-Code';
$MOD_ONEFORALL[$mod_name]['TXT_WB_LINK'] = 'WBCE Link';
$MOD_ONEFORALL[$mod_name]['TXT_ONEFORALL_LINK'] = 'Module OneForAll Link';
$MOD_ONEFORALL[$mod_name]['TXT_MODULE_NAME'] = 'Module Name';
$MOD_ONEFORALL[$mod_name]['TXT_FOLDERGALLERY_LINK'] = 'Module FolderGallery Link';
$MOD_ONEFORALL[$mod_name]['TXT_FOLDERGALLERY_SECTION_ID'] = 'FG SectionIDs (csv)';
$MOD_ONEFORALL[$mod_name]['TXT_URL'] = 'External link';
$MOD_ONEFORALL[$mod_name]['TXT_EMAIL'] = 'Email link';
$MOD_ONEFORALL[$mod_name]['TXT_MEDIA'] = 'File from a subdirectory of media';
$MOD_ONEFORALL[$mod_name]['TXT_UPLOAD'] = 'File Upload';
$MOD_ONEFORALL[$mod_name]['TXT_DATEPICKER'] = 'Datepicker';
$MOD_ONEFORALL[$mod_name]['TXT_DATEPICKER_START_END'] = 'Date from &#8230; to &#8230;';
$MOD_ONEFORALL[$mod_name]['TXT_DATETIMEPICKER'] = 'Datetimepicker';
$MOD_ONEFORALL[$mod_name]['TXT_DATETIMEPICKER_START_END'] = 'Datetime from &#8230; to &#8230;';
$MOD_ONEFORALL[$mod_name]['TXT_JS_SELECT_DATE'] = 'Select date';
$MOD_ONEFORALL[$mod_name]['TXT_JS_SELECT_DATETIME'] = 'Select datetime';
$MOD_ONEFORALL[$mod_name]['TXT_DATETIME_SEPARATOR'] = 'at';
$MOD_ONEFORALL[$mod_name]['TXT_DATEDATE_SEPARATOR'] = 'until';
$MOD_ONEFORALL[$mod_name]['TXT_DROPLET'] = 'WBCE droplet';
$MOD_ONEFORALL[$mod_name]['TXT_SELECT'] = 'Select';
$MOD_ONEFORALL[$mod_name]['TXT_MULTISELECT'] = 'Multiselect';
$MOD_ONEFORALL[$mod_name]['TXT_MULTIOPTIONS'] = 'Options (csv)';
$MOD_ONEFORALL[$mod_name]['TXT_CHECKBOX'] = 'Checkbox';
$MOD_ONEFORALL[$mod_name]['TXT_CHECKBOXES'] = 'Checkboxes (csv)';
$MOD_ONEFORALL[$mod_name]['TXT_SWITCH'] = 'Switch on / off';
$MOD_ONEFORALL[$mod_name]['TXT_SWITCHES'] = 'on,off';
$MOD_ONEFORALL[$mod_name]['TXT_RADIO'] = 'Radio buttons';
$MOD_ONEFORALL[$mod_name]['TXT_RADIO_BUTTONS'] = 'Radio buttons (csv)';
$MOD_ONEFORALL[$mod_name]['TXT_SUBDIRECTORY_OF_MEDIA'] = 'Subdir of media';
$MOD_ONEFORALL[$mod_name]['TXT_OPTIONS'] = 'Options (csv)';
$MOD_ONEFORALL[$mod_name]['TXT_GROUP'] = 'Group'; 
$MOD_ONEFORALL[$mod_name]['TXT_GROUPS'] = 'Groups (csv)';
$MOD_ONEFORALL[$mod_name]['TXT_DELETE_FIELD'] = 'Delete field';
$MOD_ONEFORALL[$mod_name]['TXT_CONFIRM_DELETE_FIELD'] = 'Do you really want to delete the fields below with all its associated item data?';

$MOD_ONEFORALL[$mod_name]['TXT_EXPORT'] = 'Export';
$MOD_ONEFORALL[$mod_name]['TXT_IMPORT'] = 'Import';
$MOD_ONEFORALL[$mod_name]['TXT_IMPORT_MODULE_SETTINGS'] = 'Import module settings';
$MOD_ONEFORALL[$mod_name]['WARN_IMPORT_MODULE_SETTINGS'] = 'WARNING\n\nTHIS IMPORT MIGHT LEAD TO DATA LOSS\n\nAn import will replace all data in the corresponding db tables. Depending on the content of the loaded json file, it can affect the fields, page settings (PageID: %s) and general settings table.\n\nTo avoid any risk, click \u0022Cancel\u0022 and make a database backup before continuing.';
$MOD_ONEFORALL[$mod_name]['TXT_SETTINGS_ADMIN_ONLY'] = 'Settings admin only';
$MOD_ONEFORALL[$mod_name]['HINT_SETTINGS_ADMIN_ONLY'] = 'Display field, page and general settings to members of the admin group only (group_id = 1).';
$MOD_ONEFORALL[$mod_name]['WARN_SETTINGS_ADMIN_ONLY'] = '<strong>BEWARE</strong><br>If you are not a member of the admin group, after changing this setting you will no longer have access to the field, page and general settings.';
$MOD_ONEFORALL[$mod_name]['TXT_ORDER_BY_POSITION_ASC'] = 'Item order';
$MOD_ONEFORALL[$mod_name]['HINT_ORDER_BY_POSITION_ASC'] = 'Order items by position ascending or descending';
$MOD_ONEFORALL[$mod_name]['TXT_ASCENDING'] = 'Ascending';
$MOD_ONEFORALL[$mod_name]['TXT_DESCENDING'] = 'Descending';
$MOD_ONEFORALL[$mod_name]['TXT_SHOW_ITEM_MOVER'] = 'Show item mover';
$MOD_ONEFORALL[$mod_name]['HINT_SHOW_ITEM_MOVER'] = 'Allow moving and / or duplicating an item from one section to another. Disable if there is for example just one module section.';
$MOD_ONEFORALL[$mod_name]['TXT_SHOW_ITEM_DUPLICATOR'] = 'Show item duplicator';
$MOD_ONEFORALL[$mod_name]['HINT_SHOW_ITEM_DUPLICATOR'] = 'If the setting above &quot;Show item mover&quot; is disabled, you can still allow duplicating an item.';
$MOD_ONEFORALL[$mod_name]['TXT_WYSIWYG_FULL_WIDTH'] = 'WYSIWYG width';
$MOD_ONEFORALL[$mod_name]['HINT_WYSIWYG_FULL_WIDTH'] = 'Width of item wysiwyg and code editor: either both columns (100%) or right column only (80%).';
$MOD_ONEFORALL[$mod_name]['TXT_SHOW_GROUP_HEADERS'] = 'Show group headers';
$MOD_ONEFORALL[$mod_name]['HINT_SHOW_GROUP_HEADERS'] = 'Show group headers on overview pages. This feature is only invoked if the group field is defined in the field settings.';
$MOD_ONEFORALL[$mod_name]['TXT_ORDER_BY_GROUP_ASC'] = 'Group order';
$MOD_ONEFORALL[$mod_name]['HINT_ORDER_BY_GROUP_ASC'] = 'Order groups ascending or descending';
$MOD_ONEFORALL[$mod_name]['TXT_FIELD_META_DESC'] = 'Field meta description';
$MOD_ONEFORALL[$mod_name]['HINT_FIELD_META_DESC'] = 'Show an additional field for the meta description on the modify item page. This will only take effect if item detail pages are enabled. For SEO optimization use module <em>%s</em> or <em>%s</em> to insert item title and a meta description into the html head of every item detail page.';
$MOD_ONEFORALL[$mod_name]['TXT_MEDIA_EXTENSIONS'] = 'Media extensions';
$MOD_ONEFORALL[$mod_name]['HINT_MEDIA_EXTENSIONS'] = 'Set extensions accepted by the media field as csv. Default are the image extensions: jpg, png, gif, svg, webp.';
$MOD_ONEFORALL[$mod_name]['TXT_UPLOAD_EXTENSIONS'] = 'Upload extensions';
$MOD_ONEFORALL[$mod_name]['HINT_UPLOAD_EXTENSIONS'] = 'Set extensions accepted by the upload field as csv. Default are the text respectively doc extensions: txt, rtf, doc, docx, odt, pdf.';
$MOD_ONEFORALL[$mod_name]['TXT_VIEW_DETAIL_PAGES'] = 'View detail pages';
$MOD_ONEFORALL[$mod_name]['HINT_VIEW_DETAIL_PAGES'] = 'Have the module generate a detail page for every item including corresponding access files.';
$MOD_ONEFORALL[$mod_name]['WARN_VIEW_DETAIL_PAGES'] = '<strong>WARNING</strong><br>Changing this setting after having already added items may cause problems. Item access files and their corresponding links will not be updated automatically. After changing you may have to manually re-save all items again to be up-to-date.';
$MOD_ONEFORALL[$mod_name]['TXT_FIELD_TYPE_CODE'] = 'Field type code';
$MOD_ONEFORALL[$mod_name]['HINT_FIELD_TYPE_CODE'] = 'Allow the field type code which makes use of the PHP language construct <code>eval()</code>.';
$MOD_ONEFORALL[$mod_name]['WARN_FIELD_TYPE_CODE'] = '<strong>CAUTION</strong><br><code>eval()</code> is dangerous because it allows execution of arbitrary PHP code. Any user provided PHP code is not validated by the module itself. Use on your own risk.';
$MOD_ONEFORALL[$mod_name]['HINT_THUMB_RESIZE'] = 'Default settings for the thumbnail resizing (Modify page settings)';
$MOD_ONEFORALL[$mod_name]['TXT_THUMB_RESIZE_SMALLEST'] = 'Thumb resize smallest';
$MOD_ONEFORALL[$mod_name]['TXT_THUMB_RESIZE_LARGEST'] = 'Thumb resize largest';
$MOD_ONEFORALL[$mod_name]['TXT_THUMB_RESIZE_STEPS'] = 'Thumb resize steps';
$MOD_ONEFORALL[$mod_name]['HINT_IMG_RESIZE'] = 'Default settings for the image resizing after uploading with Plupload (Modify item)';
$MOD_ONEFORALL[$mod_name]['TXT_MAX_FILE_SIZE'] = 'Max file size';
$MOD_ONEFORALL[$mod_name]['HINT_MAX_FILE_SIZE'] = 'Default max file size for uploaded images ';
$MOD_ONEFORALL[$mod_name]['TXT_FILENAME_MAX_LENGTH'] = 'Filename max length';
$MOD_ONEFORALL[$mod_name]['HINT_FILENAME_MAX_LENGTH'] = 'Accepted max length of filename for uploaded images ';
$MOD_ONEFORALL[$mod_name]['TXT_IMGRESIZE'] = 'Image resizing';
$MOD_ONEFORALL[$mod_name]['HINT_IMGRESIZE'] = 'Image resizing enabled by default';
$MOD_ONEFORALL[$mod_name]['TXT_RESIZE_QUALITY'] = 'Resize quality';
$MOD_ONEFORALL[$mod_name]['HINT_RESIZE_QUALITY'] = 'Default JPEG compression quality';
$MOD_ONEFORALL[$mod_name]['TXT_RESIZE_MAXWIDTH'] = 'Resize max width';
$MOD_ONEFORALL[$mod_name]['HINT_RESIZE_MAXWIDTH'] = 'Default image resize max width';
$MOD_ONEFORALL[$mod_name]['TXT_RESIZE_MAXHEIGHT'] = 'Resize max height';
$MOD_ONEFORALL[$mod_name]['HINT_RESIZE_MAXHEIGHT'] = 'Default image resize max height';
$MOD_ONEFORALL[$mod_name]['HINT_ITEM_SCHEDULING'] = 'This feature enables / disables items automatically against a start and end time. It is not possible to enable / disable a scheduled item manually since scheduling has priority (Modify item).';
$MOD_ONEFORALL[$mod_name]['TXT_SET_SCHEDULING'] = 'Item scheduling';
$MOD_ONEFORALL[$mod_name]['HINT_SET_SCHEDULING'] = 'Enable item scheduling';
$MOD_ONEFORALL[$mod_name]['TXT_SCHEDULING_DEBUG'] = 'Scheduling debug';
$MOD_ONEFORALL[$mod_name]['HINT_SCHEDULING_DEBUG'] = 'Enable debug mode that displays scheduling debug info in the backend.';
$MOD_ONEFORALL[$mod_name]['TXT_SCHEDULING_FORMAT'] = 'Scheduling format';
$MOD_ONEFORALL[$mod_name]['HINT_SCHEDULING_FORMAT'] = 'If you enter a time format here, the date / time format specified by the jQuery datepicker language file will be overwritten.';
$MOD_ONEFORALL[$mod_name]['WARN_SCHEDULING_FORMAT'] = '<strong>Important</strong><br>Format must match your datetime format, eg. &quot;<code>d#m#Y * H#i</code>&quot;';
$MOD_ONEFORALL[$mod_name]['TXT_SCHEDULING_TIMEZONE'] = 'Scheduling timezone';
$MOD_ONEFORALL[$mod_name]['HINT_SCHEDULING_TIMEZONE'] = 'Set your timezone adjustment explicitly if the WBCE constant DEFAULT_TIMEZONE returns unexpected values:<br>eg. for GMT + 1 hour enter &quot;1&quot; or for GMT - 4 hours enter &quot;-4&quot; into the text field above.';

$MOD_ONEFORALL[$mod_name]['TXT_ITEM'] = 'Item';
$MOD_ONEFORALL[$mod_name]['TXT_ITEMS'] = 'Items';
$MOD_ONEFORALL[$mod_name]['TXT_ITEMS_PER_PAGE'] = 'Items per Page';
$MOD_ONEFORALL[$mod_name]['TXT_BACKEND_ITEM_PAGE'] = 'Item page (Backend)';
$MOD_ONEFORALL[$mod_name]['TXT_HIDE_IMG_SECTION'] = 'Hide image settings and upload';
$MOD_ONEFORALL[$mod_name]['TXT_MODIFY_THIS'] = 'Update page settings of <b>current</b> &quot;'.$module_name.'&quot; page only.';
$MOD_ONEFORALL[$mod_name]['TXT_MODIFY_ALL'] = 'Update page settings of <b>all</b> &quot;'.$module_name.'&quot; pages.';
$MOD_ONEFORALL[$mod_name]['TXT_MODIFY_MULTIPLE'] = 'Update page settings of <b>selected</b> &quot;'.$module_name.'&quot; page(s) (Multiple choice):';

$MOD_ONEFORALL[$mod_name]['TXT_ADD_ITEM'] = 'Add item';
$MOD_ONEFORALL[$mod_name]['TXT_DISABLE'] = 'Disable';
$MOD_ONEFORALL[$mod_name]['TXT_ENABLE'] = 'Enable';
$MOD_ONEFORALL[$mod_name]['TXT_ENABLED'] = 'Enabled';
$MOD_ONEFORALL[$mod_name]['TXT_SORT_TABLE'] = 'Click a table heading to sort the table.';
$MOD_ONEFORALL[$mod_name]['TXT_SORT_BY1'] = 'Sort the table by';
$MOD_ONEFORALL[$mod_name]['TXT_SORT_BY2'] = '';

$MOD_ONEFORALL[$mod_name]['TXT_TITLE'] = 'Item title';
$MOD_ONEFORALL[$mod_name]['TXT_DESCRIPTION'] = 'Description';
$MOD_ONEFORALL[$mod_name]['TXT_SCHEDULING'] = 'Timing';
$MOD_ONEFORALL[$mod_name]['TXT_PREVIEW'] = 'Preview';
$MOD_ONEFORALL[$mod_name]['TXT_FILE_NAME'] = 'File name';
$MOD_ONEFORALL[$mod_name]['TXT_MAIN_IMAGE'] = 'Main image';
$MOD_ONEFORALL[$mod_name]['TXT_THUMBNAIL'] = 'Thumbnail';
$MOD_ONEFORALL[$mod_name]['TXT_CAPTION'] = 'Caption';
$MOD_ONEFORALL[$mod_name]['TXT_POSITION'] = 'Position';
$MOD_ONEFORALL[$mod_name]['TXT_IMAGE'] = 'Image';
$MOD_ONEFORALL[$mod_name]['TXT_IMAGES'] = 'Images';
$MOD_ONEFORALL[$mod_name]['TXT_SHOW_GENUINE_IMAGE'] = 'Show genuine image';
$MOD_ONEFORALL[$mod_name]['TXT_FILE_LINK'] = 'File link';
$MOD_ONEFORALL[$mod_name]['TXT_MAX_WIDTH'] = 'max. Width';
$MOD_ONEFORALL[$mod_name]['TXT_MAX_HEIGHT'] = 'max. Height';
$MOD_ONEFORALL[$mod_name]['TXT_JPG_QUALITY'] = 'JPG Quality';
$MOD_ONEFORALL[$mod_name]['TXT_NON'] = 'non';
$MOD_ONEFORALL[$mod_name]['TXT_ITEM_TO_PAGE'] = 'Move item to page';
$MOD_ONEFORALL[$mod_name]['TXT_MOVE'] = 'move';
$MOD_ONEFORALL[$mod_name]['TXT_DUPLICATE'] = 'duplicate';
$MOD_ONEFORALL[$mod_name]['TXT_SAVE_AND_BACK_TO_LISTING'] = 'Save and go back to listing';

$MOD_ONEFORALL[$mod_name]['ERR_INVALID_SCHEDULING'] = 'The scheduled start time &quot;%s&quot; must be before the end time &quot;%s&quot;.';
$MOD_ONEFORALL[$mod_name]['ERR_INVALID_EMAIL'] = 'Email address &quot;%s&quot; is invalid.';
$MOD_ONEFORALL[$mod_name]['ERR_INVALID_URL'] = 'URL &quot;%s&quot; is invalid.';
$MOD_ONEFORALL[$mod_name]['ERR_INVALID_FILE_NAME'] = 'Invalid file name';
$MOD_ONEFORALL[$mod_name]['ERR_ONLY_ONE_GROUP_FIELD'] = 'Could not save field &quot;%s&quot; since only 1 &quot;group&quot; field is allowed.';
$MOD_ONEFORALL[$mod_name]['ERR_BLANK_FIELD_NAME'] = 'Please enter for all fields a valid and unique field name!';
$MOD_ONEFORALL[$mod_name]['ERR_CONFLICT_WITH_RESERVED_NAME'] = 'The field name &quot;%s&quot; can not be used since it is reserved for a general placeholder.';
$MOD_ONEFORALL[$mod_name]['ERR_INVALID_FIELD_NAME'] = 'The field name &quot;%s&quot; is invalid! Allowed characters are a-z, A-Z, 0-9, . (dot), _ (underscore) and - (hyphen).';
$MOD_ONEFORALL[$mod_name]['ERR_FIELD_NAME_EXISTS'] = 'The field name &quot;%s&quot; is already used. Please try another one.';
$MOD_ONEFORALL[$mod_name]['ERR_FIELD_DISABLED'] = 'This field is disabled.';
$MOD_ONEFORALL[$mod_name]['ERR_FIELD_RE_ENABLE'] = 'You can either re-enable it or remove the placeholder from the template.';
$MOD_ONEFORALL[$mod_name]['ERR_FIELD_TYPE_NOT_EXIST'] = 'Sorry, this field type does not exist!';
$MOD_ONEFORALL[$mod_name]['ERR_SET_A_LABEL'] = 'Set a label';
$MOD_ONEFORALL[$mod_name]['ERR_INSTALL_MODULE'] = 'In order to use the field type &quot;%s&quot; you have to install the module &quot;%s&quot; and add at least one &quot;%s&quot; section.';

$GLOBALS['TEXT']['CAP_EDIT_CSS'] = 'Edit CSS';
?>