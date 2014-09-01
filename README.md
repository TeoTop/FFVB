FFVB
====

Projet de stage - Créer une application web permettant de gérer et générer les poules de la coupe de france jeune de volley-ball

## Présentation

Cette application web a pour but d'aider l'organisteur des poules dans la création des celles-ci. Il doit pouvoir gérer les poules comme il le souhaite, c'est-à-dire : 

    - créer et supprimer les poules
    - modifier les poules en ajoutant ou en supprimant les équipes
    - exempter des équipes
    
De plus, afin d'aider au mieux l'organisteur, il doit pouvoir sélectionner les équipes selon des critères définis et les triers. Les critères sont décomposés en trois catégories : 

    - domicile : permet de sélectionner une équipe devant évoluer à domicile pour chaque poule
    - exterieur : permet de sélectionner de 2 à 3 équipes devant évoluer à l'extérieur pour chaque poule
    - exempter : permet de sélectionner des équipes à exempter et qui seront placées dans une poule sépciale.
    
En plus de pouvoir éditer les poules, l'organisateur peut vérifier facilement si le contenue de celle-ci respecte bien les critères qu'il souhaite voir appliqués. Pour cela, il lui suffirat de se positionner dans la page de vérification et de sélectionner les critères. Les équipes ne respectent pas ces critères seront affichées en rouge, et un indicateur permettra de signifier clairement à l'organisateur quel est le problème pour chaque équipe.


En marge de cette première version, un dernier module doit être développé, c'est le générateur automatique de poules. Ce module doit permettre à l'organisteur de sélectionner les critères qu'il souhaite appliquer. Ces critères doivent être classé par ordre d'importance, doivent posséder une valeur et une action lorsque le critère est trop restrictif.

Pour plus d'information concernant la présentation du projet et de l'application web, référez-vouz auprès des deux documents suivant : 

    - supplement/projet FFVB
    - supplement/Manuel de développement
    

## Indication pour la mise en place de l'application

Cette application comporte une base de données fonctionnant en autonomie. Toutefois, plusieurs tables doivent être préalablement chargées afin que l'application puisse être utilie. Voici donc la suite de procédure et d'action à mettre en place pour faire communiquer les deux bases de données nécessaires à la bonne marche de l'application :


#### 1er point : modifier l'accée à la base de données

L'application se compose d'un fichier de connexion (bdd.php) permettant de se connecter à la base de données de l'application. Il faut modifier les identifiants de connexion afin que ceux-ci correspondent à la base de données sur votre serveur. 


#### 2er point : créer les scripts de transfert de données

Il existe au cours du déroulement de l'application, trois étapes où la base de données doit échanger des données avec une base de données extérieur. 

    - Début la coupe : A chaque début de saison, il faut créer les 8 coupes pour correspondantes pour chaque catégorie. Pour cela il faut insérer dans la base de données les informations suivantes : 
    
        - les coupes avec comme informations (le sexe, l'age et l'année qui est celle du début de saison). A chaque coupe on ajouetera le vainqueur lorsque celui-ci sera défini en fin d'année.
        
        - les clubs avec comme informations (le nom, la ville, le commité et la région). Les clubs ne doivent être inséré qu'une seul fois. Si un club a déjà participé à une coupe antérieur, il figure déjà dans la base de données, il est inutile de le réinscrire. Seul les nouveaux clubs doivent être inséré. A chaque fois qu'un nouveau club est inséré, il faut lancer le script PHP calculeDistance qui permet d'insérer dans la base la distance entre ce nouveau club et tous les autres clubs de la base.
        
        - les équipes avec comme informations (le club associé, la coupe associée). Les insertions correspondent aux équipes devant participées à la coupe de France.
        
        - il faut aussi lancer le script PHP permettant de calculer les points de l'équipe pour le classement FFVB à partir de ses résultats obtenus lors des 5 dernières années.
        
        
        
    
    - Début de chaque tour : A chaque début de tour, il faut créer le nouveau tour correspondant à la coupe. Pour cela il faut insérer dans la base de données les informations suivantes :
    
        - le tour avec comme informations (la coupe associée, le numéro du tour et la date à laquelle le tour va se jouer).
       
        - les équipes qualifiées pour ce tour dans la table résultat avec pour informations (l'équipe en question, le tour en question et la position de l'équipe dans sa poule au tour précédent).
        
        - il faut aussi lancer le script PHP permettant de calculer les points de l'équipe pour le classement de la coupe à partir de ses résultats obtenus au tour précedent.
        
        
        
        
    - Avant le déroulement de chaque tour : Il faut récupérer les poules qui ont été créées par l'organisateur ainsi que les équipes qui ont été exemptées : 
    
        - la base extérieur doit récupérer les poules situées dans la table 'poule' ainsi que leurs équipes situez dans la table 'jouer'.
        
        - la base extérieur doit récupérer les exemptés situées dans la table 'exempter'.
        
        - le script permettant de mettre à jour la distance parcouru (modifierKmParcouru.php) par une équipe doit être lancé.
        
        
Toutes ces phases et scripts doivent être définis par la personne en charge de la base de données exterieur, puisqu'il est le seul à connaitre la composition de sa base de données. Celle de l'application est décrite dans le document suivent : supplement/Manuel de développement.


