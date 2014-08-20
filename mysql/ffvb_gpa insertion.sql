-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 13 Août 2014 à 15:00
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
-- Structure de la table `classifier`
--

CREATE TABLE IF NOT EXISTS `classifier` (
  `tour` int(11) NOT NULL,
  `critere` int(11) NOT NULL,
  `valeur` int(6) DEFAULT NULL,
  PRIMARY KEY (`tour`,`critere`),
  KEY `IDX_3F8005D215ED8D43` (`tour`),
  KEY `IDX_3F8005D29E5F45AB` (`critere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `club`
--

INSERT INTO `club` (`id_club`, `nom`, `ville`, `commite`, `region`) VALUES
(1, 'ASRVC', 'Rouen', 'Seine-Maritime', 'Haute-Normandie'),
(2, 'VCR', 'Rennes', 'Illes-et-Vilaine', 'Bretagne'),
(3, 'VCS', 'Strasbourg', 'Bas-Rhin', 'Alsace'),
(4, 'VCT', 'Toulouse', 'Haute-Garonne', 'Midi-Pyrenees'),
(5, 'VCL', 'Lyon', 'Rhone', 'Rhone-Alpes');

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

--
-- Contenu de la table `coupe`
--

INSERT INTO `coupe` (`id_coupe`, `equipe`, `age`, `sexe`, `annee`) VALUES
(1, NULL, 13, 'f', 2014),
(2, NULL, 13, 'g', 2014),
(3, NULL, 15, 'f', 2014),
(4, NULL, 15, 'g', 2014),
(5, NULL, 17, 'f', 2014),
(6, NULL, 17, 'g', 2014),
(7, NULL, 20, 'f', 2014),
(8, NULL, 20, 'g', 2014),
(9, NULL, 13, 'f', 2013),
(10, NULL, 13, 'g', 2013);

-- --------------------------------------------------------

--
-- Structure de la table `critere`
--

CREATE TABLE IF NOT EXISTS `critere` (
  `id_critere` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('domicile','exterieur','exempter') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'domicile',
  `requete` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_critere`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Contenu de la table `critere`
--

INSERT INTO `critere` (`id_critere`, `nom`, `description`, `type`, `requete`) VALUES
(1, 'Reçu tour précédent', 'Critère permettant de retirer les équipes qui ont reçu au tour précédent', 'domicile', 'AND `id_equipe` NOT IN ( SELECT `equipe` FROM `jouer` WHERE `position` = 1 AND `poule` in ( SELECT `id_poule` FROM `poule` WHERE `tour` = :tourPrcd ) )'),
(2, 'Club en réception', 'Critère permettant de rertirer les équipes appartenant à un club qui reçoit dans une autre catégorie', 'domicile', NULL),
(3, 'Retirer exempté', 'Critère permettant de rertirer les équipes ayant été exemptées au tour précédent', 'domicile', NULL),
(4, 'Petite équipe', 'Critère multiple permettant de sélectionner les équipes ayant un faible niveau AVBA', 'domicile', NULL),
(5, 'Equipes engagées', 'Critère multiple permettant de sélectionner les équipes possédant le nombre indiqué d''équipes engagées pour un club (1 - 8)', 'domicile', NULL),
(6, 'Nombre de réception', 'Critère mutliple permettant de rertirer les équipes ayant déjà reçu le nombre indiqué de fois (1 - 4)', 'domicile', NULL),

(7, 'Position tour précédant', 'Critère permettant de sélectionner les équipes qui ont terminé première/second au tour précédent', 'exterieur', NULL),
(8, 'Equipe forte', 'Critère permettant de rertirer les n meilleurs équipes de la compétition si une d''entre elles fait parties de la poule (n = nombre de poules pour ce tour)', 'exterieur', NULL),
(9, 'Affrontement préalable', 'Critère permettant de rertirer les équipes qui ont déjà affronté une équipe présente dans la poule', 'exterieur', NULL),
(10, 'Même département', 'Critère permettant de rertirer les équipes qui sont du même départment qu''une équipe présente dans la poule', 'exterieur', NULL),
(11, 'Distance à parcourir', 'Critère mutliple permettant de sélectionner les équipes dont la distance à parcourir pour se rendre chez le receveur est inférieur ou égal à ce qui est indiqué (150 ; 400 ; 600 ; 2000 km)', 'exterieur', NULL),

(12, 'Exempter équipe forte', 'Critère multiple permettant d''exclure le nombre indiqué d''équipes considérées comme les plus fortes lors des tours précédents (1 - 10)', 'exempter', NULL),
(13, 'Exempter vainqueur', 'Critère permettant d''exclure les équipes qui ont gagné la compétition l''année précédante', 'exempter', NULL),
(14, 'Exempter vainqueur inf', 'Critère permettant d''exclure les équipes qui ont gagné la compétition l''année précédante dans la catégorie inférieur', 'exempter', NULL),
(15, 'Exempter isolée', 'Critère multiple permettant d''exclure les équipes qui se retrouve trop isolée, c-à-d les équipes dans la distance à parcourir avec l''équipe la plus proche est supérieur au nombre indiqué', 'exempter', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE IF NOT EXISTS `equipe` (
  `id_equipe` int(11) NOT NULL AUTO_INCREMENT,
  `club` int(11) NOT NULL,
  `coupe` int(11) DEFAULT NULL,
  `nbKmParcouru` int(5) DEFAULT '0',
  `classementCFVB` int(11) DEFAULT '0',
  `classementCoupe` int(11) DEFAULT '0',
  PRIMARY KEY (`id_equipe`),
  KEY `IDX_23E5BF2361190A32` (`club`),
  KEY `IDX_23E5BF23717D2393` (`coupe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Contenu de la table `equipe`
--

INSERT INTO `equipe` (`id_equipe`, `club`, `coupe`, `nbKmParcouru`, `classementCFVB`, `classementCoupe`) VALUES
(1, 1, 1, 0, 0, NULL),
(2, 1, 2, 0, 0, NULL),
(3, 1, 3, 0, 0, NULL),
(4, 1, 4, 0, 0, NULL),
(5, 1, 5, 0, 0, NULL),
(6, 1, 6, 0, 0, NULL),
(7, 1, 7, 0, 0, NULL),
(8, 1, 8, 0, 0, NULL),
(9, 2, 1, 0, 0, NULL),
(10, 2, 2, 0, 0, NULL),
(11, 2, 3, 0, 0, NULL),
(12, 2, 4, 0, 0, NULL),
(13, 2, 5, 0, 0, NULL),
(14, 2, 6, 0, 0, NULL),
(15, 2, 7, 0, 0, NULL),
(16, 2, 8, 0, 0, NULL),
(17, 3, 1, 0, 0, NULL),
(18, 3, 2, 0, 0, NULL),
(19, 3, 3, 0, 0, NULL),
(20, 3, 4, 0, 0, NULL),
(21, 3, 5, 0, 0, NULL),
(22, 3, 6, 0, 0, NULL),
(23, 3, 7, 0, 0, NULL),
(24, 3, 8, 0, 0, NULL),
(25, 4, 1, 0, 0, NULL),
(26, 4, 2, 0, 0, NULL),
(27, 4, 3, 0, 0, NULL),
(28, 4, 4, 0, 0, NULL),
(29, 4, 5, 0, 0, NULL),
(30, 4, 6, 0, 0, NULL),
(31, 4, 7, 0, 0, NULL),
(32, 4, 8, 0, 0, NULL),
(33, 5, 1, 0, 0, NULL),
(34, 5, 2, 0, 0, NULL),
(35, 5, 3, 0, 0, NULL),
(36, 5, 4, 0, 0, NULL),
(37, 5, 5, 0, 0, NULL),
(38, 5, 6, 0, 0, NULL),
(39, 5, 7, 0, 0, NULL),
(40, 5, 8, 0, 0, NULL);

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
  `position` int(1) NOT NULL,
  PRIMARY KEY (`equipe`,`poule`),
  KEY `IDX_439F75E96D861B89` (`equipe`),
  KEY `IDX_439F75E926596FD8` (`poule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parcourir`
--

CREATE TABLE IF NOT EXISTS `parcourir` (
  `clubExterieur` int(11) NOT NULL,
  `clubDomicile` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=71 ;

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

--
-- Contenu de la table `resultat`
--

INSERT INTO `resultat` (`equipe`, `tour`, `setGagner`, `setPerdu`, `pointGagner`, `pointPerdu`, `coefSet`, `coefPoint`, `classementPoule`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;


--
-- Déclencheurs `tour`
--
DROP TRIGGER IF EXISTS `ajout_classifier`;
DELIMITER //
CREATE TRIGGER `ajout_classifier` AFTER INSERT ON `tour`
 FOR EACH ROW INSERT INTO classifier(tour,critere,valeur) 
  SELECT NEW.id_tour, id_critere, -1 FROM critere
//
DELIMITER ;


--
-- Contenu de la table `tour`
--

INSERT INTO `tour` (`id_tour`, `coupe`, `numero`, `dateTour`) VALUES
(1, 1, 1, NULL),
(2, 1, 2, NULL),
(3, 1, 3, NULL),
(4, 1, 4, NULL),
(5, 2, 1, NULL),
(6, 2, 2, NULL),
(7, 2, 3, NULL),
(8, 2, 4, NULL),
(9, 3, 1, NULL),
(10, 3, 2, NULL),
(11, 4, 1, NULL),
(12, 4, 2, NULL),
(13, 5, 1, NULL),
(14, 5, 2, NULL),
(15, 5, 3, NULL),
(16, 6, 1, NULL),
(17, 6, 2, NULL),
(18, 6, 3, NULL),
(19, 7, 1, NULL),
(20, 7, 2, NULL),
(21, 7, 3, NULL),
(22, 8, 1, NULL),
(23, 8, 2, NULL),
(24, 8, 3, NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `classifier`
--
ALTER TABLE `classifier`
  ADD CONSTRAINT `FK_3F8005D29E5F45AB` FOREIGN KEY (`critere`) REFERENCES `critere` (`id_critere`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3F8005D215ED8D43` FOREIGN KEY (`tour`) REFERENCES `tour` (`id_tour`) ON DELETE CASCADE;

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
