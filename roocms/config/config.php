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

/**
 * @package	RooCMS
 * @subpackage	Configuration
 * @author	alex Roosso
 * @copyright	2010-2015 (c) RooCMS
 * @link	http://www.roocms.com
 * @version	1.2.1
 * @since	$date$
 * @license	http://www.gnu.org/licenses/gpl-3.0.html
 */


//#########################################################
// Anti Hack
//---------------------------------------------------------
if(!defined('RooCMS')) {
	die('Access Denied');
}
//#########################################################


//#########################################################
//	Настройки подключения к Базе Данных MySQL
//---------------------------------------------------------
$db_info = [];
//---------------------------------------------------------
$db_info['host'] = "";					#	Хост Базы Данных
$db_info['user'] = "";					#	Имя пользователя Базы Данных
$db_info['pass'] = "";					#	Пароль пользователя Базы Данных
$db_info['base'] = "";				#	Название Базы с данными
$db_info['prefix'] = "";					#	Префикс таблиц в Базе Данных
//#########################################################


//#########################################################
//	Различные параметры
//---------------------------------------------------------
$site = [];
//---------------------------------------------------------
$site['title'] = "";				#	Заголовок сайта (используется в случае сбоя БД)
$site['domain'] = "";			#	Является значением по умолчаню и используется в случае сбоя БД
$site['sysemail'] = "";				#	Системный почтовый адрес, для уведомления о сбоях в БД
$site['skin'] = "default";					#	Шаблоны дизайна по умолчанию
//#########################################################