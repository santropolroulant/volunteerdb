CREATE TABLE `volunteers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,

  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `searchableName` varchar(200) DEFAULT NULL,
  `birthyear` int(11) DEFAULT NULL,
  `birthmonth` int(11) DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,

  `phone1` varchar(20) DEFAULT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `phone3` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` text,
  `emergname` varchar(50) DEFAULT NULL,
  `emergrelation` varchar(50) DEFAULT NULL,
  `emergphone1` varchar(20) DEFAULT NULL,
  `emergphone2` varchar(20) DEFAULT NULL,
  `emergphone3` varchar(20) DEFAULT NULL,
  `emergemail` varchar(50) DEFAULT NULL,

  `occupation` varchar(50) DEFAULT NULL,
  `occupationother` text,
  `foundout` varchar(50) DEFAULT NULL,
  `foundoutother` text,
  `language1` varchar(50) DEFAULT NULL,
  `language2` varchar(50) DEFAULT NULL,
  `language3` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
