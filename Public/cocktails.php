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
    foreach ($Recettes as $key => $value) {
        foreach ($value["index"] as $key2 => $value2) {
            if (isset($Lien["sous-categorie"])) {
                foreach ($Lien["sous-categorie"] as $key3 => $value3) {
                    //var_dump($Lien["sous-categorie"][$key3]);
                    if (!isset($sc)) {
                        $sc[] = $Lien["sous-categorie"][$key3];
                    }elseif (!in_array($Lien["sous-categorie"][$key3], $sc)) {
                        $sc[] = $Lien["sous-categorie"][$key3];
                    }
                    if ($value["index"][$key2] == $Lien["sous-categorie"][$key3]) {

                        if (!isset($afficher)) {
                            $afficher[] = $Recettes[$key]["titre"];
                        }elseif (!in_array($Recettes[$key]["titre"], $afficher)) {
                            $afficher[] = $Recettes[$key]["titre"];
                        }
                    }
                }
            }
            if (!isset($_GET['page']) || $value["index"][$key2] == $_GET['page']) {
                if (!isset($afficher)) {
                    $afficher[] = $Recettes[$key]["titre"];
                }elseif (!in_array($Recettes[$key]["titre"], $afficher)) {
                    $afficher[] = $Recettes[$key]["titre"];
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
?>
    <?php
    foreach ($Recettes as $k7 => $value) {
        foreach ($afficher as $k8 => $value) {
            if ( $Recettes[$k7]["titre"] == $afficher[$k8]) {
                ?>
                <span>
                    <button><img class="svg" src="..\svg\coeurvide.svg" alt=""></button>
                    <br>
                    <p>
                        <?php
                            /*if () {
                                ?><img src="..\Photos\<?= htmlentities($Recettes[$k7]["titre"]) ?>.jpg" alt=""><?php
                            }else*/
                            ?><img src="..\Photos\cocktail.png" alt="">
                    <br>
                    
                    <a href="?Recettes=<?php echo $k7; ?>"><?php echo $Recettes[$k7]["titre"]; ?></a>
                    </p>
                    <ul> <?php
                    foreach ($Recettes[$k7]["index"] as $key4) {
                        ?> <li><?= htmlentities($key4) ?></li> <?php
                    }
                    ?> </ul> 
                </span><?php }}
            }
           
    ?>
</article>