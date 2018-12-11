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
 * Class Tags
 */
class Tags {


	/**
	 * Функция возвращает ввиде массива полный список тегов
	 *
	 * @param bool   $with_zero - Если флаг true, то вернет список тегов включая, нулевые значения. Иначе вернет только используемые теги.
	 * @param int    $limit     - Кол-во тегов (срез) которые вернет запрос
	 *
	 * @return array
	 */
	public function list_tags($with_zero=false, $limit=0) {

		global $db;

		# condition
		$cond = "amount != '0' ";
		if($with_zero) {
			$cond = " amount > '0' ";
		}

		# limit condition
		$lcond = "";
		if($limit > 0) {
			$lcond = " LIMIT 0,".$limit;
		}

		# query
		$tags = [];
		$q = $db->query("SELECT title, amount FROM ".TAGS_TABLE." WHERE ".$cond." ORDER BY amount DESC ".$lcond);
		while($data = $db->fetch_assoc($q)) {
			$tags[] = $data;
		}

		return $tags;
	}


	/**
	 * Функция собирает теги объекта в строку разделенные запятыми.
	 *
	 * @param string|array $linkedto - ссылка на объект
	 *
	 * @return array
	 */
	public function read_tags($linkedto) {

		global $db;

		if(!is_array($linkedto)) {
			$linkedto = array($linkedto);
		}

		# create condition
		$cond = "";

		foreach($linkedto AS $value) {
			$cond = $db->qcond_or($cond);
			$cond .= " l.linkedto='".$value."' ";
		}


		if($cond != "") {
			$cond = " (".$cond.")";
		}
		else {
			$cond .= " l.linkedto='0' ";
		}


		$tags = [];
		$q = $db->query("SELECT l.tag_id, t.title, t.amount, l.linkedto FROM ".TAGS_LINK_TABLE." AS l LEFT JOIN ".TAGS_TABLE." AS t ON (t.id = l.tag_id) WHERE".$cond." ORDER BY t.title ASC");
		while($data = $db->fetch_assoc($q)) {
			$tags[] = $data;
		}

		# return
		return $tags;
	}


	/**
	 * Функция собирает теги к объектам лент
	 *
	 * @param array $resarray - выходной массив, к которому добавляются теги
	 * @param array $taglinks - массив с ссылками на теги по которому осуществляется сбор
	 *
	 * @return array
	 */
	public function collect_tags(array $resarray, array $taglinks) {

		if(!empty($taglinks)) {
			$alltags = $this->read_tags($taglinks);
			foreach((array)$alltags AS $value) {
				$lid = explode("=",$value['linkedto']);
				$resarray[$lid[1]]['tags'][] = array("tag_id"=>$value['tag_id'], "title"=>$value['title']);
			}
		}

		return $resarray;
	}


	/**
	 * Функция сохраняет теги в БД
	 *
	 * @param string $tags     - строка с тегами разделенными запятой
	 * @param string $linkedto - ссылка на объект
	 */
	public function save_tags($tags, $linkedto) {

		global $db;

		# Получаем текущие теги и разбираем
		$now_tags = array_map(array($this, "get_tag_title"), $this->read_tags($linkedto));

		# Разбираем строку с полученными тегами
		$new_tags = $this->parse_tags($tags);

		# Сравниваем старые и новые теги, манипулируем.
		$tags = $this->diff_tag($now_tags, $new_tags, $linkedto);

		# Если есть теги
		if(!empty($tags)) {
			$v = $db->check_array_ids($tags, TAGS_TABLE, "title");

			foreach($tags AS $value) {
				if($v[$value]['check']) {
					# Добавляем линк к уже имеющимуся тегу
					$this->add_instock_tag($v[$value]['id_value'], $linkedto);
				}
				else {
					# Создаем новый тег и линк к нему
					$this->add_new_tag($v[$value]['value'], $linkedto);
				}
			}
		}
	}


