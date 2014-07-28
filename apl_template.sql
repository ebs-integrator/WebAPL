-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2014 at 11:24 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `apl_template`
--

-- --------------------------------------------------------

--
-- Table structure for table `apl_category_lang`
--

CREATE TABLE IF NOT EXISTS `apl_category_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `uri` varchar(250) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apl_feed`
--

CREATE TABLE IF NOT EXISTS `apl_feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT '1',
  `limit_value` int(11) NOT NULL DEFAULT '10' COMMENT '0 - unlimited; n - limited',
  `limit_type` smallint(6) NOT NULL DEFAULT '0' COMMENT '0 - pagination; 1 - strict limit',
  `order_by` int(11) NOT NULL DEFAULT '0' COMMENT 'feed_field_id',
  `order_type` enum('asc','desc','rand()','none') NOT NULL DEFAULT 'none' COMMENT 'none - disable order',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `apl_feed`
--

INSERT INTO `apl_feed` (`id`, `name`, `enabled`, `limit_value`, `limit_type`, `order_by`, `order_type`) VALUES
(1, 'werwerwer 2 dsfasdfasd dsfdsfs dfdsfdsfds', 1, 2342, 1, 1, 'rand()'),
(2, 'feed nou', 1, 10, 1, 1, 'asc'),
(3, 'feed nou', 1, 10, 1, 0, 'asc'),
(4, '', 1, 0, 0, 0, 'none');

-- --------------------------------------------------------

--
-- Table structure for table `apl_feed_field`
--

CREATE TABLE IF NOT EXISTS `apl_feed_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `fkey` varchar(50) NOT NULL,
  `field_html` text CHARACTER SET utf8 NOT NULL,
  `lang_dependent` int(1) NOT NULL DEFAULT '0',
  `value_filter` varchar(200) NOT NULL,
  `check_filter` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `apl_feed_field`
--

INSERT INTO `apl_feed_field` (`id`, `title`, `fkey`, `field_html`, `lang_dependent`, `value_filter`, `check_filter`) VALUES
(1, 'End date', 'end_date', '<input type="text" value="{value}" class="{class}" name="{name}" /> ', 0, '', ''),
(2, 'Test text', 'test_text', '<textarea name="{name}" class="{class}">\r\n{value}\r\n</textarea>', 0, '', ''),
(3, 'Test Checkbox', 'check_check', '<input type="checkbox" name="{name}" class="make-switch" {value} />', 0, 'valueCheckbox', 'checkCheckbox');

-- --------------------------------------------------------

--
-- Table structure for table `apl_feed_field_value`
--

CREATE TABLE IF NOT EXISTS `apl_feed_field_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_id` int(11) NOT NULL DEFAULT '0',
  `feed_field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apl_feed_post`
--

