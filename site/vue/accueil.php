<?php 
/*
*
* Créer par : CHAPON Théo
* Date de modification : 06/08/2013
*
*/

/*
*
* Information sur la page :
* Nom : accueil.php
* Chemin abs : site\vue\
* Information : page d'accueil du site pour les clients.
* Page d'accueil de l'application
*
*/
?>

<?php

    // permet de définir l'année actuel, si non définie, pour récupérer les coupes.
    if (!isset($_SESSION['annee'])) {
        $_SESSION['annee'] = date("Y");
        
        if(date("n") <= 7) $_SESSION['annee']--;
    } 

    //récupération de l'année si elle est fourni lors du rechargement de la page
    if(isset($_POST['annee'])){
        $_SESSION['annee'] = $_POST['annee'];
    }



    // on récupère les années de coupe présentent dans la base
    $manager = new CoupeManager();
    $annees = $manager->annees();

    // on récupère le tour le plus avancé de chaque catégorie de coupe (categorie == tour)
    $manager = new TourManager();
    $categories = $manager->getListMaxTour($_SESSION['annee']);
?>


<div class="annee">
    <div class="col-sm-10">
        <select id="selectAnnee" class="form-control">
            <?php
                // on affiche les années dans un select (fonction associé dans accueil.js)
                foreach ($annees as $key => $annee) {
                    echo '<option value="'.$annee.'" '.(($annee==$_SESSION['annee']) ? 'selected':'').'>'.$annee.' - '.($annee+1).'</option>';
                }
            ?>  
        </select>
    </div>
</div>
<table>

    <?php
    $loop = 0;
    
    //on affiche les catégories, si un des bouttons d'une catégorie est utilisé, 2 nouveaux paramètres sont passés en GET :
    // c->coupe et t->tour
    foreach ($categories as $key => $categorie) {

        if( $loop%2 == 0 ) echo '<tr>';

        echo '<td>
            <div class="categorie" id="'.$categorie->id().'">
                Catégorie : '.$categorie->coupe()->categorie().'
                <button type="button" class="btn btn-default btn-xs" 
                onclick="self.location.href=\'?m=navigation&a=editeur&c='.$categorie->coupe()->id().'&t='.$categorie->id().'\'"
                >Editeur</button>
                </br></br>

                Tour actuel : '.$categorie->numero().'
                <button type="button" class="btn btn-default btn-xs" 
                onclick="self.location.href=\'?m=navigation&a=generateur&c='.$categorie->coupe()->id().'&t='.$categorie->id().'\'"
                >Generateur</button>
                </br></br>

                Date : '.date('d-m-Y', strtotime($categorie->dateTour())).'
                <button type="button" class="btn btn-default btn-xs" 
                onclick="self.location.href=\'?m=navigation&a=verificateur&c='.$categorie->coupe()->id().'&t='.$categorie->id().'\'"
                >Verificateur</button>
            </div>
        </td>';

        if( $loop%2 == 1 ) echo '</tr>';

        $loop++;
    }
    ?>

</table>


<script>
    $(function() {
        $(".categorie").each(function() {

            var categorie = this.id;

            $.ajax({
                type: 'POST',
                url: 'site/ajax/accueil/categorieIncomplete.php',
                data: { categorie: categorie },
                dataType: 'json',
                timeout: 3000,
                
                success: function(json) {
                        $("#" + categorie).css("background-color", json.reponse);
                },

                error: function() {
                    console.log('La requête de chargement de vérification n\'a pas abouti'); 
                },
            });   
        });
    });
</script>