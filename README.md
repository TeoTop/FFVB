FFVB
====

Projet de stage - Créer une application web permettant de gérer et générer les poules de la coupe de france jeune de volley-ball

## Présentation

Cette application web a pour but d'aider l'organisteur des poules dans la création des celles-ci. Il doit pouvoir gérer les poules comme il le souhaite, c'est-à-dire : 

    - créer et supprimer les poules
    - modifier les poules en ajoutant ou en supprimant les équipes
    - exempter des équipes
    
De plus, afin d'aider au mieux l'organisteur, il doit pouvoir sélectionner les équipes selon des critères définis et les trier. Les critères sont décomposés en trois catégories : 

    - domicile : permet de sélectionner une équipe devant évoluer à domicile pour chaque poule
    - exterieur : permet de sélectionner de 2 à 3 équipes devant évoluer à l'extérieur pour chaque poule
    - exempter : permet de sélectionner des équipes à exempter et qui seront placées dans une poule sépciale.
    
En plus de pouvoir éditer les poules, l'organisateur peut vérifier facilement si le contenue de celle-ci respecte bien les critères qu'il souhaite voir appliqués. Pour cela, il lui suffira de se positionner dans la page de vérification et de sélectionner les critères. Les équipes ne respectant pas ces critères seront affichées en rouge, et un indicateur permettra de signifier clairement à l'organisateur quel est le problème pour chaque équipe.


En marge de cette première version, un dernier module doit être développé, c'est le générateur automatique de poules. Ce module doit permettre à l'organisteur de sélectionner les critères qu'il souhaite appliquer. Ces critères doivent être classé par ordre d'importance, doivent posséder une valeur et une action lorsque le critère est trop restrictif.

Pour plus d'information concernant la présentation du projet et de l'application web, référez-vouz auprès des deux documents suivant : 

    - supplement/projet FFVB
    - supplement/Manuel de développement
    

## Indication pour la mise en place de l'application

Cette application comporte une base de données fonctionnant en autonomie. Toutefois, plusieurs tables doivent être préalablement chargées afin que l'application puisse être utilisable. Voici donc la suite de procédure et d'action à mettre en place pour faire communiquer les deux bases de données nécessaires à la bonne marche de l'application :


#### 1er point : la base de données

Dans un premier temps, il faut créer la base de données qui est utilisée par l'application web. Pour cela, connectez-vous à votre gestionnaire de bases afin d'importer la base de l'application par l'intermédiaire du script 'ffvb_gpa.php' situé dans le dossier mysql.  

L'application se compose d'un fichier de connexion (bdd.php) permettant de se connecter à la base de données de l'application. Il faut modifier les identifiants de connexion afin que ceux-ci correspondent à la base de données que vous venez de créer sur votre serveur. 


#### 2eme point : ajout de l'application web sur le serveur

L'application se compose de deux parties. La première correspond aux modules de l'application et est formée du dossier 'site' et de la page principale 'index.php'. La page d'index est tout le temps appelé lorsqu'il y a une demande de chargement de page (requête HTTP). Par conséquent, elle correspond au point d'entrée de l'application, c'est donc sur cette page que doit être redirigé l'url définie par le webmaster pour accéder à l'application. 

La seconde partie se compose des divers scripts permettant de tenir à jour la base de données. Leur utilisation doit être définie par le webmaster. 

Les dossiers 'mysql' et 'supplement' sont eux des informations supplémentaires et ne doivent pas forcement figurer sur le serveur pour que l'application fonctionne.


#### 3eme point : créer les scripts de transfert de données

Il existe au cours du déroulement de l'application, trois étapes où la base de données doit échanger des données avec une base de données extérieur. 

    - Début de la coupe : A chaque début de saison, il faut créer les 8 coupes correspondantes pour chaque catégorie. Pour cela il faut insérer dans la base de données les informations suivantes : 
    
        - les coupes avec comme informations (le sexe, l'age et l'année qui est celle du début de saison). A chaque coupe on ajouetera le vainqueur lorsque celui-ci sera défini en fin d'année.
        
        - les clubs avec comme informations (le nom, la ville, le commité et la région). Les clubs ne doivent être insérés qu'une seul fois. Si un club a déjà participé à une coupe antérieur, il figure déjà dans la base de données, il est inutile de le réinscrire. Seuls les nouveaux clubs doivent être insérés. A chaque fois qu'un nouveau club est inséré, il faut lancer le script PHP 'calculeDistance.php' qui permet d'insérer dans la base la distance entre ce nouveau club et tous les autres clubs de la base.
        
        - les équipes avec comme informations (le club associé, la coupe associée). Les insertions correspondent aux équipes devant participées à la coupe de France.
        
        - il faut aussi lancer le script PHP permettant de calculer les points de l'équipe pour le classement FFVB à partir de ses résultats obtenus lors des 5 dernières années (à définir).
        
        
        
    
    - Début de chaque tour : A chaque début de tour, il faut créer le nouveau tour correspondant à la coupe. Pour cela il faut insérer dans la base de données les informations suivantes :
    
        - le tour avec comme informations (la coupe associée, le numéro du tour et la date à laquelle le tour va se jouer).
       
        - les équipes qualifiées pour ce tour dans la table 'résultat' avec pour informations (l'équipe en question, le tour en question et la position de l'équipe dans sa poule au tour précédent).
        
        - il faut aussi lancer le script PHP permettant de calculer les points de l'équipe pour le classement de la coupe à partir de ses résultats obtenus au tour précedent (à définir).
        
        
        
        
    - Avant le déroulement de chaque tour : Il faut récupérer les poules qui ont été créées par l'organisateur ainsi que les équipes qui ont été exemptées : 
    
        - la base extérieur doit récupérer les poules situées dans la table 'poule' ainsi que leurs équipes situées dans la table 'jouer'.
        
        - la base extérieur doit récupérer les exemptés situées dans la table 'exempter'.
        
        - le script permettant de mettre à jour la distance parcouru (modifierKmParcouru.php) par une équipe doit être lancé.
        
        
Toutes ces phases et scripts doivent être définis par la personne en charge de la base de données exterieur, puisqu'il est le seul à connaitre la composition de sa base de données. Celle de l'application est décrite dans le document suivent : supplement/Manuel de développement.


