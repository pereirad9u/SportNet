-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2016 at 03:12 PM
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
('582eff9833b77', 'Le plus gros mangeur de frite I', 'Vous disposerez d&#39;une énorme assiette de frites!\r\nLe but est de finir son assiette le plus rapidement possible!\r\nA vos fourchettes!!', '2016-08-11', '', 0, '582efdb552a60', 0, 30, 30, 'course', 'images/582eff9828b5f.jpg'),
('582eff984607f', 'La tentation de la frite', 'Les meilleurs frites du monde sont devant vos yeux.\r\nVous devrez tenir le plus longtemps possible à 10cm de l&#39;assiette sans en manger une seul!\r\nBon courage!', '2016-08-12', '', 0, '582efdb552a60', 0, 10, 10, 'endurance', 'images/582eff98428b3.jpg'),
('582eff985879c', 'Le plus gros mangeur de frite I', 'Second concours du plus gros mangeur de frites:\r\nVous disposerez d&#39;une énorme assiette de frites!\r\nLe but est de finir son assiette le plus rapidement possible!\r\nA vos fourchettes!!', '2016-08-13', '', 0, '582efdb552a60', 0, 30, 30, 'course', 'images/582eff9852c56.jpg'),
('582f0251b6413', 'Mangeur de saucisses', 'Installez vous devant votre assiette de saucisse.\r\nPuis terminez la le plus vite possible!\r\nA vos fourchettes!', '2016-12-21', '', 1, '582f00cd8da73', 0, 30, 30, 'course', 'images/582f0251b0c7e.jpg'),
('582f0251c9760', 'Lancé de saucisse', 'Vous disposé d&#39;un nombre limité de saucisse.\r\nVous devez en lancé à 15m le plus vite possible!', '2016-12-22', '', 1, '582f00cd8da73', 0, 10, 10, 'course', 'images/582f0251c6ccf.jpeg'),
('582f042bd10f5', 'Concours de cuisine', 'Cuisiné votre propre tartiflette!\r\nTenter de battre les autres participants à l&#39;aide de votre fumet!', '2017-01-01', '', 1, '582f03a59fa80', 0, 15, 15, 'cuisine', 'images/582f042bca920.jpg'),
('582f059518182', 'Make your french fries', 'Vous devrez réaliser en un temps record 10kg de frites!\r\nA vos fourneaux!!', '2016-11-21', '', 1, '582f04f84a2c5', 1, 10, 10, 'course', 'images/582f059512e56.jpg');

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
('582efdb552a60', 'La frite m&#39;habite I', 'Bruxelles', '2016-08-10', '2016-08-13', 'Venez déguster plus d&#39;un milliers de sorte de frites!\r\nParticiper à nos concours du plus gros mangeur de frites!\r\nEt partager votre passion de la frite!', '', 'ouvert', '582b1f4d19a72', 0),
('582f00cd8da73', 'Sausage Party', 'Strasbourg', '2016-12-20', '2016-11-23', 'L&#39;hiver est proche, le froid se fait sentir.\nVous grelottez ? Venez vous réchauffer à la grande Sausage Party de Strasbourg!!\nAu programme : \nDégustation de saucisses.\nConcours du plus gros mangeur de saucisses.\nGrand lancé de saucisses.', '', 'ouvert', '582b1f4d19a72', 0),
('582f03a59fa80', 'New Year Tartiflette', 'Mystère', '2016-12-31', '2017-01-02', 'Afin de fêter la nouvelle année dans la bonne humeur et l&#39;abondance, venez à la toute nouvelle New Year Tartiflette!\r\nRégalez vos papilles en goûtant les meilleurs tartiflettes du monde!\r\nParticipez au concours de cuisine, faites votre propre tartiflette et mesurez vous aux autres participants!!', '', 'ouvert', '582b1f4d19a72', 0),
('582f04f84a2c5', 'La frite m&#39;habite II', 'Bruxelles', '2016-11-20', '2016-11-21', 'Avec le succès de notre première édition, nous nous lançons dans un deuxième évènement.\r\nSur deux jours cette fois ci.\r\nVenez déguster une seconde fois nos meilleurs frites!\r\nNouvelle epreuve : apporter vos propres pomme de terres et faites 10kg de frites le plus rapidement possible!!', '', 'ouvert', '582b1f4d19a72', 0);

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
('582f079dd507b', 'Amateur de saucisse', '582efb668c5a1'),
('582f0898c996e', 'Les coupains!', '582efb9195ae6');

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
('582b1f4d19a72', 'PIERRE', 'Alexandre', 'alex@email.fr', 'LaFlemme', '$2y$12$d5CwFjXO44FsG7YkIx3ExeBiTsR0I/UtJ.1x5XEyh8Fr2yU/PwHAS', 'http://www.alex-website.fr', '0123456789'),
('582ef97c04838', 'POSTEL', 'Romain', 'postel@email.org', 'PostelCharity', '$2y$12$RBlc0unxwLhO458Ld/49y.uOB3IRtTLL48rwpKwSSosESa27tOVse', 'http://www.lepauvre.fr', '0111111111'),
('582ef9db283fb', 'PEREIRA DA CONCECAO', 'Alexandre', 'pereira@email.org', 'Les portugais ne sont pas morts', '$2y$12$g5VTWlfXi/IhnGKO44lkj.u7ONL/qBOA3LW6Cmm4GaRMIL6O2Gbva', 'http://www.portugaissansfrontiere.fr', '0222222222'),
('582efa2dc8503', 'LAUNAY', 'Guillaume', 'launay@email.org', 'Un cap une péninsule un NAY', '$2y$12$eUoSBgY1FUqtRRMQcnXPVe/p814ram3kBnFSbeSS2c3eMmxUBL3FW', 'http://www.lenezdunayy.fr', '0333333333');

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
('582f0bed7c03a', 1, '60', '582efb668c5a1', '582eff9833b77'),
('582f0bed8a1ca', 2, '65', '582b21287c1e5', '582eff9833b77'),
('582f0bed9a245', 3, '132', '582efb9195ae6', '582eff9833b77'),
('582f0bedafdca', 4, '400', '582efbb476181', '582eff9833b77'),
('582f0bedcb462', 1, '3000', '582efb9195ae6', '582eff984607f'),
('582f0bedd35a9', 1, '30', '582efbb476181', '582eff985879c'),
('582f0bedde0cd', 2, '33', '582efb9195ae6', '582eff985879c'),
('582f0bede8ed2', 3, '35', '582b21287c1e5', '582eff985879c'),
('582f0bedf3eee', 4, '45', '582efb668c5a1', '582eff985879c');

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
('582efb668c5a1', 'PEREIRA DA CONCECAO', 'Alexandre', 'pereira@email.user', '0122222222', '$2y$12$DNjs8FgRQ4YI7jh11oZHdOu8C1Hic0EWXY8chtUv96FbZv9KA9.Ae'),
('582efb9195ae6', 'POSTEL', 'Romain', 'postel@email.user', '0233333333', '$2y$12$st4FqI6DFaeWqUBku/W3Qufq5ULPs9TE3Tlp7kgVKlVzo.9YeShN6'),
('582efbb476181', 'LAUNAY', 'Guillaume', 'launay@email.user', '0344444444', '$2y$12$xJbMQcpA5j6lGpy44Y15c.GsxWlnT6syAHJDbIHnBbQFhtH5vZc0m');

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
('582efbb476181', '582f0251c9760', 2),
('582efb668c5a1', '582f0251c9760', 1),
('582efbb476181', '582f0251b6413', 3),
('582efb9195ae6', '582f0251b6413', 2),
('582efb668c5a1', '582f0251b6413', 1),
('582efb9195ae6', '582f042bd10f5', 1),
('582efbb476181', '582f042bd10f5', 2),
('582efb668c5a1', '582f042bd10f5', 3),
('582b21287c1e5', '582f042bd10f5', 4),
('582efb9195ae6', '582f059518182', 0),
('582efb9195ae6', '582eff9833b77', 1),
('582efbb476181', '582eff9833b77', 2),
('582efb668c5a1', '582eff9833b77', 3),
('582b21287c1e5', '582eff9833b77', 4),
('582efb9195ae6', '582eff984607f', 1),
('582efb9195ae6', '582eff985879c', 1),
('582efbb476181', '582eff985879c', 2),
('582efb668c5a1', '582eff985879c', 3),
('582b21287c1e5', '582eff985879c', 4);

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
('582efb9195ae6', '582f079dd507b'),
('582efbb476181', '582f079dd507b'),
('582efbb476181', '582f0898c996e'),
('582efb668c5a1', '582f0898c996e'),
('582b21287c1e5', '582f0898c996e');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
