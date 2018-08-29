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

# require special part for config
require_once "config_action.php";

class ACP_Config extends ACP_ConfigAction {

	# classes
	var $config;

	private $part = "global";



	/**
	* Start
	*
	*/
	public function __construct() {

		global $config, $tpl, $post;


		# include config class
		$this->config = $config;

		# Если есть запрос на обновление тогда обновляем
		if(isset($post->update_config))	{
			$this->update_config();
		}
		else {
			$this->view_config();
		}

		# Load Template
		$tpl->load_template("config");
	}


	/**
	* Показать настройки
	*
	*/
	private function view_config() {

		global $db, $smarty, $get;

		$parts = [];

		if(isset($get->_part) && $db->check_id($get->_part, CONFIG_PARTS_TABLE, "name") == 1) {
			$this->part = $get->_part;
		}
		//elseif(isset($get->_part) && $get->_part == "all") $this->part = "all";

		# запрос разделов конфигурации из БД
		$q_1 = $db->query("SELECT name, title, type, ico FROM ".CONFIG_PARTS_TABLE." ORDER BY type ASC, sort ASC");
		while($part = $db->fetch_assoc($q_1)) {

			# запрашиваем из БД опции
			if($this->part == $part['name']) {

				$this_part = $part;

				$q_2 = $db->query("SELECT id, title, description, option_name, option_type, variants, value, default_value, field_maxleight FROM ".CONFIG_TABLE." WHERE part='".$part['name']."' ORDER BY sort ASC");
				while($option = $db->fetch_assoc($q_2)) {

					# parse
					$option['option'] = $this->init_field($option['option_name'], $option['option_type'], $option['value'], $option['variants'], $option['field_maxleight']);

					# compile for output
					$this_part['options'][] = $option;
				}

				# tpl
				$smarty->assign('this_part', $this_part);
			}

			if($part['type'] == "global") {
				$parts['global'][] 	= $part;
			}
			if($part['type'] == "component") {
				$parts['component'][] 	= $part;
			}
		}

		# tpl
		$smarty->assign('parts',	$parts);
		$smarty->assign('thispart',	$this->part);
	}


	/**
	 * функция парсера опции для буфера
	 *
	 * @param string $option_name - имя поля
	 * @param string $option_type - тип поля
	 * @param string $value       - значение
	 * @param string $variants    - варианты (для селектов)
	 *
	 * @param int    $maxlength   - максимально допустимое количество символов в поле.
	 *
	 * @return string - подстановка в шаблон конфигуратора
	 */
	private function init_field($option_name, $option_type, $value, $variants, $maxlength=0) {

		global $tpl, $smarty, $parse;

		$field = array('name'=>$option_name, 'value'=>$value, 'type'=>$option_type, 'maxlength'=>$maxlength);
		$smarty->assign('field', $field);

		switch($option_type) {
			# integer OR string OR email
			case 'int':
			case 'integer':
			case 'string':
			case 'email':
			case 'color':
				$out = $tpl->load_template("config_field_string",true);
				break;

			# text OR textarea
			case 'text':
			case 'textarea':
				$out = $tpl->load_template("config_field_textarea",true);
				break;

			# html
			case 'html':
				$out = $tpl->load_template("config_field_html",true);
				break;

			# boolean
			case 'boolean':
			case 'bool':
				$out = $tpl->load_template("config_field_boolean",true);
				break;

			# date
			case 'date':
				$field['value'] = $parse->date->unix_to_rusint($field['value']);
				$out = $tpl->load_template("config_field_date",true);
				break;

			# select
			case 'select':
				$vars = explode("\n",$variants);
				foreach($vars AS $v) {
					$vars = explode("|",trim($v));

					$s = "";
					if($vars[1] == $value)  {
						$s = "selected";
					}

					$field['variants'][] = array('value'=>$vars[1], 'title'=>$vars[0], 'selected'=>$s);
				}

				$smarty->assign('field', $field);
				$out = $tpl->load_template("config_field_select",true);
				break;

			# image
			case 'image':
			case 'img':
				$image = [];
				if(is_file(_UPLOADIMAGES."/".$field['value'])) {
					$image['src'] = $field['value'];
					$size = getimagesize(_UPLOADIMAGES."/".$image['src']);
					$image['width'] = $size[0];
					$image['height'] = $size[1];
				}

				$smarty->assign("image", $image);
				$out = $tpl->load_template("config_field_image", true);
				break;

			default:
				$out = "Нераспознанный параметр";
				break;
		}

		return $out;
	}


