--
-- Contenu de la table `critere`
--

INSERT INTO `critere` (`id_critere`, `nom`, `description`, `type`, `valeur`, `requete`) VALUES
(1, 'Reçu tour précédent', 'Permet de retirer les équipes qui ont reçu au tour précédent', 'domicile', -1, ' AND `id_equipe` NOT IN ( SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL AND `poule` in ( SELECT `id_poule` FROM `poule` WHERE `tour` = :tourPrcd ) )'),
(2, 'Club en réception', 'Permet de retirer les équipes appartenant à un club qui reçoit dans une autre catégorie', 'domicile', -1, ' AND `club` NOT IN (SELECT `club` FROM `equipe` JOIN `jouer` ON `id_equipe` = `equipe` WHERE `coupe` IN ( SELECT `coupe` FROM `tour` WHERE `dateTour` = :dateTour) AND `distance` IS NULL)'),
(3, 'Exempté tour précédent', 'Permet de retirer les équipes ayant été exemptées au tour précédent', 'domicile', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `exempter` WHERE `tour` = :tourPrcd)'),
(4, 'Classement CFVB faible', 'Permet de sélectionner les équipes ayant un faible niveau global', 'domicile', -1, ' AND `classementCFVB` <= :clmtCFVB'),
(5, 'Nombre d''équipes engagées', 'Permet de sélectionner les équipes appartenant à un club qui possède le nombre indiqué, ou plus, d''équipes engagées', 'domicile', -1, ' AND `club` IN (SELECT `club` FROM `equipe` GROUP BY `club` HAVING count(`id_equipe`) >= :nbEquipe)'),
(6, 'Nombre de réception', 'Permet de retirer les équipes ayant déjà reçu le nombre indiqué de fois ou plus', 'domicile', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `jouer` WHERE `distance` IS NULL GROUP BY `equipe` HAVING count(`equipe`) >= :nbDomicile )'),
(7, 'Position tour précédant', 'Permet de sélectionner les équipes qui ont terminé première/seconde au tour précédent', 'exterieur', -1, ' AND `id_equipe` IN (SELECT `equipe` FROM `resultat` WHERE `tour` = :tourPrcd AND `classementPoule` = :position)'),
(8, 'Classement coupe forte ', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'exterieur', -1, ' AND `classementCoupe` >= :clmtCoupe'),
(9, 'Affrontement préalable', 'Permet de retirer les équipes qui ont déjà affronté une équipe présente dans la poule', 'exterieur', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `jouer` WHERE `poule` IN (SELECT `poule` FROM `jouer` WHERE `equipe` = '),
(10, 'Même département', 'Permet de retirer les équipes qui sont du même département qu''une équipe présente dans la poule', 'exterieur', -1, ' AND `commite` != '),
(11, 'Distance à parcourir', 'Permet de sélectionner les équipes dont la distance à parcourir pour se rendre chez le receveur est inférieur ou égal à ce qui est indiqué', 'exterieur', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` IN (SELECT `clubDomicile` FROM `parcourir` WHERE `clubExterieur` = :club AND `distance` <= :distanceClub) OR `id_club` IN (SELECT `clubExterieur` FROM `parcourir` WHERE `clubDomicile` = :club AND `distance` <= :distanceClub))'),
(12, 'Classement coupe forte ', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'exempter', -1, ' AND `classementCoupe` >= :clmtCoupe'),
(13, 'Exempter vainqueur', 'Permet d''afficher l''équipe qui a gagné la compétition l''année précédante', 'exempter', -1, ' AND `id_equipe` IN (SELECT `equipe` FROM `coupe` WHERE `age` = :age AND `sexe` = :sexe AND `annee` >= :anneeAnt)'),
(14, 'Exempter vainqueur inf', 'Permet d''afficher l''équipe qui a gagné la compétition l''année précédante dans la catégorie inférieure', 'exempter', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` WHERE `club` IN (SELECT `club` FROM `equipe` JOIN `coupe` ON `equipe` = `id_equipe` WHERE `age` = :ageInf AND `sexe` = :sexe AND `annee` >= :anneeAnt))'),
(15, 'Exempter isolée', 'Permet d''afficher les équipes qui se retrouvent trop isolée, c-à-d les équipes dont la distance à parcourir avec l''équipe la plus proche est supérieur au nombre indiqué', 'exempter', -1, ' AND `id_equipe` IN (SELECT `id_equipe` FROM `equipe` JOIN `club` ON `id_club` = `club` WHERE `id_club` NOT IN (SELECT `clubDomicile` FROM `parcourir` GROUP BY `clubDomicile` HAVING min(`distance`) <= :distanceMin) AND `id_club` NOT IN (SELECT `clubExterieur` FROM `parcourir` GROUP BY `clubExterieur` HAVING min(`distance`) <= :distanceMin))'),
(16, 'Classement coupe forte', 'Permet de sélectionner les équipes ayant un bon niveau pendant cette coupe', 'domicile', -1, ' AND `classementCoupe` >= :clmtCoupe'),
(17, 'Distance parcouru', 'Permet d''afficher les équipes qui ont déjà parcouru le nombre de km indiqué ou plus', 'domicile', -1, ' AND `nbKmParcouru` >= :nbKm'),
(18, 'Classement CFVB faible', 'Permet de sélectionner les équipes ayant un faible niveau global', 'exterieur', -1, ' AND `classementCFVB` <= :clmtCFVB'),
(19, 'Distance parcouru', 'Permet d''afficher les équipes qui ont déjà parcouru le nombre de km indiqué ou moins', 'exterieur', -1, ' AND `nbKmParcouru` <= :nbKm'),
(20, 'Classement CFVB forte', 'Permet de sélectionner les équipes ayant un bon niveau global', 'exempter', -1, ' AND `classementCFVB` >= :clmtCFVB'),
(21, 'Déjà exempté', 'Permet de retirer les équipes qui ont déjà été exemptées, excepté au tour 1', 'exempter', -1, ' AND `id_equipe` NOT IN (SELECT `equipe` FROM `exempter` WHERE `tour` IN (SELECT `id_tour` FROM `tour` WHERE `coupe` = :coupe AND `numero` != 1))');
