<?php
/**
 *   RooCMS - Open Source Free Content Managment System
 *   Copyright © 2010-2018 alexandr Belov aka alex Roosso. All rights reserved.
 *   Contacts: <info@roocms.com>
 *
 *   You should have received a copy of the GNU General Public License v3
 *   along with this program.  If not, see http://www.gnu.org/licenses/
 */

/**
 * @package      RooCMS
 * @subpackage	 Plugin Utilites
 * @subpackage	 CKEditor
 * @author       alex Roosso
 * @copyright    2010-2019 (c) RooCMS
 * @link         http://www.roocms.com
 * @version      1.1
 * @since        $date$
 * @license      http://www.gnu.org/licenses/gpl-3.0.html
 */


# OUTPUT
header('HTTP/1.1 200 OK');
header('Content-type: application/x-javascript');
header('Content-transfer-encoding: binary\n');
header('Accept-Ranges: bytes');
ob_start("ob_gzhandler", 9);

?>

document.write('<script type="text/javascript" src="plugin/ckeditor/ckeditor.js"></script>');
document.write('<script type="text/javascript" src="plugin/ckeditor/adapters/jquery.js"></script>');

$(document).ready(function() {
	/* CKEditor */
	$(".ckeditor").ckeditor();
	$(".ckeditor-mail").ckeditor({toolbar: 'Mail'});
	$(".ckeditor-html").ckeditor({height: '150px', toolbar: 'HTML'});
});