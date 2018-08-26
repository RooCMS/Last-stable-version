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
* @subpackage	Admin Control Panel
* @author       alex Roosso
* @copyright    2010-2019 (c) RooCMS
* @link         http://www.roocms.com
* @version      1.2
* @since        $date$
* @license      http://www.gnu.org/licenses/gpl-3.0.html
*/

//#########################################################
// Anti Hack
//---------------------------------------------------------
if(!defined('RooCMS') || !defined('ACP')) {
	die('Access Denied');
}
//#########################################################


/**
 * Class ACP_PAGES
 */
class ACP_Pages {

	# vars
	private $engine;	# [object] global structure operations
	private $unit;		# [object] for works content pages



	/**
	* Show must go on
	*
	*/
	public function __construct() {

		global $roocms, $get, $post, $tpl;

		require_once _CLASS."/class_structure.php";
		$this->engine = new Structure();


		# set object for works content
		if(isset($get->_page)) {
			switch($this->engine->page_type) {
				case 'html':
					require_once _ROOCMS."/acp/pages_html.php";
					$this->unit = new ACP_Pages_HTML;
					break;

				case 'php':
					require_once _ROOCMS."/acp/pages_php.php";
					$this->unit = new ACP_Pages_PHP;
					break;
			}
		}

		# action
		switch($roocms->part) {

			case 'edit':
				$this->unit->edit($this->engine->page_id);
				break;

			case 'update':
				if(isset($post->update_page)) {
					$this->unit->update($this->engine->page_id);
				}
				else {
					goback();
				}
				break;

			default:
				go(CP."?act=structure");
				break;
		}


		# output
		$tpl->load_template("pages");
	}
}

/**
 * Init class
 */
$acp_pages = new ACP_Pages;