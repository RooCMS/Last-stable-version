<?php
/**
 * RooCMS - Open Source Free Content Managment System
 * @copyright © 2010-2020 alexandr Belov aka alex Roosso. All rights reserved.
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
 * Class Parser
 * $_POST / $_GET && other input data
 */
class Parser {

	# included classes
	public 	$text;				# [obj]		for parsing texts
	public 	$date;				# [obj]		for parsing date format

	# objects
	public 	$get;				# [obj]		$_GET data

	# uri params
	public 	$uri		= "";		# [string]	URI
	public	$uri_chpu	= false;	# [bool]	on/off flag for use (как ЧПУ по аглицки будет?)
	public	$uri_separator	= "/";		# [string]	URI seperator

	# notice
	public	$info		= "";		# [text]	information
	public	$error		= "";		# [text]	error message



	/**
	* Lets begin
	*
	*/
	public function __construct() {

		# process global arrays
		$this->parse_global_arrays();

		# process URI
		$this->get_uri();
		$this->parse_uri();

		# process URL
		$this->set_url_vars();

		# process notice for user
		$this->parse_notice();

		# endending this class
		require_once "class_parserText.php";
		$this->text = new ParserText;

		require_once "class_parserDate.php";
		$this->date = new ParserDate;
	}


	/**
	* Process global array
	*
	*/
	private function parse_global_arrays() {

		# $_GET
		settype($this->get, "object");
		if(!empty($_GET)) {
			$this->parse_get();
		}

		# $_POST
		if(!empty($_POST)) {
			$this->parse_post();
		}

		# init session data
		if(!empty($_SESSION)) {
			$this->get_session();
		}
	}


	/**
	* parse $_POST array
	*
	*/
	protected function parse_post() {

		global $post;

		$datapost = $this->check_array($_POST);

		foreach ($datapost as $key=>$value) {

			if(is_array($value)) {
				$value = $this->check_array($value);
				$post->{$key} = (array) $value;
			}
			else {
				$post->{$key} = (trim($value) != "") ? (string) $value : NULL ;
			}
		}

		unset($_POST);
	}


	/**
	* parse $_GET array
	*
	*/
	protected function parse_get() {

		$get = $this->check_array($_GET);

		foreach($get as $key=>$value) {

			# clear key
			$key = "_".$key;

			if(is_array($value)) {
				$value = $this->check_array($value);
				$this->get->{$key} = (array) $value;
			}
			else {
				$this->get->{$key} = (trim($value) != "") ? (string) $this->escape_string($value) : NULL ;
			}
		}
	}


	/**
	* Get session data
	*
	*/
	private function get_session() {

		global $roocms;

		$roocms->sess = $this->check_array($_SESSION);
	}


	/**
	 * Get URI and clear garbage
	 */
	private function get_uri() {

		# get uri
		$this->uri = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']);
		if(isset($_SERVER['REDIRECT_URL']) && trim($_SERVER['REDIRECT_URL']) != "") {
			$this->uri = str_replace($_SERVER['REDIRECT_URL'], "", $_SERVER['REQUEST_URI']);
		}

		/**
		 * Ex: friendly URL fix
		 */
		if($this->uri == "" && isset($_SERVER['REDIRECT_QUERY_STRING']) && trim($_SERVER['REDIRECT_QUERY_STRING']) != "") {
			$this->uri = "?".str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REDIRECT_QUERY_STRING']);
		}

		$this->uri = str_ireplace("\\","", $this->uri);
	}


	/**
	* Parser URI
	*
	*/
	private function parse_uri() {

		# explode uri
		$gets = explode("/",$this->uri);

		# calculate
		$c = count($gets);
		# if clear uri
		if($c > 2 && trim($gets[0]) == "") {

			# if detect frendly Url
			$this->uri_chpu = true;

			# handle
			for($el=1;$el<=$c-1;$el++) {
				if(trim($gets[$el]) != "") {

					$elp = $el + 1;

					if(trim($gets[$el]) != "" && isset($gets[$elp]) && trim($gets[$elp]) != "") {
						$gets[$el] = "_".$this->clear_string($gets[$el]);
						$this->get->{$gets[$el]} = (string) $this->escape_string($gets[$elp]);
						$el++;
					}
				}
			}
		}
	}


	/**
	 * transform uri if friendly URL
	 *
	 * @param string $url - URI
	 *
	 * @return string $uri
	 */
	public function transform_uri($url) {

		if($this->uri_chpu) {
			$url = str_ireplace(array('?','&','='), $this->uri_separator, $url);
		}

		return $url;
	}


	/**
	* Set global vars from url
	*
	*/
	protected function set_url_vars() {

		global $roocms, $db;

		# pages
		if(isset($this->get->_pg)) {
			$db->page = floor($this->get->_pg);
		}

		# act(ion) & part(ition) & move
		if(isset($this->get->_act)) {
			$roocms->act = $this->clear_string($this->get->_act);
		}

		if(isset($this->get->_part)) {
			$roocms->part = $this->clear_string($this->get->_part);
		}

		if(isset($this->get->_move)) {
			$roocms->move = $this->clear_string($this->get->_move);
		}

		# check query RSS Export
		if(isset($this->get->_export)) {
			$roocms->rss = true;
		}

		# check ajax flag
		if(isset($this->get->_ajax)) {
			$roocms->ajax = true;
		}
	}


