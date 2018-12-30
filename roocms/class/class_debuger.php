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
 * Class Debuger
 */
class Debuger {

	# hand flag show full debug text
	public  $show_debug          = false;

	# debug info
	public  $debug_info          = ""; # buffer for debug info text
	private $debug_dump          = []; # data dump for developers

	# Timer
	private $starttime           = 0;
	public  $productivity_time   = 0.0;

	# Memory
	private $memory_usage        = 0;
	public  $productivity_memory = 0;
	public  $memory_peak_usage   = 0;

	# error log file
	public  $exist_errors        = false;

	# requirement php extension
	private $reqphpext		= array("Core", "standard", "mysqli", "session", "mbstring",
						"calendar", "date", "pcre", "xml", "SimpleXML", "gd");

	public  $phpextensions       = []; # list installed php extends
	public  $nophpextensions     = []; # list non installed php extends required for RooCMS


	/**
	* Construct
	*/
	public function __construct() {

		# set error handler
		set_error_handler(array($this,'debug_critical_error'));

		# default : error hide
		$this->error_report(false);

        	# for admins all time measure productivity
		if(DEBUGMODE || defined('ACP') || defined('INSTALL')) {
			# start Debug timer
			$this->start_productivity();

			# check required php extends
			$this->check_phpextensions();

			# try show error
			$this->error_report(true);

			# check error log
			$this->check_errorlog();
		}

		# show debug info
		if($this->show_debug) {
                	register_shutdown_function(array($this,'shutdown'), false);
		}
	}


	/**
	* Start productivity timer measure script working
	*/
        private function start_productivity() {

    	        # timer
                $this->starttime = $_SERVER['REQUEST_TIME'];

                # memory
                $this->memory_usage = MEMORYUSAGE;
        }


	/**
	* Stop productivity timer measure script working
	*/
        public function end_productivity() {

    	        # timer
                $endtime = microtime(true);
                $totaltime = round(($endtime - $this->starttime), 4);

	        $this->productivity_time = $totaltime;

	        # memory
	        $this->productivity_memory 	= memory_get_usage() - $this->memory_usage;
	        $this->memory_peak_usage 	= memory_get_peak_usage();
        }


	/**
	* Check required php extensions
	*
	*/
	private function check_phpextensions() {

		$this->phpextensions = get_loaded_extensions();

		foreach($this->reqphpext AS $v) {
			if(!in_array($v, $this->phpextensions)) {
				$this->nophpextensions[] = $v;
			}
		}
	}


	/**
	 * Check log file for errors
	 * and set flag 'true' if file not empty
	 */
	private function check_errorlog() {
		if(is_file(ERRORSLOG) && filesize(ERRORSLOG) != 0) {
			$this->exist_errors = true;
		}

		if(is_file(SYSERRLOG) && filesize(SYSERRLOG) != 0) {
			$this->exist_errors = true;
		}
	}


