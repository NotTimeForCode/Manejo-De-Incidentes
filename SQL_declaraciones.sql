CREATE DATABASE IF NOT EXISTS `incidents` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
USE `incidents`;

CREATE TABLE IF NOT EXISTS `incident-logs` (
  `hostname` varchar(255) NOT NULL,
  `user` varchar(50) NOT NULL,
  `incident_id` int(11) NOT NULL AUTO_INCREMENT,
  `incident` text NOT NULL,
  `log_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

INSERT INTO incident_logs (hostname, user, incident)
VALUES ('dyna_automocion_001', 'user1', 'problem1');