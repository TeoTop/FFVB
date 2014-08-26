-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 26 Août 2014 à 16:21
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `ffvb_gpa`
--
CREATE DATABASE IF NOT EXISTS FFVB_GPA;
USE FFVB_GPA;

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE IF NOT EXISTS `club` (
  `id_club` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ville` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `commite` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_club`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;


-- --------------------------------------------------------

--
-- Structure de la table `coupe`
--

CREATE TABLE IF NOT EXISTS `coupe` (
  `id_coupe` int(11) NOT NULL AUTO_INCREMENT,
  `equipe` int(11) DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `sexe` enum('f','g') COLLATE utf8_unicode_ci DEFAULT 'g',
  `annee` int(4) DEFAULT NULL,
  PRIMARY KEY (`id_coupe`),
  KEY `IDX_FAE9744B59F9EECF` (`equipe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;


-- --------------------------------------------------------

--
-- Structure de la table `critere`
--

CREATE TABLE IF NOT EXISTS `critere` (
  `id_critere` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('domicile','exterieur','exempter') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'domicile',
  `valeur` int(5) DEFAULT '-1',
  `requete` varchar(350) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_critere`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE IF NOT EXISTS `equipe` (
  `id_equipe` int(11) NOT NULL AUTO_INCREMENT,
  `club` int(11) NOT NULL,
  `coupe` int(11) DEFAULT NULL,
  `nbKmParcouru` int(5) DEFAULT '0',
  `classementCFVB` int(5) DEFAULT '0',
  `classementCoupe` int(4) DEFAULT '0',
  PRIMARY KEY (`id_equipe`),
  KEY `IDX_23E5BF2361190A32` (`club`),
  KEY `IDX_23E5BF23717D2393` (`coupe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;


-- --------------------------------------------------------

--
-- Structure de la table `exempter`
--

CREATE TABLE IF NOT EXISTS `exempter` (
  `tour` int(11) NOT NULL,
  `equipe` int(11) NOT NULL,
  PRIMARY KEY (`tour`,`equipe`),
  KEY `IDX_11C75DFF15ED8D43` (`tour`),
  KEY `IDX_11C75DFF6D861B89` (`equipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jouer`
--

CREATE TABLE IF NOT EXISTS `jouer` (
  `equipe` int(11) NOT NULL,
  `poule` int(11) NOT NULL,
  `distance` int(4) DEFAULT NULL,
  PRIMARY KEY (`equipe`,`poule`),
  KEY `IDX_439F75E96D861B89` (`equipe`),
  KEY `IDX_439F75E926596FD8` (`poule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déclencheurs `jouer`
--
DROP TRIGGER IF EXISTS `ajouter_distance_parcouru`;
DELIMITER //
CREATE TRIGGER `ajouter_distance_parcouru` AFTER INSERT ON `jouer`
 FOR EACH ROW IF (NEW.distance IS NOT NULL)
THEN

	UPDATE `equipe` SET `nbKmParcouru` = `nbKmParcouru` + 	NEW.distance WHERE `id_equipe` = NEW.equipe;

END IF
//
DELIMITER ;
DROP TRIGGER IF EXISTS `retirer_distance_parcouru`;
DELIMITER //
CREATE TRIGGER `retirer_distance_parcouru` AFTER DELETE ON `jouer`
 FOR EACH ROW IF (OLD.distance IS NOT NULL)
THEN
	UPDATE `equipe` SET `nbKmParcouru` = `nbKmParcouru` - OLD.distance WHERE `id_equipe` = OLD.equipe;
END IF
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `parcourir`
--

CREATE TABLE IF NOT EXISTS `parcourir` (
  `clubDomicile` int(11) NOT NULL,
  `clubExterieur` int(11) NOT NULL,
  `distance` double DEFAULT NULL,
  PRIMARY KEY (`clubExterieur`,`clubDomicile`),
  KEY `IDX_674F85F93F8BA4FD` (`clubExterieur`),
  KEY `IDX_674F85F939606E3F` (`clubDomicile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `poule`
--

CREATE TABLE IF NOT EXISTS `poule` (
  `id_poule` int(11) NOT NULL AUTO_INCREMENT,
  `tour` int(11) NOT NULL,
  `nom` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_poule`),
  KEY `IDX_3BDEC44415ED8D43` (`tour`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `poulesupprimer`
--

CREATE TABLE IF NOT EXISTS `poulesupprimer` (
  `id_poule` int(11) NOT NULL,
  `tour` int(11) NOT NULL,
  `nom` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_poule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `recevoir`
--

CREATE TABLE IF NOT EXISTS `recevoir` (
  `club` int(11) NOT NULL,
  `equipe` int(11) NOT NULL,
  `tour` int(11) NOT NULL,
  PRIMARY KEY (`club`,`equipe`,`tour`),
  KEY `IDX_73F67EFA61190A32` (`club`),
  KEY `IDX_73F67EFA6D861B89` (`equipe`),
  KEY `IDX_73F67EFA15ED8D43` (`tour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

CREATE TABLE IF NOT EXISTS `resultat` (
  `equipe` int(11) NOT NULL,
  `tour` int(11) NOT NULL,
  `setGagner` int(1) DEFAULT NULL,
  `setPerdu` int(1) DEFAULT NULL,
  `pointGagner` int(3) DEFAULT NULL,
  `pointPerdu` int(3) DEFAULT NULL,
  `coefSet` double DEFAULT NULL,
  `coefPoint` double DEFAULT NULL,
  `classementPoule` int(1) DEFAULT NULL,
  PRIMARY KEY (`equipe`,`tour`),
  KEY `IDX_1EAD3FB46D861B89` (`equipe`),
  KEY `IDX_1EAD3FB415ED8D43` (`tour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tour`
--

CREATE TABLE IF NOT EXISTS `tour` (
  `id_tour` int(11) NOT NULL AUTO_INCREMENT,
  `coupe` int(11) NOT NULL,
  `numero` int(1) DEFAULT NULL,
  `dateTour` date DEFAULT NULL,
  PRIMARY KEY (`id_tour`),
  KEY `IDX_CAE35657717D2393` (`coupe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `coupe`
--
ALTER TABLE `coupe`
  ADD CONSTRAINT `FK_FAE9744B59F9EECF` FOREIGN KEY (`equipe`) REFERENCES `equipe` (`id_equipe`) ON DELETE SET NULL;

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `FK_23E5BF2361190A32` FOREIGN KEY (`club`) REFERENCES `club` (`id_club`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_23E5BF23717D2393` FOREIGN KEY (`coupe`) REFERENCES `coupe` (`id_coupe`) ON DELETE SET NULL;

--
-- Contraintes pour la table `exempter`
--
ALTER TABLE `exempter`
  ADD CONSTRAINT `FK_11C75DFF6D861B89` FOREIGN KEY (`equipe`) REFERENCES `equipe` (`id_equipe`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_11C75DFF15ED8D43` FOREIGN KEY (`tour`) REFERENCES `tour` (`id_tour`) ON DELETE CASCADE;

--
-- Contraintes pour la table `jouer`
--
ALTER TABLE `jouer`
  ADD CONSTRAINT `FK_439F75E926596FD8` FOREIGN KEY (`poule`) REFERENCES `poule` (`id_poule`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_439F75E96D861B89` FOREIGN KEY (`equipe`) REFERENCES `equipe` (`id_equipe`) ON DELETE CASCADE;

--
-- Contraintes pour la table `parcourir`
--
ALTER TABLE `parcourir`
  ADD CONSTRAINT `FK_674F85F939606E3F` FOREIGN KEY (`clubDomicile`) REFERENCES `club` (`id_club`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_674F85F93F8BA4FD` FOREIGN KEY (`clubExterieur`) REFERENCES `club` (`id_club`) ON DELETE CASCADE;

--
-- Contraintes pour la table `poule`
--
ALTER TABLE `poule`
  ADD CONSTRAINT `FK_3BDEC44415ED8D43` FOREIGN KEY (`tour`) REFERENCES `tour` (`id_tour`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recevoir`
--
ALTER TABLE `recevoir`
  ADD CONSTRAINT `FK_73F67EFA15ED8D43` FOREIGN KEY (`tour`) REFERENCES `tour` (`id_tour`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_73F67EFA61190A32` FOREIGN KEY (`club`) REFERENCES `club` (`id_club`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_73F67EFA6D861B89` FOREIGN KEY (`equipe`) REFERENCES `equipe` (`id_equipe`) ON DELETE CASCADE;

--
-- Contraintes pour la table `resultat`
--
ALTER TABLE `resultat`
  ADD CONSTRAINT `FK_1EAD3FB415ED8D43` FOREIGN KEY (`tour`) REFERENCES `tour` (`id_tour`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1EAD3FB46D861B89` FOREIGN KEY (`equipe`) REFERENCES `equipe` (`id_equipe`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `FK_CAE35657717D2393` FOREIGN KEY (`coupe`) REFERENCES `coupe` (`id_coupe`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
