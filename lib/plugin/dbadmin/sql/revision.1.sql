CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `additional` text,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `challenge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `iduser` int(10) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `duration_unit` varchar(255) NOT NULL,
  `rythm` int(11) NOT NULL,
  `rythm_unit` varchar(255) NOT NULL,
  `start` date NOT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `iduser` (`iduser`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idchallenge` int(10) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idchallenge` (`idchallenge`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
