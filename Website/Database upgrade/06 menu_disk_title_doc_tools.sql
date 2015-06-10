-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 09 jun 2015 kl 19:44
-- Serverversion: 5.5.43
-- PHP-version: 5.4.41-0+deb7u1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `atarilegend`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `menu_disk_title_doc_tools`
--

DROP TABLE IF EXISTS `menu_disk_title_doc_tools`;
CREATE TABLE IF NOT EXISTS `menu_disk_title_doc_tools` (
  `menu_disk_title_doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_disk_title_id` int(11) DEFAULT NULL,
  `doc_tools_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_disk_title_doc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
