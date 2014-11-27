SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP DATABASE IF EXISTS c2mycloud;
CREATE DATABASE IF NOT EXISTS c2mycloud;

DROP TABLE IF EXISTS `cloud_chat`;
CREATE TABLE IF NOT EXISTS `cloud_chat` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nick` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `zprava` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cas` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT;

-- Struktura tabulky `cloud_files`

DROP TABLE IF EXISTS `cloud_files`;
CREATE TABLE IF NOT EXISTS `cloud_files` (
  `filename` text COLLATE utf8_czech_ci NOT NULL,
  `filetype` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `size` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `typ` text COLLATE utf8_czech_ci NOT NULL,
  `who` text COLLATE utf8_czech_ci NOT NULL,
  `Date_time` text COLLATE utf8_czech_ci NOT NULL,
  UNIQUE KEY `jmeno` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Struktura tabulky `cloud_reg_allow`

DROP TABLE IF EXISTS `cloud_reg_allow`;
CREATE TABLE IF NOT EXISTS `cloud_reg_allow` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Name` text CHARACTER SET utf8 NOT NULL,
  `Surname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `klic` varchar(100) COLLATE utf8_czech_ci NOT NULL DEFAULT 'NaN',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Surname` (`Surname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT ;

-- Vypisuji data pro tabulku `cloud_reg_allow`

INSERT INTO `cloud_reg_allow` (`Name`, `Surname`, `klic`) VALUES ('Superuser', 'Superuser', '02aa55e3b18343ee62548056e7c7a58a');

-- Struktura tabulky `cloud_users`

DROP TABLE IF EXISTS `cloud_users`;
CREATE TABLE IF NOT EXISTS `cloud_users` (
  `Jmeno` text COLLATE utf8_czech_ci NOT NULL,
  `Prijmeni` text COLLATE utf8_czech_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `Mail` text COLLATE utf8_czech_ci NOT NULL,
  `Heslo` text COLLATE utf8_czech_ci NOT NULL,
  `IPregistrace` text COLLATE utf8_czech_ci NOT NULL,
  `vek` int(255) COLLATE utf8_czech_ci NOT NULL,
  `isAdmin` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Vypisuji data pro tabulku `cloud_users`

INSERT INTO `cloud_users` (`Jmeno`, `Prijmeni`, `username`, `Mail`, `Heslo`, `IPregistrace`, `vek`, `isAdmin`) VALUES ('Superuser', 'Superuser', 'Superuser', 'root@localhost', '593b0a983250809aedfe2051d8ac9c8503a2b99f6a7a0617b896aed18f4f08c8', '127.0.0.1', 123, 'true');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;