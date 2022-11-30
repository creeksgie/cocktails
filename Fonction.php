<?php

/***
 * Fonction qui permet d'afficher les images des cocktails
 * @param string $mot nom du cocktail
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

/**
 * Fonction qui permet d'afficher le bouton like
 * @param int $cocktail l'indice du cocktail
 */
function Afficher_Bouton_like($cocktail)
{
    if (isset($_SESSION['user'])) { //Si je suis connecter
        $Login = $_SESSION['user']['login'];
        include('user\\'.$Login.'.php');
    }
    ?>
    <button class="btn" id="<?php echo $cocktail; ?>">
        <?php
        //on affiche un coeur plein si le cocktail est dans le tableau des likes sinon on affiche un coeur vide
        if (isset($_SESSION['like']) || isset($userLike)) {
            if (!isset($_SESSION['like'])) {
                $like = array();
            } else {
                $like = $_SESSION['like'];
            }
            if (!isset($userLike)) {
                $uLike = array();
            }else{
                $uLike = $userLike;
            }
            if (in_array($cocktail, $like) || in_array($cocktail, $uLike)) {
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
 * @param int $cocktails
 */
function Afficher_Recette_synt($cocktails)
{
    global $Recettes;
?>
    <div>
        <?php
        Afficher_Bouton_like($cocktails);
        ?>
        <p>
            <?php
            Afficher_Image($Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]);
            ?>
            <br>
            <?php
            if (!isset($_GET['page'])) {
                ?>
            <a href="?page=Aliment&Recettes=<?php echo $cocktails; ?>"><?php echo $Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]; ?></a>
            <?php }
            else {
                ?>
            <a href="?page=<?php echo $_GET['page']; ?>&Recettes=<?php echo $cocktails; ?>"><?php echo $Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]; ?></a>
            <?php } ?>
            
        </p>
        <ul>
            <?php
            //on affiche les ingrédients
            foreach ($Recettes[$cocktails][array_keys($Recettes[$cocktails])[3]] as $ing) {
            ?> <li><?= htmlentities($ing) ?></li>
            <?php
            }
            ?> </ul>
    </div>
<?php
}

/**
 * Fonction qui permet de parcourir le tableau des recettes et de mettre les cocktails qui contiennent les ingrédients recherchés dans un tableau
 * @param array $Lien Lien à l'ingrédient recherché (ex : $Hierarchie['ingrédient'])
 * @return array 
 */
function Tourner_Recettes($Lien)
{
    global $Recettes, $Hierarchie;
    $nom = $Lien;
    $Lien = $Hierarchie[$Lien];
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
                if ($ingredients == $nom) {               //si on est sur la page Aliment ou si l'ingrédient est égal à la page
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
    return $afficher;
}


function Recup_Sous_cat($Lien)
{
    global $Recettes, $Hierarchie;
    $nom = $Lien;
    $Lien = $Hierarchie[$Lien];
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
                    }
                }
            }
        }

        $i++;                                                                               //on incrémente i pour passer à la sous-catégorie suivante
        if (isset($sc[$i])) {                                                               //si la sous-catégorie existe
            $Lien = $Hierarchie[$sc[$i]];                                                   //on change le lien
        }
    } while ($i < count($sc));                                                              //on recommence tant que i est inférieur au nombre de sous-catégories
    return $sc;
}


/**
 * 
 */
function rechercheDansTab(&$tableauConnu,&$tabNonVoulu,&$tableauInconnu, $Recherche)
{
    $RecherchePossible=false;
    $Cmpt=substr_count($Recherche, '"')/2;
    if(preg_match('/(\+|-)?"([^"]+)"/', $Recherche)){
        $ListMotComp = null;
        preg_match_all('/(\+|-)?"([^"]+)"/', $Recherche, $ListMotComp);
        $Recherche = preg_replace('/( (\+|-)?"([^"]+)"|(\+|-)?"([^"]+)")/', "", $Recherche);
        for($i=0;$i<$Cmpt;$i++){
            $MotsComposer=str_replace('"', "", $ListMotComp[0][$i]);
            pushDansTab($tableauConnu,$tabNonVoulu,$tableauInconnu, $MotsComposer);
        }
        $RecherchePossible=true;

    }
    if($Recherche != ""){
        $List_Recherche = explode(" ", $Recherche);
        foreach($List_Recherche as $index=>$Mot){
            pushDansTab($tableauConnu,$tabNonVoulu,$tableauInconnu, $Mot);
        }
        $RecherchePossible=true;

    }
    return $RecherchePossible;
}

function pushDansTab(&$tabVoulu,&$tabNonVoulu,&$tableauInconnu, $Mot)
{
    global $Hierarchie;
    $MotPush=false;
    if(!empty($Mot)){
        if(preg_match('/^\+?[A-Z][a-z]+/',$Mot)){
            if(preg_match('/^\+/', $Mot)){
                $Mot = substr($Mot, 1);
                if(array_key_exists($Mot, $Hierarchie)){
                    $MotPush=true;
                    array_push($tabVoulu, $Mot);
                }
            }
            else{
                if(array_key_exists($Mot, $Hierarchie)){
                    $MotPush=true;
                    array_push($tabVoulu, $Mot);
                }
            }
        }
        if(preg_match("/^-[A-Z][a-z]+/",$Mot))
        {
            $Mot = substr($Mot, 1);
            if(array_key_exists($Mot, $Hierarchie)){
                $MotPush=true;
                array_push($tabNonVoulu, $Mot);
            }
        }
        if(!$MotPush){
            array_push($tableauInconnu, $Mot);
        }
    }
}
?>