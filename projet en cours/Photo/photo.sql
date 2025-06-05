-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 05 juin 2025 à 09:07
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

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
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `Id_Photo` int NOT NULL AUTO_INCREMENT,
  `Photo_Photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_parent` int NOT NULL,
  PRIMARY KEY (`Id_Photo`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`Id_Photo`, `Photo_Photo`, `id_parent`) VALUES
(1, 'images/test.jpg', 1),
(8, 'images/test.jpg', 2),
(3, 'images/fa.jpg', 1),
(4, 'images/ma.jpg', 1),
(5, 'images/test.jpg', 1),
(6, 'images/fa.jpg', 1),
(7, 'images/ma.jpg', 1),
(9, 'images/fa.jpg', 2),
(10, 'images/ma.jpg', 2),
(11, 'images/test.jpg', 2),
(12, 'images/fa.jpg', 2),
(13, 'images/ma.jpg', 2),
(14, 'images/test.jpg', 3),
(15, 'images/fa.jpg', 3),
(16, 'images/ma.jpg', 3),
(17, 'images/test.jpg', 3),
(18, 'images/fa.jpg', 3),
(19, 'images/ma.jpg', 3),
(107, 'images/6839a004f0282_Capture d\'écran 2024-03-08 124353.png', 1),
(85, 'images/683057fa5c0e9_Capture d\'écran 2024-01-04 175707.png', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
