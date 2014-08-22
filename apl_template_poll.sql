-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 22 Aug 2014 la 17:34
-- Server version: 5.6.16
-- PHP Version: 5.5.9

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
-- Structura de tabel pentru tabelul `apl_poll`
--

CREATE TABLE IF NOT EXISTS `apl_poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` int(11) NOT NULL DEFAULT '1',
  `enabled` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Salvarea datelor din tabel `apl_poll`
--

INSERT INTO `apl_poll` (`id`, `date_created`, `author_id`, `enabled`) VALUES
(10, '2014-08-22 15:10:01', 1, 1),
(13, '2014-08-22 15:12:46', 1, 1);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `apl_poll_answer`
--

CREATE TABLE IF NOT EXISTS `apl_poll_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `poll_question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Salvarea datelor din tabel `apl_poll_answer`
--

INSERT INTO `apl_poll_answer` (`id`, `title`, `poll_question_id`) VALUES
(11, 'answer1', 7),
(12, 'answer2', 7),
(13, 'answer3', 7),
(14, 'ответ1', 8),
(15, 'ответ2', 8),
(16, 'ответ3', 8),
(17, 'answer21', 9),
(18, 'answer22', 9),
(19, 'вопрос21', 10),
(20, 'вопрос22', 10);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `apl_poll_question`
--

CREATE TABLE IF NOT EXISTS `apl_poll_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Salvarea datelor din tabel `apl_poll_question`
--

INSERT INTO `apl_poll_question` (`id`, `title`, `poll_id`, `lang_id`) VALUES
(7, 'Intrebare 1', 10, 1),
(8, 'Вопрос 1', 10, 2),
(9, 'Intrebare 2', 13, 1),
(10, 'Вопрос 2', 13, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
