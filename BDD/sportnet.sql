-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2016 at 04:46 PM
-- Server version: 5.6.30-1
-- PHP Version: 7.0.12-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportnet`
--

-- --------------------------------------------------------

--
-- Table structure for table `epreuves`
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
  `nb_participants_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evenements`
--

CREATE TABLE `evenements` (
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
-- Table structure for table `organisateurs`
--

CREATE TABLE `organisateurs` (
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
-- Table structure for table `participe`
--

CREATE TABLE `participe` (
  `id_utilisateur` varchar(23) NOT NULL,
  `id_epreuve` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resultats`
--

CREATE TABLE `resultats` (
  `id` varchar(23) NOT NULL,
  `classement` int(11) NOT NULL,
  `temps` time NOT NULL,
  `id_utilisateur` varchar(23) NOT NULL,
  `id_epreuve` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` varchar(23) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `email` text NOT NULL,
  `telephone` text NOT NULL,
  `motdepasse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `epreuves`
--
ALTER TABLE `epreuves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisateurs`
--
ALTER TABLE `organisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participe`
--
ALTER TABLE `participe`
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_epreuve` (`id_epreuve`);

--
-- Indexes for table `resultats`
--
ALTER TABLE `resultats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `participe_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `participe_ibfk_2` FOREIGN KEY (`id_epreuve`) REFERENCES `epreuves` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
