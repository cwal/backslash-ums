DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(32) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('valid', 'pending', 'banned') NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `date_gmt` datetime NOT NULL,
  `remember_me` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;