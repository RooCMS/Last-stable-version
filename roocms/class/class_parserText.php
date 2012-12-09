<?php
/**
* @package      RooCMS
* @subpackage	Engine RooCMS classes
* @subpackage	Parser Class [extends: Text]
* @author       alex Roosso
* @copyright    2010-2014 (c) RooCMS
* @link         http://www.roocms.com
* @version      1.0.27
* @since        $date$
* @license      http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
*   Данное программное обеспечение является свободным и распространяется
*   по лицензии Фонда Свободного ПО - GNU General Public License версия 2.
*   При любом использовании данного ПО вы должны соблюдать все условия
*   лицензии.
*/

//#########################################################
// Anti Hack
//---------------------------------------------------------
if(!defined('RooCMS')) die('Access Denied');
//#########################################################


class ParserText {

	/* ####################################################
	 * Парсим ББКод (BBCode)
	 * Функция в разработке
	*/
	public function bbcode($text) {

		# [blackquote]
		$text = str_ireplace("[blockquote]", "<blockquote>", $text, $tag_bq_o);
		$text = str_ireplace("[/blockquote]", "</blockquote>", $text, $tag_bq_c);

		# [b]
		$text = str_ireplace("[b]", "<b>", $text, $tag_b_o);
		$text = str_ireplace("[/b]", "</b>", $text, $tag_b_c);
		# [i]
		$text = str_ireplace("[i]", "<i>", $text, $tag_i_o);
		$text = str_ireplace("[/i]", "</i>", $text, $tag_i_c);
		# [u]
		$text = str_ireplace("[u]", "<u>", $text, $tag_u_o);
		$text = str_ireplace("[/u]", "</u>", $text, $tag_u_c);

		#font

		#link


		$text = $this->br($text);

		return $text;
	}


	/* ####################################################
	 * Парсим хтмл (HTML)
	 * Функция принимает данные обработанный функцией htmlspecialchars() и возвращает им обратное значение.
	 * 	$text	-	[text]	Текстовый буфер, который надлежит отпарсить
	 */
	public function html($text) {

		$text = htmlspecialchars_decode($text);
 		$text = strtr($text, array(
			'&#123;'	=> '{', 		//	{
			'&#125;'	=> '}', 		//	}
			'&#39;'		=> '\'', 		//	" [quot]
			'&#36;'		=> '$'
		));

		return $text;
	}


	/* ####################################################
	 * Парсим данные
	 * Функция принимает данные обработанный функцией htmlspecialchars() и вычищает все специфические символы.
	 * 	$text	-	[text]	Текстовый буфер, который надлежит отпарсить
	 */
	public function clearhtml($text) {

 		$text = strtr($text, array(
			'&lt;'		=> '', 		//	< [lt]
			'&gt;'		=> '', 		//	> [rt]
			'&#123;'	=> '', 		//	{
			'&#125;'	=> '', 		//	}
			'&#39;'		=> '', 		//	" [quot]
			'&quot;'	=> '', 		//	" [quot]
			'&amp;'		=> '',		//	& [amp]
			'&#36;'		=> ''
		));

		return $text;
	}


	/* ####################################################
	 * Парсим данные
	 * Функция заменяет перевод каретки \n на хтмл тег <br />
	 * 	$text	-	[text]	Текстовый буфер, который надлежит отпарсить
	 */
	public function br($text) {
		$text = nl2br($text);
		return $text;
	}


	//#####################################################
	// parser anchor in text
	public function anchors($text) {
		// Извлекаем имя хоста из URL
		// preg_match("/^(http:\/\/)?([^\/]+)/i",
			// "http://www.php.net/index", $matches);
		// $host = $matches[2];

		// извлекаем две последние части имени хоста
		// preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
		// echo "domain name is: {$matches[0]}\n";

		if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $text, $matches)) {

			for($i=0;$i<sizeof($matches['0']);$i++) {

				$period = '';

				if (preg_match("|\.$|", $matches['6'][$i])) {

					$period = '.';
					$matches['6'][$i] = mb_substr($matches['6'][$i], 0, -1);
				}

				$text = str_ireplace($matches['0'][$i],
									 $matches['1'][$i].'<a href="http'.
									 $matches['4'][$i].'://'.
									 $matches['5'][$i].
									 $matches['6'][$i].'" target="_blank" rel="nofollow">http'.
									 $matches['4'][$i].'://'.
									 $matches['5'][$i].
									 $matches['6'][$i].'</a>'.
									 $period, $text);
			}
		}

		return $text;
	}


	/* ####################################################
	 * Парсим данные
	 * Функция обрабатывает строку, оставляя в ней только цифры
	 * 	$n	-	[string]	Текстовая строка, которую требуется отпарсить
	 */
	public function only_numbers($n) {
		return preg_replace("/[^0-9\-()]+/","",$n);
	}
}

?>