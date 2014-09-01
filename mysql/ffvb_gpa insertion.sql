-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 29 Août 2014 à 14:01
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

--
-- Contenu de la table `club`
--

INSERT INTO `club` (`id_club`, `nom`, `ville`, `commite`, `region`) VALUES
(1, 'AS Rouen Volley-Club', 'Rouen', 'Seine-Maritime', 'Haute-Normandie'),
(2, 'Rennes Etudiant', 'Rennes', 'Ille-et-Vilaine', 'Bretagne'),
(3, 'Volley-Club Strasbourgeois', 'Strasbourg', 'Bas-Rhin', 'Alsace'),
(4, 'Elan Sportif de Toulouse', 'Toulouse', 'Haute-Garonne', 'Midi-Pyrenees'),
(5, 'Lyon Volley-Club', 'Lyon', 'Rhone', 'Rhone-Alpes'),
(6, 'Paris Volley-Ball Club', 'Paris', 'Paris', 'Ile-de-France'),
(7, 'AS Marseille Volley-Ball', 'Marseille', 'Bouches-du-Rhône', 'Provence-Alpes-Côte d''Azur'),
(8, 'Volley-Ball Club Niçois', 'Nice', 'Alpes-Maritimes', 'Provence-Alpes-Côte d''Azur'),
(9, 'Nantes Volley-Ball Club', 'Nantes', 'Loire-Atlantique', 'Pays de la Loire'),
(10, 'ASVB Montpellier Hérault', 'Montpellier', 'Hérault', 'Languedoc-Roussillon'),
(11, 'Bordeaux Volley-Club', 'Bordeaux', 'Gironde', 'Aquitaine'),
(12, 'Lille Métropole VBC', 'Lille', 'Nord', 'Nord-Pas-de-Calais'),
(13, 'Racing Club de Reims', 'Reims', 'Marne', 'Champagne-Ardenne'),
(14, 'Saint-Etienne Volley-Ball', 'Saint-Étienne', 'Loire', 'Rhône-Alpes'),
(15, 'ASPTT Caen Volley-Ball', 'Caen', 'Calvados', 'Basse-Normandie');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

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
(8, NULL, 20, 'g', 2014);

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
  `requeteInv` varchar(350) COLLATE utf8_unicode_ci DEFAULT NULL,
  `requeteVerif` varchar(350) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_critere`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Contenu de la table `critere`
--

INSERT INTO `critere` (`id_critere`, `nom`, `description`, `type`, `valeur`, `requete`, `requeteInv`, `requeteVerif`) VALUES
(1, 'Reçu tour précédent', 'Permet de retirer les équipes qui ont reçu au tour précédent', 'domicile', -1, ' AND `id_equipe` NOT IN ( SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` in ( SELECT `id_poule` FROM `poule` WHERE `tour` = :tourPrcd ) )', ' AND `id_equipe` IN ( SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` in ( SELECT `id_poule` FROM `poule` WHERE `tour` = :tourPrcd ) )', ' AND `id_equipe` IN ( SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` in ( SELECT `id_poule` FROM `poule` WHERE `tour` = :tourPrcd ) )'),
(2, 'Club en réception', 'Permet de retirer les équipes appartenant à un club qui reçoit dans une autre catégorie', 'domicile', -1, ' AND `club` NOT IN (SELECT `club` FROM `equipe` JOIN `jouer` ON `id_equipe` = `equipe` WHERE `coupe` IN ( SELECT `coupe` FROM `tour` WHERE `dateTour` = :dateTour) AND `distance` IS NULL)', ' AND `club` IN (SELECT `club` FROM `equipe` JOIN `jouer` ON `id_equipe` = `equipe` WHERE `coupe` IN ( SELECT `coupe` FROM `tour` WHERE `dateTour` = :dateTour AND `coupe` != :coupe) AND `distance` IS NULL)', ' AND `club` IN (SELECT `club` FROM `equipe` JOIN `jouer` ON `id_equipe` = `equipe` WHERE `coupe` IN ( SELECT `coupe` FROM `tour` WHERE `dateTour` = :dateTour AND `coupe` != :coupe) AND `distance` IS NULL)'),
(3, 'Exempté tour précédent', 'Permet de retirer les équipes ayant été exemptées au tour précédent', 'domicile', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `exempter` WHERE `tour` = :tourPrcd)', ' AND `id_equipe` IN (SELECT `equipe` FROM `exempter` WHERE `tour` = :tourPrcd)', ' AND `id_equipe` IN (SELECT `equipe` FROM `exempter` WHERE `tour` = :tourPrcd)'),
(4, 'Classement CFVB faible', 'Permet de sélectionner les équipes ayant un faible niveau global', 'domicile', 1000, ' AND `classementCFVB` <= :clmtCFVB', ' AND `classementCFVB` > :clmtCFVB', ' AND `classementCFVB` > :clmtCFVB'),
(5, 'Nombre d''équipes engagées', 'Permet de sélectionner les équipes appartenant à un club qui possède le nombre indiqué, ou plus, d''équipes engagées', 'domicile', -1, ' AND `club` IN (SELECT `club` FROM `equipe` WHERE `id_equipe` IN (SELECT `equipe` FROM `resultat` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `club` HAVING count(`id_equipe`) >= :nbEquipe)', ' AND `club` NOT IN (SELECT `club` FROM `equipe` WHERE `id_equipe` IN (SELECT `equipe` FROM `resultat` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `club` HAVING count(`id_equipe`) >= :nbEquipe)', ' AND `club` NOT IN (SELECT `club` FROM `equipe` WHERE `id_equipe` IN (SELECT `equipe` FROM `resultat` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `club` HAVING count(`id_equipe`) >= :nbEquipe)'),
(6, 'Nombre de réception', 'Permet de retirer les équipes ayant déjà reçu le nombre indiqué de fois ou plus', 'domicile', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` IN (SELECT `id_poule` FROM `poule` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `equipe` HAVING count(`equipe`) >= :nbDomicile )', ' AND `id_equipe` IN (SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` IN (SELECT `id_poule` FROM `poule` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `id_tour` != :tour AND `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `equipe` HAVING count(`equipe`) >= :nbDomicile )', ' AND `id_equipe` IN (SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` IN (SELECT `id_poule` FROM `poule` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `id_tour` != :tour AND `coupe` IN (SELECT `id_coupe` FROM `coupe` WHERE `annee` = :annee))) GROUP BY `equipe` HAVING count(`equipe`) >= :nbDomicile )'),
(7, 'Position tour précédant', 'Permet de sélectionner les équipes qui ont terminé première/seconde au tour précédent', 'exterieur', -1, ' AND `id_equipe` IN (SELECT `equipe` FROM `resultat` WHERE `tour` = :tourPrcd AND `classementPoule` = :position)', ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `resultat` WHERE `tour` = :tourPrcd AND `classementPoule` = :position)', 'SELECT `classementPoule` FROM `resultat` WHERE `tour` = :tourPrcd AND `equipe` = :equipe'),
(8, 'Classement coupe forte ', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'exterieur', -1, ' AND `classementCoupe` >= :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe'),
(9, 'Affrontement préalable', 'Permet de retirer les équipes qui ont déjà affronté une équipe présente dans la poule', 'exterieur', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `jouer` WHERE `poule` IN (SELECT `poule` FROM `jouer` WHERE `equipe` = ', ' AND `id_equipe` IN (SELECT `equipe` FROM `jouer` WHERE `poule` IN (SELECT `poule` FROM `jouer` WHERE `equipe` = ', 'SELECT `id_poule` FROM `poule` WHERE `tour` != :tour AND `id_poule` IN (SELECT `poule` FROM `jouer` WHERE'),
(10, 'Même département', 'Permet de retirer les équipes qui sont du même département qu''une équipe présente dans la poule', 'exterieur', -1, ' AND `commite` != ', ' AND `commite` LIKE ', ' AND `commite` LIKE '),
(11, 'Distance à parcourir', 'Permet de sélectionner les équipes dont la distance à parcourir pour se rendre chez le receveur est inférieur ou égal à ce qui est indiqué', 'exterieur', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` IN (SELECT `clubDomicile` FROM `parcourir` WHERE `clubExterieur` = :club AND `distance` <= :distanceClub) OR `id_club` IN (SELECT `clubExterieur` FROM `parcourir` WHERE `clubDomicile` = :club AND `distance` <= :distanceClub))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` IN (SELECT `clubDomicile` FROM `parcourir` WHERE `clubExterieur` = :club AND `distance` <= :distanceClub) OR `id_club` IN (SELECT `clubExterieur` FROM `parcourir` WHERE `clubDomicile` = :club AND `distance` <= :distanceClub))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` IN (SELECT `clubDomicile` FROM `parcourir` WHERE `clubExterieur` = :club AND `distance` <= :distanceClub) OR `id_club` IN (SELECT `clubExterieur` FROM `parcourir` WHERE `clubDomicile` = :club AND `distance` <= :distanceClub))'),
(12, 'Classement coupe forte ', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'exempter', -1, ' AND `classementCoupe` >= :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe'),
(13, 'Exempter vainqueur', 'Permet d''afficher l''équipe qui a gagné la compétition l''année précédante', 'exempter', -1, ' AND `id_equipe` IN (SELECT `equipe` FROM `coupe` WHERE `age` = :age AND `sexe` = :sexe AND `annee` >= :anneeAnt)', ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `coupe` WHERE `age` = :age AND `sexe` = :sexe AND `annee` >= :anneeAnt AND `equipe` IS NOT NULL)', ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `coupe` WHERE `age` = :age AND `sexe` = :sexe AND `annee` >= :anneeAnt AND `equipe` IS NOT NULL)'),
(14, 'Exempter vainqueur inf', 'Permet d''afficher l''équipe qui a gagné la compétition l''année précédante dans la catégorie inférieure', 'exempter', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` WHERE `club` IN (SELECT `club` FROM `equipe` JOIN `coupe` ON `equipe` = `id_equipe` WHERE `age` = :ageInf AND `sexe` = :sexe AND `annee` >= :anneeAnt))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` WHERE `club` IN (SELECT `club` FROM `equipe` JOIN `coupe` ON `equipe` = `id_equipe` WHERE `age` = :ageInf AND `sexe` = :sexe AND `annee` >= :anneeAnt))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` WHERE `club` IN (SELECT `club` FROM `equipe` JOIN `coupe` ON `equipe` = `id_equipe` WHERE `age` = :ageInf AND `sexe` = :sexe AND `annee` >= :anneeAnt))'),
(15, 'Exempter isolée', 'Permet d''afficher les équipes qui se retrouvent trop isolée, c-à-d les équipes dont la distance à parcourir avec l''équipe la plus proche est supérieur au nombre indiqué', 'exempter', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` NOT IN (SELECT `clubDomicile` FROM `parcourir` GROUP BY `clubDomicile` HAVING min(`distance`) <= :distanceMin) AND `id_club` NOT IN (SELECT `clubExterieur` FROM `parcourir` GROUP BY `clubExterieur` HAVING min(`distance`) <= :distanceMin))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` NOT IN (SELECT `clubDomicile` FROM `parcourir` GROUP BY `clubDomicile` HAVING min(`distance`) <= :distanceMin) AND `id_club` NOT IN (SELECT `clubExterieur` FROM `parcourir` GROUP BY `clubExterieur` HAVING min(`distance`) <= :distanceMin))', ' AND `id_equipe` NOT IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` NOT IN (SELECT `clubDomicile` FROM `parcourir` GROUP BY `clubDomicile` HAVING min(`distance`) <= :distanceMin) AND `id_club` NOT IN (SELECT `clubExterieur` FROM `parcourir` GROUP BY `clubExterieur` HAVING min(`distance`) <= :distanceMin))'),
(16, 'Classement coupe forte', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'domicile', -1, ' AND `classementCoupe` >= :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe', ' AND `classementCoupe` < :clmtCoupe'),
(17, 'Distance parcouru', 'Permet d''afficher les équipes qui ont déjà parcouru le nombre de km indiqué ou plus', 'domicile', -1, ' AND `nbKmParcouru` >= :nbKm', ' AND `nbKmParcouru` < :nbKm', ' AND `nbKmParcouru` < :nbKm'),
(18, 'Classement CFVB faible', 'Permet de sélectionner les équipes ayant un faible niveau global', 'exterieur', -1, ' AND `classementCFVB` <= :clmtCFVB', ' AND `classementCFVB` > :clmtCFVB', ' AND `classementCFVB` > :clmtCFVB'),
(19, 'Distance parcouru', 'Permet d''afficher les équipes qui ont déjà parcouru le nombre de km indiqué ou moins', 'exterieur', -1, ' AND `nbKmParcouru` <= :nbKm', ' AND `nbKmParcouru` > :nbKm', ' AND `nbKmParcouru` > :nbKm'),
(20, 'Classement CFVB forte', 'Permet de sélectionner les équipes ayant un bon niveau global', 'exempter', -1, ' AND `classementCFVB` >= :clmtCFVB', ' AND `classementCFVB` < :clmtCFVB', ' AND `classementCFVB` < :clmtCFVB'),
(21, 'Déjà exempté', 'Permet de retirer les équipes qui ont déjà été exemptées, excepté au tour 1', 'exempter', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `exempter` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` = :coupe AND `numero` != 1))', ' AND `id_equipe` IN (SELECT `equipe` FROM `exempter` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` = :coupe AND `numero` != 1 AND `id_tour` != :tour))', ' AND `id_equipe` IN (SELECT `equipe` FROM `exempter` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` = :coupe AND `numero` != 1 AND `id_tour` != :tour))');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=121 ;

