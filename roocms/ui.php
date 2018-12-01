<?php
/**
 * RooCMS - Open Source Free Content Managment System
 * @copyright © 2010-2019 alexandr Belov aka alex Roosso. All rights reserved.
 * @author    alex Roosso <info@roocms.com>
 * @link      http://www.roocms.com
 * @license   http://www.gnu.org/licenses/gpl-3.0.html
 *
 * You should have received a copy of the GNU General Public License v3
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */


//#########################################################
// Anti Hack
//---------------------------------------------------------
if(!defined('RooCMS')) {
	die('Access Denied');
}
//#########################################################


//#########################################################
// Initialisation User CP identification
//---------------------------------------------------------
if(!defined('UI')) {
	define('UI', true);
}
//#########################################################


nocache();

/**
 * Init Blocks & Modules
 */
if(!class_exists("Blocks"))  {
	require_once "site_blocks.php";
}
if(!class_exists("Modules")) {
	require_once "site_modules.php";
}

# init partition
if(trim($roocms->part) != "") {
	if(is_file(_UI."/".$roocms->part.".php")) {
		require_once _UI."/".$roocms->part.".php";
		$structure->page_meta_title = $structure->page_title;
	}
	else {
		go("/");
	}
}