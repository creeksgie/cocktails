<article class="like" id="like">
    <?php
    if (isset($_SESSION['like'])) {
        $indice = $_SESSION['like'];
        sort($indice);
        foreach ($indice as $index_a => $cocktails) {
            Afficher_Recette_synt($cocktails,$Recettes[$cocktails]);
        }
    }
    ?>
</article>