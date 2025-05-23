-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 23 mai 2025 à 11:35
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

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
-- Structure de la table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `Id_Activite` int NOT NULL AUTO_INCREMENT,
  `Type_Activite` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nombre_Inscri_Activite` int NOT NULL,
  `Lieux_Activite` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prix_Activite` int NOT NULL,
  `Date_Activite` date NOT NULL,
  PRIMARY KEY (`Id_Activite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaires_news`
--

DROP TABLE IF EXISTS `commentaires_news`;
CREATE TABLE IF NOT EXISTS `commentaires_news` (
  `Id_Commentaire` int NOT NULL AUTO_INCREMENT,
  `Id_News` int NOT NULL,
  `Id_Membre` int NOT NULL,
  `Contenu_Commentaire` text NOT NULL,
  `Date_Commentaire` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id_Commentaire`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaires_news`
--

INSERT INTO `commentaires_news` (`Id_Commentaire`, `Id_News`, `Id_Membre`, `Contenu_Commentaire`, `Date_Commentaire`) VALUES
(1, 1, 1, 'Mael a posté un commentaire', '2025-04-18 12:35:33'),
(2, 1, 1, 'Mael ce bg', '2025-04-18 12:35:33'),
(87, 8, 2, 'mama', '2025-04-18 12:35:33'),
(88, 7, 2, 'mama', '2025-04-18 12:35:33'),
(92, 6, 2, 'a', '2025-04-18 12:35:33'),
(93, 4, 2, 'aa', '2025-04-18 12:35:33'),
(94, 2, 2, 'aaa', '2025-04-18 12:35:33'),
(95, 3, 2, 'aaa', '2025-04-18 12:35:33'),
(96, 6, 2, 'aa', '2025-04-18 12:35:33'),
(97, 4, 2, 'aa', '2025-04-18 12:35:33'),
(99, 2, 2, 'mama', '2025-04-18 12:35:33'),
(100, 2, 2, 'schrobi', '2025-04-18 12:35:33'),
(101, 2, 2, 'schrobi', '2025-04-18 12:35:33'),
(102, 2, 2, 'schrobi', '2025-04-18 12:35:33'),
(103, 8, 2, 'mama2', '2025-04-18 12:41:43'),
(121, 8, 2, 'mama4', '2025-04-18 13:32:44'),
(122, 8, 2, 'mama5', '2025-04-18 13:32:54'),
(123, 7, 2, 'aa', '2025-04-18 13:33:03'),
(124, 8, 2, 'mama', '2025-04-18 13:37:06'),
(125, 8, 2, 'aaaaaaaaaa', '2025-04-24 10:03:51'),
(126, 8, 2, 'Wesh', '2025-04-25 12:43:33'),
(127, 8, 2, 'Ma bite', '2025-04-25 13:14:56');

-- --------------------------------------------------------

--
-- Structure de la table `likes_news`
--

DROP TABLE IF EXISTS `likes_news`;
CREATE TABLE IF NOT EXISTS `likes_news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_news` int NOT NULL,
  `id_membre` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `likes_news`
--

INSERT INTO `likes_news` (`id`, `id_news`, `id_membre`) VALUES
(27, 7, 2);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `ID_Membre` int NOT NULL AUTO_INCREMENT,
  `Nom_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prenom_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Telephone_Membre` int NOT NULL,
  `Mail_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Age_Membre` int NOT NULL,
  `Affilie_Membre` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Membre`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`ID_Membre`, `Nom_Membre`, `Prenom_Membre`, `Telephone_Membre`, `Mail_Membre`, `Age_Membre`, `Affilie_Membre`) VALUES
(1, 'Distave', 'Dorian', 476910686, 'distave.dorian.el@pierrard.eu', 18, 1),
(2, 'Schrobi', 'Tom', 476910686, 'dodorian.el@pierrard.eu', 18, 1);

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `Id_News` int NOT NULL AUTO_INCREMENT,
  `Reaction_News` int NOT NULL,
  `Info_News` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Photo_News` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_News` date NOT NULL,
  `Nombre_Likes` int NOT NULL,
  PRIMARY KEY (`Id_News`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`Id_News`, `Reaction_News`, `Info_News`, `Photo_News`, `Date_News`, `Nombre_Likes`) VALUES
(1, 1, 'Sortie de printemps', 'https://docs.google.com/presentation/d/e/2PACX-1vSsTfyAcvRMMUWh7KA4Xs7k6VaVcRl24WzFCcfLKtDLyPj-aW_nYdGWXMSlBLVl-ymFm3sjO5mQ4Q8S/pub?start=false&loop=false&delayms=60000', '2012-01-25', 0),
(2, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vQR-voCW_clRl9FKrItZBA3r9u2dfS3R4k8S39gHbWCqNQgnHPFzqlKJugdMWN0WaPJpNCO9qDxGCKn/pub?start=false&loop=false&delayms=3000', '2025-04-04', 0),
(3, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vS_c8F3J4Kof6KhA1U8R7BDJ_bT-N9xqUjWlA4O4oqSpy3NpUqwZuHydjZRoDXyUSczBsMOHY9AZfCI/pub?start=false&loop=false&delayms=3000', '2025-04-04', 0),
(4, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vQq9WhE3FDyiFnn6a6GXUihDtTkQ4N4nwMlF5ws2jpCYHPfTbFu30KF_6aPPJDZ3bZ2XXdICcAsvP4v/pub?start=false&loop=false&delayms=3000', '2025-04-04', 0),
(6, 1, 'SORTIE 3', 'https://docs.google.com/presentation/d/e/2PACX-1vTFCZHGpEnNlH0S7HIFXRH1AVWWhW5qCF38R4wIvXPyV6GqIFVe9bN9FKKD85RHnQI53HNRdzYdzPE7/pub?start=false&loop=false&delayms=3000', '2025-05-04', 0),
(7, 1, 'Sortie 5', 'https://docs.google.com/presentation/d/e/2PACX-1vSRGoPz3r1Fml9rj_H4E1wCS7-Qd95tmNZHOylPulNaAL9DrcL8lRcDLrjKiGhNiv3_dynlttknUKoD/pub?start=false&loop=false&delayms=3000', '2025-02-23', 1),
(8, 1, 'Halloween', 'https://docs.google.com/presentation/d/e/2PACX-1vSXN-VcH9EWRaAHeWFsi86xdJzDYY-fex6xcUzxhsN9jlmDqHfSwdkdaIvQUKPPGIbJwUsvBSjNzOT7/pub?start=false&loop=false&delayms=3000', '2025-03-31', 0);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `Id_Note` int NOT NULL AUTO_INCREMENT,
  `News_Note` int NOT NULL,
  `Membre_Note` int NOT NULL,
  `Texte_Note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Id_Note`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `Id_Photo` int NOT NULL AUTO_INCREMENT,
  `Photo_Photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Utilisation_Photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Id_Photo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
