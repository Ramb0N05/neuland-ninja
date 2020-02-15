-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 09. Feb 2019 um 16:47
-- Server-Version: 10.2.21-MariaDB-10.2.21+maria~stretch-log
-- PHP-Version: 7.0.33-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ninjaDB`
--
CREATE DATABASE IF NOT EXISTS `ninjaDB` DEFAULT CHARACTER SET utf32 COLLATE utf32_unicode_ci;
USE `ninjaDB`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `acl`
--

CREATE TABLE `acl` (
  `ID` int(11) NOT NULL,
  `CN` varchar(128) COLLATE utf32_unicode_ci NOT NULL,
  `serial` varchar(32) COLLATE utf32_unicode_ci NOT NULL,
  `aclGroupList` text COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aclGroups`
--

CREATE TABLE `aclGroups` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `permissionsList` text COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Daten für Tabelle `aclGroups`
--

INSERT INTO `aclGroups` (`ID`, `name`, `permissionsList`) VALUES
(1, 'Administratoren', '1,2,3,4,5,6,7'),
(2, 'Moderatoren', '1,2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aclPermissions`
--

CREATE TABLE `aclPermissions` (
  `ID` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Daten für Tabelle `aclPermissions`
--

INSERT INTO `aclPermissions` (`ID`, `name`) VALUES
(1, 'admin.controlPanel.access'),
(7, 'admin.controlPanel.acl'),
(2, 'admin.controlPanel.menu'),
(3, 'admin.controlPanel.menu.add'),
(5, 'admin.controlPanel.menu.delete'),
(4, 'admin.controlPanel.menu.edit'),
(6, 'admin.controlPanel.menu.order');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `acpMenuItems`
--

CREATE TABLE `acpMenuItems` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `displayName` text COLLATE utf32_unicode_ci NOT NULL,
  `pageName` varchar(50) COLLATE utf32_unicode_ci NOT NULL DEFAULT 'welcome',
  `permission` varchar(128) COLLATE utf32_unicode_ci NOT NULL,
  `itemOrder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Daten für Tabelle `acpMenuItems`
--

INSERT INTO `acpMenuItems` (`ID`, `name`, `displayName`, `pageName`, `permission`, `itemOrder`) VALUES
(1, 'acpMenu', 'ACP Men&uuml;', 'menu', 'admin.controlPanel.menu', NULL),
(2, 'acl', 'Zugangssliste', 'welcome', 'admin.controlPanel.acl', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ninjaMessageTbl`
--

CREATE TABLE `ninjaMessageTbl` (
  `ID` int(11) NOT NULL,
  `isEncrypted` tinyint(1) NOT NULL,
  `hasErrors` tinyint(1) NOT NULL,
  `showTimeLeft` tinyint(1) NOT NULL,
  `sdMode` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `sdTimestamp` bigint(20) DEFAULT NULL,
  `payload` mediumtext COLLATE utf32_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sdModes`
--

CREATE TABLE `sdModes` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `displayName` varchar(255) COLLATE utf32_unicode_ci NOT NULL,
  `timeOffset` int(11) NOT NULL,
  `addOffsetAfterReading` tinyint(1) NOT NULL,
  `isDefault` tinyint(1) DEFAULT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Daten für Tabelle `sdModes`
--

INSERT INTO `sdModes` (`ID`, `name`, `displayName`, `timeOffset`, `addOffsetAfterReading`, `isDefault`, `position`) VALUES
(1, 'afterRead', 'sofort nach dem lesen', 0, 1, 1, 3),
(2, 'now+7d', 'nach 7 Tagen', 604800, 0, NULL, 5),
(3, 'afterRead+15min', '15 Minuten nach dem ersten Lesen', 900, 1, NULL, 2),
(4, 'afterRead+30min', '30 Minuten nach dem ersten Lesen', 1800, 1, NULL, 1),
(7, 'afterRead+2h', '2 Stunden nach dem ersten Lesen', 7200, 1, NULL, 0),
(8, 'now+30min', 'nach 30 Minuten', 1800, 0, NULL, 4),
(9, 'nw+24h', 'nach 24 Stunden', 86400, 0, NULL, 6);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `acl`
--
ALTER TABLE `acl`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CN` (`CN`),
  ADD UNIQUE KEY `serial` (`serial`);

--
-- Indizes für die Tabelle `aclGroups`
--
ALTER TABLE `aclGroups`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `aclPermissions`
--
ALTER TABLE `aclPermissions`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `acpMenuItems`
--
ALTER TABLE `acpMenuItems`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `ninjaMessageTbl`
--
ALTER TABLE `ninjaMessageTbl`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `sdMode` (`sdMode`);

--
-- Indizes für die Tabelle `sdModes`
--
ALTER TABLE `sdModes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `position` (`position`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `aclGroups`
--
ALTER TABLE `aclGroups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `aclPermissions`
--
ALTER TABLE `aclPermissions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `acpMenuItems`
--
ALTER TABLE `acpMenuItems`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `sdModes`
--
ALTER TABLE `sdModes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ninjaMessageTbl`
--
ALTER TABLE `ninjaMessageTbl`
  ADD CONSTRAINT `ninjaMessageTbl_ibfk_1` FOREIGN KEY (`sdMode`) REFERENCES `sdModes` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
