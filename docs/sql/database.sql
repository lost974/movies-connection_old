-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 23 Juillet 2012 à 14:57
-- Version du serveur: 5.5.9
-- Version de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `lost974`
--

-- --------------------------------------------------------

--
-- Structure de la table `mc_critiques`
--

CREATE TABLE `mc_critiques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `critique` varchar(1000) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mc_events`
--

CREATE TABLE `mc_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `arguments` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mc_follows`
--

CREATE TABLE `mc_follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mc_friends`
--

CREATE TABLE `mc_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mc_intentions`
--

CREATE TABLE `mc_intentions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mc_maintenances`
--

CREATE TABLE `mc_maintenances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mc_marks`
--

CREATE TABLE `mc_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mc_movies`
--

CREATE TABLE `mc_movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `release` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `genre_id` int(11) NOT NULL,
  `synopsis` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `b_a` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `moyenne` float NOT NULL,
  `nb_mark` int(7) NOT NULL,
  `nb_vues` int(11) NOT NULL,
  `useradd_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `genre_id` (`genre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mc_moviesaws`
--

CREATE TABLE `mc_moviesaws` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mc_movies_genres`
--

CREATE TABLE `mc_movies_genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mc_news`
--

CREATE TABLE `mc_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mc_news_comments`
--

CREATE TABLE `mc_news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `comment` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `news_id` (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mc_recommends`
--

CREATE TABLE `mc_recommends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `friend_id` (`friend_id`),
  KEY `movie_id` (`movie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mc_users`
--

CREATE TABLE `mc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `moderateur` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `activate` int(11) NOT NULL DEFAULT '0',
  `activate_key` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `actif` int(11) NOT NULL,
  `nbr_connection` int(11) NOT NULL,
  `last_connection` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `mc_critiques`
--
ALTER TABLE `mc_critiques`
  ADD CONSTRAINT `mc_critiques_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mc_critiques_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `mc_movies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mc_events`
--
ALTER TABLE `mc_events`
  ADD CONSTRAINT `mc_events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mc_intentions`
--
ALTER TABLE `mc_intentions`
  ADD CONSTRAINT `mc_intentions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mc_intentions_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `mc_movies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mc_marks`
--
ALTER TABLE `mc_marks`
  ADD CONSTRAINT `mc_marks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mc_marks_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `mc_movies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mc_moviesaws`
--
ALTER TABLE `mc_moviesaws`
  ADD CONSTRAINT `mc_moviesaws_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mc_moviesaws_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `mc_movies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mc_news_comments`
--
ALTER TABLE `mc_news_comments`
  ADD CONSTRAINT `mc_news_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mc_news_comments_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `mc_news` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mc_recommends`
--
ALTER TABLE `mc_recommends`
  ADD CONSTRAINT `mc_recommends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mc_recommends_ibfk_3` FOREIGN KEY (`movie_id`) REFERENCES `mc_movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mc_recommends_ibfk_4` FOREIGN KEY (`friend_id`) REFERENCES `mc_users` (`id`) ON DELETE CASCADE;