	/**
	 * System Error Interceptor
	 *
	 * @param mixed $errno - error number
	 * @param mixed $msg   - message od error
	 * @param mixed $file  - filename with error
	 * @param mixed $line  - string number with error
	 *
	 * @return null|boolean
	 */
	public static function debug_critical_error($errno, $msg, $file, $line) {

                # read error in file
		$subj = file_read(ERRORSLOG);
		

                switch($errno) {
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
        		        $erlevel = 1; $ertitle = "Критическая ошибка";
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

                if($erlevel == 0) {
                	register_shutdown_function(array('debug','shutdown'), "debug");
		}

        	$time = date("d.m.Y H:i:s");

		$subj .= $time." | ".$ertitle." | ".$errno." | ".$msg." | ".$line." | ".$file."\r\n";

		$f = fopen(ERRORSLOG, "w+");
		if(is_writable(ERRORSLOG)) {
			fwrite($f, $subj);
		}
		fclose($f);

		# hide error if not use debugmode
		if(error_reporting() == 0 && $erlevel == 0) {
			die(CRITICAL_STYLESHEETS."<blockquote>Извините, что то пошло не так. Мы уже работаем над устранением причин.
							<small>".$time."</small>
							<a href='javascript:history.back(1)'>< Вернуться назад</a></blockquote>");
		}

                if(DEBUGMODE) {
			echo CRITICAL_STYLESHEETS."
			<div class='alert alert-danger text-left in fade col-md-12' role='alert'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			ОШИБКА: <b>#{$errno} - {$ertitle}</b>
			<br />Строка: <b>{$line}</b> в файле <b>{$file}</b>
			<br /><b>{$msg}</b>
			</div>\n";
		}

		# We kill the standard handler, so that he would not give out anything to spy (:
		return true;
	}


        /**
        * on/off error log
        *
        * @param boolean $show
        */
	private static function error_report($show = false) {

		ini_set("error_log", SYSERRLOG);

		if($show) {
			error_reporting(E_ALL);			#8191
			ini_set("display_startup_errors",	1);
			ini_set("display_errors",		1);
			ini_set("html_errors",			1);
			ini_set("report_memleaks",		1);
			ini_set("track_errors",			1);
			ini_set("log_errors",			1);
			ini_set("log_errors_max_len",		2048);
			ini_set("ignore_repeated_errors",	1);
			ini_set("ignore_repeated_source",	1);
		}
		else {
			error_reporting(0);
		}
	}


	/**
	 * Debug function
	 *
	 * @param mixed $var - variable/data/object for debugging
	 *
	 * @return mixed     - show variable dump for $var
	 */
	public function rundebug($var) {
                static $use = 1;

                # shutdown register
    	        if($use == 1) {
			register_shutdown_function(array($this,'shutdown'));
    	        }

		# print var
		ob_start();

			if(is_object($var) || is_array($var)) {
				$var = (array) $var;
			}

			print_r($var);

			$output = ob_get_contents();

		ob_end_clean();

		$this->debug_dump[] = $output;

    	        # step
    	        $use++;
	}


        /**
        * Shutdown (show debug information)
        */
	public static function shutdown() {

		global $debug, $db;

                echo "<div class='container'><div class='row'><div class='col-xs-12'><h3>Отладка</h3>";

                foreach($debug->debug_dump AS $k=>$v) {
        	        echo "<code>debug <b>#".$k."</b></code><pre class='small' style='overflow: auto;max-height: 300px;'>".htmlspecialchars($v)."</pre>";
                }

                echo "</div></div></div>";

		if($debug->show_debug) {
			echo "<div class='container'><div class='row'><div class='col-xs-12'><div class='panel-group' id='debugaccordion'>";

			echo "	<div class='panel panel-primary'>
					<div class='panel-heading'>
						<h4 class='panel-title'><a class='accordion-toggle' data-toggle='collapse' data-parent='#debugaccordion' href='#collapseQuerys'>Запросы к БД</a></h4>
					</div>
					<div id='collapseQuerys' class='panel-collapse collapse'>
						<div class='panel-body'>
							{$debug->debug_info}
						</div>
					</div>
				</div>";

			echo "</div></div></div></div>";
		}

		# functions
		echo "<div class='container'><div class='row'><div class='col-xs-12'><div class='panel-group' id='debug2accordion'>";
		echo "	<div class='panel panel-default'>
				<div class='panel-heading'>
					<h4 class='panel-title'><a class='accordion-toggle' data-toggle='collapse' data-parent='#debug2accordion' href='#collapseFCC'>Defined Functions/Classes/Constants</a></h4>
				</div>
			<ul id='collapseFCC' class='list-group panel-collapse collapse'>";


		$func_array = get_defined_functions();
		foreach($func_array['user'] AS $v) {
			echo "\n<li class='list-group-item'><b>function</b> {$v}();</li>";
		}


		$cl_array = get_declared_classes();
		foreach($cl_array AS $v) {
			echo "\n<li class='list-group-item'><b>class</b> {$v}</li>";
		}


		$const_array = get_defined_constants(true);
		foreach($const_array['user'] AS $k=>$v) {
			echo "\n<li class='list-group-item'><b>{$k}</b> - ".htmlspecialchars($v)."</li>";
		}

		echo "	</ul></div>";

		echo "</div></div></div></div>";

                echo "  <div class='container'>
				<nobr><span class='fa fa-bar-chart-o fa-fw'></span> Число обращений к БД: <b>{$db->cnt_querys}</b></nobr>
				&nbsp;&nbsp; <nobr><span class='fa fa-tachometer fa-fw'></span> Использовано памяти : <span style='cursor: help;' title='".round($debug->memory_peak_usage/1024/1024, 2)." байт макс'><b>".round($debug->productivity_memory/1024/1024, 2)." Мб</b></span></nobr>
				&nbsp;&nbsp; <nobr><span class='fa fa-clock-o fa-fw'></span> Время работы скрипта : <b>{$debug->productivity_time} мс</b></nobr>
			</div>";

                exit;
	}
}