CREATE TABLE IF NOT EXISTS `apl_feed_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `apl_feed_post`
--

INSERT INTO `apl_feed_post` (`id`, `feed_id`, `post_id`) VALUES
(1, 1, 19),
(2, 1, 20),
(3, 1, 21),
(17, 1, 22),
(18, 2, 22),
(19, 3, 22),
(23, 1, 23),
(24, 2, 23),
(25, 3, 23),
(36, 1, 24),
(37, 2, 24),
(38, 3, 24),
(39, 4, 24);

-- --------------------------------------------------------

--
-- Table structure for table `apl_feed_rel`
--

CREATE TABLE IF NOT EXISTS `apl_feed_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) NOT NULL,
  `feed_field_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `apl_feed_rel`
--

INSERT INTO `apl_feed_rel` (`id`, `feed_id`, `feed_field_id`) VALUES
(1, 1, 1),
(2, 3, 1),
(3, 4, 1),
(4, 4, 2),
(5, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `apl_file`
--

CREATE TABLE IF NOT EXISTS `apl_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `path` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `size` decimal(10,2) NOT NULL,
  `date_uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `module_name` varchar(20) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `apl_file`
--

INSERT INTO `apl_file` (`id`, `name`, `path`, `type`, `extension`, `size`, `date_uploaded`, `module_name`, `module_id`) VALUES
(66, 'metis-tile.png', 'upload/53bd627b58e51_-1087306386.png', 'image', 'png', '5194.00', '2014-07-09 15:40:43', 'test', 1),
(75, 'metis-tile.png', 'upload/53bd636adcff2_689146877ce1dffa6e2b2fa0ad274d09.png', 'image', 'png', '5194.00', '2014-07-09 15:44:42', 'test', 1),
(77, 'user.gif', 'upload/53bd637e19f73_54b9352428c145c962dd452e9a927122.gif', 'image', 'gif', '239.00', '2014-07-09 15:45:02', 'rewwe', 1),
(78, 'user.gif', 'upload/53c134ddc015e_54b9352428c145c962dd452e9a927122.gif', 'image', 'gif', '239.00', '2014-07-12 13:15:09', 'test', 1),
(79, 'image.jpg', 'upload/53c934bf0d8f4_0d5b1c4c7f720f698946c7f6ab08f687.jpg', 'image', 'jpg', '53058.00', '2014-07-18 14:52:47', 'page', 12),
(81, '53cb90c0e28e2_26d1c2c946f83a115a680df4a69f2f5f.png', 'upload/53cec7eb72c50_90cd3318d570ca2a0dbeb67abdbf909e.png', 'image', 'png', '576952.00', '2014-07-22 20:22:03', 'page', 18);

-- --------------------------------------------------------

--
-- Table structure for table `apl_gallery`
--

CREATE TABLE IF NOT EXISTS `apl_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `apl_gallery`
--

