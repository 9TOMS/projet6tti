-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 25 avr. 2025 à 10:42
-- Version du serveur :  5.7.29
-- Version de PHP : 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crepuscule`
--

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `ID_Membre` int(11) NOT NULL,
  `Enfant` tinyint(1) NOT NULL,
  `Nom_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prenom_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Anniversaire_Membre` date NOT NULL,
  `Nom_parent_Membre` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Prenom_parent_Membre` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Telephone_Membre` bigint(11) NOT NULL,
  `Mail_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Comment_decouvert` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Condition_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mot_de_passe_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Affilie_Membre` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`ID_Membre`, `Enfant`, `Nom_Membre`, `Prenom_Membre`, `Anniversaire_Membre`, `Nom_parent_Membre`, `Prenom_parent_Membre`, `Telephone_Membre`, `Mail_Membre`, `Comment_decouvert`, `Condition_Membre`, `Mot_de_passe_Membre`, `Affilie_Membre`) VALUES
(7, 1, 'Distave', 'Dorian', '2025-04-09', 'Barbie', 'Barbu', 32498798800, 'madomage1227dd@gmail.com', 'jsp', 'jspa', '$2y$10$17P6Hs/X9WwHRzhaK5cfzOloMNdCqr2UcyhaXYdirMox4QvpJW3zi', 0),
(8, 1, 'Distave', 'Dorian', '2025-04-09', 'Barbie', 'Barbu', 32498798800, 'madomage1227dd@gmail.com', 'jsp', 'jspa', '$2y$10$8h0FDX3nldhGmUK8AGfXo.8a.mxOlrBg0Sloeu6DCiydcLyn0Iz/y', 0),
(9, 1, 'Distave', 'Dorian', '2025-04-10', '/', '/', 32498798800, 'madomage1227dd@gmail.com', 'jsp', '', '$2y$10$4RaDRkfQs4L1uJpqiVjjTOzU9HCxyVoANMYNnrU9VpKN9MhsqdW9u', 0),
(14, 1, 'Richard', 'Maxime', '2025-04-05', '/', '/', 32498798800, 'madomage1227dd@gmail.com', 'lkfrhoiaz', 'lkfrhoiaz', '$2y$10$UCvFmm85pixqYl9CCCR.yu5HyjXsE0p3Q.fu3wXmA4wta5lplaRb6', 0),
(15, 1, 'ytz', 'hzte', '2025-04-03', NULL, NULL, 4646416564, 'oqzhefiuhzaiufh@iuhseg.com', 'lkfrhoiaz', 'jspa', '$2y$10$M1h2gnZE7OqlL7R5c8J5me6hbIKFCni.Pb817Ybnc4SsVUIb7mJSe', 0),
(16, 1, 'ytz', 'hzte', '2025-04-03', NULL, NULL, 4646416564, 'oqzhefiuhzaiufh@iuhseg.com', 'lkfrhoiaz', 'jspa', '$2y$10$NvODQrdhbHowmwENetpiteeotO98DvkVCBYV/KsNTc/Bk5yMg9sqK', 0),
(17, 1, 'Distave', 'Dirua', '2021-02-16', 'Barbie', 'Barbu', 4646416564, 'madomage1227dd@gmail.com', 'lkfrhoiaz', 'lkfrhoiaz', '$2y$10$BsGprULB5UhDI53WOx4m.OztlLNWmzCmzggLUSK1AKlgq5MGkC6QO', 0),
(18, 1, 'Distave', 'Maxime', '2025-04-18', NULL, NULL, 32498798800, 'madomage1227dd@gmail.com', 'jsp', 'jspa', '$2y$10$cJv4FcSxpRNXvgeRf16ase2ktsjH6qN.CO4M8XroFSoUqutyegpdi', 0),
(19, 1, 'Distave', 'Dorian', '2025-04-04', 'Barbie', 'Barbu', 4646416564, 'madomage1227dd@gmail.com', 'jsp', 'jspa', '$2y$10$XjEpTiwx5s.QVp4uc3Bjo.d3kj8XtP2VSi6EjkkTvwuRkpa2RSR5C', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`ID_Membre`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `ID_Membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
