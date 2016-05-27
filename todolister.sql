DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(20) NOT NULL,
  `pw` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `done` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

ALTER TABLE `projects`
ADD CONSTRAINT fk_project_user_id FOREIGN KEY (user_id) REFERENCES `users`(id)
	ON DELETE CASCADE; -- Si l'utilisateur est effacé, ses projets aussi

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `done` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

ALTER TABLE `items`
ADD CONSTRAINT fk_items_project_id FOREIGN KEY (project_id) REFERENCES `projects`(id)
	ON DELETE CASCADE; -- Si le projet est effacé, ses tâches aussi

INSERT INTO `users` (`id`, `pseudo`, `pw`) VALUES
(1, `admin`, `401c9a033e60f1eefda1ddcba53e317d292ac352`);
