<?php

/**
* @package	RooCMS
* @subpackage	Module
* @author	alex Roosso
* @copyright	2010-2015 (c) RooCMS
* @link		http://www.roocms.com
* @version	1.0
* @since	$date$
* @license	http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
*   RooCMS - Russian free content managment system
*   Copyright (C) 2010-2016 alex Roosso aka alexandr Belov info@roocms.com
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
*   Copyright (C) 2010-2016 alex Roosso (александр Белов) info@roocms.com
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


/**
 * Class Module_Auth
 */
class Module_Auth {

	public $title = "Авторизация пользователя";

	# vars
	private $userdata = array();


	# buffer out
	private $out = "";


	/**
	 * Start
	 */
	function Module_Auth() {

		global $tpl, $smarty;

		$this->get_userdata();


		# draw
		$smarty->assign("userdata", $this->userdata);
		$this->out .= $tpl->load_template("module_auth", true);
	}


	/**
	 * Функция получает данные о текущем пользователе и передает их в модуль
	 */
	private function get_userdata() {

		global $users;

		$this->userdata = array(
			'uid'		=> $users->uid,
			'gid'		=> $users->gid,
			'login'		=> $users->login,
			'nickname'	=> $users->nickname,
			'title'		=> $users->title
		);
	}


	/**
	 * Finish
	 */
	function __destruct() {
		echo $this->out;
	}
}


/**
 * Init class
 */
$module_auth = new Module_Auth;

?>