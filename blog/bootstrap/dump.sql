-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 16. Okt 2019 um 16:04
-- Server-Version: 10.4.6-MariaDB-1:10.4.6+maria~bionic
-- PHP-Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Datenbank: `blog`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
    `id` int(11) NOT NULL,
    `title` varchar(280) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
                                             (1, 'category 1'),
                                             (2, 'category 2'),
                                             (3, 'category 3'),
                                             (4, 'category 4');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories_posts_mm`
--

CREATE TABLE `categories_posts_mm` (
    `id` int(11) NOT NULL,
    `category_id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `categories_posts_mm`
--

INSERT INTO `categories_posts_mm` (`id`, `category_id`, `post_id`) VALUES
                                                                       (1, 2, 1),
                                                                       (2, 3, 1),
                                                                       (3, 3, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE `comments` (
    `id` int(11) NOT NULL,
    `content` text NOT NULL,
    `user_id` int(11) NOT NULL,
    `parent_comment_id` int(11) DEFAULT NULL,
    `post_id` int(11) NOT NULL,
    `crdate` timestamp NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
    `id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `title` varchar(280) NOT NULL,
    `content` text DEFAULT NULL,
    `tags` varchar(280) DEFAULT NULL,
    `crdate` timestamp NOT NULL DEFAULT current_timestamp(),
    `udated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `tags`, `crdate`, `udated_date`) VALUES
                                                                                               (1, 1, 'First Blog Post', 'First Blog Post Content', '%fancy%%post%', '2019-09-30 16:54:32', '2019-09-30 16:54:32'),
                                                                                               (2, 1, 'Second Post', 'Second Post Content', '%second%%post%', '2019-09-30 16:54:32', '2019-09-30 16:54:32');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts_comments_mm`
--

CREATE TABLE `posts_comments_mm` (
    `id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
    `comment_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts_votes_mm`
--

CREATE TABLE `posts_votes_mm` (
    `id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
    `vote_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
    `id` int(11) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `is_admin` tinyint(1) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_admin`) VALUES
                                                                (1, 'buster@dummy.com', '$2y$12$GJijL6H8sxUwFjhX9xQl4uvaJHZMjD7ucMJWWWRP3d3YyXJ.h0nGS', 1),
                                                                (2, 'arthur.dent@galaxy.com', '$2y$12$NVbHowuq4htGvOc446RKyuPqhG4hbxD5736aKxELxiOp4J9G6Ba8.', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `votes`
--

CREATE TABLE `votes` (
    `id` int(11) NOT NULL,
    `type` enum('up','down') NOT NULL,
    `post_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `categories_posts_mm`
--
ALTER TABLE `categories_posts_mm`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `comments`
--
ALTER TABLE `comments`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `posts_comments_mm`
--
ALTER TABLE `posts_comments_mm`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `posts_votes_mm`
--
ALTER TABLE `posts_votes_mm`
    ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `votes`
--
ALTER TABLE `votes`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `categories_posts_mm`
--
ALTER TABLE `categories_posts_mm`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `comments`
--
ALTER TABLE `comments`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `posts_comments_mm`
--
ALTER TABLE `posts_comments_mm`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `posts_votes_mm`
--
ALTER TABLE `posts_votes_mm`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `votes`
--
ALTER TABLE `votes`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
