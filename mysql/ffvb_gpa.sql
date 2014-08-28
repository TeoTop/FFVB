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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


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
  `requeteVerif` varchar(350) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_critere`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `critere`
--

INSERT INTO `critere` (`id_critere`, `nom`, `description`, `type`, `valeur`, `requete`, `requeteVerif`) VALUES
(1, 'Reçu tour précédent', 'Permet de retirer les équipes qui ont reçu au tour précédent', 'domicile', -1, ' AND `id_equipe` NOT IN ( SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` in ( SELECT `id_poule` FROM `poule` WHERE `tour` = :tourPrcd ) )', ' AND `id_equipe` IN ( SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` in ( SELECT `id_poule` FROM `poule` WHERE `tour` = :tourPrcd ) )'),
(2, 'Club en réception', 'Permet de retirer les équipes appartenant à un club qui reçoit dans une autre catégorie', 'domicile', -1, ' AND `club` NOT IN (SELECT `club` FROM `equipe` JOIN `jouer` ON `id_equipe` = `equipe` WHERE `coupe` IN ( SELECT `coupe` FROM `tour` WHERE `dateTour` = :dateTour) AND `distance` IS NULL)', ' AND `club` IN (SELECT `club` FROM `equipe` JOIN `jouer` ON `id_equipe` = `equipe` WHERE `coupe` IN ( SELECT `coupe` FROM `tour` WHERE `dateTour` = :dateTour AND `coupe` != :coupe) AND `distance` IS NULL)'),
(3, 'Exempté tour précédent', 'Permet de retirer les équipes ayant été exemptées au tour précédent', 'domicile', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `exempter` WHERE `tour` = :tourPrcd)', ' AND `id_equipe` IN (SELECT `equipe` FROM `exempter` WHERE `tour` = :tourPrcd)'),
(4, 'Classement CFVB faible', 'Permet de sélectionner les équipes ayant un faible niveau global', 'domicile', -1, ' AND `classementCFVB` <= :clmtCFVB', ' AND `classementCFVB` > :clmtCFVB'),
(5, 'Nombre d''équipes engagées', 'Permet de sélectionner les équipes appartenant à un club qui possède le nombre indiqué, ou plus, d''équipes engagées', 'domicile', -1, ' AND `club` IN (SELECT `club` FROM `equipe` WHERE `id_equipe` IN (SELECT `equipe` FROM `resultat` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `club` HAVING count(`id_equipe`) >= :nbEquipe)', ' AND `club` NOT IN (SELECT `club` FROM `equipe` WHERE `id_equipe` IN (SELECT `equipe` FROM `resultat` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `club` HAVING count(`id_equipe`) >= :nbEquipe)'),
(6, 'Nombre de réception', 'Permet de retirer les équipes ayant déjà reçu le nombre indiqué de fois ou plus', 'domicile', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` IN (SELECT `id_poule` FROM `poule` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `equipe` HAVING count(`equipe`) >= :nbDomicile )', ' AND `id_equipe` IN (SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` IN (SELECT `id_poule` FROM `poule` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `equipe` HAVING count(`equipe`) >= :nbDomicile )'),
(7, 'Position tour précédant', 'Permet de sélectionner les équipes qui ont terminé première/seconde au tour précédent', 'exterieur', -1, ' AND `id_equipe` IN (SELECT `equipe` FROM `resultat` WHERE `tour` = :tourPrcd AND `classementPoule` = :position)', 'SELECT `position` FROM `resultat` WHERE `tour` = :tourPrcd AND `equipe` = :equipe'),
(8, 'Classement coupe forte ', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'exterieur', -1, ' AND `classementCoupe` >= :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe'),
(9, 'Affrontement préalable', 'Permet de retirer les équipes qui ont déjà affronté une équipe présente dans la poule', 'exterieur', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `jouer` WHERE `poule` IN (SELECT `poule` FROM `jouer` WHERE `equipe` = ', 'SELECT `id_poule` FROM `poule` WHERE `tour` != :tour AND `id_poule` IN (SELECT `poule` FROM `jouer` WHERE'),
(10, 'Même département', 'Permet de retirer les équipes qui sont du même département qu''une équipe présente dans la poule', 'exterieur', -1, ' AND `commite` != ', ' AND `commite` LIKE '),
(11, 'Distance à parcourir', 'Permet de sélectionner les équipes dont la distance à parcourir pour se rendre chez le receveur est inférieur ou égal à ce qui est indiqué', 'exterieur', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` IN (SELECT `clubDomicile` FROM `parcourir` WHERE `clubExterieur` = :club AND `distance` <= :distanceClub) OR `id_club` IN (SELECT `clubExterieur` FROM `parcourir` WHERE `clubDomicile` = :club AND `distance` <= :distanceClub))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` IN (SELECT `clubDomicile` FROM `parcourir` WHERE `clubExterieur` = :club AND `distance` <= :distanceClub) OR `id_club` IN (SELECT `clubExterieur` FROM `parcourir` WHERE `clubDomicile` = :club AND `distance` <= :distanceClub))'),
(12, 'Classement coupe forte ', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'exempter', -1, ' AND `classementCoupe` >= :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe'),
(13, 'Exempter vainqueur', 'Permet d''afficher l''équipe qui a gagné la compétition l''année précédante', 'exempter', -1, ' AND `id_equipe` IN (SELECT `equipe` FROM `coupe` WHERE `age` = :age AND `sexe` = :sexe AND `annee` >= :anneeAnt)', ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `coupe` WHERE `age` = :age AND `sexe` = :sexe AND `annee` >= :anneeAnt AND `equipe` IS NOT NULL)'),
(14, 'Exempter vainqueur inf', 'Permet d''afficher l''équipe qui a gagné la compétition l''année précédante dans la catégorie inférieure', 'exempter', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` WHERE `club` IN (SELECT `club` FROM `equipe` JOIN `coupe` ON `equipe` = `id_equipe` WHERE `age` = :ageInf AND `sexe` = :sexe AND `annee` >= :anneeAnt))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` WHERE `club` IN (SELECT `club` FROM `equipe` JOIN `coupe` ON `equipe` = `id_equipe` WHERE `age` = :ageInf AND `sexe` = :sexe AND `annee` >= :anneeAnt))'),
(15, 'Exempter isolée', 'Permet d''afficher les équipes qui se retrouvent trop isolée, c-à-d les équipes dont la distance à parcourir avec l''équipe la plus proche est supérieur au nombre indiqué', 'exempter', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` NOT IN (SELECT `clubDomicile` FROM `parcourir` GROUP BY `clubDomicile` HAVING min(`distance`) <= :distanceMin) AND `id_club` NOT IN (SELECT `clubExterieur` FROM `parcourir` GROUP BY `clubExterieur` HAVING min(`distance`) <= :distanceMin))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` NOT IN (SELECT `clubDomicile` FROM `parcourir` GROUP BY `clubDomicile` HAVING min(`distance`) <= :distanceMin) AND `id_club` NOT IN (SELECT `clubExterieur` FROM `parcourir` GROUP BY `clubExterieur` HAVING min(`distance`) <= :distanceMin))'),
(16, 'Classement coupe forte', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'domicile', -1, ' AND `classementCoupe` >= :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe'),
(17, 'Distance parcouru', 'Permet d''afficher les équipes qui ont déjà parcouru le nombre de km indiqué ou plus', 'domicile', -1, ' AND `nbKmParcouru` >= :nbKm', ' AND `nbKmParcouru` < :nbKm'),
(18, 'Classement CFVB faible', 'Permet de sélectionner les équipes ayant un faible niveau global', 'exterieur', -1, ' AND `classementCFVB` <= :clmtCFVB', ' AND `classementCFVB` > :clmtCFVB'),
(19, 'Distance parcouru', 'Permet d''afficher les équipes qui ont déjà parcouru le nombre de km indiqué ou moins', 'exterieur', -1, ' AND `nbKmParcouru` <= :nbKm', ' AND `nbKmParcouru` > :nbKm'),
(20, 'Classement CFVB forte', 'Permet de sélectionner les équipes ayant un bon niveau global', 'exempter', -1, ' AND `classementCFVB` >= :clmtCFVB', ' AND `classementCFVB` < :clmtCFVB'),
(21, 'Déjà exempté', 'Permet de retirer les équipes qui ont déjà été exemptées, excepté au tour 1', 'exempter', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `exempter` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` = :coupe AND `numero` != 1))', ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `exempter` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` = :coupe AND `numero` != 1 AND `id_tour` != :tour))');


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