	/**
	 * Clear keys from global vars
	 *
	 * @param string $string - имя ключа
	 *
	 * @return string clear $key
	 */
	public function clear_string($string) {

		$string = trim(str_ireplace(array('?','!','@','#','$','%','^','&','*','(',')','{','}','[',']','|','<','>','/','\\','"','`','.',',','~','=',';'), '', $string));

		return $string;
	}


	/**
	 * Escape special String
	 *
	 * @param      $string
	 * @param bool $key
	 *
	 * @return string|array
	 */
	public function escape_string($string, $key=true) {
		global $db;

		if(!is_array($string)) {

			if($key) {
				$string = str_replace('\\','',$string);
			}
			else {
				$string = addslashes($string);
			}

			$string = $db->escape_string($string);
			$string = str_ireplace('\&','&',$string);
			$string = trim($string);
		}

		return $string;
	}


	/**
	 * Check array & clear
	 *
	 * @param $array
	 *
	 * @return array
	 */
	public function check_array($array) {

		$arr = [];

		foreach($array as $key=>$value)	{
			if(is_array($value)) {
				$subarr	= $this->check_array($value);
				$arr[$key] = $subarr;
			}
			else {
				# clear key
				$key	= str_replace("'","",$key);
				$key 	= $this->escape_string($key);

				# clear value
				$value 	= $this->escape_string($value, false);

				$arr[$key] = (trim($value) != "") ? $value : NULL ;
			}
		}

		return $arr;
	}


	/**
	 * Parse NOTICE Massages
	 *
	 */
	public function parse_notice() {

		global $roocms, $debug;

		# Notice
		if(isset($roocms->sess['info'])) {
			foreach($roocms->sess['info'] AS $value) {
				$this->info .= "<i class='fa fa-info-circle fa-fw'></i> {$value}<br />";
			}

			# kill
			unset($_SESSION['info']);
		}

		# Errors
		if(isset($roocms->sess['error'])) {
			foreach($roocms->sess['error'] AS $value) {
				$this->error .= "<i class='fa fa-exclamation-triangle fa-fw'></i> {$value}<br />";
			}

			# kill
			unset($_SESSION['error']);
		}

		# Critical errors in PHP
		if(!empty($debug->nophpextensions)) {
			foreach($debug->nophpextensions AS $value) {
				$this->error .= "<b><span class='fa fa-exclamation-triangle fa-fw'></span> КРИТИЧЕСКАЯ ОШИБКА:</b> Отсутсвует PHP расширение - {$value}. Работа RooCMS нестабильна!";
			}
		}
	}


	/**
	 * Validate email
	 *
	 * @param string $email - email
	 *
	 * @return bool
	 */
	public function valid_email($email) {

		$pattern = '/^[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?\.[A-Za-z0-9]{2,6}$/';

		return (bool) preg_match($pattern, trim($email));

	}


	/**
	 * Validate phone
	 *
	 * will be confirmed:
	 *      Code country with plus and none
	 *      Without code country
	 *      City code from 3 to 5 num with hooks and without hook
	 *      Phone number from 5 to 7 number
	 *      special symbols (hyphen, spaces) counted but may be skipped
	 * Example:
	 *      +1 (5555) 555-55-55
	 *      +1 5555 5555555
	 *      55555555555
	 *
	 * @param mixed $phone - phone number
	 *
	 * @return bool
	 */
	public function valid_phone($phone){

		$pattern = "/^[\+]?[0-9]?(\s)?(\-)?(\s)?(\()?[0-9]{3,5}(\))?(\s)?(\-)?(\s)?[0-9]{1,3}(\s)?(\-)?(\s)?[0-9]{2}(\s)?(\-)?(\s)?[0-9]{2}\Z/";

		return (bool) preg_match($pattern, trim($phone));

	}


	/**
	 * Get percent from N
	 *
	 * @param int $n    - %
	 * @param int $from - number from which we calculate %
	 *
	 * @return float
	 */
 	public function percent($n,$from) {

		$percent = ($n / $from) * 100;
		$percent = round($percent);

		return $percent;
	}


	/**
	 * Convert hex color to decimal color
	 *
	 * @param string $hexcolor - color HEX. Example: #A9B7D3
	 *
	 * @return array|false
	 */
	public function cvrt_color_h2d($hexcolor) {
		if(mb_strlen($hexcolor) != 7 || mb_strpos($hexcolor, "#") === false) {
			return false;
		}

		return array(	"r" => hexdec(mb_substr($hexcolor, 1, 2)),
				"g" => hexdec(mb_substr($hexcolor, 3, 2)),
				"b" => hexdec(mb_substr($hexcolor, 5, 2))
			    );
	}
}
