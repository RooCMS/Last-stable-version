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
if(!defined('RooCMS')) {
	die('Access Denied');
}
//#########################################################


/**
 * Class Files
 */
class Files {

	/**
	 * Функция проверки Content-type
	 * [не дописана]
	 *
	 * @param string $file файл для проверки
	 *
	 * @return object
	 */
	/*public function mimetype($file) {

		global $debug;

		if(is_file($file) && array_search("apache2handler", $debug->phpextensions)) {
			$fileinfo = apache_lookup_uri($file);
		}

		if(isset($fileinfo->content_type)) {
			debug($fileinfo);
		}
	}*/


	/**
	 * Создание имени файлов
	 *
	 * @param string $filename Имя файла
	 * @param string $prefix   Префикс имени файла
	 * @param string $pofix    Пофикс имени файла
	 *
	 * @return string Имя файла
	 */
	public function create_filename($filename, $prefix="", $pofix="") {

		global $parse;
		static $names = [];

		# убиваем прицепившиейся расширение к имени файла
		$pi = pathinfo($filename);
		$filename = str_ireplace(".".$pi['extension'], "", $filename);

		# префикс
		if(trim($prefix) != "")	{
			$prefix .= "_";
		}
		# постфикс
		if(trim($pofix)  != "")	{
			$pofix = "_".$pofix;
		}

		# транслит
		$filename = $parse->text->transliterate($filename, "lower");

		# Чистим имя файла от "левых" символов.
		$filename = preg_replace(array('(\s\s+)','(\-\-+)','(__+)','([^a-zA-Z0-9\-_])'), array(' ','-','_',''), $filename);

		# Проверяем длину имения файла
		$length = 5;
		if($prefix != "") {
			$length += mb_strlen($prefix) + 1;
		}
		if($pofix != "") {
			$length += mb_strlen($pofix) + 1;
		}
		$length += mb_strlen(time());

		$filelength = mb_strlen($filename);

		# постараемся не выскочить за длину допустимого пути.
		$maxlenght = PHP_MAXPATHLEN - mb_strlen(__DIR__);
		if($length + $filelength > $maxlenght) {
			$maxfilelength = $maxlenght - $length;
                        $filename = mb_substr($filename,0,$maxfilelength);
		}

		# suffix for unduplicated
		$suffix = (in_array($filename,$names)) ? "_".randcode(3,"RooCMSbestChoiceForYourSite"): "" ;
		$names[] = $filename;

		$filename = $prefix.$filename.$suffix."_".time().$pofix;

		return $filename;
	}


	/**
	 * Выгружаем присоедененные файлы
	 *
	 * @param string $cond  параметр указывающий на элемент к которому прикреплены изображения
	 * @param int    $from  стартовая позиция для загрузки файлов
	 * @param int    $limit лимит загружаемых файлов
	 *
	 * @return array $data  массив с данными о файлах.
	 */
	public function load_files($cond, $from = 0, $limit = 0) {

		global $db;

		$data = [];

		$l = ($limit != 0) ? "LIMIT {$from},{$limit}" : "" ;

		$q = $db->query("SELECT id, filename, fileext, filetitle, sort FROM ".FILES_TABLE." WHERE attachedto='{$cond}' ORDER BY sort ASC ".$l);
		while($file = $db->fetch_assoc($q)) {
			$file['file']	= $file['filename'].".".$file['fileext'];
			$data[] = $file;
		}

		return $data;
	}


	/**
	 * Функция загрузки файлов
	 *
	 * @param string       $file        Параметр файла массива $_FILES
	 * @param string       $attached    Элемент родитель файла
	 * @param string       $prefix      Префикс имени файла
	 * @param string|array $allowtypes  Допустимые типы файлов (в будущем)
	 * @param string       $path        путь для загрузки файлов
	 *
	 * @return array|false
	 */
	public function upload($file, $attached, $prefix="", $allowtypes="", $path=_UPLOADFILES) {

    	        global $parse;

		# Объявляем выходной массив
		$files = [];

		# Составляем массив для проверки разрешенных типов файлов к загрузке
		$allow_exts = $this->get_allow_exts($allowtypes);

		# Если $_FILES не является массивом конвертнем в массив
		# Я кстати в курсе, что сам по себе $_FILES уже массив. Тут в другом смысл.
		$upfiles = [];
		if(!is_array($_FILES[$file]['tmp_name'])) {
			foreach($_FILES[$file] AS $k=>$v) {
				$upfiles[$file][$k][$file] = $v;
			}
		}
		else {
			$upfiles[$file] = $_FILES[$file];
		}


		# приступаем к обработке
		foreach($upfiles[$file]['tmp_name'] AS $key=>$value) {
			if(isset($upfiles[$file]['tmp_name'][$key]) && $upfiles[$file]['error'][$key] == 0) {

				$upload = false;

				# ext
				$ffn = explode(".", $upfiles[$file]['name'][$key]);
				$upfiles[$file]['ext'][$key] = array_pop($ffn);

				# исключение для tar.gz (в будущем оформим нормальным образом)
				if($upfiles[$file]['ext'][$key] == "gz") {
					$upfiles[$file]['ext'][$key] = "tar.gz";
				}

				# Грузим апельсины бочками
				if(array_key_exists($upfiles[$file]['ext'][$key], $allow_exts)) {

					# Создаем имя файлу.
					$filename  = $this->create_filename($upfiles[$file]['name'][$key], $prefix);
					$ext       = $allow_exts[$upfiles[$file]['ext'][$key]];

					# Создаем титул файлу
					$filetitle = preg_replace(array('(\s\s+)','(\-\-+)','(__+)','([^a-zA-Z0-9а-яА-Я\-\._]+/msi)'), array(' ','-','_',''), $upfiles[$file]['name'][$key]);


					# Сохраняем оригинал
					copy($upfiles[$file]['tmp_name'][$key], $path."/".$filename.".".$ext);

					# Если загрузка прошла и файл на месте
					$upload = is_file($path."/".$filename.".".$ext);
				}

				# Если не загрузка удалась
				if(!$upload) {
					$filename = false;
				}
			}
			else {
				# вписать сообщение об ошибке.
				# впрочем ещё надо и обработчик ошибок написать.
				$filename = false;
			}

			if($filename !== false) {
				# upload
				$this->insert_file($filename.".".$ext, $filetitle, $attached);

				# callback array
				$files[] = $filename.".".$ext;
			}
		}

		# Возвращаем массив имен файлов для внесения в БД
		return (count($files) > 0) ? $files : false ;
	}


