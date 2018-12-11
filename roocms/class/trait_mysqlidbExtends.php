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
 * Class MySqlExtends
 */
trait MySQLiDBExtends {

	# pages param
	public  $pages		= 0;	# [int]	Всего страниц
	public  $page		= 1;	# [int] Текущая страница
	public	$prev_page	= 0;	# [int] Предыдущая страница
	public	$next_page	= 0;	# [int] Следующая страница
	public 	$limit		= 15;	# [int] Число строк для запроса
	public  $from		= 0;	# [int] Стартовая позиция для запроса


	/**
	* Функция подсчета страниц
	*
	* @param mixed $from
	* @param mixed $cond
	* @param mixed $query
	*/
	public function pages_mysql($from, $cond="id!=0", $query="") {

		# Считаем
		$count = $this->count($from, "{$cond} {$query}");

		# Если товаров больше чем на одну страницу...
		if($count > $this->limit) {
			# Получаем кол-во страниц
			$this->pages = $count / $this->limit;
			# Проверяем полученное число на "целое" или "десятичное"
			if(mb_strpos($this->pages,".", 0, "utf8") !== false || mb_strpos($this->pages,",", 0,"utf8") !== false) {
				$this->pages++;
			}
			# Округляем
			$this->pages = (int) floor($this->pages);
		}

		# завершаем расчитывать переменные
		$this->claculate_page_vars();
	}


	/**
	* Функция для расчета страниц, на случай когда не используется mySql
	*
	* @param int $items - общее число элементов
	*/
	public function pages_non_mysql($items) {

		# Если товаров больше чем на одну страницу...
		if($items > $this->limit) {
			# Получаем кол-во страниц
			$this->pages = $items / $this->limit;
			# Проверяем полученное число на "целое" или "десятичное"
			if(mb_strpos($this->pages,".", 0, "utf8") !== false || mb_strpos($this->pages,",", 0, "utf8") !== false) {
				$this->pages++;
			}
			# Округляем
			$this->pages = (int) floor($this->pages);
		}

		# завершаем расчитывать переменные
		$this->claculate_page_vars();
	}


	/**
	 * Вспомогательная функция расчитывает переменные для управления постраничного листинга
	 */
	private function claculate_page_vars() {

		# Если у нас используется переменная страницы в строке запроса, неравная первой странице...
		if($this->pages > "1" && $this->page != 0) {
			# Округляем до целых, что бы не вызвать ошибки в скрипте.
			$this->page = (int) floor($this->page);

			# Если запрос не к нулевой странице и такая страница имеет право быть...
			if($this->page != "0" && $this->page <= $this->pages) {
				$this->from = (int) $this->limit * ($this->page - 1);
			}
		}

		# Если у нас в строке запроса указана страница, больше максимальной...
		if($this->page > $this->pages) {
			$this->page = $this->pages;
		}

		# Предыдущая и следующая страница
		if($this->page > 1) {
			$this->prev_page = $this->page - 1;
		}
		if($this->page < $this->pages) {
			$this->next_page = $this->page + 1;
		}
	}


	/**
	 * check connection pattern
	 *
	 * @return bool
	 */
	protected function connecting() {

		if($this->db_connect || DEBUGMODE) {
			$res = true;
		}
		else {
			$res = false;
		}

		return $res;
	}


	/**
	 * Check for adding AND rules for condition
	 *
	 * @param string $cond - condition
	 *
	 * @return string
	 */
	public function qcond_and($cond) {
		if(trim($cond) != "") {
			$cond .= " AND ";
		}

		return $cond;
	}


	/**
	 * Check for adding OR rules for condition
	 *
	 * @param string $cond - condition
	 *
	 * @return string
	 */
	public function qcond_or($cond) {
		if(trim($cond) != "") {
			$cond .= " OR ";
		}

		return $cond;
	}


	/**
	 * Abstract
	 *
	 * @param $from
	 * @param $proviso
	 *
	 * @return mixed
	 */
	abstract protected function count($from, $proviso);
}
