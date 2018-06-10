-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 10 Juin 2018 à 11:03
-- Version du serveur :  5.7.22-0ubuntu0.16.04.1
-- Version de PHP :  7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `discussions`
--

CREATE TABLE `discussions` (
  `name_discussion` varchar(32) COLLATE utf8_bin NOT NULL,
  `name_sous-salon` varchar(32) COLLATE utf8_bin NOT NULL,
  `nbr_message` smallint(5) NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_u` smallint(4) NOT NULL,
  `name_discussion` varchar(32) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(32) COLLATE utf8_bin NOT NULL,
  `contenu` text COLLATE utf8_bin NOT NULL,
  `date_envoi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `salon`
--

CREATE TABLE `salon` (
  `id_salon` smallint(1) NOT NULL,
  `name_salon` varchar(32) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `salon`
--

INSERT INTO `salon` (`id_salon`, `name_salon`) VALUES
(1, 'Maison'),
(2, 'Santé & Bien-être'),
(3, 'Vêtement et Accessoires'),
(4, 'Drône'),
(5, 'Mobilité'),
(6, 'Loisirs'),
(7, 'Insolite');

-- --------------------------------------------------------

--
-- Structure de la table `sous_salon`
--

CREATE TABLE `sous_salon` (
  `id_salon` smallint(1) NOT NULL,
  `name_discussion` varchar(32) COLLATE utf8_bin NOT NULL,
  `name_sous_salon` varchar(32) COLLATE utf8_bin NOT NULL,
  `nbr_discussion` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_u` smallint(4) NOT NULL,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(32) COLLATE utf8_bin NOT NULL,
  `mail` varchar(32) COLLATE utf8_bin NOT NULL,
  `pwd` varchar(32) COLLATE utf8_bin NOT NULL,
  `age` int(11) NOT NULL,
  `date_inscription` date NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`name_discussion`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_u`,`name_discussion`),
  ADD KEY `name_discussion` (`name_discussion`);

--
-- Index pour la table `salon`
--
ALTER TABLE `salon`
  ADD PRIMARY KEY (`id_salon`);

--
-- Index pour la table `sous_salon`
--
ALTER TABLE `sous_salon`
  ADD PRIMARY KEY (`id_salon`,`name_discussion`),
  ADD KEY `name_discussion` (`name_discussion`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_u`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_u` smallint(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_u` smallint(4) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `users` (`id_u`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`name_discussion`) REFERENCES `discussions` (`name_discussion`);

--
-- Contraintes pour la table `sous_salon`
--
ALTER TABLE `sous_salon`
  ADD CONSTRAINT `sous_salon_ibfk_1` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`),
  ADD CONSTRAINT `sous_salon_ibfk_2` FOREIGN KEY (`name_discussion`) REFERENCES `discussions` (`name_discussion`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
