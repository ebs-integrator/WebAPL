-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2014 at 05:28 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apl_feed_field`
--

CREATE TABLE IF NOT EXISTS `apl_feed_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `type` int(11) NOT NULL COMMENT 'feed_field_type',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apl_feed_field_type`
--

CREATE TABLE IF NOT EXISTS `apl_feed_field_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apl_feed_field_value`
--

CREATE TABLE IF NOT EXISTS `apl_feed_field_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_lang_id` int(11) NOT NULL,
  `feed_field_type_id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `apl_file`
--

INSERT INTO `apl_file` (`id`, `name`, `path`, `type`, `extension`, `size`, `date_uploaded`, `module_name`, `module_id`) VALUES
(66, 'metis-tile.png', 'upload/53bd627b58e51_-1087306386.png', 'image', 'png', '5194.00', '2014-07-09 15:40:43', 'test', 1),
(75, 'metis-tile.png', 'upload/53bd636adcff2_689146877ce1dffa6e2b2fa0ad274d09.png', 'image', 'png', '5194.00', '2014-07-09 15:44:42', 'test', 1),
(77, 'user.gif', 'upload/53bd637e19f73_54b9352428c145c962dd452e9a927122.gif', 'image', 'gif', '239.00', '2014-07-09 15:45:02', 'rewwe', 1),
(78, 'user.gif', 'upload/53c134ddc015e_54b9352428c145c962dd452e9a927122.gif', 'image', 'gif', '239.00', '2014-07-12 13:15:09', 'test', 1),
(79, 'image.jpg', 'upload/53c934bf0d8f4_0d5b1c4c7f720f698946c7f6ab08f687.jpg', 'image', 'jpg', '53058.00', '2014-07-18 14:52:47', 'page', 12);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `apl_lang`
--

INSERT INTO `apl_lang` (`id`, `name`, `ext`, `enabled`) VALUES
(1, 'Romanian', 'ro', 1);

-- --------------------------------------------------------

--
-- Table structure for table `apl_menu`
--

CREATE TABLE IF NOT EXISTS `apl_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `apl_menu`
--

INSERT INTO `apl_menu` (`id`, `name`, `enabled`) VALUES
(5, 'dffasfasdfasdf', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `apl_menu_item`
--

INSERT INTO `apl_menu_item` (`id`, `menu_id`, `enabled`, `parent`, `ord`) VALUES
(14, 5, 1, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `apl_menu_item_lang`
--

INSERT INTO `apl_menu_item_lang` (`id`, `menu_item_id`, `lang_id`, `title`, `href`) VALUES
(14, 14, 1, 'fadsfasd fdasf', 'ads fdasf asdf as');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `apl_module`
--

INSERT INTO `apl_module` (`id`, `name`, `extension`, `settings_page`, `enabled`) VALUES
(1, 'First Module', 'mymodule', 'mymodule/settings', 1);

-- --------------------------------------------------------

--
-- Table structure for table `apl_post`
--

CREATE TABLE IF NOT EXISTS `apl_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` int(11) DEFAULT NULL,
  `taxonomy_id` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `apl_post`
--

INSERT INTO `apl_post` (`id`, `date_create`, `date_update`, `author_id`, `taxonomy_id`, `parent`) VALUES
(5, '2014-07-18 17:02:07', '2014-07-18 17:02:07', 1, NULL, 0),
(6, '2014-07-18 17:03:07', '2014-07-18 17:03:07', 1, NULL, 0),
(7, '2014-07-18 17:03:43', '2014-07-18 17:03:43', 1, NULL, 5),
(8, '2014-07-18 17:12:58', '2014-07-18 17:12:58', 1, NULL, 5),
(9, '2014-07-18 17:13:05', '2014-07-18 17:13:05', 1, NULL, 5),
(10, '2014-07-18 17:13:16', '2014-07-18 17:13:16', 1, NULL, 8),
(11, '2014-07-18 17:13:21', '2014-07-18 17:13:21', 1, NULL, 8),
(12, '2014-07-18 17:13:57', '2014-07-18 17:13:57', 1, NULL, 10),
(13, '2014-07-18 17:32:27', '2014-07-18 17:32:27', 1, NULL, 12),
(14, '2014-07-19 17:56:10', '2014-07-18 18:25:30', 1, NULL, 9);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `apl_post_lang`
--

INSERT INTO `apl_post_lang` (`id`, `title`, `text`, `uri`, `post_id`, `lang_id`, `enabled`) VALUES
(4, '', '', '', 5, 1, 1),
(5, '', '', '', 6, 1, 1),
(6, '', '', '', 7, 1, 1),
(7, '', '', '', 8, 1, 1),
(8, '', '', '', 9, 1, 1),
(9, '', '', '', 10, 1, 1),
(10, '', '', '', 11, 1, 1),
(11, '', '', '', 12, 1, 1),
(12, '', '', '', 13, 1, 1),
(13, '', '', '', 14, 1, 1);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
