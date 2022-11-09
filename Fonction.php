<?php

function Afficher_Image($mot){

    $nom_photo = null;
    $string = preg_replace('/\s+/', '_', $mot);
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
}

?>