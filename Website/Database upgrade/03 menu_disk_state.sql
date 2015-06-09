-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 07 jun 2015 kl 15:07
-- Serverversion: 5.5.43
-- PHP-version: 5.4.39-0+deb7u2

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
-- Tabellstruktur `menu_disk_state`
--

CREATE TABLE IF NOT EXISTS `menu_disk_state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_state` text NOT NULL,
  UNIQUE KEY `id_state` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `menu_disk_state`
--

INSERT INTO `menu_disk_state` (`state_id`, `menu_state`) VALUES
(1, 'missing'),
(2, 'intro only or partially damaged'),
(3, 'slightly damaged'),
(4, 'fully working');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
