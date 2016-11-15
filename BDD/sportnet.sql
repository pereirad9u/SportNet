-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 15 Novembre 2016 à 08:44
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sportnet`
--

-- --------------------------------------------------------

--
-- Structure de la table `epreuves`
--

CREATE TABLE `epreuves` (
  `id` varchar(23) NOT NULL,
  `nom` text NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `photo` text NOT NULL,
  `inscription` tinyint(1) NOT NULL,
  `id_evenement` varchar(23) NOT NULL,
  `nb_participants` int(11) NOT NULL,
  `nb_participants_max` int(11) NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` varchar(23) NOT NULL,
  `nom` text NOT NULL,
  `lieu` text NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `description` text NOT NULL,
  `discipline` text NOT NULL,
  `etat` text NOT NULL,
  `id_organisateur` varchar(23) NOT NULL,
  `nb_participants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `organisers`
--

CREATE TABLE `organisers` (
  `id` varchar(23) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `email` text NOT NULL,
  `nom_association` text NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `siteweb` text NOT NULL,
  `telephone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `results`
--

CREATE TABLE `results` (
  `id` varchar(23) NOT NULL,
  `classement` int(11) NOT NULL,
  `temps` time NOT NULL,
  `id_utilisateur` varchar(23) NOT NULL,
  `id_epreuve` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` varchar(23) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `email` text NOT NULL,
  `telephone` text NOT NULL,
  `motdepasse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users_epreuves`
--

CREATE TABLE `users_epreuves` (
  `id_users` varchar(23) NOT NULL,
  `id_epreuves` varchar(23) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `epreuves`
--
ALTER TABLE `epreuves`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `organisers`
--
ALTER TABLE `organisers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_epreuves`
--
ALTER TABLE `users_epreuves`
  ADD PRIMARY KEY (`id_users`,`id_epreuves`),
  ADD KEY `id_epreuves` (`id_epreuves`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
