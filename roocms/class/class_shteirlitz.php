<?php
/**
 * RooCMS - Open Source Free Content Managment System
 * Copyright © 2010-2018 alexandr Belov aka alex Roosso. All rights reserved.
 * Contacts: <info@roocms.com>
 *
 * You should have received a copy of the GNU General Public License v3
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */

/**
 * @package	RooCMS
 * @subpackage	Engine RooCMS classes
 * @author	alex Roosso
 * @copyright	2010-2019 (c) RooCMS
 * @link	http://www.roocms.com
 * @version	1.0
 * @license	http://www.gnu.org/licenses/gpl-3.0.html
 */


//#########################################################
// Anti Hack
//---------------------------------------------------------
if(!defined('RooCMS')) {
	die('Access Denied');
}
//#########################################################

class Shteirlitz {

	/**
	 * Шифруем
	 *
	 * @param        $str
	 * @param string $salt  - соль
	 * @param string $passw - пароль
	 *
	 * @return string
	 */
	public function encode($str, $passw="", $salt="") {
		return base64_encode($this->code($str, $passw, $salt));
	}


	/**
	 * Расшифровываем
	 *
	 * @param        $str
	 * @param string $salt  - соль
	 * @param string $passw - пароль
	 *
	 * @return data|int
	 */
	public function decode($str, $passw="", $salt="") {
		return $this->code(base64_decode($str), $passw, $salt);
	}


	/**
	 * Кодируем XOP
	 *
	 * @param        $str
	 * @param string $salt		- соль
	 * @param string $passw		- пароль
	 *
	 * @return data|int
	 */
	private function code($str, $passw="", $salt="") {

		$len = strlen($str);
		$n = $len > 100 ? 8 : 2;

		$gamma = '';
		while(strlen($gamma) < $len ) {
			$gamma .= substr(pack('H*', sha1($passw.$gamma.$salt)), 0, $n);
		}

		return $str^$gamma;
	}
}