-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.1.59-community - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2012-09-04 10:06:20
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table ci_album.options
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table ci_album.options: 4 rows
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT IGNORE INTO `options` (`id`, `name`, `value`) VALUES
	(1, 'album_name', 'Tuzki\'s Album'),
	(4, 'domain', 'tuzki52'),
	(3, 'description', '兔子不舒服斯基的相册'),
	(5, 'per_page', '8');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;


-- Dumping structure for table ci_album.photos
CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `title` text,
  `description` text,
  `preview` text NOT NULL,
  `size` int(11) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `storage` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_photos_users` (`author`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- Dumping data for table ci_album.photos: 34 rows
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;


-- Dumping structure for table ci_album.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `pass` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table ci_album.users: 1 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
