-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 25 avr. 2025 à 12:37
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
-- Structure de la table `activite`
--

CREATE TABLE `activite` (
  `Id_Activite` int(11) NOT NULL,
  `Type_Activite` text NOT NULL,
  `Nombre_Inscri_Activite` int(11) NOT NULL,
  `Lieux_Activite` text NOT NULL,
  `Prix_Activite` int(11) NOT NULL,
  `Date_Activite` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaires_news`
--

CREATE TABLE `commentaires_news` (
  `Id_Commentaire` int(11) NOT NULL,
  `Id_News` int(11) NOT NULL,
  `Id_Membre` int(11) NOT NULL,
  `Contenu_Commentaire` text NOT NULL,
  `Date_Commentaire` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(125, 8, 2, 'aaaaaaaaaa', '2025-04-24 10:03:51');

-- --------------------------------------------------------

--
-- Structure de la table `likes_news`
--

CREATE TABLE `likes_news` (
  `id` int(11) NOT NULL,
  `id_news` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `likes_news`
--

INSERT INTO `likes_news` (`id`, `id_news`, `id_membre`) VALUES
(18, 8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `ID_Membre` int(11) NOT NULL,
  `Nom_Membre` text NOT NULL,
  `Prenom_Membre` text NOT NULL,
  `Telephone_Membre` int(11) NOT NULL,
  `Mail_Membre` text NOT NULL,
  `Age_Membre` int(11) NOT NULL,
  `Affilie_Membre` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `news` (
  `Id_News` int(11) NOT NULL,
  `Reaction_News` int(11) NOT NULL,
  `Info_News` text NOT NULL,
  `Photo_News` text NOT NULL,
  `Date_News` date NOT NULL,
  `Nombre_Likes` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`Id_News`, `Reaction_News`, `Info_News`, `Photo_News`, `Date_News`, `Nombre_Likes`) VALUES
(1, 1, 'Sortie de printemps', 'https://docs.google.com/presentation/d/e/2PACX-1vSsTfyAcvRMMUWh7KA4Xs7k6VaVcRl24WzFCcfLKtDLyPj-aW_nYdGWXMSlBLVl-ymFm3sjO5mQ4Q8S/pub?start=false&loop=false&delayms=60000', '2012-01-25', 0),
(2, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vQR-voCW_clRl9FKrItZBA3r9u2dfS3R4k8S39gHbWCqNQgnHPFzqlKJugdMWN0WaPJpNCO9qDxGCKn/pub?start=false&loop=false&delayms=3000', '2025-04-04', 0),
(3, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vS_c8F3J4Kof6KhA1U8R7BDJ_bT-N9xqUjWlA4O4oqSpy3NpUqwZuHydjZRoDXyUSczBsMOHY9AZfCI/pub?start=false&loop=false&delayms=3000', '2025-04-04', 0),
(4, 1, 'sortie 2', 'https://docs.google.com/presentation/d/e/2PACX-1vQq9WhE3FDyiFnn6a6GXUihDtTkQ4N4nwMlF5ws2jpCYHPfTbFu30KF_6aPPJDZ3bZ2XXdICcAsvP4v/pub?start=false&loop=false&delayms=3000', '2025-04-04', 0),
(6, 1, 'SORTIE 3', 'https://docs.google.com/presentation/d/e/2PACX-1vTFCZHGpEnNlH0S7HIFXRH1AVWWhW5qCF38R4wIvXPyV6GqIFVe9bN9FKKD85RHnQI53HNRdzYdzPE7/pub?start=false&loop=false&delayms=3000', '2025-05-04', 0),
(7, 1, 'Sortie 5', 'https://docs.google.com/presentation/d/e/2PACX-1vSRGoPz3r1Fml9rj_H4E1wCS7-Qd95tmNZHOylPulNaAL9DrcL8lRcDLrjKiGhNiv3_dynlttknUKoD/pub?start=false&loop=false&delayms=3000', '2025-02-23', 0),
(8, 1, 'Halloween', 'https://docs.google.com/presentation/d/e/2PACX-1vSXN-VcH9EWRaAHeWFsi86xdJzDYY-fex6xcUzxhsN9jlmDqHfSwdkdaIvQUKPPGIbJwUsvBSjNzOT7/pub?start=false&loop=false&delayms=3000', '2025-03-31', 1);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `Id_Note` int(11) NOT NULL,
  `News_Note` int(11) NOT NULL,
  `Membre_Note` int(11) NOT NULL,
  `Texte_Note` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `Id_Photo` int(11) NOT NULL,
  `Photo_Photo` text NOT NULL,
  `Utilisation_Photo` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`Id_Activite`);

--
-- Index pour la table `commentaires_news`
--
ALTER TABLE `commentaires_news`
  ADD PRIMARY KEY (`Id_Commentaire`);

--
-- Index pour la table `likes_news`
--
ALTER TABLE `likes_news`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`ID_Membre`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`Id_News`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`Id_Note`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`Id_Photo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activite`
--
ALTER TABLE `activite`
  MODIFY `Id_Activite` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaires_news`
--
ALTER TABLE `commentaires_news`
  MODIFY `Id_Commentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT pour la table `likes_news`
--
ALTER TABLE `likes_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `ID_Membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `Id_News` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `Id_Note` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `Id_Photo` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
