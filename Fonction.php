<?php

/***
 * Fonction qui permet d'afficher les images des cocktails
 */
function Afficher_Image($mot)
{
    $nom_photo = null;
    $string = preg_replace('/\s+/', '_', $mot); //remplace les espaces par des _
    $string = explode("_", $string);            //transforme la chaine de caractère en tableau exploser par _

    $s = $string[0];                            //on sauvegarde le premier mot car aucune modification n'est nécessaire

    //on parcoure le tableau et on formate les mots pour n'avoir que des minuscules
    foreach ($string as $index_s => $mot) {
        if ($index_s > 0) {
            $string[$index_s] = strtolower($string[$index_s]);
            $s = $s . "_" . $string[$index_s];
        }
    }

    //on remplace tout les caractères avec accent par leur équivalent sans accent
    $s = str_replace(
        array(
            'à', 'â', 'ä', 'á', 'ã', 'å',
            'î', 'ï', 'ì', 'í',
            'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
            'ù', 'û', 'ü', 'ú',
            'é', 'è', 'ê', 'ë',
            'ç', 'ÿ', 'ñ',
        ),
        array(
            'a', 'a', 'a', 'a', 'a', 'a',
            'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u',
            'e', 'e', 'e', 'e',
            'c', 'y', 'n',
        ),
        $s
    );

    $dir = scandir("..\Photos"); //on récupère le contenu du dossier Photos

    //on parcours le dossier et on sauvegarde le nom de la photo
    foreach ($dir as $index_photo => $photo) {
        if (preg_match_all('#^[A-Z]([a-z]+[_]*){0,8}#', $dir[$index_photo], $match)) {
            $TabCo[] = $match[0][0];
        }
    }

    //on parcours le tableau des cocktails pour verifier si le nom du cocktail est présent dans le tableau des photos
    foreach ($TabCo as $index_cocktail => $value4) {
        if ($s == $TabCo[$index_cocktail]) {
            $nom_photo =  $TabCo[$index_cocktail];
        }
    }

    //Si la photo est présente dans le dossier on l'affiche sinon on affiche une image par défaut
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

function Afficher_Bouton_like($cocktails)
{
    ?>
    <button class="btn" id="<?php echo $cocktails; ?>">
        <?php
        //on affiche un coeur plein si le cocktail est dans le tableau des likes sinon on affiche un coeur vide
        if (isset($_SESSION['like'])) {
            if (in_array($cocktails, $_SESSION['like'])) {
        ?>
                <img class="svg" src="..\svg\coeurplein.svg" alt="">
            <?php
            } else {
            ?>
                <img class="svg" src="..\svg\coeurvide.svg" alt="">
            <?php
            }
        } else {
            ?>
            <img class="svg" src="..\svg\coeurvide.svg" alt="">
        <?php
        }
        ?>
    </button>
<?php
}

/***
 * Fonction qui permet d'afficher la version synthétique des recettes
 */
function Afficher_Recette_synt($cocktails, $tab)
{
?>
    <div>
        <?php
        Afficher_Bouton_like($cocktails);
        ?>
        <p>
            <?php
            Afficher_Image($tab[array_keys($tab)[0]]);
            ?>
            <br>

            <a href="?page=<?php echo $_GET['page']; ?>&Recettes=<?php echo $cocktails; ?>"><?php echo $tab[array_keys($tab)[0]]; ?></a>
        </p>
        <ul>
            <?php
            //on affiche les ingrédients
            foreach ($tab[array_keys($tab)[3]] as $ing) {
            ?> <li><?= htmlentities($ing) ?></li>
            <?php
            }
            ?> </ul>
    </div>
<?php
}



?>