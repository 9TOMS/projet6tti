-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 21 mars 2025 à 13:01
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
-- Structure de la table `com`
--

DROP TABLE IF EXISTS `com`;
CREATE TABLE IF NOT EXISTS `com` (
  `Id_Com` int NOT NULL AUTO_INCREMENT,
  `Id_Membre` int NOT NULL,
  `Texte_Com` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_Com` date NOT NULL,
  `Reaction_Com` int NOT NULL,
  `Id_News` int NOT NULL,
  PRIMARY KEY (`Id_Com`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `Stage_Inscri_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Stage_Payer_Membre` int NOT NULL,
  `Cours_Inscri_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Cours_Payer_Membre` int NOT NULL,
  `Balade_Inscri_Membre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Balade_Payer_Membre` int NOT NULL,
  PRIMARY KEY (`ID_Membre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `Id_News` int NOT NULL AUTO_INCREMENT,
  `Reaction_News` int NOT NULL,
  `Info_News` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Photo_News` int NOT NULL,
  `Date_News` date NOT NULL,
  `Id_Com` int NOT NULL,
  PRIMARY KEY (`Id_News`)
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
