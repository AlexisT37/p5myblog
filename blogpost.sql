-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for oc4
CREATE DATABASE IF NOT EXISTS `oc4` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `oc4`;

-- Dumping structure for table oc4.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `author` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `validated` tinyint(4) DEFAULT '0',
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_comments_user` (`author`),
  KEY `FK_comments_posts` (`post_id`),
  CONSTRAINT `FK_comments_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `FK_comments_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table oc4.comments: ~6 rows (approximately)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `post_id`, `author`, `comment`, `comment_date`, `modified_date`, `validated`, `deleted`) VALUES
	(1, 8, 7, 'commentaire 1', '2022-10-07 10:12:32', '2022-10-07 10:12:32', 1, 0),
	(2, 9, 7, 'commentaire 2', '2022-10-07 22:55:46', '2022-10-07 22:55:46', 1, 1),
	(3, 6, 7, 'commentaire 3', '2022-10-10 08:09:27', '2022-10-10 08:09:27', 1, 1),
	(4, 6, 7, 'commentaire 4', '2022-10-13 06:56:27', '2022-10-13 07:00:05', 1, 0),
	(5, 8, 7, '<p><span style="text-decoration: underline;"><em><strong>test special char</strong></em></span></p>', '2022-10-13 09:42:55', '2022-10-13 09:46:10', 0, 0),
	(6, 7, 7, '<p><span style="text-decoration: underline;"><em><strong>test special char 2</strong></em></span></p>', '2022-10-13 09:49:13', '2022-10-13 09:49:13', 0, 0),
	(7, 11, 7, '<p>test</p>', '2022-10-15 12:11:15', '2022-10-15 12:11:15', 1, 0);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Dumping structure for table oc4.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `leadParagraph` varchar(255) DEFAULT NULL,
  `User_id` int(11) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `validated` tinyint(4) DEFAULT '0',
  `modified_date` datetime DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`,`User_id`) USING BTREE,
  KEY `fk_Post_User_idx` (`User_id`) USING BTREE,
  CONSTRAINT `fk_Post_User` FOREIGN KEY (`User_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Dumping data for table oc4.posts: ~9 rows (approximately)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `title`, `content`, `leadParagraph`, `User_id`, `creation_date`, `validated`, `modified_date`, `deleted`) VALUES
	(6, 'test jeudi matin', '<h6><span style="text-decoration: underline;">post special char 2</span><em><strong><br></strong></em></h6>', 'post effacé', 7, '2022-10-13 06:55:02', 1, '2022-10-13 08:04:32', 1),
	(7, 'toto', '<p><em><strong>post special char</strong></em></p>', 'post 5 ', 7, '2022-10-13 08:07:50', 1, '2022-10-13 08:07:50', 0),
	(8, 'toto', '<p>post</p>', 'post 4', 7, '2022-10-13 09:10:10', 1, '2022-10-13 09:10:10', 0),
	(9, 'toto filme', '<p>post</p>', 'post 3', 7, '2022-10-13 09:48:29', 1, '2022-10-13 09:48:29', 0),
	(10, 'test jeudi aprem', '<p>post</p>', 'post 2', 7, '2022-10-13 13:50:26', 0, '2022-10-13 13:50:26', 0),
	(11, 'samedi 15', '<p><em><strong>post test</strong></em></p>', 'post 1', 7, '2022-10-15 12:10:58', 1, '2022-10-15 12:10:58', 0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Dumping structure for table oc4.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `roles` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table oc4.user: ~7 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `email`, `username`, `password`, `roles`) VALUES
	(7, 'ater@gmail.com', 'aleron', '$2y$10$qLq.KSST7YgHvxXYsj94v.f0i.0MSoGHvrp0hyvjtm6M8RWUse2HS', '\'ROLE_ADMIN\',\'ROLE_USER\''),
	(9, 'nana@gmail.com', 'neoventus', '$2y$10$oyamBXpCSKxVQL44z1rrMOvqiYCFVwk2hpbjjkC.Kjd.DOjz8KW92', '\'ROLE_USER\'');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