--
-- Contenu de la table `equipe`
--

INSERT INTO `equipe` (`id_equipe`, `club`, `coupe`, `nbKmParcouru`, `classementCFVB`, `classementCoupe`) VALUES
(1, 1, 1, 0, 782, 223),
(2, 2, 1, 312, 3004, 451),
(3, 3, 1, 347, 926, 331),
(4, 4, 1, 0, 3749, 500),
(5, 5, 1, 313, 4088, 401),
(6, 6, 1, 0, 2533, 621),
(7, 7, 1, 0, 2347, 422),
(8, 8, 1, 204, 1496, 640),
(9, 9, 1, 0, 349, 407),
(10, 10, 1, 0, 3167, 603),
(11, 11, 1, 244, 2339, 834),
(12, 12, 1, 201, 1667, 721),
(13, 13, 1, 0, 2995, 527),
(14, 14, 1, 535, 4220, 772),
(15, 15, 1, 129, 3884, 912),
(16, 1, 2, 0, 782, 0),
(17, 2, 2, 0, 3004, 0),
(18, 3, 2, 0, 926, 0),
(19, 4, 2, 0, 3749, 0),
(20, 5, 2, 0, 4088, 0),
(21, 6, 2, 0, 3560, 0),
(22, 7, 2, 0, 2347, 0),
(23, 8, 2, 0, 1496, 0),
(24, 9, 2, 0, 349, 0),
(25, 10, 2, 0, 3167, 0),
(26, 11, 2, 0, 2339, 0),
(27, 12, 2, 0, 1667, 0),
(28, 13, 2, 0, 2995, 0),
(29, 14, 2, 0, 4220, 0),
(30, 15, 2, 0, 3884, 0),
(31, 1, 3, 0, 782, 0),
(32, 2, 3, 0, 3004, 0),
(33, 3, 3, 0, 926, 0),
(34, 4, 3, 0, 3749, 0),
(35, 5, 3, 0, 4088, 0),
(36, 6, 3, 0, 3560, 0),
(37, 7, 3, 0, 2347, 0),
(38, 8, 3, 0, 1496, 0),
(39, 9, 3, 0, 349, 0),
(40, 10, 3, 0, 3167, 0),
(41, 11, 3, 0, 2339, 0),
(42, 12, 3, 0, 1667, 0),
(43, 13, 3, 0, 2995, 0),
(44, 14, 3, 0, 4220, 0),
(45, 15, 3, 0, 3884, 0),
(46, 1, 4, 0, 782, 0),
(47, 2, 4, 0, 3004, 0),
(48, 3, 4, 0, 926, 0),
(49, 4, 4, 0, 3749, 0),
(50, 5, 4, 0, 4088, 0),
(51, 6, 4, 0, 3560, 0),
(52, 7, 4, 0, 2347, 0),
(53, 8, 4, 0, 1496, 0),
(54, 9, 4, 0, 349, 0),
(55, 10, 4, 0, 3167, 0),
(56, 11, 4, 0, 2339, 0),
(57, 12, 4, 0, 1667, 0),
(58, 13, 4, 0, 2995, 0),
(59, 14, 4, 0, 4220, 0),
(60, 15, 4, 0, 3884, 0),
(61, 1, 5, 0, 782, 0),
(62, 2, 5, 0, 3004, 0),
(63, 3, 5, 0, 926, 0),
(64, 4, 5, 0, 3749, 0),
(65, 5, 5, 0, 4088, 0),
(66, 6, 5, 0, 3560, 0),
(67, 7, 5, 0, 2347, 0),
(68, 8, 5, 0, 1496, 0),
(69, 9, 5, 0, 349, 0),
(70, 10, 5, 0, 3167, 0),
(71, 11, 5, 0, 2339, 0),
(72, 12, 5, 0, 1667, 0),
(73, 13, 5, 0, 2995, 0),
(74, 14, 5, 0, 4220, 0),
(75, 15, 5, 0, 3884, 0),
(76, 1, 6, 0, 782, 0),
(77, 2, 6, 0, 3004, 0),
(78, 3, 6, 0, 926, 0),
(79, 4, 6, 0, 3749, 0),
(80, 5, 6, 0, 4088, 0),
(81, 6, 6, 0, 3560, 0),
(82, 7, 6, 0, 2347, 0),
(83, 8, 6, 0, 1496, 0),
(84, 9, 6, 0, 349, 0),
(85, 10, 6, 0, 3167, 0),
(86, 11, 6, 0, 2339, 0),
(87, 12, 6, 0, 1667, 0),
(88, 13, 6, 0, 2995, 0),
(89, 14, 6, 0, 4220, 0),
(90, 15, 6, 0, 3884, 0),
(91, 1, 7, 0, 782, 0),
(92, 2, 7, 0, 3004, 0),
(93, 3, 7, 0, 926, 0),
(94, 4, 7, 0, 3749, 0),
(95, 5, 7, 0, 4088, 0),
(96, 6, 7, 0, 3560, 0),
(97, 7, 7, 0, 2347, 0),
(98, 8, 7, 0, 1496, 0),
(99, 9, 7, 0, 349, 0),
(100, 10, 7, 0, 3167, 0),
(101, 11, 7, 0, 2339, 0),
(102, 12, 7, 0, 1667, 0),
(103, 13, 7, 0, 2995, 0),
(104, 14, 7, 0, 4220, 0),
(105, 15, 7, 0, 3884, 0),
(106, 1, 8, 0, 782, 0),
(107, 2, 8, 0, 3004, 0),
(108, 3, 8, 0, 926, 0),
(109, 4, 8, 0, 3749, 0),
(110, 5, 8, 0, 4088, 0),
(111, 6, 8, 0, 3560, 0),
(112, 7, 8, 0, 2347, 0),
(113, 8, 8, 0, 1496, 0),
(114, 9, 8, 0, 349, 0),
(115, 10, 8, 0, 3167, 0),
(116, 11, 8, 0, 2339, 0),
(117, 12, 8, 0, 1667, 0),
(118, 13, 8, 0, 2995, 0),
(119, 14, 8, 0, 4220, 0),
(120, 15, 8, 0, 3884, 0);

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
-- Contenu de la table `jouer`
--

