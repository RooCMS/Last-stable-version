<?php
/**
 *   RooCMS - Open Source Free Content Managment System
 *   Copyright © 2010-2018 alexandr Belov aka alex Roosso. All rights reserved.
 *   Contacts: <info@roocms.com>
 *
 *   You should have received a copy of the GNU General Public License v3
 *   along with this program.  If not, see http://www.gnu.org/licenses/
 */

/**
 * @package      RooCMS
 * @subpackage	 User Control Panel
 * @author       alex Roosso
 * @copyright    2010-2019 (c) RooCMS
 * @link         http://www.roocms.com
 * @version      1.1.1
 * @since        $date$
 * @license      http://www.gnu.org/licenses/gpl-3.0.html
 */

//#########################################################
// Anti Hack
//---------------------------------------------------------
if(!defined('RooCMS') || !defined('UI')) {
	die('Access Denied');
}
//#########################################################


//#########################################################
// Initialisation User CP identification
//---------------------------------------------------------
if(!defined('UCP')) {
	define('UCP', true);
}
//#########################################################


nocache();

# Security check
require_once _UI."/ucp/security_check.php";

if($ucpsecurity->access) {
	if(file_exists(_UI."/ucp/".$roocms->act.".php")) {
		require_once _UI."/ucp/".$roocms->act.".php";
	}
	else {
		require_once _UI."/ucp/ucp.php";
	}
}
else {
	require_once _UI."/ucp/login.php";
}