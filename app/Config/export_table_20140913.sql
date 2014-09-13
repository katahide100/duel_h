-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- ホスト: localhost:3306
-- 生成日時: 2014 年 9 月 13 日 02:53
-- サーバのバージョン: 5.5.38-0ubuntu0.12.04.1
-- PHP のバージョン: 5.3.10-1ubuntu3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `wktk0486`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `civilization` varchar(30) DEFAULT NULL,
  `kind` varchar(50) DEFAULT NULL,
  `power` varchar(20) DEFAULT NULL,
  `cost` varchar(20) DEFAULT NULL,
  `evolution` varchar(20) DEFAULT NULL,
  `effects` varchar(20) DEFAULT NULL,
  `trigger` varchar(20) DEFAULT NULL,
  `str` varchar(700) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4673 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `godlinks`
--

DROP TABLE IF EXISTS `godlinks`;
CREATE TABLE IF NOT EXISTS `godlinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `god_name` varchar(255) DEFAULT NULL,
  `god_link` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pack_id` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4755 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `packs`
--

DROP TABLE IF EXISTS `packs`;
CREATE TABLE IF NOT EXISTS `packs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_id` int(11) DEFAULT NULL,
  `pack_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `parts`
--

DROP TABLE IF EXISTS `parts`;
CREATE TABLE IF NOT EXISTS `parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `psychics`
--

DROP TABLE IF EXISTS `psychics`;
CREATE TABLE IF NOT EXISTS `psychics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `psychic_s` varchar(255) DEFAULT NULL,
  `psychic_l` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=136 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `symbols`
--

DROP TABLE IF EXISTS `symbols`;
CREATE TABLE IF NOT EXISTS `symbols` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `mark` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `login` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
