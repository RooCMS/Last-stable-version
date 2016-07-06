<?php
/**
 * @package      RooCMS
 * @subpackage	 Engine RooCMS classes
 * @author       alex Roosso
 * @copyright    2010-2017 (c) RooCMS
 * @link         http://www.roocms.com
 * @version      1.0
 * @since        $date$
 * @license      http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 *   RooCMS - Russian free content managment system
 *   Copyright (C) 2010-2017 alex Roosso aka alexandr Belov info@roocms.com
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see http://www.gnu.org/licenses/
 *
 *
 *   RooCMS - Русская бесплатная система управления сайтом
 *   Copyright (C) 2010-2017 alex Roosso (александр Белов) info@roocms.com
 *
 *   Это программа является свободным программным обеспечением. Вы можете
 *   распространять и/или модифицировать её согласно условиям Стандартной
 *   Общественной Лицензии GNU, опубликованной Фондом Свободного Программного
 *   Обеспечения, версии 3 или, по Вашему желанию, любой более поздней версии.
 *
 *   Эта программа распространяется в надежде, что она будет полезной, но БЕЗ
 *   ВСЯКИХ ГАРАНТИЙ, в том числе подразумеваемых гарантий ТОВАРНОГО СОСТОЯНИЯ ПРИ
 *   ПРОДАЖЕ и ГОДНОСТИ ДЛЯ ОПРЕДЕЛЁННОГО ПРИМЕНЕНИЯ. Смотрите Стандартную
 *   Общественную Лицензию GNU для получения дополнительной информации.
 *
 *   Вы должны были получить копию Стандартной Общественной Лицензии GNU вместе
 *   с программой. В случае её отсутствия, посмотрите http://www.gnu.org/licenses/
 */

//#########################################################
// Anti Hack
//---------------------------------------------------------
if(!defined('RooCMS')) die('Access Denied');
//#########################################################


class Logger {

	# сток
	private	$log = array();


	
	/**
	 * Logger constructor.
	 */
	function __construct() {
		# регистрируем обработчик записи логов
		register_shutdown_function(array($this,'save'));
	}

	/**
	 * Записываем ошибку
	 *
	 * @param $subj
	 */
	public function error($subj) {
		$_SESSION['error'][] = $subj;
		$this->log($subj, "error");
	}


	/**
	 * Записываем информационное сообщение
	 *
	 * @param $subj
	 */
	public function info($subj) {
		$_SESSION['info'][] = $subj;
		$this->log($subj, "info");
	}


	/**
	 * Добавляем запись в лог
	 *
	 * @param        $subj
	 * @param string $type
	 */
	public function log($subj, $type="log") {

		# обезопасим на всякий случай
		if($type != "info" && $type != "error") $type="log";

		$this->log[] = array("subj" => $subj, "type"=>$type);
	}


	/**
	 * Save log into database
	 */
	public function save() {

		global $db;

		if(!empty($this->log)) {

			$dump = "";
			$uid = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : 0 ;

			foreach($this->log AS $value) {
				if(trim($dump) != "") $dump .= ", ";
				$dump .= "('".$uid."', '".$value["subj"]."', '".$value["type"]."', '".time()."')";
			}

			$db->query("INSERT INTO ".LOG_TABLE." (uid, message, type_log, date_log) VALUES ".$dump);
		}
	}
}

?>