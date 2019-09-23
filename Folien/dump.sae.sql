-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 23. Sep 2019 um 18:25
-- Server-Version: 10.4.6-MariaDB-1:10.4.6+maria~bionic
-- PHP-Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `sae`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `actors`
--

CREATE TABLE `actors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `birthday` date DEFAULT NULL,
  `origin` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `actors`
--

INSERT INTO `actors` (`id`, `first_name`, `last_name`, `birthday`, `origin`) VALUES
(1, 'Samuel L.', 'Jackson', NULL, 'US'),
(2, 'Keanu', 'Reeves', NULL, 'LBN'),
(3, 'Blake', 'Lively', NULL, 'US'),
(4, 'Halle', 'Berry', NULL, 'US'),
(5, 'Laurence', 'Fishburne', NULL, 'US');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `genre` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `main_act` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `movies`
--

INSERT INTO `movies` (`id`, `title`, `genre`, `year`, `main_act`) VALUES
(1, 'Star Wars Episode 1', 'sci-fi', 1999, 1),
(2, 'Matrix', 'sci-fi', 1999, 2),
(3, 'Green Lantern', 'fantasy', 2011, 3),
(4, 'Matrix 2', 'sci-fi', 2003, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `movies_actors_mm`
--

CREATE TABLE `movies_actors_mm` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `movies_actors_mm`
--

INSERT INTO `movies_actors_mm` (`id`, `movie_id`, `actor_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 2),
(5, 2, 5),
(6, 4, 5);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indizes für die Tabelle `movies_actors_mm`
--
ALTER TABLE `movies_actors_mm`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `movies_actors_mm`
--
ALTER TABLE `movies_actors_mm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
