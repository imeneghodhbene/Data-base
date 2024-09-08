-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 19 juin 2024 à 08:22
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
-- Base de données : `inscription2`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectation etu`
--

DROP TABLE IF EXISTS `affectation etu`;
CREATE TABLE IF NOT EXISTS `affectation etu` (
  `id` int NOT NULL,
  `idcl` int NOT NULL,
  KEY `affectation etu_ibfk_1` (`id`),
  KEY `idcl` (`idcl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `affectation etu`
--

INSERT INTO `affectation etu` (`id`, `idcl`) VALUES
(216, 12),
(217, 12);

-- --------------------------------------------------------

--
-- Structure de la table `affectation matcl`
--

DROP TABLE IF EXISTS `affectation matcl`;
CREATE TABLE IF NOT EXISTS `affectation matcl` (
  `idcl` int NOT NULL,
  `idmat` int NOT NULL,
  KEY `idcl` (`idcl`),
  KEY `idmat` (`idmat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `affectation matcl`
--

INSERT INTO `affectation matcl` (`idcl`, `idmat`) VALUES
(12, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Structure de la table `affectation prof`
--

DROP TABLE IF EXISTS `affectation prof`;
CREATE TABLE IF NOT EXISTS `affectation prof` (
  `idprof` int NOT NULL,
  `idmat` int NOT NULL,
  KEY `idprof` (`idprof`),
  KEY `idmat` (`idmat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `affectation prof`
--

INSERT INTO `affectation prof` (`idprof`, `idmat`) VALUES
(23, 1),
(23, 1);

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `idcl` int NOT NULL AUTO_INCREMENT,
  `nomcl` text NOT NULL,
  PRIMARY KEY (`idcl`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`idcl`, `nomcl`) VALUES
(12, 'l1'),
(15, 'l15');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `nom`, `prenom`) VALUES
(216, 'ghodhbene', 'imen'),
(217, 'hajri', 'rahma');

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

DROP TABLE IF EXISTS `matiere`;
CREATE TABLE IF NOT EXISTS `matiere` (
  `idmat` int NOT NULL AUTO_INCREMENT,
  `nommat` text NOT NULL,
  PRIMARY KEY (`idmat`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`idmat`, `nommat`) VALUES
(1, 'reseaux');

-- --------------------------------------------------------

--
-- Structure de la table `prof`
--

DROP TABLE IF EXISTS `prof`;
CREATE TABLE IF NOT EXISTS `prof` (
  `idprof` int NOT NULL AUTO_INCREMENT,
  `nomprof` text NOT NULL,
  `prenomprof` text NOT NULL,
  PRIMARY KEY (`idprof`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `prof`
--

INSERT INTO `prof` (`idprof`, `nomprof`, `prenomprof`) VALUES
(23, 'dridi', 'farah');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affectation etu`
--
ALTER TABLE `affectation etu`
  ADD CONSTRAINT `affectation etu_ibfk_1` FOREIGN KEY (`id`) REFERENCES `etudiant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `affectation etu_ibfk_2` FOREIGN KEY (`idcl`) REFERENCES `classe` (`idcl`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `affectation matcl`
--
ALTER TABLE `affectation matcl`
  ADD CONSTRAINT `affectation matcl_ibfk_1` FOREIGN KEY (`idcl`) REFERENCES `classe` (`idcl`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `affectation matcl_ibfk_2` FOREIGN KEY (`idmat`) REFERENCES `matiere` (`idmat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `affectation prof`
--
ALTER TABLE `affectation prof`
  ADD CONSTRAINT `affectation prof_ibfk_1` FOREIGN KEY (`idprof`) REFERENCES `prof` (`idprof`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `affectation prof_ibfk_2` FOREIGN KEY (`idmat`) REFERENCES `matiere` (`idmat`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