INSERT INTO `jouer` (`equipe`, `poule`, `distance`) VALUES
(1, 1, NULL),
(2, 1, 312),
(3, 2, 347),
(4, 4, NULL),
(5, 3, 313),
(7, 3, NULL),
(8, 3, 204),
(11, 4, 244),
(12, 2, 201),
(13, 2, NULL),
(14, 4, 535),
(15, 1, 129);

--
-- Déclencheurs `jouer`
--
DROP TRIGGER IF EXISTS `ajouter_distance_parcouru`;
DELIMITER //
CREATE TRIGGER `ajouter_distance_parcouru` AFTER INSERT ON `jouer`
 FOR EACH ROW IF (NEW.distance IS NOT NULL)
THEN

  UPDATE `equipe` SET `nbKmParcouru` = `nbKmParcouru` +   NEW.distance WHERE `id_equipe` = NEW.equipe;

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

--
-- Contenu de la table `parcourir`
--

INSERT INTO `parcourir` (`clubDomicile`, `clubExterieur`, `distance`) VALUES
(1, 2, 312),
(1, 3, 634),
(2, 3, 825),
(1, 4, 767),
(2, 4, 700),
(3, 4, 974),
(1, 5, 594),
(2, 5, 737),
(3, 5, 495),
(4, 5, 539),
(1, 6, 135),
(2, 6, 348),
(3, 6, 487),
(4, 6, 679),
(5, 6, 465),
(1, 7, 903),
(2, 7, 1046),
(3, 7, 805),
(4, 7, 405),
(5, 7, 313),
(6, 7, 774),
(1, 8, 1060),
(2, 8, 1203),
(3, 8, 787),
(4, 8, 562),
(5, 8, 470),
(6, 8, 931),
(7, 8, 204),
(1, 9, 387),
(2, 9, 106),
(3, 9, 862),
(4, 9, 585),
(5, 9, 684),
(6, 9, 384),
(7, 9, 985),
(8, 9, 1142),
(1, 10, 835),
(2, 10, 912),
(3, 10, 795),
(4, 10, 244),
(5, 10, 304),
(6, 10, 747),
(7, 10, 170),
(8, 10, 327),
(9, 10, 824),
(1, 11, 655),
(2, 11, 461),
(3, 11, 965),
(4, 11, 244),
(5, 11, 548),
(6, 11, 584),
(7, 11, 645),
(8, 11, 802),
(9, 11, 347),
(10, 11, 483),
(1, 12, 256),
(2, 12, 564),
(3, 12, 521),
(4, 12, 894),
(5, 12, 690),
(6, 12, 219),
(7, 12, 999),
(8, 12, 1157),
(9, 12, 600),
(10, 12, 989),
(11, 12, 806),
(1, 13, 285),
(2, 13, 482),
(3, 13, 347),
(4, 13, 812),
(5, 13, 488),
(6, 13, 144),
(7, 13, 798),
(8, 13, 955),
(9, 13, 518),
(10, 13, 787),
(11, 13, 724),
(12, 13, 201),
(1, 14, 652),
(2, 14, 716),
(3, 14, 553),
(4, 14, 535),
(5, 14, 62),
(6, 14, 523),
(7, 14, 332),
(8, 14, 490),
(9, 14, 663),
(10, 14, 321),
(11, 14, 527),
(12, 14, 749),
(13, 14, 547),
(1, 15, 129),
(2, 15, 184),
(3, 15, 727),
(4, 15, 768),
(5, 15, 694),
(6, 15, 234),
(7, 15, 1004),
(8, 15, 1161),
(9, 15, 290),
(10, 15, 917),
(11, 15, 609),
(12, 15, 387),
(13, 15, 384),
(14, 15, 721);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `poule`
--

INSERT INTO `poule` (`id_poule`, `tour`, `nom`) VALUES
(1, 1, 'BFA'),
(2, 1, 'BFB'),
(3, 1, 'BFC'),
(4, 1, 'BFD');

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
(2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Contenu de la table `tour`
--

INSERT INTO `tour` (`id_tour`, `coupe`, `numero`, `dateTour`) VALUES
(1, 1, 1, '2014-10-19'),
(2, 2, 1, '2014-10-19'),
(3, 3, 1, '2014-10-26'),
(4, 4, 1, '2014-10-26'),
(5, 5, 1, '2014-10-19'),
(6, 6, 1, '2014-10-19'),
(7, 7, 1, '2014-12-07'),
(8, 8, 1, '2014-12-07');

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
  ADD CONSTRAINT `FK_11C75DFF15ED8D43` FOREIGN KEY (`tour`) REFERENCES `tour` (`id_tour`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_11C75DFF6D861B89` FOREIGN KEY (`equipe`) REFERENCES `equipe` (`id_equipe`) ON DELETE CASCADE;

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
