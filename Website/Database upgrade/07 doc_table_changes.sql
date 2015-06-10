-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 10 jun 2015 kl 16:30
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
-- Tabellstruktur `doc_category`
--

DROP TABLE IF EXISTS `doc_category`;
CREATE TABLE IF NOT EXISTS `doc_category` (
  `doc_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`doc_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `doc_game`
--

DROP TABLE IF EXISTS `doc_game`;
CREATE TABLE IF NOT EXISTS `doc_game` (
  `doc_games_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `doc_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`doc_games_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `doc_tools`
--

DROP TABLE IF EXISTS `doc_tools`;
CREATE TABLE IF NOT EXISTS `doc_tools` (
  `doc_tools_id` int(11) NOT NULL AUTO_INCREMENT,
  `tools_id` int(11) DEFAULT NULL,
  `doc_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`doc_tools_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `doc_type`
--

DROP TABLE IF EXISTS `doc_type`;
CREATE TABLE IF NOT EXISTS `doc_type` (
  `doc_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_type_name` varchar(255) DEFAULT NULL,
  `doc_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`doc_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
