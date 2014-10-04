-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 04, 2014 at 06:03 PM
-- Server version: 5.5.38-0+wheezy1-log
-- PHP Version: 5.4.4-14+deb7u14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kopceak1_apl`
--

-- --------------------------------------------------------

--
-- Table structure for table `apl_acte`
--

CREATE TABLE IF NOT EXISTS `apl_acte_test` (
`id` int(11) NOT NULL,
  `doc_nr` varchar(50) NOT NULL,
  `title` varchar(500) NOT NULL,
  `type` enum('Dispoziție','Decizie') NOT NULL DEFAULT 'Decizie',
  `date_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emitent` enum('Primaria','Consiliu Local') NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `apl_acte`
--

INSERT INTO `apl_acte_test` (`id`, `doc_nr`, `title`, `type`, `date_upload`, `emitent`) VALUES
(1, '12/43', 'dfgdsgfdgfdgffgdert', 'Dispoziție', '2014-10-09 02:57:50', 'Primaria'),
(2, '101', 'gdfgdfgdfgdf gdgd', 'Decizie', '2014-10-03 12:19:24', 'Primaria'),
(3, '123', 'Nike Aix Max 90 VT', 'Decizie', '2014-10-03 12:19:44', 'Primaria');


--
-- Indexes for table `apl_acte`
--
ALTER TABLE `apl_acte_test`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `apl_acte`
--
ALTER TABLE `apl_acte_test`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;


