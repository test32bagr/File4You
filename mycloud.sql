SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS `cloud_chat`;
CREATE TABLE IF NOT EXISTS `cloud_chat` (
`ID` int(11) NOT NULL,
  `Nick` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `zprava` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cas` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cloud_files`;
CREATE TABLE IF NOT EXISTS `cloud_files` (
  `filename` text COLLATE utf8_czech_ci NOT NULL,
  `filetype` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `size` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `typ` text COLLATE utf8_czech_ci NOT NULL,
  `who` text COLLATE utf8_czech_ci NOT NULL,
  `Date_time` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

DROP TABLE IF EXISTS `cloud_reg_allow`;
CREATE TABLE IF NOT EXISTS `cloud_reg_allow` (
`id` int(10) NOT NULL,
  `Name` text CHARACTER SET utf8 NOT NULL,
  `Surname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `klic` varchar(100) COLLATE utf8_czech_ci NOT NULL DEFAULT 'NaN'
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `cloud_reg_allow` (`id`, `Name`, `Surname`, `klic`) VALUES
(1, 'Michal', 'Halabica', '413b88c31ab4c8f76f9b80e65d36dc51'),
(2, 'Miroslav', 'Necas', '6c6ed4fcfcee1e988dc66860c988dba3'),
(3, 'Lukas', 'Fiser', '3c490fd8f835cd9f03c0c7ec1fabccae'),
(4, 'Patrik', 'Klic', '2423058d8f5a4dfef9de3793b666c8d3'),
(5, 'Dominik', 'Blazek', 'c73d0064cb716f47738afb1978cc3ed5'),
(6, 'Ondrej', 'Hnoupek', '0808ffde840a1333beb3218a6b017d2a'),
(7, 'Marek', 'Sos', '72e4c0727640535765782aa622344c3b'),
(8, 'Ondrej', 'Mikulasek', '35488cdb1980c898ca343c35a20f89e6'),
(9, 'Adam', 'Prichystal', '93bbb8d7f67767b334a9087b04496463'),
(10, 'Ales', 'Gretz', '6cccf9beaf6d25f68e68bc776815eec0'),
(11, 'Lukas', 'Krehula', '30dba7d25159dc851db33882793b50cc'),
(12, 'Ladislav', 'Pospisil', 'd8c96443dd08cc17ad8d2778b810d408'),
(13, 'David', 'Zeleny', 'c9531ef5e4c5d8a5dadaedfefad1110a'),
(14, 'Dominik', 'Musil', 'fa38a1d7f743cf9a01063f7dd842eba4'),
(15, 'Zdenek', 'Durer', '0aaea07593156245d95e055bdda50e28'),
(16, 'Martin', 'Machacek', '53ea009a462cfd1c67ced7fcfdbf06e8'),
(17, 'Pavel', 'Janecek', '23af5e3685bb4bd5022b87ff84fd400b'),
(18, 'Tomas', 'Blaha', 'd25f5087c2893c4098619fc2b6ff27ea'),
(19, 'Jan', 'Uhlir', 'cd222452ffd28c8fd355443791d96158'),
(20, 'Pavel', 'Simkuj', '4528fea2b1dbd989a0c4c8cf4a6744e7'),
(21, 'Michal', 'Handl', 'aa481a0cfeab395d7dc06115c941026e'),
(31, 'Jan', 'Flek', 'c289843c4821f36200844011ee479d0c'),
(23, 'Tomas', 'Juracka', '673302d4f2ee34c04e9c02b479afcbe2'),
(24, 'Jaroslav', 'Hena', '9712524dc88851032bd53054f8b49b4a'),
(25, 'Superuser', 'Superuser', '02aa55e3b18343ee62548056e7c7a58a'),
(26, 'Dominik', 'Soldan', '93ee3340d4cefd59f4869266b3809106'),
(27, 'Tomas', 'Pluhacek', 'dbd71ed7210d115d3a6775cdab83f055'),
(28, 'Jan', 'Chaloupka', '5eedfbf4dfabe51fcaf68506dede25ca'),
(32, 'David', 'Marek', '091cbaf8fc9a3d12ce957d6228b3c04c');

DROP TABLE IF EXISTS `cloud_users`;
CREATE TABLE IF NOT EXISTS `cloud_users` (
  `Jmeno` text COLLATE utf8_czech_ci NOT NULL,
  `Prijmeni` text COLLATE utf8_czech_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `Mail` text COLLATE utf8_czech_ci NOT NULL,
  `Heslo` text COLLATE utf8_czech_ci NOT NULL,
  `IPregistrace` text COLLATE utf8_czech_ci NOT NULL,
  `vek` text COLLATE utf8_czech_ci NOT NULL,
  `isAdmin` varchar(20) COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `cloud_users` (`Jmeno`, `Prijmeni`, `username`, `Mail`, `Heslo`, `IPregistrace`, `vek`, `isAdmin`) VALUES
('Michal', 'Halabica', 'Misha12', 'm.halabica@gmail.com', 'ae6082ad93d97b82aab9378ec8fd84a5831216f3ffa5ae9bc4777b1d946fd81e', '90.177.173.128', '17', 'true');


ALTER TABLE `cloud_chat`
 ADD PRIMARY KEY (`ID`);

ALTER TABLE `cloud_files`
 ADD UNIQUE KEY `jmeno` (`name`);

ALTER TABLE `cloud_reg_allow`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `Surname` (`Surname`);

ALTER TABLE `cloud_users`
 ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `cloud_chat`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
ALTER TABLE `cloud_reg_allow`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
