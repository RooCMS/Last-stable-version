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
if(!defined('RooCMS') || (!defined('ACP') && !defined('INSTALL'))) {
	die('Access Denied');
}
//#########################################################


class ACP_Login {

	/**
	 * Проверяем введенные данные
	 */
	public function __construct() {

		global $db, $post, $security, $smarty, $tpl, $site, $logger;


		$smarty->assign("site", $site);


		# check
		if(isset($post->login, $post->password)) {

			if($db->check_id($post->login, USERS_TABLE, "login", "status='1' AND title='a'")) {

				$q = $db->query("SELECT uid, login, nickname, title, password, salt FROM ".USERS_TABLE." WHERE login='".$post->login."' AND status='1' AND title='a'");
				$data = $db->fetch_assoc($q);

				$dbpass = $security->hashing_password($post->password, $data['salt']);

				if($dbpass == $data['password']) {

					$_SESSION['uid'] 	= $data['uid'];
					$_SESSION['login'] 	= $data['login'];
					$_SESSION['title'] 	= $data['title'];
					$_SESSION['nickname'] 	= $data['nickname'];
					$_SESSION['token'] 	= $security->hashing_token($data['login'], $dbpass, $data['salt']);

					# log
					$logger->log("Пользователь успешно авторизовался в Панели управления");

					# go
					goback();
				}
			}

			# неверный логин или пароль
			$this->incorrect_entering($post->login, mb_strlen($post->password));
		}


		# load template
		$tpl->load_template("login");
	}


	/**
	 * Функция вывода сообщения о некоректной попытки входа
	 *
	 * @param string $login    - введенный логин
	 * @param string $password - введенный пароль
	 */
	private function incorrect_entering($login, $password) {

		global $smarty, $logger;

		# log
		$logger->log("Неудачная попытка авторизации - логин: ".$login." пароль: *".$password." символов*");

		session_destroy();

		sleep(3);
		$smarty->assign("error_login", "Неверный логин или пароль.");
	}
}

/**
 * Init Class
 */
$acplogin = new ACP_Login;
