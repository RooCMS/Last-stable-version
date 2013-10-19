<?php
/**
* @package	RooCMS
* @subpackage	Engine RooCMS classes
* @subpackage	Debug Class
* @author	alex Roosso
* @copyright	2010-2014 (c) RooCMS
* @link		http://www.roocms.com
* @version	2.0.1
* @since	$date$
* @license	http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
*   RooCMS - Russian free content managment system
*   Copyright (C) 2010-2014 alex Roosso aka alexandr Belov info@roocms.com
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
*   along with this program.  If not, see <http://www.gnu.org/licenses/
*
*
*   RooCMS - Русская бесплатная система управления сайтом
*   Copyright (C) 2010-2014 alex Roosso (александр Белов) info@roocms.com
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
* Инициализируем класс отладки
*
* @var Debug
*/
$debug = new Debug;

/**
* Класс отладки
*/
class Debug {

	# vars
	public	$show_debug 		= false;		# [bool] 	show full debug text
	public	$debug_info 		= "";			# [text] 	buffer for debug info text
	private	$debug_dump		= array();		# [array]	Дамп с данными отладки, для разработчика.
	public	$phpextensions		= array();		# [array]	Список установленных PHP расширений
	public	$nophpextensions	= array();		# [array]	Список отсуствующих PHP приложений, требуемых для RooCMS

	private	$starttime		= 0;
	public	$productivity_time	= 0;

	private	$memory_usage		= 0;
	public	$productivity_memory	= 0;
	public	$memory_peak_usage	= 0;

	# requirement
	private $reqphpext		= array("Core",		# [array]	Обязательные php расширения для работы RooCMS
						"calendar",
						"date",
						"pcre",
						"session",
						"xml",
						"gd",
						"mbstring",
						"standard",
						"SimpleXML",
						"apache2handler",
						"mysql");


	/**
	* Запускаем класс
	*
	*/
	function __construct() {

		# устанавливаем перехватчик ошибок
		@set_error_handler(array($this,'debug_critical_error'));


                if(!defined('DEBUGMODE')) 	define('DEBUGMODE', true);
                if(!defined('DEVMODE')) 	define('DEVMODE', true);


        	# Для админа всегда показываем ошибки и замеряем время выполнения RooCMS
		if(DEBUGMODE || defined('ACP') || defined('INSTALL')) {
			# start Debug timer
			$this->start_productivity();

			# Проверяем наличие требуемых PHP расширений
			$this->check_phpextensions();

			# try show error
			$this->error_report(true);
		}
		else $this->error_report(false);
	}


	/**
	* Запускаем таймер подсчета времени выполнения скрипта
	*
	*/
        private function start_productivity() {

    	        # timer
                $mtime = STARTTIME;
                $mtime = explode(' ', $mtime);
                $mtime = $mtime[1] + $mtime[0];
                $this->starttime = $mtime;

                # memory
                $this->memory_usage = MEMORYUSAGE;
        }


