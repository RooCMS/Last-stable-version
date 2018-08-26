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
* @subpackage	User Control Panel
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
if(!defined('RooCMS') || !defined('UI') || !defined('UCP')) {
	die('Access Denied');
}
//#########################################################


class UCP_CP {


	/**
	 * Init
	 */
	public function __construct() {

		global $structure, $roocms;

		# title
		$structure->page_title = "Личный кабинет";

		# move
		switch($roocms->move) {
			case 'edit_info':
				$this->edit_info();
				break;

			case 'update_info':
				$this->update_info();
				break;

			case 'mailing':
				$this->mailing();
				break;

			//case 'ummailing':
			//	$this->unmailing();
			//	break;

			default:
				$this->cp();
				break;
		}

		# breadcumb
		$structure->breadcumb[] = array('part'=>'ucp', 'act'=>'ucp', 'title'=>'Личный кабинет');
	}


	/**
	 * Функция главной страницы личного кабинета пользователя
	 */
	private function cp() {

		global $users, $tpl, $smarty;

		# tpl
		$smarty->assign("userdata", $users->userdata);
		$tpl->load_template("ucp");
	}


	/**
	 * Функция редактирования личных данных
	 */
	private function edit_info() {

		global $structure, $users, $parse, $tpl, $smarty;

		# title
		$structure->page_title = "Изменяем личные данные";

		# breadcumb
		$structure->breadcumb[] = array('part'=>'ucp', 'act' => 'ucp', 'title'=>'Изменяем личные данные');

		# tpl
		$users->userdata['user_slogan_edit'] = $parse->text->clearhtml($users->userdata['user_slogan']);
		$smarty->assign("userdata", $users->userdata);
		$tpl->load_template("ucp_edit_info");
	}


	/**
	 * Функция обновляет личные данные пользователя
	 */
	private function update_info() {

		global $db, $config, $post, $img, $parse, $logger, $users, $site, $tpl, $smarty;

		$query = "";

		# login
		if(isset($post->login)) {

			$post->login = mb_strtolower($parse->text->transliterate($post->login));

			if(!$users->check_field("login", $post->login, $users->userdata['login'])) {
				$logger->error("Ваш логин не был изменен. Возможно использование такого логина невозможно, попробуйте выбрать другой логин");
			}
		}
		else {
			$logger->error("Вы не указали логин.");
		}

		# nickname
		if(isset($post->nickname)) {
			if(!$users->check_field("nickname", $post->nickname, $users->userdata['nickname'])) {
				$logger->error("Такой псевдоним уже имеется у одного из пользователей. Пожалуйста, выберите другой псевдоним.");
			}
		}
		else {
			$logger->error("Вы не указали псевдоним.", false);
		}

		# email
		if(isset($post->email) && $parse->valid_email($post->email)) {
			if(!$users->check_field("email", $post->email, $users->userdata['email'])) {
				$logger->error("Указанный email уже существует в Базе Данных!");
			}
		}
		else {
			$logger->info("Вы не указали электронную почту (или указали в некорректном формате), поэтому мы сохранили ту, что была указана ранее.<br />На эту почту вам будут приходить уведомления с сайта. В случае если вы забудете свой пароль, восстановить его можно будет с помошью указанной почты.", false);
		}

		# personal data
		$users->correct_personal_data();

		# avatar
		if(isset($post->delete_avatar)) {
			$users->delete_avatar($users->uid);
			$query .= "avatar='', ";
		}

		$av = $img->upload_image("avatar", "", array($config->users_avatar_width, $config->users_avatar_height), array("filename"=>"av_".$users->uid, "watermark"=>false, "modify"=>false));
		if(isset($av[0])) {
			if($users->avatar != "" && $users->avatar != $av[0]) {
				unlink(_UPLOADIMAGES."/".$users->avatar);
			}
			$query .= "avatar='".$av[0]."', ";
		}

		# update
		if(!isset($_SESSION['error'])) {
			# password
			if(isset($post->password)) {
				$salt = $users->create_new_salt();
				$password = $users->hashing_password($post->password, $salt);

				$query .= "password='".$password."', salt='".$salt."', ";
			}

			$db->query("UPDATE ".USERS_TABLE." SET 
								login = '".$post->login."',
								nickname = '".$post->nickname."',
								email = '".$post->email."',
								mailing = '".$post->mailing."',
								".$query." 
								user_name = '".$post->user_name."',
								user_surname = '".$post->user_surname."',
								user_last_name = '".$post->user_last_name."',
								user_birthdate = '".$post->user_birthdate."',
								user_sex='".$post->user_sex."',
								user_slogan='".$post->user_slogan."',
								date_update='".time()."' 
							WHERE uid='".$users->userdata['uid']."'");

			# notice
			$logger->info("Ваши данные успешно обновлены.", false);

			# Уведомление пользователю на электропочту
			$smarty->assign("login", $post->login);
			$smarty->assign("nickname", $post->nickname);
			$smarty->assign("email", $post->email);
			$smarty->assign("password", $post->password);
			$smarty->assign("site", $site);
			$message = $tpl->load_template("email_update_userinfo", true);

			sendmail($post->email, "Ваши данные на \"".$site['title']."\" были обновлены", $message);

			# go out
			go(SCRIPT_NAME."?part=ucp&act=ucp");
		}
		else {
			goback();
		}
	}


	/**
	 * Быстрая подписка на рассылку
	 */
	private function mailing() {

		global $db, $users, $logger;

		# update
		$db->query("UPDATE ".USERS_TABLE." SET mailing = '1', date_update='".time()."' WHERE uid='".$users->userdata['uid']."'");

		# notice
		$logger->info("Спасибо, что подписались на рассылку.", false);

		# go
		goback();
	}
}

/**
 * Init Class
 */
$ucpcp = new UCP_CP;