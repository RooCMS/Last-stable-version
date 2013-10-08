<?php
/**
* @package      RooCMS
* @subpackage	Library
* @subpackage	MimeTypes
* @author       alex Roosso
* @copyright    2010-2014 (c) RooCMS
* @link         http://www.roocms.com
* @version      1.0.2
* @since        $date$
* @license      http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
*	RooCMS - Russian free content managment system
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


$mimetype = array();


/**
* File
*
* @var array
*/
$filetype		= array();
$filetype[]		= array('ext'	=> 'm3u',		'type'	=> 'audio/mpegurl',					'ico'	=> 'mp3.png');
$filetype[]		= array('ext'	=> 'ttf',		'type'	=> 'application/octet-stream',		'ico'	=> 'ttf.png');
$filetype[]		= array('ext'	=> 'zip',		'type'	=> 'application/x-zip-compressed',	'ico'	=> 'zip.png');
$filetype[]		= array('ext'	=> 'zip',		'type'	=> 'application/zip',				'ico'	=> 'zip.png');
$filetype[]		= array('ext'	=> 'tar.gz',	'type'	=> 'application/octetstream',		'ico'	=> 'tgz.png');
$filetype[]		= array('ext'	=> 'rar',		'type'	=> 'application/octet-stream',		'ico'	=> 'rar.png');
$filetype[]		= array('ext'	=> 'js',		'type'	=> 'application/x-javascript',		'ico'	=> 'js.png');
$filetype[]		= array('ext'	=> 'html',		'type'	=> 'text/html',						'ico'	=> 'html.png');
$filetype[]		= array('ext'	=> 'htm',		'type'	=> 'text/html',						'ico'	=> 'htm.png');
$filetype[]		= array('ext'	=> 'css',		'type'	=> 'text/css',						'ico'	=> 'css.png');
$filetype[]		= array('ext'	=> 'xml',		'type'	=> 'text/xml',						'ico'	=> 'xml.png');
$filetype[]		= array('ext'	=> 'ini',		'type'	=> 'application/octet-stream',		'ico'	=> 'ini.png');
$filetype[]		= array('ext'	=> 'swf',		'type'	=> 'application/x-shockwave-flash',	'ico'	=> 'swf.png');
$filetype[]		= array('ext'	=> 'fla',		'type'	=> 'application/octet-stream',		'ico'	=> 'fla.png');
$filetype[]		= array('ext'	=> 'psd',		'type'	=> 'application/octet-stream',		'ico'	=> 'psd.png');
$filetype[]		= array('ext'	=> 'cdr',		'type'	=> 'application/octet-stream',		'ico'	=> 'cdr.png');
$filetype[]		= array('ext'	=> 'csv',		'type'	=> 'application/vnd.ms-excel',		'ico'	=> 'csv.png');
$filetype[]		= array('ext'	=> 'doc',		'type'	=> 'application/msword',			'ico'	=> 'doc.png');
$filetype[]		= array('ext'	=> 'xls',		'type'	=> 'application/vnd.ms-excel',		'ico'	=> 'xls.png');
$filetype[]		= array('ext'	=> 'docx',		'type'	=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',	'ico'	=> 'docx.png');
$filetype[]		= array('ext'	=> 'xlsx',		'type'	=> 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',			'ico'	=> 'xlsx.png');


/**
* Image
*
* @var array
*/
$imagetype		= array();
$imagetype[]	= array('ext'	=> 'png',		'type'	=> 'image/png',						'ico'	=> 'png.png');
$imagetype[]	= array('ext'	=> 'gif',		'type'	=> 'image/gif',						'ico'	=> 'gif.png');
$imagetype[]	= array('ext'	=> 'jpg',		'type'	=> 'image/jpg',						'ico'	=> 'jpg.png');
$imagetype[]	= array('ext'	=> 'jpg',		'type'	=> 'image/jpeg',					'ico'	=> 'jpeg.png');
$imagetype[]	= array('ext'	=> 'jpg',		'type'	=> 'image/pjpeg',					'ico'	=> 'jpg.png');
//$imagetype[]	= array('ext'	=> 'ico',		'type'	=> 'image/x-icon',					'ico'	=> 'ico.png');
//$imagetype[]	= array('ext'	=> 'bmp',		'type'	=> 'image/bmp',						'ico'	=> 'bmp.png');

$mimetype = array_merge($filetype, $imagetype);

?>