	/**
	* Останавливаем таймер подсчета времени выполнения скрипта
	*
	*/
        public function end_productivity() {

    	        # timer
                $mtime = microtime();
                $mtime = explode(' ', $mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $totaltime = round(($endtime - $this->starttime), 4);

	        $this->productivity_time = $totaltime;

	        # memory
	        $this->productivity_memory 	= memory_get_usage() - $this->memory_usage;
	        $this->memory_peak_usage 	= memory_get_peak_usage();
        }


	/**
	* Проверяем наличие требуемых PHP расширений
	*
	*/
	private function check_phpextensions() {

		$this->phpextensions = get_loaded_extensions();

		foreach($this->reqphpext AS $k=>$v) {
			if(!in_array($v, $this->phpextensions)) $this->nophpextensions[] = $v;
		}
	}


        /**
        * Перехватчик системных ошибок
        *
        * @param mixed $errno - Номер ошибки
        * @param mixed $msg   - Сообщение об ошибке
        * @param mixed $file  - Имя файла с ошбкой
        * @param mixed $line  - Номер строки с ошибкой
        */
	public static function debug_critical_error($errno, $msg, $file, $line, $context) {

                // Записываем ошибку в файл
                $file_error = _LOGS."/errors.log";
		$subj = "";

                if(file_exists($file_error)) {
			$f = file($file_error);
	                foreach($f AS $v) {
        		        $subj .= $v;
	                }
                }

                switch($errno) {	// Для "умников" - E_CORE_ERROR не вписываем, потому что, до выполнения этого скрипта дело не дойдет. А дойдет, значит не E_CORE_ERROR
        	        case E_ERROR:			# critical
        		        $erlevel = 0; $ertitle = "Критическая ошибка";
        		        break;

        	        case E_USER_ERROR:		# critical
        		        $erlevel = 0; $ertitle = "Критическая пользовательская ошибка";
        		        break;

        	        case E_RECOVERABLE_ERROR :	# warning(?)critical
        		        $erlevel = 1; $ertitle = "Критическая ошибка в работе ПО";
        		        break;

        	        case E_WARNING:			# warning
        		        $erlevel = 1; $ertitle = "Некритическая ошибка";
        		        break;

        	        case E_USER_WARNING:		# warning
        		        $erlevel = 1; $ertitle = "Некритическая пользовательская ошибка";
        		        break;

        	        case E_CORE_WARNING:		# warning
        		        $erlevel = 1; $ertitle = "Некритическая ошибка ядра";
        		        break;

        	        case E_COMPILE_WARNING:		# warning
        		        $erlevel = 1; $ertitle = "Некритическая ошибка Zend";
        		        break;

        	        case E_NOTICE:			# notice
        		        $erlevel = 2; $ertitle = "Ошибка";
        		        break;

        	        case E_USER_NOTICE:		# notice
        		        $erlevel = 2; $ertitle = "Пользователская ошибка";
        		        break;

        	        default:			# unknown
        		        $erlevel = 3; $ertitle = "Неизвестная ошибка";
        		        break;
                }

                if($erlevel == 0) register_shutdown_function(array($this,'shotdown'), "debug");

        	$time = date("d.m.Y H:i:s");

		$subj .= $time."\t|\tPHPError\t|\t".$ertitle."\t|\t[ #".$errno." ] ".$msg." (Строка: ".$line." в файле ".$file.")\r\n";
		#foreach($context AS $k=>$v)	$subj .= "\t\t".$k." - ".$v."\r\n";

		$f = fopen($file_error, "w+");
		if(is_writable($file_error)) {
			fwrite($f, $subj);
		}
		fclose($f);

		# Не будем ничего выводить, если нам приказано скрыть ошибки.
		if(error_reporting() == 0) {
        	        if($erlevel == 0) die(CRITICAL_STYLESHEETS."<blockquote>Извините, что то пошло не так. Мы уже работаем над устранением причин.<small>".$time."</small></blockquote>");
        	        else return;
		}

                echo CRITICAL_STYLESHEETS."
                <div class='alert alert-danger t12 text-left in fade col-md-10 col-md-offset-1' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	        ОШИБКА: <b>#{$errno} - {$ertitle}</b>
	        <br />Строка: <b>{$line}</b> в файле <b>{$file}</b>
	        <br /><b>{$msg}</b>
		</div>\n";

		# Убиваем стандартный обработчик, что бы он ничего не выдал шпиёну (:
		return true;
	}


        /**
        * Функция включения/отключения протоколирования ошибок
        *
        * @param boolean $show - флаг включает/выключает ошибки
        */
	private static function error_report($show = false) {
		if($show) {
			error_reporting(E_ALL);				#8191
			ini_set("display_startup_errors",	1);
			ini_set("display_errors",		1);
			ini_set("html_errors",			1);
			ini_set("report_memleaks",		1);
			ini_set("track_errors",			1);
			ini_set("log_errors",			1);
			ini_set("log_errors_max_len",		2048);
			ini_set("ignore_repeated_errors",	1);
			ini_set("ignore_repeated_source",	1);
			ini_set("error_log",			_LOGS."/php_error.log");
		}
		else {
			error_reporting(0);
		}
	}


        /**
        * Функция отладки
        *
        * @param mixed $var     - Переменная для отладки
        * @param mixed $expand  - Флаг развернутого вида
        * @return mixed - Функция выводит на экран дамп переменной $var
        */
	public function debug($var, $expand=false) {
                static $use = 1;

                # регестрируем шотдаун
    	        if($use == 1 && $expand) {
        	        register_shutdown_function(array($this,'shotdown'), "debugexpand");

			ob_start();
				debug_print_backtrace();
				$backtrace = ob_get_contents();
			ob_end_clean();

			$this->debug_dump['backtrace'] = $backtrace;
    	        }
    	        elseif($use == 1 && !$expand) register_shutdown_function(array($this,'shotdown'), "debug");
    	        	# print var
		        ob_start();
			        if($expand) var_dump($var);
			        else		print_r($var);
			        $output = ob_get_contents();
		        ob_end_clean();

		        $this->debug_dump[] = $output;

    	        # шагаем
    	        $use++;
	}


        /**
        * Шотдаун (выодвим отладку)
        *
        * @param mixed $type
        */
	public static function shotdown($type="debug") {
    	        global $debug;

                echo "<div class='container'><div class='row'><div class='col-xs-12'><h3>Отладка</h3>";

                foreach($debug->debug_dump AS $k=>$v) {
        	        echo "<code>debug <b>#".$k."</b></code><pre class='small' style='overflow: auto;max-height: 300px;'>".htmlspecialchars($v)."</pre>";
                }

                if($type == "debugexpand") {
		        ob_start();
			        print_r(debug_backtrace());
			        $backtrace = ob_get_contents();
		        ob_end_clean();

        	        echo "<code>backtrace</code><pre class='small' style='overflow: auto;max-height: 300px;'>".$backtrace."</pre>";
                }

                echo "</div></div></div>";

                exit;
	}
}
?>