-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 27. Nov 2019 um 17:21
-- Server-Version: 10.4.6-MariaDB-1:10.4.6+maria~bionic
-- PHP-Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Datenbank: `mvc`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE `orders` (
    `id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `products` text NOT NULL COMMENT 'Serialisierter Array an Products',
    `crdate` timestamp NOT NULL DEFAULT current_timestamp(),
    `address_id` int(11) NOT NULL,
    `status` enum('open','delivered','in_progress','cancelled') NOT NULL DEFAULT 'open',
    `payment` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
