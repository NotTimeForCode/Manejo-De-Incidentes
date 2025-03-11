CREATE DATABASE IF NOT EXISTS `incidents` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
USE `incidents`;

CREATE TABLE IF NOT EXISTS `incident-logs` (
  `hostname` varchar(255) NOT NULL,
  `user` varchar(50) NOT NULL,
  `incident_id` int(11) NOT NULL AUTO_INCREMENT,          /* Main table */
  `incident` text NOT NULL,
  `log_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`incident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `concluded_incidents` (
  `hostname` varchar(255) NOT NULL,
  `user` varchar(50) NOT NULL,
  `incident_id` int(11) NOT NULL UNIQUE,                        /* Redundant */
  `incident` text NOT NULL,
  `log_time` DATETIME NOT NULL,
  `details` text
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,                       /*Table for storing users*/
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE `loginlogs` (
`id` int(11) NOT NULL,
`IpAddress` varbinary(16) NOT NULL,
`TryTime` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

INSERT INTO incident_logs (hostname, user, incident)      /* Template for adding incidents */ 
VALUES ('dyna_automocion_001', 'user1', 'problem1');

UPDATE `incident_logs` SET `incident_status` = 'Neutral' WHERE `incident_logs`.`incident_status` = 'Concluded'; /* Set all incidents to 'Neutral' */