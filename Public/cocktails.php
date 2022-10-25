<article>
    <?php
    $i = 0;
    if (!isset($_GET['page']) || $_GET['page'] == 'Aliment') {
        $Lien = $Hierarchie['Aliment'];
    } else {
        $Lien = $Hierarchie[$_GET['page']];
    }
    $i = -1;
    $sc = null;
    do {
        foreach ($Recettes as $index_c => $cocktails) {
            foreach ($cocktails[array_keys($cocktails)[3]] as $index_ing => $ingredients) {
                if (isset($Lien["sous-categorie"])) {
                    foreach ($Lien["sous-categorie"] as $index_sc => $sous_categorie) {
                        if (!isset($sc)) {
                            $sc[] = $sous_categorie;
                        } elseif (!in_array($sous_categorie, $sc)) {
                            $sc[] = $sous_categorie;
                        }
                        if ($ingredients == $sous_categorie) {
                            if (!isset($afficher)) {
                                $afficher[] = $index_c;
                            } elseif (!in_array($index_c, $afficher)) {
                                $afficher[] = $index_c;
                            }
                        }
                    }
                }
                if (!isset($_GET['page']) || $ingredients == $_GET['page']) {
                    if (!isset($afficher)) {
                        $afficher[] = $index_c;
                    } elseif (!in_array($index_c, $afficher)) {
                        $afficher[] = $index_c;
                    }
                }
            }
        }
        $i++;
        if (isset($sc[$i])) {
            $Lien = $Hierarchie[$sc[$i]];
        }
    } while ($i < count($sc));
    sort($afficher);
    foreach ($afficher as $index_a => $cocktails) {

    ?>
        <div>
            <button><img class="svg" src="..\svg\coeurvide.svg" alt=""></button>
            <br>
            <p>
                <?php

                /* permet d'afficher le nom du cocktail pour afficher les images
                    $string = preg_replace('/\s+/', '_',$Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]);
                    echo $string;
                    $string = explode("_", $string);
                    var_dump($string);
                    $s = $string[0];
                    foreach ($string as $key => $value) {
                        if ($key > 0) {
                            $string[$key] = strtolower($string[$key]);
                            $s = $s."_".$string[$key];
                        }
                    }
                    var_dump($s); */
                                /*if () {
                        ?><img src="..\Photos\<?= htmlentities($Recettes[$k7]["titre"]) ?>.jpg" alt=""><?php
                        }else*/
                ?>
                <img src="..\Photos\cocktail.png" alt="">
                <br>

                <a href="?Recettes=<?php echo $cocktails; ?>"><?php echo $Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]; ?></a>
            </p>
            <ul>
                <?php
                foreach ($Recettes[$cocktails][array_keys($Recettes[$cocktails])[3]] as $ing) {
                ?> <li><?= htmlentities($ing) ?></li>
                <?php
                }
                ?> </ul>
        </div>
    <?php
    }

    /**
     * $dir = scandir("..\Photos");
        print_r($dir);
        $string = "Ceci est un test";
        $string =  preg_replace('/\s+/', '_', $string);
        print_r($string); //ne recupère pas la bonne valeur si je la met dans le preg_match_all 

        foreach ($dir as $key => $value) {
            if (preg_match_all('#^[A-Z]([a-z]+[_]*){0,8}#',$dir[$key],$match)) {
                $yo[] = $match[0][0];
            }

        }
        print_r($yo);
     */




    ?>
</article>