INSERT INTO `apl_gallery` (`id`, `name`) VALUES
(1, 'dfsdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `apl_lang`
--

CREATE TABLE IF NOT EXISTS `apl_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `ext` varchar(2) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `apl_lang`
--

INSERT INTO `apl_lang` (`id`, `name`, `ext`, `enabled`) VALUES
(1, 'Romanian', 'ro', 1),
(2, 'Russian', 'ru', 1);

-- --------------------------------------------------------

--
-- Table structure for table `apl_menu`
--

CREATE TABLE IF NOT EXISTS `apl_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `apl_menu`
--

INSERT INTO `apl_menu` (`id`, `name`, `enabled`) VALUES
(5, 'dffasfasdfasdf', 1),
(6, 'dsfasdfasdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `apl_menu_item`
--

CREATE TABLE IF NOT EXISTS `apl_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1',
  `parent` int(11) NOT NULL DEFAULT '0',
  `ord` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `apl_menu_item`
--

INSERT INTO `apl_menu_item` (`id`, `menu_id`, `enabled`, `parent`, `ord`) VALUES
(14, 5, 1, 0, 0),
(16, 5, 1, 0, 0),
(17, 6, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `apl_menu_item_lang`
--

CREATE TABLE IF NOT EXISTS `apl_menu_item_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_item_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `href` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `apl_menu_item_lang`
--

INSERT INTO `apl_menu_item_lang` (`id`, `menu_item_id`, `lang_id`, `title`, `href`) VALUES
(14, 14, 1, 'fadsfasd fdasf', 'ads fdasf asdf as'),
(15, 15, 1, 'qweqdsadasd', 'asdasdasdasd'),
(16, 16, 1, 'qweqqwe', 'sdafsdfasdf'),
(17, 17, 1, 'sdfsdf', 'asdfasdfasd'),
(18, 17, 2, 'fasdfasd', 'fsadfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `apl_module`
--

CREATE TABLE IF NOT EXISTS `apl_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `extension` varchar(100) NOT NULL,
  `settings_page` varchar(255) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `apl_module`
--

INSERT INTO `apl_module` (`id`, `name`, `extension`, `settings_page`, `enabled`) VALUES
(1, 'First Module', 'mymodule', 'mymodule/settings', 1),
(2, 'Gallery', 'gallery', 'gallery/settings', 1);

-- --------------------------------------------------------

--
-- Table structure for table `apl_post`
--

CREATE TABLE IF NOT EXISTS `apl_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` int(11) DEFAULT NULL,
  `taxonomy_id` int(11) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `parent` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `apl_post`
--

INSERT INTO `apl_post` (`id`, `created_at`, `updated_at`, `author_id`, `taxonomy_id`, `views`, `parent`) VALUES
(17, '2014-07-20 17:33:52', '2014-07-20 17:33:52', 1, 1, 0, 0),
(18, '2014-07-20 17:34:30', '2014-07-20 17:34:30', 1, 1, 0, 17),
(19, '2014-07-23 00:21:14', '2014-07-23 00:21:14', 1, 2, 0, 0),
(20, '2014-07-23 00:21:24', '2014-07-23 09:40:42', 1, 2, 0, 0),
(21, '2014-08-23 00:25:00', '2014-07-23 10:12:43', 1, 2, 0, 0),
(22, '2014-07-23 11:28:50', '2014-07-23 12:06:45', 1, 2, 0, 0),
(23, '2014-07-23 12:11:39', '2014-07-23 12:11:39', 1, 2, 0, 0),
(24, '2014-07-25 07:40:12', '2014-07-25 07:40:12', 1, 2, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `apl_post_category`
--

CREATE TABLE IF NOT EXISTS `apl_post_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apl_post_lang`
--

CREATE TABLE IF NOT EXISTS `apl_post_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `uri` varchar(200) NOT NULL,
  `post_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `apl_post_lang`
--

INSERT INTO `apl_post_lang` (`id`, `title`, `text`, `uri`, `post_id`, `lang_id`, `enabled`) VALUES
(18, 'wqeqweqw', 'qweqweqweqweqw', 'eqweqwe', 17, 1, 1),
(19, 'qweqw', 'eqqweqwe', 'eqwewqeqwe', 17, 2, 1),
(20, 'dfsf gdfgdfg', ' fdgsdf gsdfgdf gdfgdfg dfg dfg dfgs df', 'dfsdf fdgsdfg sdfgdvevfev', 18, 1, 0),
(21, 'dsfsdffsdfsdfs', 'dss gsfdgsdfg sdfgdfgsdf s gfds', 'dsfsdffsdfsdfs', 18, 2, 1),
(22, 'dadsfsdfasdfasdxcvxcvzxc', '', '', 21, 1, 1),
(23, 'sdfsdfsdf ds fsdfsd fs', '', '', 21, 2, 1),
(24, 'zxcZXczXCZXczxczxCZX', 'dfsdfsadfadsfs\ndfasdsafasdfasdfasdf', '', 22, 1, 1),
(25, 'dfgsdgdsfgdsfg', 'fdg sdfgdfgdsfg sdfgfgdfg dfgsdf gd', '', 22, 2, 1),
(26, 'qweqweqwe', '', '', 23, 1, 1),
(27, 'qweqweqweqwqwe', '', '', 23, 2, 1),
(28, '', '', '', 24, 1, 1),
(29, '', '', '', 24, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `apl_setting`
--

CREATE TABLE IF NOT EXISTS `apl_setting` (
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `apl_taxonomy`
--

CREATE TABLE IF NOT EXISTS `apl_taxonomy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `apl_taxonomy`
--

INSERT INTO `apl_taxonomy` (`id`, `name`) VALUES
(2, 'article'),
(1, 'page');

-- --------------------------------------------------------

--
-- Table structure for table `apl_user`
--

CREATE TABLE IF NOT EXISTS `apl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `apl_user`
--

INSERT INTO `apl_user` (`id`, `username`, `password`, `remember_token`, `email`, `register_date`, `updated_at`) VALUES
(1, 'admin', '$2y$10$FuiZTWjWab34tm7pyMjPcu45ec0UBZyvdwqpCtwyQWtROdQAybSkW', 'SIg58swpP88EO5qk6FQV07lzR86wjCX1gIOM8eW8HYa5ouduefDvT1MlfBlt', 'ngodina@eba.md', '2014-06-28 18:23:41', '2014-06-28 16:19:49');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
