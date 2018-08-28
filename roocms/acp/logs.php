<?php
/**
 * RooCMS - Open Source Free Content Managment System
 * @copyright © 2010-2018 alexandr Belov aka alex Roosso. All rights reserved.
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
if(!defined('RooCMS') || !defined('ACP')) {
	die('Access Denied');
}
//#########################################################


class ACP_Logs {

	/**
	 * ACP_Logs constructor.
	 */
	public function __construct() {

		global $roocms, $tpl;

		switch($roocms->part) {
			case 'phperror':
				$this->lowerrors();
				break;

			default:
				$this->lowerrors();
				break;
		}

		# отрисовываем шаблон
		$tpl->load_template("logs");
	}


	private function lowerrors() {

		global $tpl, $smarty;

		$data = file_read(ERRORSLOG);

		$error = [];
		$errors = explode("\r", $data);
		foreach($errors as $e) {
			if(trim($e) != "") {
				$error[] = explode("|", $e);
			}
		}

		$smarty->assign('error', $error);
		$content = $tpl->load_template("logs_lowerrors", true);
		$smarty->assign('content', $content);
	}
}

/**
 * Init Class
 */
$acp_logs = new ACP_Logs;