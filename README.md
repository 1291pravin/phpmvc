Database Table Structure is 

CREATE TABLE `user` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `username` varchar(512) NOT NULL,
 `password` varchar(256) NOT NULL,
 `email` varchar(256) NOT NULL,
 `contact` varchar(16) NOT NULL,
 `date_created` datetime NOT NULL,
 `date_modified` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1

Update database config from config/params_local.php

To run project go to public directory and run php -s localhost:8000


