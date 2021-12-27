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


// prevent this file from being accessed directly
if (!defined('WB_PATH')) die(header('Location: ../../index.php'));

$PRECHECK = array();


/**
 * Specify required WBCE version
 * You need to provide at least the Version number (Default operator:= >=)
 */
$PRECHECK['WB_VERSION'] = array('VERSION' => '2.7', 'OPERATOR' => '>=');
#$PRECHECK['WB_VERSION'] = array('VERSION' => '2.7');


/**
 * Specify required PHP version
 * You need to provide at least the Version number (Default operator:= >=)
 */
#$PRECHECK['PHP_VERSION'] = array('VERSION' => '5.2.4');
$PRECHECK['PHP_VERSION'] = array('VERSION' => '4.3.11', 'OPERATOR' => '>=');


/**
 * Specify required PHP extension
 * Provide a simple array with the extension required by the module
 */
$PRECHECK['PHP_EXTENSIONS'] = array('gd');


/**
 * Specify required PHP INI settings
 * Provide a array with the setting and the expected value
 */
$PRECHECK['PHP_SETTINGS'] = array('safe_mode' => '0');


?>