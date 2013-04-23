-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 10, 2013 at 04:39 AM
-- Server version: 5.5.29
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `dengubenko_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `first_comment`
--

CREATE TABLE IF NOT EXISTS `first_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `text` varchar(10000) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `check` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `first_post`
--

CREATE TABLE IF NOT EXISTS `first_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `text` varchar(10000) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `tags` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `first_post`
--

INSERT INTO `first_post` (`id`, `user`, `text`, `active`, `tags`) VALUES
(1, 4, 'asdasdasdasdasdasd', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `first_roles`
--

CREATE TABLE IF NOT EXISTS `first_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `c1` enum('0','1') DEFAULT '0',
  `c2` enum('0','1') DEFAULT '0',
  `c3` enum('0','1') DEFAULT '0',
  `c4` enum('0','1') DEFAULT '0',
  `cr2` enum('0','1') DEFAULT '0',
  `cr3` enum('0','1') DEFAULT '0',
  `cr4` enum('0','1') DEFAULT '0',
  `post` varchar(255) DEFAULT NULL,
  `p1` enum('0','1') DEFAULT '0',
  `p2` enum('0','1') DEFAULT '0',
  `p3` enum('0','1') DEFAULT '0',
  `p4` enum('0','1') DEFAULT '0',
  `pr2` enum('0','1') DEFAULT '0',
  `pr3` enum('0','1') DEFAULT '0',
  `pr4` enum('0','1') CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT '0',
  `order` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `first_roles`
--

INSERT INTO `first_roles` (`id`, `name`, `comment`, `c1`, `c2`, `c3`, `c4`, `cr2`, `cr3`, `cr4`, `post`, `p1`, `p2`, `p3`, `p4`, `pr2`, `pr3`, `pr4`, `order`) VALUES
(1, 'guest', '2/', '1', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', '0', '0', '0', '0', '0'),
(2, 'auth', '2/', '1', '1', '0', '1', '0', '1', '1', '1/2/3/4', '1', '1', '0', '1', '0', '0', '1', '1'),
(3, 'admin', '1/2/3/4', '1', '1', '1', '1', '1', '1', '1', '1/2/3/4', '1', '1', '1', '1', '1', '1', '1', '2');

-- --------------------------------------------------------

--
-- Table structure for table `first_roles_rules`
--

CREATE TABLE IF NOT EXISTS `first_roles_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `first_roles_rules`
--

INSERT INTO `first_roles_rules` (`id`, `name`) VALUES
(1, 'create'),
(2, 'edit'),
(3, 'hide'),
(4, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `first_test`
--

CREATE TABLE IF NOT EXISTS `first_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `first_user`
--

CREATE TABLE IF NOT EXISTS `first_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) NOT NULL,
  `role` enum('0','1','2') DEFAULT '0',
  `passnocesret` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `first_user`
--

INSERT INTO `first_user` (`id`, `nickname`, `role`, `passnocesret`) VALUES
(3, 'admin', '2', '111111'),
(4, 'test', '1', '1'),
(5, 'guest', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `first_user_hash`
--

CREATE TABLE IF NOT EXISTS `first_user_hash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `hash` text,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `first_user_hash`
--

INSERT INTO `first_user_hash` (`id`, `user`, `hash`) VALUES
(14, 3, '1489564155-526369471-1510454072-1270131924');
