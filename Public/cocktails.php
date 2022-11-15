<article>
    <?php
    $i = 0;
    //creation du $Lien en fonction de la page
    if (!isset($_GET['page']) || $_GET['page'] == 'Aliment') {
        $Lien = $Hierarchie['Aliment'];
    } else {
        $Lien = $Hierarchie[$_GET['page']];
    }

    $i = -1;
    $sc = null;

    do {
        foreach ($Recettes as $index_c => $cocktails) {                                     //on parcours le tableau des cocktails
            foreach ($cocktails[array_keys($cocktails)[3]] as $index_ing => $ingredients) { //on parcours le tableau des ingrédients
                if (isset($Lien["sous-categorie"])) {                                       //si on est sur les sous-catégories de la page
                    foreach ($Lien["sous-categorie"] as $index_sc => $sous_categorie) {     //on parcours le tableau des sous-catégories
                        if (!isset($sc)) { 
                            $sc[] = $sous_categorie;                                        //on stocke la première sous-catégorie 
                        } elseif (!in_array($sous_categorie, $sc)) {                        //si la sous-catégorie n'est pas déjà stockée
                            $sc[] = $sous_categorie;                                        //on stocke la sous-catégorie
                        }
                        if ($ingredients == $sous_categorie) {                              //si l'ingrédient est égal à la sous-catégorie
                            if (!isset($afficher)) { 
                                $afficher[] = $index_c;                                     //on stocke le premier cocktail
                            } elseif (!in_array($index_c, $afficher)) {                     //si le cocktail n'est pas déjà stocké
                                $afficher[] = $index_c;                                     //on stocke le cocktail
                            }
                        }
                    }
                }
                //affiche tout les cocktails contenant l'ingrédient courant 
                if (!isset($_GET['page']) || $ingredients == $_GET['page']) {               //si on est sur la page Aliment ou si l'ingrédient est égal à la page
                    if (!isset($afficher)) { 
                        $afficher[] = $index_c;                                             //on stocke le premier cocktail
                    } elseif (!in_array($index_c, $afficher)) {                             //si le cocktail n'est pas déjà stocké
                        $afficher[] = $index_c;                                             //on stocke le cocktail
                    }
                }
            }
        }

        $i++;                                                                               //on incrémente i pour passer à la sous-catégorie suivante
        if (isset($sc[$i])) {                                                               //si la sous-catégorie existe
            $Lien = $Hierarchie[$sc[$i]];                                                   //on change le lien
        }
    } while ($i < count($sc));                                                              //on recommence tant que i est inférieur au nombre de sous-catégories

    sort($afficher);                                                                        //on trie le tableau des cocktails à afficher

    foreach ($afficher as $index_a => $cocktails) {                                         //on affiche la recettes synthétique pour chaque cocktails présent dans le tableau
        Afficher_Recette_synt($cocktails, $Recettes[$cocktails]);
    }
    ?>

    <script>
        $('.btn').on('click', function() {
            var btn = $(this);
            var svg = btn.find("img");
            var indice = (this.id);
            if (svg.attr("src").match("coeurvide.svg")) {
                svg.attr("src", "../svg/coeurplein.svg");
            } else {
                svg.attr("src", "../svg/coeurvide.svg");
            }
            $.ajax({
                url: 'like.php',
                data: {
                    indice: indice
                }
            });
        });
    </script>
</article>