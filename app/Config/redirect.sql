-- MySQL dump 10.10
--
-- Host: localhost    Database: no1s_redirect
-- ------------------------------------------------------
-- Server version	5.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) NOT NULL auto_increment,
  `email` varchar(255) ,
  `login` varchar(255) ,
  `password` varchar(255) ,
  `modified` datetime default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `shorts`
--

DROP TABLE IF EXISTS `shorts`;
CREATE TABLE `shorts` (
`id` int(10) NOT NULL auto_increment,
`matter_name` varchar(255) ,
`short_url` varchar(255) NOT NULL UNIQUE,
`is_available` tinyint(4) ,
`modified` datetime default NULL,
`created` datetime default NULL,
PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `redirects`;
CREATE TABLE `redirects` (
`id` int(10) NOT NULL auto_increment,
`short_id` int(10) ,
`redirect_name` varchar(255) ,
`url` varchar(255) ,
`effective_flg` tinyint(4) ,
`is_available` tinyint(4) ,
`modified` datetime default NULL,
`created` datetime default NULL,
PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


