-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 25. Nov 2019 um 18:35
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
-- Tabellenstruktur für Tabelle `addresses`
--

CREATE TABLE `addresses` (
    `id` int(11) NOT NULL,
    `address` text NOT NULL,
    `user_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `addresses`
--

INSERT INTO `addresses` (`id`, `address`, `user_id`) VALUES
                                                         (1, '42 Wallaby Way\r\nSydney', 2),
                                                         (2, 'At the End of the Universe 1\r\nUniverse', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
    `id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `price` float NOT NULL,
    `images` text DEFAULT NULL,
    `stock` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `images`, `stock`) VALUES
                                                                                     (1, 'Product 1', 'Product 1 Description', 42, 'uploads/pimp-rollator.jpg', 10),
                                                                                     (2, 'Product 2', 'Product 2 Description', 42, 'image2.jpg,image2_2.jpg', 10),
                                                                                     (3, 'Product 3 umbenannt', 'Product 3 Description', 42, '', 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
    `id` int(11) NOT NULL,
    `email` varchar(255) NOT NULL,
    `username` varchar(255) DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `is_admin` tinyint(1) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `is_admin`) VALUES
                                                                            (1, 'buster@dummy.com', NULL, '$2y$12$GJijL6H8sxUwFjhX9xQl4uvaJHZMjD7ucMJWWWRP3d3YyXJ.h0nGS', 1),
                                                                            (2, 'arthur.dent@galaxy.com', 'adent', '$2y$12$NVbHowuq4htGvOc446RKyuPqhG4hbxD5736aKxELxiOp4J9G6Ba8.', 1),
                                                                            (4, 'peter@peter.at', 'peter', '$2y$10$wROOwmna4B3Yk4DtgMpvGOIrLtYDtZ1xWzdJiAmwDf0TAawkyYT6u', NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `addresses`
--
ALTER TABLE `addresses`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `email` (`email`),
    ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `addresses`
--
ALTER TABLE `addresses`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;
