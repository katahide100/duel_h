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

DROP TABLE IF EXISTS `cards`;
set sql_mode='NO_AUTO_VALUE_ON_ZERO';
create table `cards`(
`id` int AUTO_INCREMENT PRIMARY KEY,
`name` varchar(255),
`civilization` varchar(30),
`kind` varchar(50),
`power` varchar(20),
`cost` varchar(20),
`evolution` varchar(20),
`effects` varchar(20),
`trigger` varchar(20),
`str` varchar(700)
)DEFAULT CHARACTER SET=utf8;

DROP TABLE IF EXISTS `parts`;
set sql_mode='NO_AUTO_VALUE_ON_ZERO';
create table `parts`(
`id` int AUTO_INCREMENT PRIMARY KEY,
`part_name` varchar(255)
)DEFAULT CHARACTER SET=utf8;

DROP TABLE IF EXISTS `packs`;
set sql_mode='NO_AUTO_VALUE_ON_ZERO';
create table `packs`(
`id` int AUTO_INCREMENT PRIMARY KEY,
`part_id` int,
`pack_name` varchar(255)
)DEFAULT CHARACTER SET=utf8;

DROP TABLE IF EXISTS `links`;
set sql_mode='NO_AUTO_VALUE_ON_ZERO';
create table `links`(
`id` int AUTO_INCREMENT PRIMARY KEY,
`pack_id` int,
`card_id` int
)DEFAULT CHARACTER SET=utf8;
