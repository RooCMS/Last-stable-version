-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- ����� ��������: ��� 31 2011 �., 15:27
-- ������ �������: 5.1.40
-- ������ PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
--

-- --------------------------------------------------------

--
-- ��������� ������� `roocms_config__parts`
--

CREATE TABLE IF NOT EXISTS `roocms_config__parts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `part` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort` int(3) unsigned NOT NULL,
  `type` enum('component','mod','module') NOT NULL DEFAULT 'component',
  PRIMARY KEY (`id`),
  UNIQUE KEY `part` (`part`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- ���� ������ ������� `roocms_config__parts`
--

INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(1, 'Global', '���������� ���������', 1, 'component');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(2, 'GD', '��������� �����������', 10, 'component');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(3, 'News', '�������', 20, 'mod');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(4, 'Portfolio', '���������', 30, 'mod');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(5, 'Gallery', '������� �����������', 35, 'mod');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(6, 'LastNews', '��������� �������', 25, 'module');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(7, 'VK', '��������� (�����)', 50, 'module');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(8, 'VKComments', '��������� (�����������)', 52, 'module');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(9, 'VKLike', '��������� (��� ��������)', 55, 'module');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(10, 'GooglePlusOne', 'Google Plus One', 70, 'module');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(11, 'Sape', 'Sape (����)', 150, 'module');
INSERT INTO `roocms_config__parts` (`id`, `part`, `title`, `sort`, `type`) VALUES(12, 'RSS', 'RSS 2.0', 30, 'component');

-- --------------------------------------------------------

--
-- ��������� ������� `roocms_config__settings`
--

CREATE TABLE IF NOT EXISTS `roocms_config__settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `part` varchar(255) NOT NULL,
  `sort` int(3) unsigned NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL DEFAULT 'TitleOption',
  `description` text NOT NULL,
  `options` varchar(255) NOT NULL,
  `setting_name` varchar(255) NOT NULL,
  `options_type` enum('boolean','bool','int','integer','string','text','textarea','date','email','select') NOT NULL DEFAULT 'boolean',
  `variants` text NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `options` (`options`),
  KEY `part` (`part`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- ���� ������ ������� `roocms_config__settings`
--

INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(1, 'Global', 1, 'Base Url', '������� ������� ���� � ����� �����.\r\n������: http://www.roocms.com\r\n* ��� ����� �� �����', 'baseurl', '', 'string', '', '');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(2, 'Global', 2, 'Meta Description', '�������� ���� ������� ����� ��� ��������� �������.', 'meta_description', '', 'string', '', 'RooCMS');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(3, 'Global', 3, 'Meta Keywords', '�������� ����� ����� �����, ��� ��������� �������\r\n���������� ����� ��������', 'meta_keywords', '', 'string', '', 'RooCMS,  CMS, Content, Managment, System, ���, �������, ����������, ������, open, source, web cms, ��� ���');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(4, 'Global', 5, '��������� 304', '����� ���/���� ����� ��������� 304 �� ������ IF_MODIFED_SINCE �� ��������� ������� ��� ��� ��� ���������.', 'if_modifed_since', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(5, 'Global', 10, 'Fuck Internet Explorer', '����� �������� ����������� ������������ ���������� �� IE � ������ ������ ���������.', 'fuckie', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(6, 'GD', 1, '��������� ���������', '����� ��������� ��������� �� ��������� ��� ����������� ���������.', 'gd_resize_image', '', 'boolean', '', 'true');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(7, 'GD', 2, '������ ���������', '������� ������ ������������ ����������� �� ����������� (� ��������)', 'gd_thumb_image_width', '', 'int', '', '120');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(8, 'GD', 3, '������ ���������', '������� ������ ������������ ����������� �� ���������(� ��������)', 'gd_thumb_image_height', '', 'int', '', '120');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(9, 'GD', 10, '������� ����', '������������ �� ����������� ������������ Watermark (�������������� ��������) ��� ������ ����������� �� ����������� �� ��������� �������?', 'gd_use_watermark', '', 'boolean', '', 'true');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(10, 'GD', 11, '������ ������ �������� �����', '������ ������� �������� ����� �������������� �� �����������', 'gd_watermark_string_one', '', 'string', '', 'RooCMS');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(11, 'GD', 12, '������ ������ �������� �����', '������ ������� �������� ����� �������������� �� �����������', 'gd_watermark_string_two', '', 'string', '', 'http://dev.roocms.com');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(12, 'News', 1, '�������� �� ��������', '������� ���������� �������� ��� ������ �� ����� ��������.', 'news_newsonpage', 'newsonpage', 'int', '', '5');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(13, 'News', 2, '������', '������ ��� �������� ���������\r\n����������� � ���������', 'news_indention', 'indention', 'int', '', '15');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(14, 'Portfolio', 1, '���������', '��������� ������ ���������.\r\n������: ����� ��������� - ������ ���������', 'portfolio_title', 'title', 'string', '', 'RooCMS - ��� ���������');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(15, 'Portfolio', 4, '���� ��������', '������� ���� ���� ��������', 'portfolio_birthdate', 'birth_date', 'date', '', '11/29/2010');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(16, 'Portfolio', 5, '� ����', '��������, ��� ������ � ����, ��� ����� ��������������� ���, ��� �������������.', 'portfolio_about', 'about', 'textarea', '', '������ ��� ����� �������������� ��� ��� ������� ��������� ��� ��� ��� �������� �����. ��� ���� ��� �������� ������, ��� ��� ������� �� �������� ����� � ������� &quot;�������&quot;, ��� ����������� ����� ��������� �� ������ RooCMS.\r\n\r\n���������� ������� ������� ���� �� �������� ������������ � ��������� (������ ����� � �������� ������� ;-) ). ��������� �������� ��������� ����� �����. ��� �� ���������� �� �������� ����� ��������� ��������� �����.\r\n\r\n� ����� �� ��������, �� ���������� �������, ��� �� ����� ��������� ���� �����, ��� �� ��������, ��� ������ ��� ����� ��������������� ������ ��������������. � ������� ��������� � �������, ����� �������� ��� ������� � ���������� �����.');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(17, 'Portfolio', 6, '�����', '�������� ���� ����� ��� ������', 'portfolio_motto', 'motto', 'string', '', 'RooCMS - ������� ���������� ������� ���������� ������');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(18, 'Portfolio', 7, '�������', '������� ����� ������ ��������', 'portfolio_phone', 'phone', 'string', '', '+7(*0*)**0-0*-*0');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(19, 'Portfolio', 8, 'E-Mail', '������� ��� �������� ����������� �����', 'portfolio_email', 'email', 'email', '', 'info@roocms.com');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(20, 'Portfolio', 9, 'ICQ', '������� ����� ������ ICQ', 'portfolio_icq', 'icq', 'int', '', '3405729');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(21, 'Portfolio', 10, '������', '������� ���� ������', 'portfolio_country', 'country', 'string', '', '������');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(22, 'Portfolio', 11, '�����', '������� ����� ������ ����������', 'portfolio_city', 'city', 'string', '', '��� ������');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(23, 'Portfolio', 12, '���� ��������', '�������� ��������� ��� ����-�����', 'portfolio_metadescription', 'meta_description', 'string', '', '������������ ���� ��������� �� RooCMS');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(24, 'Portfolio', 13, '���� �������� �����', '�������� ����� ��� ����-�����', 'portfolio_metakeywords', 'meta_keywords', 'string', '', 'portfolio, php, css, mysql, js, seo, web, programming, smarty, ����������������, ���, ����, ���, html, ajax, roocms, cms, ����� �� RooCMS, ���');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(25, 'Portfolio', 14, '������', '������ ��� �������� ���������\r\n����������� � ���������', 'portfolio_indention', 'indention', 'int', '', '15');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(26, 'Portfolio', 15, '����� �� ��������', '���������� ����� ������������ �� ����� ��������', 'portfolio_workonpage', 'workonpage', 'int', '', '5');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(27, 'Gallery', 10, '����������� �� ��������', '����������� ���������� ����������� �� ��������', 'gallery_imageonpage', 'imageonpage', 'int', '', '15');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(28, 'Gallery', 20, '������', '������ ��� �������� ���������\r\n����������� � ���������', 'gallery_indention', 'indention', 'int', '', '15');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(29, 'LastNews', 1, '��������� �����', '������� ��������� ����� � ���������� ���������.\r\n���� �� ����������� ���� � ���������� ������, � ��� ����� ������ ���������, ������� ��������� � ������� ������ � ���������� ��� ������� ��� �������������� �������.', 'lastnews_title', '', 'string', '', '������ (� �� �����) �������');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(30, 'LastNews', 2, '���������� ��������', '������� ����� ����� ��������� �������� ������ ���������� � �����', 'lastnews_limit', '', 'int', '', '3');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(31, 'VK', 1, 'apiID Widget VK', '������� API ID ��� ����� �������� �� ��', 'vk_apiid', '', 'int', '', '');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(32, 'VKComments', 1, '����������� ��', '�������� ����������� � ������� ���������\r\nWidget VK Comments', 'vk_comments_on', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(33, 'VKComments', 3, '���������� ������������', '���������� ������������ �� ���� ��������.\r\n(�� 5 �� 100)', 'vk_comments_limit', '', 'int', '', '10');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(34, 'VKComments', 5, '��������', '��������� �������� � ����������� ����������\r\n(����� "����������� ���������" ������ ���� ��������"', 'vk_comments_graffiti', '', 'boolean', '', 'true');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(35, 'VKComments', 6, '����������', '��������� ���������� � ����������� ����������\r\n(����� "����������� ���������" ������ ���� ��������"', 'vk_comments_photo', '', 'boolean', '', 'true');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(36, 'VKComments', 7, '�����', '��������� ����� � ����������� ����������\r\n(����� "����������� ���������" ������ ���� ��������"', 'vk_comments_video', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(37, 'VKComments', 8, '�����', '��������� ����� � ����������� ����������\r\n(����� "����������� ���������" ������ ���� ��������"', 'vk_comments_audio', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(38, 'VKComments', 9, '������', '��������� ������ � ����������� ����������\r\n(����� "����������� ���������" ������ ���� ��������"', 'vk_comments_link', '', 'boolean', '', 'true');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(39, 'VKComments', 4, '����������� ���������', '��������� ������������ � ���������� �� Widget VK �������������� �����������', 'vk_comments_attach', '', 'boolean', '', 'true');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(40, 'VKComments', 10, '���/���� ��������������', '��������� ���������� ����� ������������ � �������� �������.', 'vk_comments_norealtime', '', 'boolean', '', 'true');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(41, 'VKComments', 11, '�������������� � ������', '�������������� ���������� ����������� � ������ ������������', 'vk_comments_autopublish', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(42, 'VKComments', 12, '������ �������', '������� � �������� ������ �������\r\n(�����������: 300\r\n� - ����� �������� ������ �������������)', 'vk_comments_width', '', 'int', '', '0');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(43, 'VKLike', 1, '��� �������� ��', '�������� "��� ��������" � ������� ���������\r\nWidget VK Like', 'vk_like_on', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(44, 'VKLike', 2, '�������� ������', '�������� ������� �������� ���� ������', 'vk_like_type', '', 'select', '������ � ��������� ���������|full\r\n������ � ����������� ���������|button\r\n����������� ������|mini\r\n����������� ������, ������� ������|vertical', 'button');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(45, 'VKLike', 3, '�������� ������', '������� ����� ������� ������ ������������ �� ������.', 'vk_like_verb', '', 'select', '��� ��������|0\r\n��� ���������|1', '1');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(46, 'GooglePlusOne', 1, '���/���� Google "+1" ', '�������� ������ "+1" �� Google', 'google_plusone_on', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(47, 'GooglePlusOne', 2, '������ ������', '������� ������ ������', 'google_plusone_size', '', 'select', '��������� (15 ��������)|small\r\n������� (20 ��������)|meduim\r\n�������� (24 �������)|standart\r\n������� (60 ��������)|tall', 'meduim');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(48, 'GooglePlusOne', 3, '���/���� �������', '����� ��������/��������� ������� ��� ������.\r\n������ ����� ������������, ���� ���� �� ������� ������� "������� (60 ��������)"', 'google_plusone_count', '', 'boolean', '', 'true');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(49, 'Sape', 1, '���/���� Sape', '�������� ����� ������� �� sape.ru\r\n(�������������� �� �������� �������� ����� �� sape � ���������� �� �� ����������� �����\r\n���������� ��������� �� ������ http://www.sape.ru/site.php?act=add)', 'sape_on', '', 'boolean', '', 'false');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(50, 'Sape', 2, '���� ������������� sape.ru', '�� ������ ������ ��� �������� � ���������� � ������ 2.\r\n�������� ������� �� 32 �������� � �������� ������ �������', 'sape_id', '', 'string', '', '');
INSERT INTO `roocms_config__settings` (`id`, `part`, `sort`, `title`, `description`, `options`, `setting_name`, `options_type`, `variants`, `value`) VALUES(51, 'RSS', 10, 'TTL', '����� ����� ���� � �������.\r\n�������� �� ����� ���� ������ 60.\r\n�� ���������: 240', 'rss_ttl', '', 'int', '', '300');

-- --------------------------------------------------------

--
-- ��������� ������� `roocms_gallery__category`
--

CREATE TABLE IF NOT EXISTS `roocms_gallery__category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(32) unsigned NOT NULL DEFAULT '0',
  `type` enum('category','part') NOT NULL DEFAULT 'category',
  `name` varchar(255) NOT NULL,
  `images` int(32) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_gallery__category`
--



-- --------------------------------------------------------

--
-- ��������� ������� `roocms_gallery__items`
--

CREATE TABLE IF NOT EXISTS `roocms_gallery__items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb_img` varchar(255) NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_gallery__items`
--



-- --------------------------------------------------------

--
-- ��������� ������� `roocms_news__category`
--

CREATE TABLE IF NOT EXISTS `roocms_news__category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `items` int(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT= ;

--
-- ���� ������ ������� `roocms_news__category`
--



-- --------------------------------------------------------

--
-- ��������� ������� `roocms_news__files`
--

CREATE TABLE IF NOT EXISTS `roocms_news__files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `ext` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_news__files`
--


-- --------------------------------------------------------

--
-- ��������� ������� `roocms_news__image`
--

CREATE TABLE IF NOT EXISTS `roocms_news__image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `thumb_img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_news__image`
--



-- --------------------------------------------------------

--
-- ��������� ������� `roocms_news__item`
--

CREATE TABLE IF NOT EXISTS `roocms_news__item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `date_create` int(30) unsigned NOT NULL DEFAULT '0',
  `date_update` int(30) unsigned NOT NULL DEFAULT '0',
  `date` int(30) unsigned NOT NULL DEFAULT '1',
  `brief_news` text NOT NULL,
  `full_news` longtext NOT NULL,
  `images` int(4) unsigned NOT NULL DEFAULT '0',
  `files` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_news__item`
--


-- --------------------------------------------------------

--
-- ��������� ������� `roocms_page__unit`
--

CREATE TABLE IF NOT EXISTS `roocms_page__unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `def` enum('false','true') NOT NULL DEFAULT 'false',
  `alias` varchar(255) NOT NULL,
  `page_type` enum('html','php') NOT NULL DEFAULT 'html',
  `page_title` varchar(255) NOT NULL,
  `page_content` longtext NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `last_update` bigint(32) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_page__unit`
--


-- --------------------------------------------------------

--
-- ��������� ������� `roocms_portfolio__category`
--

CREATE TABLE IF NOT EXISTS `roocms_portfolio__category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('category','part') NOT NULL DEFAULT 'category',
  `name` varchar(255) NOT NULL,
  `projects` int(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_portfolio__category`
--


-- --------------------------------------------------------

--
-- ��������� ������� `roocms_portfolio__projects`
--

CREATE TABLE IF NOT EXISTS `roocms_portfolio__projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(4) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `poster` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_portfolio__projects`
--


-- --------------------------------------------------------

--
-- ��������� ������� `roocms_portfolio__projects_steps`
--

CREATE TABLE IF NOT EXISTS `roocms_portfolio__projects_steps` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `step` int(10) unsigned NOT NULL,
  `step_picture` varchar(255) NOT NULL,
  `step_description` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `roocms_portfolio__projects_steps`
--

