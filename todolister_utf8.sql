-- --------------------------------------------------------

--
-- Database: `todolister`
--
-- May 2016
-- MySQL version: 5.7.9
-- PHP Version: 5.6.16

-- --------------------------------------------------------
--
-- Database:  `todolister`
--
CREATE DATABASE IF NOT EXISTS `todolister` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `todolister`;
-- --------------------------------------------------------
--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `pw` varchar(50) NOT NULL,
  `active` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `done` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
ADD CONSTRAINT fk_project_user_id FOREIGN KEY (user_id) REFERENCES `users`(id)
	ON DELETE CASCADE; -- If user is deleted, so are its projets

-- --------------------------------------------------------

--
-- Table structure for table `items`
--
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `done` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
--
-- Constraints for table `items`
--
ALTER TABLE `items`
ADD CONSTRAINT fk_items_project_id FOREIGN KEY (project_id) REFERENCES `projects`(id)
	ON DELETE CASCADE; -- If project is deleted, so are its items

-- --------------------------------------------------------

--
-- Table structure for table `confirm`
--
CREATE TABLE IF NOT EXISTS `confirm` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `key` varchar(128) NOT NULL default '',
  `email` varchar(250) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
--
-- Constraints for table `confirm`
--
ALTER TABLE `confirm`
ADD CONSTRAINT fk_confirm_user_id FOREIGN KEY (user_id) REFERENCES `users`(id)
	ON DELETE CASCADE; -- If user is deleted, so is its corresponding confirm row


-- --------------------------------------------------------
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pw`, `active`) VALUES
(1, 'admin', '401c9a033e60f1eefda1ddcba53e317d292ac352', 1);