	/**
	 * Функция обновления настроек
	 */
	private function update_config() {

		global $parse, $logger, $post, $img;

		# запрашиваем из БД типы опций и ограничений
		$cfg_vars = $this->get_cfg_vars();

		# if use special part
		$this->init_for_special_part();

		# Удаляем тех батоны "Сохранить настроки" итд
		unset($post->update_config);

		# Обновляем опции
		foreach($post AS $key=>$value) {

			$check = false;

			switch($cfg_vars[$key]['type']) {
				# integer
				case 'int':
				case 'integer':
					$value = round($value);
					settype($value, "integer");
					$check = true;
					break;

				# email
				case 'email':
					$check = $parse->valid_email($value);
					break;

				# text OR textarea OR html
				case 'string':
				case 'color':
				case 'text':
				case 'textarea':
				case 'html':
					$value = $this->check_string_value($value,$cfg_vars[$key]['maxleight']);
					$check = true;
					break;

				# boolean
				case 'boolean':
				case 'bool':
					if($value == "true" || $value == "false") {
						$check = true;
					}
					break;

				# date
				case 'date':
					$value = $parse->date->rusint_to_unix($post->$key);
					$check = true;
					break;

				# select
				case 'select':
					if(isset($cfg_vars[$key]['var'][$value])) {
						$check = true;
					}
					break;

				# image
				case 'image':
				case 'img':
					$image = $img->upload_image("image_".$key, "", array(), array("filename"=>$key, "watermark"=>false, "modify"=>false, "noresize"=>true));

					if(isset($image[0])) {
						if($value != "" && $value != $image[0]) {
							unlink(_UPLOADIMAGES."/".$value);
						}
						$value = $image[0];
						$check = true;
					}
					break;
			}

			# update db
			$this->update_db_config($check, $key, $value);
		}


		# notice
		$logger->info("Настройки обновлены", false);


		# move
		if(isset($post->cp_script) && CP != $post->cp_script) { // Если мы изменяли путь скрипта к панели управления.
			$path = getenv("HTTP_REFERER");
			$path = str_ireplace(CP, $post->cp_script, $path);

			unlink(_SITEROOT."/".CP);

			go($path);
		}

		# goback
		goback();
	}


	/**
	 * Update config in database
	 *
	 * @param bool   $check  - флаг проверки
	 * @param string $option - option name
	 * @param string $value  - option value
	 */
	private function update_db_config($check, $option, $value) {

		global $db, $logger;

		if($check) {
			$db->query("UPDATE ".CONFIG_TABLE." SET value='".$value."' WHERE option_name='".$option."'");

			# log
			$logger->log("Update config: option name=".$option.", value=".$value);
		}
	}


	/**
	 * Функция обработки строковых данных конфигуратора сайта
	 *
	 * @param string $value 	- Значение
	 * @param int    $maxleight	- Максимальная длина строки
	 *
	 * @return string
	 */
	private function check_string_value($value, $maxleight=0) {

		if($maxleight > 0) {
			$value = substr($value, 0, $maxleight);
		}

		return $value;
	}


	/**
	 * Функция запрашивает из БД типы опций и ограничений и возвращает их в массиве
	 *
	 * @return array
	 */
	private function get_cfg_vars() {

		global $db;

		$cfg_vars = [];
		$q = $db->query("SELECT option_name, option_type, variants, field_maxleight FROM ".CONFIG_TABLE);
		while($row = $db->fetch_assoc($q)) {

			$cfg_vars[$row['option_name']]['type'] 		= $row['option_type'];
			$cfg_vars[$row['option_name']]['maxleight'] 	= $row['field_maxleight'];

			if(trim($row['variants']) != "") {

				$vars = explode("\n",$row['variants']);

				foreach($vars AS $v) {
					$v = explode("|",trim($v));
					$cfg_vars[$row['option_name']]['var'][$v[1]] = trim($v[1]);
				}
			}
		}

		return $cfg_vars;
	}
}

/**
 * Init Class
 */
$acp_config = new ACP_Config;