	/**
	 * Загружаем информацию о файлах в БД
	 *
	 * @param string $filename имя файла без $pofix
	 * @param string $filetitle название файла
	 * @param mixed  $attached родитель файла
	 */
	public function insert_file($filename, $filetitle, $attached) {

		global $db, $logger;

		$fileinfo = pathinfo($filename);

		$db->query("INSERT INTO ".FILES_TABLE." (attachedto, filename, fileext, filetitle)
						VALUES ('".$attached."', '".$fileinfo['filename']."', '".$fileinfo['extension']."', '".$filetitle."')");

		# msg
		$logger->log("Файл ".$filename." успешно загружен на сервер");
	}


	/**
	 * Функция удаления файлов из хранилища
	 *
	 * @param int|string $file - указать числовой идентификатор или attachedto
	 * @param boolean    $clwhere - флаг указывает как считывать параметр $file
	 * 				положение false указывает, что передается параметр id или attachedto
	 * 				положение true указывает, что передается полностью выраженное условие
	 */
	public function remove_files($file, $clwhere=false) {

		global $db, $logger;

		if(is_numeric($file) || is_integer($file)) {
			$cond = " id='".$file."' ";
		}
		else {
			$cond = " attachedto='".$file."' ";
		}

		if($clwhere) {
			$cond = $file;
		}

		$q = $db->query("SELECT id, filename, fileext FROM ".FILES_TABLE." WHERE ".$cond);
		while($row = $db->fetch_assoc($q)) {
			if(!empty($row)) {
				$filename = $row['filename'].".".$row['fileext'];

				# delete
				$this->erase_file(_UPLOADFILES."/".$filename);
			}
		}

		$db->query("DELETE FROM ".FILES_TABLE." WHERE ".$cond);
	}


	/**
	 * Функция составляет массив допустимых расширений файлов разрешенных для загрузки на сервер.
	 *
	 * @param string|array $allowtypes     Допустимые типы файлов (в будущем)
	 *
	 * @return mixed Возвращает массив с допустимыми расширениями изображения для загрузки на сервер
	 */
	public function get_allow_exts($allowtypes="") {
		require _LIB."/mimetype.php";

		$allow_exts = [];

		# listing allow types
		if($allowtypes != "") {

			if(!is_array($allowtypes)) {
				$exts = preg_split("/[\s,-]+/", $allowtypes);
				$allowtypes &= $exts;
			}

			# create callback array
			foreach($filetype AS $itype) {
				if(in_array($itype['ext'], $allowtypes)) $allow_exts[$itype['ext']] = $itype['ext'];
			}
		}
		else {
			# create callback array
			foreach($filetype AS $itype) {
				$allow_exts[$itype['ext']] = $itype['ext'];
			}
		}

		return $allow_exts;
	}


	/**
	 * Проверка размера файла
	 *
	 * @param string $file Указывается путь к файлу и имя файла
	 *
	 * @return string|false Функция возвращает результат вида 10.2Kb или 2.10Mb
	 */
	public function file_size($file) {

		if(is_file($file)) {
			$t = "Kb";

			$f = filesize($file) / 1024;
			if($f > 1024) {
				$t = "Mb";
				$f = $f / 1024;
			}

			$f = round($f,2).$t;
		}
		else {
			$f = false;
		}

		return $f;
	}


	/**
	 * Узнаем расширение файла по его имени
	 *
	 * @param string $filename Полное имя файла, включая расширение
	 *
	 * @return string расширение файла без точки
	 */
	public function get_ext($filename) {

		$pi = pathinfo($filename);
		$ext = $pi['extension'];

		return $ext;
	}


	/**
	 * Отображение прав доступа в виде восьмеричного числа
	 *
	 * @param string $file название файла с указанием полного пути до него
	 *
	 * @return int|string
	 */
	public function show_fileperms($file) {
		return mb_substr(sprintf('%o', fileperms($file)), -4);
	}


	/**
	 * Записываем файл
	 *
	 * @param string $file    - полный пукть к файлу
	 * @param string $context - информация для записи в файл
	 */
	public function write_file($file, $context) {
		$f = fopen($file, "w+");
		if(is_writable($file) && is_resource($f)) {
			fwrite($f, $context);
		}
		fclose($f);
	}


	/**
	 * Стираем файл
	 *
	 * @param string $file - путь к файлу
	 */
	public function erase_file($file) {

		global $logger;

		if(is_file($file)) {
			unlink($file);
			$logger->log("Удален файл: ".$file);
		}
		elseif(!is_file($file)) {
			$logger->error("Не удалось найти файл ".$file, "error");
		}
	}
}