<article>
    <?php
    //creation du $Lien en fonction de la page
    if (!isset($_GET['page']) || $_GET['page'] == 'Aliment') {
        $Lien = 'Aliment';
    } else {
        $Lien = $_GET['page'];
    }

    $afficher = Tourner_Recettes($Lien);
    
    sort($afficher);                                                                        //on trie le tableau des cocktails à afficher

    foreach ($afficher as $index_a => $cocktails) {                                         //on affiche la recettes synthétique pour chaque cocktails présent dans le tableau
        Afficher_Recette_synt($cocktails);
    }
    ?>
</article>