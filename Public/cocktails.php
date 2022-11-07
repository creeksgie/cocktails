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
        $TabCo = null;
        $nom_photo = null;
    ?>
        <div>
            <button><img class="svg" src="..\svg\coeurvide.svg" alt=""></button>
            <p>
                <?php

                $string = preg_replace('/\s+/', '_', $Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]);
                $string = explode("_", $string);

                $s = $string[0];
                foreach ($string as $index_s => $mot) {
                    if ($index_s > 0) {
                        $string[$index_s] = strtolower($string[$index_s]);
                        $s = $s . "_" . $string[$index_s];
                    }
                }
                $dir = scandir("..\Photos");

                foreach ($dir as $index_photo => $photo) {
                    if (preg_match_all('#^[A-Z]([a-z]+[_]*){0,8}#', $dir[$index_photo], $match)) {
                        $TabCo[] = $match[0][0];
                    }
                }
                foreach ($TabCo as $index_cocktail => $value4) {
                    if ($s == $TabCo[$index_cocktail]) {
                        $nom_photo =  $TabCo[$index_cocktail];
                    }
                }
                if ($nom_photo != null) {
                ?>
                    <img src="..\Photos\<?= htmlentities($nom_photo) ?>.jpg" alt="">
                <?php
                } else {
                ?>
                    <img src="..\Photos\cocktail.png" alt="">
                <?php
                }
                ?>
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
    ?>
</article>
