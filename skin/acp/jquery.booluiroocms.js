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

(function($) {

	var defaults = {
		icon_on: 'fa-check-square-o',
		icon_off: 'fa-square-o'
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
						fa.removeClass(settings.icon_off).addClass(settings.icon_on);
					else
						fa.removeClass(settings.icon_on).addClass(settings.icon_off);
				}).click(function(){
					$(this).parent().each(function() {
						var fa = $(this).find(".fa");
						fa.removeClass(settings.icon_on).addClass(settings.icon_off);
					});

					var fa = $(this).find(".fa");
					fa.removeClass(settings.icon_off).addClass(settings.icon_on);
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