<?php
/**
 * RooCMS - Open Source Free Content Managment System
 * Copyright © 2010-2018 alexandr Belov aka alex Roosso. All rights reserved.
 * Contacts: <info@roocms.com>
 *
 * You should have received a copy of the GNU General Public License v3
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */

/**
 * @package      RooCMS
 * @subpackage	 Plugin Utilites
 * @subpackage	 Codemirror Library
 * @author       alex Roosso
 * @copyright    2010-2019 (c) RooCMS
 * @link         http://www.roocms.com
 * @version      2.0
 * @license      http://www.gnu.org/licenses/gpl-3.0.html
 */


$mode = "";
if(isset($_GET['mode']) && trim($_GET['mode']) != "") {
	$mode = $_GET['mode'];
}

# OUTPUT
header('HTTP/1.1 200 OK');
header("Content-type: application/x-javascript; charset=utf-8");
header('Content-transfer-encoding: binary\n');
header('Accept-Ranges: bytes');
ob_start("ob_gzhandler", 9);
?>

document.write('<link rel="stylesheet" href="/plugin/codemirror/lib/codemirror.min.css">');
document.write('<link rel="stylesheet" href="/plugin/codemirror/addon/dialog/dialog.min.css">');
document.write('<link rel="stylesheet" href="/plugin/codemirror/addon/display/fullscreen.min.css">');

document.write('<script src="/plugin/codemirror/lib/codemirror.min.js"></script>');			// Engine
document.write('<script src="/plugin/codemirror/addon/dialog/dialog.min.js"></script>');		// ALL
document.write('<script src="/plugin/codemirror/addon/search/search.min.js"></script>');
document.write('<script src="/plugin/codemirror/addon/search/searchcursor.min.js"></script>');
document.write('<script src="/plugin/codemirror/addon/search/match-highlighter.min.js"></script>');
document.write('<script src="/plugin/codemirror/addon/edit/matchbrackets.min.js"></script>');
document.write('<script src="/plugin/codemirror/addon/edit/closebrackets.min.js"></script>');

document.write('<script src="/plugin/codemirror/addon/mode/overlay.min.js"></script>');
document.write('<script src="/plugin/codemirror/addon/mode/multiplex.min.js"></script>');
document.write('<script src="/plugin/codemirror/addon/display/fullscreen.min.js"></script>');		// Util

/* mode */
document.write('<script src="/plugin/codemirror/mode/htmlmixed/htmlmixed.min.js"></script>');
document.write('<script src="/plugin/codemirror/mode/xml/xml.min.js"></script>');
document.write('<script src="/plugin/codemirror/mode/javascript/javascript.min.js"></script>');
document.write('<script src="/plugin/codemirror/mode/css/css.min.js"></script>');
document.write('<script src="/plugin/codemirror/mode/clike/clike.min.js"></script>');
document.write('<script src="/plugin/codemirror/mode/php/php.min.js"></script>');
document.write('<script src="/plugin/codemirror/mode/htmlembedded/htmlembedded.min.js"></script>');

<?php if($mode == "php") { ?>

<?php } ?>
