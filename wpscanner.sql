-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2012 at 02:54 PM
-- Server version: 5.1.63
-- PHP Version: 5.3.5-1ubuntu7.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wpscanner`
--

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `pay_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `pay_date` date NOT NULL,
  `amount` smallint(5) unsigned NOT NULL,
  `pay_status` varchar(10) NOT NULL,
  `plan` varchar(15) NOT NULL,
  `recurring` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plugins_details`
--

CREATE TABLE IF NOT EXISTS `plugins_details` (
  `plugin_id` smallint(5) unsigned NOT NULL,
  `plugin_name` int(11) NOT NULL,
  `plugin_grep` int(11) NOT NULL,
  `plugin_curr_version` int(11) NOT NULL,
  `plugin_known_vuln` int(11) NOT NULL,
  `plugin_count` int(11) NOT NULL,
  `plugin_vuln_count` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plugins_found`
--

CREATE TABLE IF NOT EXISTS `plugins_found` (
  `scan_id` int(10) unsigned NOT NULL,
  `plugins_found` tinytext NOT NULL,
  KEY `scan_id` (`scan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scans`
--

CREATE TABLE IF NOT EXISTS `scans` (
  `scan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `url` varchar(250) NOT NULL,
  `cms` varchar(15) NOT NULL,
  `version` varchar(6) NOT NULL,
  `cms_path` varchar(250) NOT NULL,
  `plugins_count` tinyint(3) unsigned NOT NULL,
  `score` tinyint(6) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL,
  `browser` varchar(150) NOT NULL,
  PRIMARY KEY (`scan_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3051 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_stats`
--

CREATE TABLE IF NOT EXISTS `site_stats` (
  `stat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `stat_date` date NOT NULL,
  `scans_today` smallint(5) unsigned NOT NULL,
  `scans_week` mediumint(8) unsigned NOT NULL,
  `scans_month` mediumint(8) unsigned NOT NULL,
  `total_scans` int(10) unsigned NOT NULL,
  `warned_sites` int(10) unsigned NOT NULL,
  `vuln_sites` mediumint(8) unsigned NOT NULL,
  `warned_plugins` int(10) unsigned NOT NULL,
  `vuln_plugins` int(10) unsigned NOT NULL,
  `total_payments` int(11) NOT NULL,
  `total_gross` int(11) NOT NULL,
  PRIMARY KEY (`stat_id`),
  KEY `stat_date` (`stat_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `reg_date` date NOT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `last_scan` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `scans_today` smallint(5) unsigned NOT NULL DEFAULT '1',
  `total_scans` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `total_payments` mediumint(8) unsigned DEFAULT NULL,
  `salt` char(21) NOT NULL,
  `password` char(60) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1290 ;

-- --------------------------------------------------------

--
-- Table structure for table `warnings_details`
--

CREATE TABLE IF NOT EXISTS `warnings_details` (
  `warning_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `warning_level` tinyint(3) unsigned NOT NULL,
  `warning_description` varchar(250) NOT NULL,
  `warning_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`warning_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `warnings_found`
--

CREATE TABLE IF NOT EXISTS `warnings_found` (
  `scan_id` int(10) unsigned NOT NULL,
  `warnings_found` tinytext NOT NULL,
  KEY `scan_id` (`scan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
