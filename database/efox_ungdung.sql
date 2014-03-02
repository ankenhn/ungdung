-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2014 at 12:26 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `efox_ungdung`
--

-- --------------------------------------------------------

--
-- Table structure for table `efox_activity`
--

CREATE TABLE IF NOT EXISTS `efox_activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `target_url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `browser` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `browser_version` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`activity_id`,`browser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `efox_activity`
--

INSERT INTO `efox_activity` (`activity_id`, `module`, `action`, `user_id`, `target_id`, `target_url`, `browser`, `browser_version`, `ip`, `os`, `created_on`, `read`, `customer_id`) VALUES
(1, 'users', 'updated a user', 1, 3, '/settings/users/profile/', 'Firefox', '27.0', '127.0.0.1', 'Windows 7', '2014-03-02 18:13:11', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `efox_customer`
--

CREATE TABLE IF NOT EXISTS `efox_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `expiry_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `efox_customer`
--

INSERT INTO `efox_customer` (`customer_id`, `username`, `active`, `expiry_date`) VALUES
(1, 'duyanhvn', 1, '2014-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `efox_domain`
--

CREATE TABLE IF NOT EXISTS `efox_domain` (
  `domain_id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modify_by` int(11) DEFAULT NULL,
  `modify_on` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_on` datetime DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`domain_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `efox_domain`
--

INSERT INTO `efox_domain` (`domain_id`, `domain`, `active`, `created_by`, `created_on`, `modify_by`, `modify_on`, `deleted`, `deleted_on`, `customer_id`) VALUES
(1, 'customer.com', 1, NULL, NULL, NULL, NULL, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `efox_email_queue`
--

CREATE TABLE IF NOT EXISTS `efox_email_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `message` text,
  `to` longtext,
  `send_success` longtext,
  `send_failed` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `efox_email_queue`
--

INSERT INTO `efox_email_queue` (`id`, `subject`, `message`, `to`, `send_success`, `send_failed`) VALUES
(1, 'hhh', 'asdasd<br/>ha duy anh', '["keith@jupitech.sg","enternity90@gmail","coder.notepad@gmail.com"]', '["keith@jupitech.sg","coder.notepad@gmail.com"]', '["enternity90@gmail"]');

-- --------------------------------------------------------

--
-- Table structure for table `efox_login_attempts`
--

CREATE TABLE IF NOT EXISTS `efox_login_attempts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) NOT NULL,
  `login` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `efox_menu`
--

CREATE TABLE IF NOT EXISTS `efox_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `target` enum('_self','_blank','_top') DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `order` int(11) DEFAULT '0',
  `parent` int(11) DEFAULT '0',
  `image` varchar(250) DEFAULT NULL,
  `roles` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `efox_menu`
--

INSERT INTO `efox_menu` (`id`, `name`, `url`, `target`, `active`, `order`, `parent`, `image`, `roles`) VALUES
(1, 'Dashboard', '/admin/content', '_self', 1, 0, 0, 'assets/uploads/8d6ab84ca2af9fccd4e4048694176ebf/cee8d6b7ce52554fd70354e37bbf44a2/ff44570aca8241914870afbc310cdb85/dashboard.png', '["1","2"]'),
(2, 'Users', '/admin/settings/users', '_self', 1, 2, 0, 'assets/uploads/8d6ab84ca2af9fccd4e4048694176ebf/cee8d6b7ce52554fd70354e37bbf44a2/ff44570aca8241914870afbc310cdb85/users.png', '["1","2"]'),
(4, 'System', '/admin/settings/system', '_self', 1, 3, 0, 'assets/uploads/8d6ab84ca2af9fccd4e4048694176ebf/cee8d6b7ce52554fd70354e37bbf44a2/ff44570aca8241914870afbc310cdb85/system.png', '["1","2"]'),
(11, 'Roles', '/admin/settings/roles', '_self', 1, 0, 4, '', '["1"]'),
(20, 'Permissions', '/admin/settings/permissions', '_self', 1, 1, 4, '', '["1"]'),
(23, 'Menu', '/admin/content/menu', '_self', 1, 2, 4, 'menu.png', '["1"]'),
(28, 'Config', '/admin/settings/system', '_self', 1, 3, 4, '', '["1","2"]'),
(29, 'Emailer', '/admin/settings/emailer', '_self', 0, 1, 0, 'assets/uploads/8d6ab84ca2af9fccd4e4048694176ebf/cee8d6b7ce52554fd70354e37bbf44a2/ff44570aca8241914870afbc310cdb85/mail.png', '["1","2"]');

