-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.3.22-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.0.0.5958
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица beejee.bee_users
CREATE TABLE IF NOT EXISTS `bee_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `surname` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(250) NOT NULL DEFAULT '0',
  `online` datetime DEFAULT NULL,
  `last_act` datetime DEFAULT NULL,
  `salt` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы beejee.bee_users: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `bee_users` DISABLE KEYS */;
INSERT INTO `bee_users` (`id`, `name`, `surname`, `email`, `password`, `online`, `last_act`, `salt`) VALUES
	(5, 'John', 'Smith', 'admin', '9a91ddbc582ba5146d85af5d0dddcef5', '2020-04-29 11:17:46', '2020-04-29 11:17:46', '1588137382');
/*!40000 ALTER TABLE `bee_users` ENABLE KEYS */;

-- Дамп структуры для таблица beejee.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `task` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` enum('New','Complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  `updated_by` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы beejee.tasks: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `name`, `email`, `task`, `status`, `updated_by`) VALUES
	(1, 'John', 'john@mail.com', 'first', 'New', 0),
	(2, 'Mary', 'mary@mail.com', 'second', 'New', 0),
	(3, 'Bany', 'bany@mail.com', 'third', 'New', 0),
	(4, 'Any', 'any@mail.com', 'Evil\'); DROP TABLE drop_table;--', 'New', 0);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
