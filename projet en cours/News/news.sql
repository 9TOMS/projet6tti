-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 04 avr. 2025 à 08:38
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `Id_News` int(11) NOT NULL,
  `Reaction_News` int(11) NOT NULL,
  `Info_News` text NOT NULL,
  `Photo_News` text NOT NULL,
  `Date_News` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`Id_News`, `Reaction_News`, `Info_News`, `Photo_News`, `Date_News`) VALUES
(1, 1, 'Sortie de printemps', 'https://docs.google.com/presentation/d/e/2PACX-1vSsTfyAcvRMMUWh7KA4Xs7k6VaVcRl24WzFCcfLKtDLyPj-aW_nYdGWXMSlBLVl-ymFm3sjO5mQ4Q8S/pub?start=false&loop=false&delayms=60000', '2012-01-25'),
(2, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vQR-voCW_clRl9FKrItZBA3r9u2dfS3R4k8S39gHbWCqNQgnHPFzqlKJugdMWN0WaPJpNCO9qDxGCKn/pub?start=false&loop=false&delayms=3000', '2025-04-04'),
(3, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vS_c8F3J4Kof6KhA1U8R7BDJ_bT-N9xqUjWlA4O4oqSpy3NpUqwZuHydjZRoDXyUSczBsMOHY9AZfCI/pub?start=false&loop=false&delayms=3000', '2025-04-04'),
(4, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vQq9WhE3FDyiFnn6a6GXUihDtTkQ4N4nwMlF5ws2jpCYHPfTbFu30KF_6aPPJDZ3bZ2XXdICcAsvP4v/pub?start=false&loop=false&delayms=3000', '2025-04-04'),
(6, 1, 'SORTIE 3', 'https://docs.google.com/presentation/d/e/2PACX-1vTFCZHGpEnNlH0S7HIFXRH1AVWWhW5qCF38R4wIvXPyV6GqIFVe9bN9FKKD85RHnQI53HNRdzYdzPE7/pub?start=false&loop=false&delayms=3000', '2025-05-04'),
(7, 1, 'Sortie 5', 'https://docs.google.com/presentation/d/e/2PACX-1vSRGoPz3r1Fml9rj_H4E1wCS7-Qd95tmNZHOylPulNaAL9DrcL8lRcDLrjKiGhNiv3_dynlttknUKoD/pub?start=false&loop=false&delayms=3000', '2025-02-23'),
(8, 1, 'Halloween', 'https://docs.google.com/presentation/d/e/2PACX-1vSXN-VcH9EWRaAHeWFsi86xdJzDYY-fex6xcUzxhsN9jlmDqHfSwdkdaIvQUKPPGIbJwUsvBSjNzOT7/pub?start=false&loop=false&delayms=3000', '2025-03-31');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`Id_News`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `Id_News` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
