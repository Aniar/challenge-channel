#SQL commands to create tables

CREATE TABLE IF NOT EXISTS `userInfo` (
  `firstName` varchar(255),
  `lastName` varchar(255),
  `userName` varchar(255) PRIMARY KEY,
  `email` varchar(255) UNIQUE,
  `password` varchar(255),
  `age` tinyint(3) unsigned,
  `challenges` blob
);

CREATE TABLE IF NOT EXISTS `challenges` (
  `title` varchar(255) PRIMARY KEY,
  `summary` text,
  `tasks` blob,
  `numTasks` tinyint(3) unsigned,
  `currentTask` tinyint(3) unsigned DEFAULT '1'
);