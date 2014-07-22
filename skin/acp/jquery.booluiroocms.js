/**
 * @package     RooCMS
 * @subpackage	Admin Control Panel
 * @subpackage	UI
 * @subpackage	jQuery plugin
 * @author      alex Roosso
 * @copyright   2010-2015 (c) RooCMS
 * @link        http://www.roocms.com
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
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

(function($) {

	var defaults = {
		on: 'fa-check-square-o',
		off: 'fa-square-o'
	};

	var methods = {
		init : function(options) {

			// настройки
			var settings = $.extend({}, defaults, options);

			return this.each(function() {
				$(this).children("label").each(function() {

					var labelstatus = ($(this).hasClass("active")) ? true : false ;
					var fa = $(this).find(".fa");

					if(labelstatus)
						fa.removeClass(settings.off).addClass(settings.on);
					else
						fa.removeClass(settings.on).addClass(settings.off);
				});
			});
		}
	};

	$.fn.booluiroocms = function(method) {

		// логика вызова метода
		if (methods[method]) {
			return methods[method].apply( this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Метод с именем ' +  method + ' не существует для jQuery.booluiroocms');
		}
	};

})( jQuery );


/**
 * Lets begin
 */
$(document).ready(function() {
	$(".boolui-roocms").booluiroocms();
});