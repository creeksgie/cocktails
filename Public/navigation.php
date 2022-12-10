<article>
    <p>Aliment Courant</p>
    <span>
        <?php
        //permet de créer le file d'ariane
        if (!isset($_GET['page']) || $_GET['page'] == 'Aliment') {  //si on est sur la page d'accueil ou sur la page Aliment
            $Lien = $Hierarchie['Aliment'];                         //on affiche les recettes avec les aliments
        ?>
            <a href="?page=Aliment">Aliment</a> /
            <?php
            $chemin[] = "Aliment";                                  //on ajoute Aliment dans le chemin
        } else {
            $chemin = $_SESSION['chemin'];                          //on récupère le chemin
            $i = count($chemin);                                    //on récupère le nombre d'élément dans le chemin
            $Lien = $Hierarchie[$_GET['page']];                     //on récupère les sous catégories de la page
            $chemin[] = $_GET['page'];                              //on ajoute la page dans le chemin
            if (in_array($_GET['page'],$_SESSION['chemin'])) {      //si la page est déjà dans le chemin
                do {
                    array_splice($chemin, $i);                      //on supprime l'élément
                    $i--;                                           //on décrémente i
                } while ($chemin[$i] != $_GET['page']);             //tant que l'élément n'est pas la page
            }
            foreach ($chemin as $index_chemin => $page) {          //on affiche le chemin
            ?>
                <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a> /
        <?php
            }
        }

        $_SESSION['chemin'] = $chemin;                             //on enregistre le chemin

        ?>
    </span>
    <?php
    //permet de créer les Liens vers les sous catégories
    foreach ($Lien as $index_nav => $nav) {                         //pour chaque sous catégorie
        if ($index_nav != 'super-categorie') {                      //si ce n'est pas la super catégorie
    ?>
            <p><?= htmlentities($index_nav) ?></p>
            <ul><?php
                foreach ($nav as $index_ing => $ingredient) {       //on affiche les sous catégories
                ?> <li><a href="?page=<?php echo $ingredient; ?>"><?php echo $ingredient; ?></a></li>
                <?php
                }
                ?> </ul>
    <?php
        }
    }
    ?>
</article>