-- --------------------------------------------------------

--
-- Table structure for table `efox_permissions`
--

CREATE TABLE IF NOT EXISTS `efox_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `efox_permissions`
--

INSERT INTO `efox_permissions` (`permission_id`, `name`, `description`, `status`) VALUES
(1, 'Site.BackEnd.Login', '', 'active'),
(2, 'Site.FrontEnd.Login', '', 'active'),
(4, 'Site.Roles.Manage', '', 'active'),
(5, 'Permission.Users.Manage', '', 'active'),
(6, 'Site.Administrator.Manage', '', 'active'),
(7, 'Site.Customers.Manage', '', 'active'),
(8, 'Site.Menu.Manage', '', 'active'),
(9, 'Site.Settings.Manage', '', 'active'),
(12, 'Emailer.Queue.Run', '', 'active'),
(13, 'Emailer.Queue.Update', '', 'active'),
(14, 'Emailer.Queue.Delete', '', 'active'),
(16, 'Site.Permissions.Manage', '', 'active'),
(18, 'Site.Customer.Manage', 'To manage the access control permissions for the  role', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `efox_roles`
--

CREATE TABLE IF NOT EXISTS `efox_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(60) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `login_destination` varchar(255) NOT NULL DEFAULT '/',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `default_context` varchar(255) NOT NULL DEFAULT 'content',
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `efox_roles`
--

