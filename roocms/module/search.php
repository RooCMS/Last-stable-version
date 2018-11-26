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


/**
 * Class Module_Search
 */
class Module_Search {

	# Название
	public $title = "Поиск";

	# buffer out
	private $out = "";


	/**
	 * Start
	 */
	public function __construct() {

		global $tpl, $smarty;

		// TODO: В конфиг
		$minleight = 3;

		# template
		$smarty->assign("minleight", $minleight);
		$this->out .= $tpl->load_template("module_search", true);

		# finish
		echo $this->out;
	}
}

/**
 * Init class
 */
$module_search = new Module_Search;