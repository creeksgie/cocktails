<article>
    <?php
        if (!isset($_GET['page'])|| $_GET['page'] == 'Aliment') {
            $Lien = $Hierarchie['Aliment'];
         }else{
            $Lien = $Hierarchie[$_GET['page']];
         }
    $i = -1;
    $sc= null;
    do {
    foreach ($Recettes as $index_c => $cocktails) {
        foreach ($cocktails[array_keys($cocktails)[3]] as $index_ing => $ingredients) {
            if (isset($Lien["sous-categorie"])) {
                foreach ($Lien["sous-categorie"] as $index_sc => $sous_categorie) {
                    if (!isset($sc)) {
                        $sc[] = $sous_categorie;
                    }elseif (!in_array($sous_categorie, $sc)) {
                        $sc[] = $sous_categorie;
                    }
                    if ($ingredients == $sous_categorie) {
                        if (!isset($afficher)) {
                            $afficher[] = $index_c;
                        }elseif (!in_array($index_c, $afficher)) {
                            $afficher[] = $index_c;
                        }
                    }
                }
            }
            if (!isset($_GET['page']) || $ingredients == $_GET['page']) {
                if (!isset($afficher)) {
                    $afficher[] = $index_c;
                }elseif (!in_array($index_c, $afficher)) {
                    $afficher[] = $index_c;
                }
            }
        }
    }
    $i++;
    if (isset($sc[$i])) {
        $Lien = $Hierarchie[$sc[$i]];
    }
    else {
        goto alpha;
    }
} while (array_key_exists($i,$sc));
alpha:
foreach ($afficher as $index_a => $cocktails) {
?>
    <div>
        <button><img class="svg" src="..\svg\coeurvide.svg" alt=""></button>
        <br>
        <p>
<?php
        /*if () {
        ?><img src="..\Photos\<?= htmlentities($Recettes[$k7]["titre"]) ?>.jpg" alt=""><?php
        }else*/
?>
        <img src="..\Photos\cocktail.png" alt="">
        <br>
                    
        <a href="?Recettes=<?php echo $index_a; ?>"><?php echo $Recettes[$index_a]["titre"]; ?></a>
        </p>
        <ul> <?php
        foreach ($Recettes[$index_a]["index"] as $ing ) {
            ?> <li><?= htmlentities($ing) ?></li> <?php
        }
        ?> </ul> 
    </div>
<?php }
           
    ?>
</article>