INSERT INTO `efox_roles` (`role_id`, `role_name`, `description`, `default`, `can_delete`, `login_destination`, `deleted`, `default_context`, `customer_id`) VALUES
(1, 'Administrator', 'Has full control over every aspect of the site.', 0, 0, '/admin/settings/users', 0, 'content', NULL),
(2, 'Customer', '', 1, 1, '/admin/settings/users', 0, 'content', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `efox_role_permissions`
--

CREATE TABLE IF NOT EXISTS `efox_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`,`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `efox_role_permissions`
--

INSERT INTO `efox_role_permissions` (`role_id`, `permission_id`, `customer_id`) VALUES
(1, 1, 0),
(1, 2, 0),
(1, 3, 0),
(1, 4, 0),
(1, 5, 0),
(1, 6, 0),
(1, 7, 0),
(1, 8, 0),
(1, 9, 0),
(1, 12, 0),
(1, 13, 0),
(1, 14, 0),
(1, 16, 0),
(1, 17, 0),
(1, 18, 0),
(2, 1, 0),
(2, 5, 0),
(2, 7, 0),
(2, 8, 0),
(2, 9, 0),
(2, 17, 0),
(2, 18, 0);

-- --------------------------------------------------------

--
-- Table structure for table `efox_sessions`
--

CREATE TABLE IF NOT EXISTS `efox_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `efox_sessions`
--

INSERT INTO `efox_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('754eaded7b51addbd81634f569754429', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', 1391615995, 'a:11:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"username";s:5:"admin";s:5:"email";s:17:"admin@jupitech.sg";s:6:"avatar";s:163:"assets/uploads/aec9f4efc5a055bbd053f220538c61e0/cee8d6b7ce52554fd70354e37bbf44a2/ff44570aca8241914870afbc310cdb85/hinh-xam-ca-chep-dep-19-cua-nam-fuong-tattoo3.jpg";s:11:"auth_custom";s:17:"admin@jupitech.sg";s:10:"user_token";s:40:"53f6b34d3fb0e7c57372f6c5991ef137aec66fb0";s:8:"identity";s:17:"admin@jupitech.sg";s:7:"role_id";s:1:"1";s:9:"logged_in";b:1;s:13:"previous_page";s:41:"http://localhost/php/admin/settings/users";}');

-- --------------------------------------------------------

--
-- Table structure for table `efox_settings`
--

CREATE TABLE IF NOT EXISTS `efox_settings` (
  `name` varchar(30) NOT NULL,
  `module` varchar(50) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `efox_settings`
--

INSERT INTO `efox_settings` (`name`, `module`, `value`) VALUES
('document.upload', 'upload', ''),
('gallery.upload', 'upload', 'jpg,png,jpeg'),
('mailpath', 'email', '/usr/sbin/sendmail'),
('media.upload', 'upload', ''),
('meta.description', 'meta', 'this is demo description'),
('meta.keyword', 'meta', 'html,css'),
('protocol', 'email', 'smtp'),
('sender_email', 'email', 'admin@jupitech.sg'),
('sender_name', 'email', 'Keith'),
('site.maintenance', 'core', '0'),
('site.maintenance_content', 'core', '<p style="text-align:center"><span style="font-size:24px"><span style="font-family:comic sans ms,cursive"><strong>Maintenance</strong></span></span></p>\r\n'),
('site.title', 'core', 'CMS v1.2'),
('size.upload', 'upload', '2048'),
('smtp_crypto', 'email', 'tls'),
('smtp_host', 'email', 'mail1.thejupitech.com'),
('smtp_pass', 'email', 'UUd9zkzEE6'),
('smtp_port', 'email', '587'),
('smtp_timeout', 'email', '30'),
('smtp_user', 'email', 'no-reply@mail1.thejupitech.com');

-- --------------------------------------------------------

--
-- Table structure for table `efox_users`
--

CREATE TABLE IF NOT EXISTS `efox_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '4',
  `email` varchar(120) NOT NULL,
  `first_name` varchar(30) NOT NULL DEFAULT '',
  `last_name` varchar(30) NOT NULL,
  `password_hash` char(60) NOT NULL,
  `reset_hash` varchar(40) DEFAULT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(40) NOT NULL DEFAULT '',
  `reset_by` int(10) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `modify_by` int(11) DEFAULT NULL,
  `modify_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(250) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `efox_users`
--

INSERT INTO `efox_users` (`id`, `role_id`, `email`, `first_name`, `last_name`, `password_hash`, `reset_hash`, `last_login`, `last_ip`, `reset_by`, `deleted`, `modify_by`, `modify_on`, `active`, `avatar`, `birthday`, `created_by`, `created_on`, `customer_id`) VALUES
(1, 1, 'keith@jupitech.sg', 'Duy Anh', 'Ha', '$2a$08$nEBztpwD7RMORzWSlx18RezmogItnin8ke5q6fejSFJbHYeJd1q5G', '04b953fa45286657763277530e27e1f794c59465', '2014-03-02 17:18:34', '127.0.0.1', 1392266953, 0, 1, '2014-03-02 10:18:34', 1, 'assets/uploads/aec9f4efc5a055bbd053f220538c61e0/cee8d6b7ce52554fd70354e37bbf44a2/ff44570aca8241914870afbc310cdb85/hinh-xam-ca-chep-dep-19-cua-nam-fuong-tattoo3.jpg', '1990-01-22', 1, '2014-01-21 09:18:27', 1),
(2, 2, 'customer@jupitech.sg', 'Jupitech', '', '$2a$08$3bPGnaQj8nwDdslQ1QW1OedvZuko0degh6bjT53LKUAzKhKpgh14S', NULL, '2014-02-10 10:27:17', '::1', NULL, 0, NULL, '0000-00-00 00:00:00', 1, '', '2014-02-06', 1, '2014-02-06 02:07:51', 1),
(3, 1, 'admin@jupitech.sg', 'Developer', 'j', '$2a$08$.sMgePH1RxmyxWmRQ3RbPuaicQ2X26pyZ0lBY0CC/K6wJDVtFnVQS', NULL, '0000-00-00 00:00:00', '', NULL, 0, 1, '2014-03-02 11:13:11', 1, '', '2014-02-10', 1, '2014-02-10 08:58:41', 2),
(4, 1, 'haduyanh@gmail.com', 'Test', 'User', '$2a$08$53UILJt2wmAUlszWVyD3rOPPUU/onShqsAamRL55JA6N7hxSxA7py', NULL, '0000-00-00 00:00:00', '', NULL, 0, 1, '0000-00-00 00:00:00', 1, 'assets/uploads/aec9f4efc5a055bbd053f220538c61e0/cee8d6b7ce52554fd70354e37bbf44a2/ff44570aca8241914870afbc310cdb85/0pbembhfqj6e5joe0mam1.jpg', '2014-03-21', 1, '2014-03-01 11:41:12', 2);

-- --------------------------------------------------------

--
-- Table structure for table `efox_user_cookies`
--

CREATE TABLE IF NOT EXISTS `efox_user_cookies` (
  `user_id` bigint(20) NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL,
  KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `efox_user_cookies`
--

INSERT INTO `efox_user_cookies` (`user_id`, `token`, `created_on`) VALUES
(1, 'zH45UtYVzZSvGS5zrVK7Uvzt1It3s7wuJV5ltjDYUWoIRvxrvJz9xcVpdCZ4yQx6uPG2C8IxBCWLLNFUxJZExQDE9s1emov88er5EvhUOo0ZypIIwFyRiYBQrT8u7vMP', '2014-01-24 03:05:22');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
