<article>
    <?php
    //creation du $Lien en fonction de la page
    if (!isset($_GET['page']) || $_GET['page'] == 'Aliment') {                              //si on est sur la page d'accueil ou sur la page Aliment
        $Lien = 'Aliment';                                                                  //on affiche les recettes avec les aliments
    } else {                                                                                //sinon
        $Lien = $_GET['page'];                                                              //on affiche les recettes avec les cocktails
    }

    $afficher = Tourner_Recettes($Lien);                                                    //on récupère les recettes à afficher
    
    sort($afficher);                                                                        //on trie le tableau des cocktails à afficher

    foreach ($afficher as $index_a => $cocktails) {                                         //on affiche la recettes synthétique pour chaque cocktails présent dans le tableau
        Afficher_Recette_synt($cocktails);
    }
    ?>
</article>