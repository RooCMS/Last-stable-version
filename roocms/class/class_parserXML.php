<?php
/**
* @package      RooCMS
* @subpackage	Engine RooCMS classes
* @author       alex Roosso
* @copyright    2010-2014 (c) RooCMS
* @link         http://www.roocms.com
* @version      1.0.7
* @since        $date$
* @license      http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
*   RooCMS - Russian free content managment system
*   Copyright (C) 2010-2016 alex Roosso aka alexandr Belov info@roocms.com
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
*   along with this program.  If not, see http://www.gnu.org/licenses/
*
*
*   RooCMS - Русская бесплатная система управления сайтом
*   Copyright (C) 2010-2016 alex Roosso (александр Белов) info@roocms.com
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
 * Class ParserXML
 */
class ParserXML {

	# object output data
	public $data;


	# params
	protected $file 	= "";		# target xml file
	private $xml_parser = false;	# xml parser
	private $xml_string	= "";		# xml data buffer for parsing



	//#####################################################
	//	Parse XML data file
	public function parse($file = false, $callback = false) {

		if(!$file) $file = $this->file;

		$this->xml_string = "";

		$this->xml_parser = xml_parser_create();

		# set options
		xml_parser_set_option($this->xml_parser,XML_OPTION_SKIP_WHITE,1);
		xml_parser_set_option($this->xml_parser,XML_OPTION_CASE_FOLDING,1);

		# set handlers
		xml_set_element_handler($this->xml_parser, array('ParserXML','start_el'), array('ParserXML','end_el'));
		xml_set_character_data_handler($this->xml_parser, array('ParserXML','data_el'));

		xml_set_default_handler($this->xml_parser, array('ParserXML','data_el'));

		//xml_set_processing_instruction_handler($this->xml_parser, array('ParserXML','pi'));
		//xml_set_external_entity_ref_handler($this->xml_parser, array('ParserXML','eer'));

		# read
		$xml_file = file($file);
		foreach($xml_file AS $key=>$value) {
			xml_parse($this->xml_parser,$value);
		}
		xml_parser_free($this->xml_parser);

		# i-i-h-h-h-a-a-a
		if($callback)
			return simplexml_load_string($this->xml_string);
		else
			$this->data = simplexml_load_string($this->xml_string);
	}


	//#####################################################
	//	Function start element
	protected function start_el($parser, $name, $attr) {

		$this->xml_string .= "<".mb_strtolower($name);
		foreach($attr AS $key=>$value) {
			$this->xml_string .= ' '.mb_strtolower($key).'="'.mb_strtolower($value).'"';
		}
		$this->xml_string .= ">";
	}


	//#####################################################
	//	Function data element
	protected function data_el($parser, $data) {
		$this->xml_string .= "".htmlspecialchars($data)."";
	}


	//#####################################################
	//	Function end element
	protected function end_el($parser, $name) {
		$this->xml_string .= "</".mb_strtolower($name).">";
	}


	//#####################################################
	//	Function entity element
	protected function pi($parser, $enname, $base, $sid, $pid) {
		$this->xml_string .= "enname:".$enname."";
		$this->xml_string .= "base:".$base."";
		$this->xml_string .= "sid:".$sid."";
		$this->xml_string .= "pid:".$pid."";
	}


	//#####################################################
	//	Function end element
	protected function php($parser, $target, $data) {
		$this->xml_string .= "<!".$target."!>";
		$this->xml_string .= "<!".$data."!>";
	}
}
?>