	/**
	 * Функция проводит сравнении данных в массивах определя какие теги трогать, как пропустить
	 *
	 * @param array  $now      - массив с имеющимися у объекта тегами
	 * @param array  $new      - массив с новыми тегами
	 * @param string $linkedto - ссылка на объект
	 *
	 * @return array
	 */
	public function diff_tag(array $now, array $new, $linkedto) {

		$tags = [];

		if(empty($new)) {     // Если теги удалили...
			$this->remove_tags($now, $linkedto);
		}
		elseif(empty($now)) { // Если тегов не было, то дальнейшие обработки не нужны. Возвращаем список новых тегов.
			$tags = $new;
		}
		else {                // Если в массивах есть что, проводим сравнение
			$tags = $new;

			# массив для устаревших тегов
			$old = [];

			foreach($now AS $value) {
				if(!in_array($value, $new)) {
					$old[] = $value;
				}

				if(($k = array_search($value, $new)) !== false) {
					unset($tags[$k]);
				}
			}

			# Удаляем ненужные теги
			$this->remove_tags($old, $linkedto);
		}

		# возвращаем список новых/обновленных тегов
		return $tags;
	}


	/**
	 * Добавляем новый Тег
	 *
	 * @param string $tag      - Тег
	 * @param string $linkedto - Указатель к чему прикреплен данный тег
	 */
	private function add_new_tag($tag, $linkedto) {

		global $db;

		# create
		$db->query("INSERT INTO ".TAGS_TABLE." (title, amount) VALUES ('".$tag."', '1')");
		$tag_id = $db->insert_id();

		# linked
		$this->add_instock_tag($tag_id, $linkedto);
	}


	/**
	 * Добавляем Тег, который уже используется на сайте.
	 *
	 * @param int    $tag_id   - Идентификатор теша
	 * @param string $linkedto - Указатель к чему прикреплен данный тег
	 */
	private function add_instock_tag($tag_id, $linkedto) {

		global $db;

		# linked
		$db->query("INSERT INTO ".TAGS_LINK_TABLE." (tag_id, linkedto) VALUES ('".$tag_id."', '".$linkedto."')");

		# recount
		$this->recount_tag($tag_id);
	}


	/**
	 * Функция удаляет теги у заданного объекта.
	 *
	 * @param array|string $tags     - массив или строка с тегами
	 * @param string       $linkedto - ссылка на объект
	 */
	private function remove_tags($tags, $linkedto) {

		global $db;

		# Если получили строку, преобразуем ее в массив.
		if(!is_array($tags)) {
			$tags = $this->parse_tags($tags);
		}

		# Если массив не пустой.
		if(!empty($tags)) {

			# составляем условие
			$cond1 = "";
			foreach($tags AS $value) {
				$cond1 = $db->qcond_or($cond1);
				$cond1 .= "title='".$value."'";
			}

			# get tag id for condition unlinks
			$tr = [];
			$cond2 = "";
			$q = $db->query("SELECT id FROM ".TAGS_TABLE." WHERE ".$cond1);
			while($data = $db->fetch_assoc($q)) {
				$cond2 = $db->qcond_or($cond2);
				$cond2 .= "tag_id='".$data['id']."'";

				$tr[] = $data['id'];
			}
			$cond2 = "(".$cond2.")";

			# unlinked
			$db->query("DELETE FROM ".TAGS_LINK_TABLE." WHERE ".$cond2." AND linkedto='".$linkedto."'");

			# recount
			foreach($tr AS $v) {
				$this->recount_tag($v);
			}
		}
	}


	/**
	 * Функция парсит и форматирует строку с тегами разделенными запятыми и преобразует её в массив.
	 *
	 * @param string $tags     - строка с тегами разделенными запятой
	 *
	 * @return array возврашает массив с тегами
	 */
	private function parse_tags($tags) {

		global $parse;

		# check
		$strtag = array_unique($parse->check_array(explode(",",mb_strtolower($tags))));

		$tag = [];
		foreach($strtag as $value) {
			if(trim($value) != "") {
				# чистим от мусорных символов
				$tag[] = $parse->clear_string($value);
			}
		}

		return $tag;
	}


	/**
	 * Пересчитываем кол-во использований тега.
	 *
	 * @param int $tag_id - Идентификатор Тега
	 * @param int $amount - кол-во на текущий момент, если известно
	 */
	private function recount_tag($tag_id, $amount=-1) {

		global $db;

		# считаем
		$c = $db->count(TAGS_LINK_TABLE, "tag_id='".$tag_id."'");

		# обновляем если кол-во изменилось
		if(round($amount) != $c) {
			$db->query("UPDATE ".TAGS_TABLE." SET amount='".$c."' WHERE id='".$tag_id."'");
		}
	}


	/**
	 * Функция для array_map, которая вернет названия тега.
	 *
	 * @param $tag
	 *
	 * @return mixed
	 */
	static public function get_tag_title($tag) {

		return $tag['title'];
	}
}
