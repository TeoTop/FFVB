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



--
-- Contenu de la table `club`
--

INSERT INTO `club` (`id_club`, `nom`, `ville`, `commite`, `region`) VALUES
(1, 'ASRVC', 'Rouen', 'Seine-Maritime', 'Haute-Normandie'),
(2, 'VCR', 'Rennes', 'Ille-et-Vilaine', 'Bretagne'),
(3, 'VCS', 'Strasbourg', 'Bas-Rhin', 'Alsace'),
(4, 'VCT', 'Toulouse', 'Haute-Garonne', 'Midi-Pyrenees'),
(5, 'VCL', 'Lyon', 'Rhone', 'Rhone-Alpes'),
(6, 'PVBC', 'Paris', 'Paris', 'Ile-de-France'),
(7, 'ASMVB', 'Marseille', 'Bouches-du-Rhône', 'Provence-Alpes-Côte d''Azur'),
(8, 'VBCN', 'Nice', 'Alpes-Maritimes', 'Provence-Alpes-Côte d''Azur'),
(9, 'NVBC', 'Nantes', 'Loire-Atlantique', 'Pays de la Loire'),
(10, 'ASVBMH', 'Montpellier', 'Hérault', 'Languedoc-Roussillon'),
(11, 'BVBC', 'Bordeaux', 'Gironde', 'Aquitaine'),
(12, 'LMVBC', 'Lille', 'Nord', 'Nord-Pas-de-Calais'),
(13, 'RRCVB', 'Reims', 'Marne', 'Champagne-Ardenne'),
(14, 'SEVB', 'Saint-Étienne', 'Loire', 'Rhône-Alpes'),
(15, 'STC', 'Caen', 'Calvados', 'Basse-Normandie');



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


--
-- Contenu de la table `equipe`
--

INSERT INTO `equipe` (`id_equipe`, `club`, `coupe`, `nbKmParcouru`, `classementCFVB`, `classementCoupe`) VALUES
(1, 1, 1, 0, 2500, 752),
(2, 1, 2, 0, 0, NULL),
(3, 1, 3, 0, 0, NULL),
(5, 1, 5, 0, 0, NULL),
(7, 1, 7, 0, 0, NULL),
(8, 1, 8, 0, 0, NULL),
(9, 2, 1, 0, 3000, 631),
(10, 2, 2, 0, 0, NULL),
(12, 2, 4, 0, 0, NULL),
(13, 2, 5, 0, 0, NULL),
(15, 2, 7, 0, 0, NULL),
(16, 2, 8, 0, 0, NULL),
(17, 3, 1, 634, 500, 140),
(19, 3, 3, 0, 0, NULL),
(21, 3, 5, 0, 0, NULL),
(23, 3, 7, 0, 0, NULL),
(24, 3, 8, 0, 0, NULL),
(25, 4, 1, 1731, 4200, 907),
(26, 4, 2, 0, 0, NULL),
(27, 4, 3, 0, 0, NULL),
(28, 4, 4, 0, 0, NULL),
(29, 4, 5, 0, 0, NULL),
(31, 4, 7, 0, 0, NULL),
(33, 5, 1, 0, 1900, 763),
(34, 5, 2, 0, 0, NULL),
(35, 5, 3, 0, 0, NULL),
(37, 5, 5, 0, 0, NULL),
(39, 5, 7, 0, 0, NULL),
(40, 5, 8, 0, 0, NULL);