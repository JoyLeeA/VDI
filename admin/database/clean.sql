-- CREATE DATABASE `kuproject` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `kuproject`;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`(
	`idx` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	`name` varchar(255) NOT NULL, 
	`username` varchar(80) NOT NULL, 
	`password` varchar(255) NOT NULL, 
	`create_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	`delete_datetime` timestamp DEFAULT '0000-00-00', 
	INDEX(name(255)), 
	INDEX(username(80))
) ENGINE MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `client`;
CREATE TABLE `client`(
	`idx` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	`name` varchar(255) NOT NULL, 
	`status` enum('on','off') DEFAULT 'off', 
	`create_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	`delete_datetime` timestamp DEFAULT '0000-00-00', 
	INDEX(name(255))
) ENGINE MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `os`;
CREATE TABLE `os`(
	`idx` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	`name` varchar(255) NOT NULL, 
	`image_name` varchar(255) NOT NULL, 
	`create_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	`delete_datetime` timestamp DEFAULT '0000-00-00', 
	INDEX(name(255)), 
	INDEX(image_name(255))
) ENGINE MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `specification`;
CREATE TABLE `specification`(
	`idx` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	`name` varchar(255) NOT NULL, 
	`cpu` int(3) NOT NULL, 
	`ram` int(3) NOT NULL, 
	`hdd` int(3) NOT NULL, 
	`os_idx` int(11) NOT NULL, 
	`create_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	`delete_datetime` timestamp DEFAULT '0000-00-00', 
	INDEX(name(255))
) ENGINE MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`(
	`idx` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	`name` varchar(255) NOT NULL, 
	`username` varchar(80) NOT NULL, 
	`password` varchar(255) NOT NULL, 
	`specification_idx` int(11) NOT NULL, 
	`create_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	`delete_datetime` timestamp DEFAULT '0000-00-00', 
	INDEX(name(255)), 
	INDEX(username(80))
) ENGINE MyISAM DEFAULT CHARSET=utf8mb4;
