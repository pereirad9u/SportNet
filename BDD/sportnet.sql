-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2016 at 10:26 AM
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
  `nb_participants_max` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `discipline` varchar(50) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `epreuves`
--

INSERT INTO `epreuves` (`id`, `nom`, `description`, `date`, `photo`, `inscription`, `id_evenement`, `nb_participants`, `nb_participants_max`, `prix`, `discipline`, `image`) VALUES
('582c34273c556', 'saute mouton', 'de la merde', '2016-11-17', '', 1, '582c339518a14', 0, 333, 333, 'saut', 'images/582c3427381b5.jpg'),
('582c7907849c3', 'Lancer de bites', 'Lisez le nom...\r\nTout est dit.', '2016-11-25', '', 1, '582c78486ef3a', 3, 10, 10, 'lancé', 'images/582c790781564.jpeg'),
('582c7907947a3', 'Course déguisé en couteau', 'Effectuez une course de 15km déguisé en votre plus beau canif!\r\nUne expérience inoubliable.', '2016-11-26', '', 1, '582c78486ef3a', 0, 300, 300, 'course', 'images/582c79079101a.jpg'),
('582c7ccb91e66', 'tes', 'test', '2016-11-25', '', 1, '582c7ca5a349b', 0, 888, 888, 'test', 'images/582c7ccb8f23c.jpg'),
('582ec56444f35', 'Dodo', 'Dormir...\r\nLe plus longtemps possible!!', '2016-11-29', '', 1, '582ec3d706e94', 0, 15, 15, 'endurance', 'images/582ec5643e2c4.png'),
('582ec5645c2ad', 'Sieste', 'Faire le maximum de sieste en un temps limité!', '2016-11-29', '', 1, '582ec3d706e94', 0, 25, 25, 'course', 'images/582ec5645820b.jpg'),
('582ec5647a28a', 'Se réveiller', 'Vous dormez ...\r\nSoudain le réveil sonne!\r\nTenter de vous réveiller le plus vite possible!!!', '2016-11-30', '', 1, '582ec3d706e94', 1, 30, 30, 'course', 'images/582ec5646bab9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `events`
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

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `nom`, `lieu`, `date_debut`, `date_fin`, `description`, `discipline`, `etat`, `id_organisateur`, `nb_participants`) VALUES
('582c339518a14', 'Une flemme intense', 'in your ass', '2016-11-20', '2016-11-21', 'Un truc de merde', '', 'ouvertes', '582b1f4d19a72', 0),
('582c78486ef3a', 'Une flemme intense II', 'Quelque part', '2016-11-24', '2016-11-26', 'Un évènement pronant la flemme.\r\nDeuxième édition.\r\nPensez à prendre vos bites et vos couteaux.', '', 'ouvertes', '582b1f4d19a72', 0),
('582c7ca5a349b', 'test', 'test', '2016-11-17', '2016-11-18', 'test', '', 'ouvertes', '582b1f4d19a72', 0),
('582c7d344414f', 'test', 'test', '2016-11-16', '2016-11-16', 'test', '', 'nonvalide', '582b1f4d19a72', 0),
('582ec3d706e94', 'Une flemme intense III', 'Mystère', '2016-11-29', '2016-11-30', 'Troisième édition de notre évènement!\r\nToujours dans le meme état d&#39;esprit, la flemme level over 9000!!', '', 'ouvert', '582b1f4d19a72', 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` varchar(23) NOT NULL,
  `nom` text NOT NULL,
  `id_responsable` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `nom`, `id_responsable`) VALUES
('582dd68650227', 'Les teubayy', '582b21287c1e5');

-- --------------------------------------------------------

--
-- Table structure for table `organisers`
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

--
-- Dumping data for table `organisers`
--

INSERT INTO `organisers` (`id`, `nom`, `prenom`, `email`, `nom_association`, `motdepasse`, `siteweb`, `telephone`) VALUES
('582b1f4d19a72', 'PIERRE', 'Alexandre', 'alex@email.fr', 'LaFlemme', '$2y$12$d5CwFjXO44FsG7YkIx3ExeBiTsR0I/UtJ.1x5XEyh8Fr2yU/PwHAS', 'http://www.alex-website.fr', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` varchar(23) NOT NULL,
  `classement` int(11) NOT NULL,
  `temps` text NOT NULL,
  `id_utilisateur` varchar(23) NOT NULL,
  `id_epreuve` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `classement`, `temps`, `id_utilisateur`, `id_epreuve`) VALUES
('582c5aad2b7b7', 1, '30', '582b21287c1e5', '582c34273c556'),
('582c5aad3d549', 2, '145', '582b24eb424f6', '582c34273c556'),
('582ec86fcd9ee', 1, '30', '582b21287c1e5', '582ec56444f35'),
('582ec86fdeeeb', 1, '30', '582b21287c1e5', '582ec5645c2ad'),
('582ec86fef539', 1, '145', '582b21287c1e5', '582ec5647a28a'),
('582ec8f81468b', 2, '45', '582b24eb424f6', '582ec56444f35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(23) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `email` text NOT NULL,
  `telephone` text NOT NULL,
  `motdepasse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `telephone`, `motdepasse`) VALUES
('582b21287c1e5', 'PIERRE', 'Alexandre', 'alex@email.fr', '0123456789', '$2y$12$4bxQ/e4TdFc8zlC5HSe7WeSwWBnJn2XOMvvAcGjYVDtIdylVnp7Ua'),
('582b24eb424f6', 'test', 'test', 'test@test.test', '0000000000', '$2y$12$UnHZQ6BVkq/zuUwhW8VJPuDX0yVpnonnF6S0/aT0NAjm.rCpdqaGi');

-- --------------------------------------------------------

--
-- Table structure for table `users_epreuves`
--

CREATE TABLE `users_epreuves` (
  `id_users` varchar(23) NOT NULL,
  `id_epreuves` varchar(23) NOT NULL,
  `num_dossard` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_epreuves`
--

INSERT INTO `users_epreuves` (`id_users`, `id_epreuves`, `num_dossard`) VALUES
('582b21287c1e5', '582ec56444f35', 1),
('582b24eb424f6', '582c7907849c3', 2),
('582b21287c1e5', '582c7907849c3', 1),
('582b24eb424f6', '582ec56444f35', 2),
('582b21287c1e5', '582ec5645c2ad', 1),
('582b21287c1e5', '582ec5647a28a', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id_utilisateur` varchar(23) NOT NULL,
  `id_group` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id_utilisateur`, `id_group`) VALUES
('582b24eb424f6', '582dd68650227');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `epreuves`
--
ALTER TABLE `epreuves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisers`
--
ALTER TABLE `organisers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_epreuves`
--
ALTER TABLE `users_epreuves`
  ADD PRIMARY KEY (`id_users`,`id_epreuves`),
  ADD KEY `id_epreuves` (`id_epreuves`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id_group`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `users_groups_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_groups_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
