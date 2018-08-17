/**
 * @package     RooCMS
 * @subpackage	Admin Control Panel
 * @subpackage	JavaScript
 * @author      alex Roosso
 * @copyright   2010-2019 (c) RooCMS
 * @link        http://www.roocms.com
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 *   RooCMS - Russian
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
 *   RooCMS - Бесплатная система управления сайтом
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
$(document).ready(function() {

	//$(".corner").corner("round 4px");

	$("[rel='tooltip']").tooltip();
	$("[rel='popover']").popover();
	$(".alert").alert();

	/*$('#LeftMenu').affix({
		offset: {
			top: 60,
			bottom: 60
		}
	});*/
	//$(".collapse").collapse({hide: true});

	/* Select */
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		$('.selectpicker').selectpicker('mobile');
	}
	else {
		$('.selectpicker').selectpicker();
	}

	/* Datepicker */
	$(".datepicker").datepicker({
		format: 'dd.mm.yyyy',
		language: 'ru',
		todayHighlight: true
	});

	$(".datepicker-0d").datepicker({
		format: 'dd.mm.yyyy',
		language: 'ru',
		startDate: '0'
	});

	/* Colorpicker */
	$(".colorpicker").colorpicker();

	/* Tags Input */
	$(".tagsinput").tagsinput({
		maxTags: 10,
		trimValue: true
	});

	$(".addtag").click(function() {
		$("#inputTags").tagsinput('add', $(this).attr("value"));
	});

	/* Colorbox */
    	$("a[rel='colorbox']").colorbox({maxWidth: "95%", maxHeight: "95%",
		'onComplete': function(){
			$('#cboxLoadedContent').zoom({'on': 'click'});
		}
	});

	/* Swiper */
	$(document).bind('cbox_open', function(){
		$("#colorbox").swipe({
			//Generic swipe handler for all directions
			swipeLeft:function(event, direction, distance, duration, fingerCount) {
				jQuery.colorbox.next();
			},
			swipeRight:function(event, direction, distance, duration, fingerCount) {
				jQuery.colorbox.prev();
			},
			//Default is 75px, set to 0 for demo so any distance triggers swipe
			threshold:0
		});
	});

	$(".carousel").swipe({
		swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

			if (direction === "left") $(this).carousel('next');
			if (direction === "right") $(this).carousel('prev');
		},
		allowPageScroll:"vertical"
	});

    	/* Style */
	$(".show-feed-element").hover(function() {
		var l = $(this).find(".fa");
		l.removeClass("text-muted fa-eye-slash").addClass("text-info fa-eye");
	}, function() {
		var l = $(this).find(".fa");
		l.removeClass("text-info fa-eye").addClass("text-muted fa-eye-slash");
	});

	$(".hide-feed-element").hover(function() {
		var l = $(this).find(".fa");
		l.removeClass("text-default fa-eye").addClass("text-danger fa-eye-slash");
	}, function() {
		var l = $(this).find(".fa");
		l.removeClass("text-danger fa-eye-slash").addClass("text-default fa-eye");
	});

	/* Leight */
	/*$('[maxleight]').keyup(function(){
		var ml = $(this).attr('maxleight');
		var fl = $(this).val().length;
		var c = (fl > ml) ? 'red t10' : 'grey t10';
		if(fl > ml) {
			$('#calcbd').text('Введено: ' + $(this).val().length + ' Лишний текст будет обрезан');
		}
		else {
			$('#calcbd').text('Введено: ' + $(this).val().length);
		}
		$('#calcbd').attr('class', c);
	});*/

	/* Alert */
	/*setTimeout(function() {
		var ah = $(".alert-info").height();
		var mm = ah + 100;
		$(".alert-info").animate({'margin-top': '-='+mm+'px'}, 1200, function() {
			$(this).hide();
		});
	}, 3700);*/
});