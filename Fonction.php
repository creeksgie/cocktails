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

    $Tstring = $string[0];                            //on sauvegarde le premier mot car aucune modification n'est nécessaire

    //on parcoure le tableau et on formate les mots pour n'avoir que des minuscules
    foreach ($string as $index_s => $mot) {
        if ($index_s > 0) {
            $string[$index_s] = strtolower($string[$index_s]);
            $Tstring = $Tstring . "_" . $string[$index_s];
        }
    }

    //on remplace tout les caractères avec accent par leur équivalent sans accent
    $Tstring = str_replace(
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
        $Tstring
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
        if ($Tstring == $TabCo[$index_cocktail]) {
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
 * @param float $Satis
 */
function Afficher_Recette_synt($cocktails, $Satis = null )
{
    global $Recettes;
?>
    <div>
        <?php
        Afficher_Bouton_like($cocktails);
        if ($Satis >= 1 || $Satis === 0) {
            $Satis = 1;
        }
        if ($Satis != null) {
            $Satis = $Satis * 100;
            ?><p><?php echo round($Satis,2);?>%</p><?php
        }
        ?>
        
        <p>
            <?php
            Afficher_Image($Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]); //on affiche l'image du cocktail
            ?>
            <br>
            <?php
            if (!isset($_GET['page'])) { //on affiche le nom du cocktail
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
                if ($ingredients == $nom) {                                                 //si on est sur la page Aliment ou si l'ingrédient est égal à la page
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

/**
 * Fonction qui permet de récupérer les sous-catégories d'un ingrédient
 * @param string $Lien Lien à l'ingrédient recherché (ex : $Hierarchie['ingrédient'])
 * @return array
 */
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
 * Fonction qui permet de récupérer les cocktails contenant un ingrédient
 */
function Recherche_Dans_Tab(&$tableauConnu,&$tabNonVoulu,&$tableauInconnu, $Recherche)
{
    $RecherchePossible=false;
    $Cmpt=substr_count($Recherche, '"')/2;              //on compte le nombre de mots composés
    if(preg_match('/(\+|-)?"([^"]+)"/', $Recherche)){   //si il y a des mots composés
        $ListMotComp = null;                            //on initialise le tableau des mots composés
        preg_match_all('/(\+|-)?"([^"]+)"/', $Recherche, $ListMotComp); //on récupère les mots composés
        $Recherche = preg_replace('/( (\+|-)?"([^"]+)"|(\+|-)?"([^"]+)")/', "", $Recherche); //on supprime les mots composés de la recherche
        for($i=0;$i<$Cmpt;$i++){ //pour chaque mot composé
            $MotsComposer=str_replace('"', "", $ListMotComp[0][$i]); //on supprime les guillemets
            pushDansTab($tableauConnu,$tabNonVoulu,$tableauInconnu, $MotsComposer); //on push le mot composé dans le tableau
        }
        $RecherchePossible=true;                                            //on indique que la recherche est possible

    }
    if($Recherche != ""){                                                   //si il y a des mots simples
        $List_Recherche = explode(" ", $Recherche);                         //on récupère les mots simples
        foreach($List_Recherche as $index=>$Mot){                           //pour chaque mot simple
            pushDansTab($tableauConnu,$tabNonVoulu,$tableauInconnu, $Mot);  //on push le mot simple dans le tableau
        }
        $RecherchePossible=true;                                            //on indique que la recherche est possible

    }
    return $RecherchePossible;
}

/**
 * Fonction qui permet de push un mot dans un tableau
 * @param array $tabVoulu Tableau dans lequel on veut push le mot
 * @param array $tabNonVoulu Tableau dans lequel on ne veut pas push le mot
 * @param array $tableauInconnu Tableau dans lequel on ne sait pas si on veut push le mot
 * @param string $Mot Mot à push
 */
function pushDansTab(&$tabVoulu,&$tabNonVoulu,&$tableauInconnu, $Mot)
{
    global $Hierarchie;
    $MotPush=false; 
    if(!empty($Mot)){                                       //si le mot n'est pas vide
        if(preg_match('/^\+?[A-Z][a-z]+/',$Mot)){           //si le mot commence par un + ou une majuscule
            if(preg_match('/^\+/', $Mot)){                  //si le mot commence par un +
                $Mot = substr($Mot, 1);                     //on enlève le +
                if(array_key_exists($Mot, $Hierarchie)){    //si le mot existe dans la hierarchie
                    $MotPush=true;
                    array_push($tabVoulu, $Mot);            //on le push
                }
            }
            else{                                           //si le mot commence par une majuscule
                if(array_key_exists($Mot, $Hierarchie)){    //si le mot existe dans la hierarchie
                    $MotPush=true;
                    array_push($tabVoulu, $Mot);            //on le push
                }
            }
        }
        if(preg_match("/^-[A-Z][a-z]+/",$Mot))              //si le mot commence par un -
        {
            $Mot = substr($Mot, 1);                         //on enlève le -
            if(array_key_exists($Mot, $Hierarchie)){        //si le mot existe dans la hierarchie
                $MotPush=true;
                array_push($tabNonVoulu, $Mot);             //on le push
            }
        }
        if(!$MotPush){
            array_push($tableauInconnu, $Mot);              //on le push
        }
    }
}

/**
 * Fonction qui permet d'afficher les résultats de la recherche bien organisés
 * @param array $TabAlimentVoulu
 * @param array $TabAlimentNonDesire
 */
function Afficher_Recherche($TabAlimentVoulu,$TabAlimentNonDesire)
{
    global $Recettes;
    $Satis = count($TabAlimentVoulu);
    if ((empty($TabAlimentVoulu) || !empty($TabAlimentNonDesire)) && !in_array("Aliment", $TabAlimentVoulu)) { //si on a des aliments non désirés ou qu'on a pas d'aliments voulus
        $TabAlimentVoulu[] = 'Aliment';
        $Satis = count($TabAlimentVoulu) + count($TabAlimentNonDesire) -1; //on ajoute un aliment voulus pour que la satisfaction de la recette soit bonne
    } 

    foreach ($TabAlimentVoulu as $index => $recherche) {    //on parcourt les aliments voulus
        $afficher[] = Tourner_Recettes($recherche);         //on récupère les recettes qui contiennent l'aliment voulu
    }
    foreach($afficher as $index=>$tab){         //on parcourt les recettes récupérées
        foreach($tab as $index2=>$recette){     //on parcourt les recettes 
            $TabCocktail[]=$recette;            //on ajoute les recettes dans un tableau
        }
    }
    $TabCocktail = array_unique($TabCocktail);  //on supprime les doublons
    sort($TabCocktail);                         //on trie le tableau
    if (!empty($TabAlimentNonDesire)) {         //si on a des aliments non désirés
        $afficher = null; 
        foreach ($TabAlimentNonDesire as $index => $recherche) {    //on parcourt les aliments non désirés
            $afficher[] = Tourner_Recettes($recherche);             //on récupère les recettes qui contiennent l'aliment non désiré
        }
        foreach($afficher as $index=>$tab){         //on parcourt les recettes récupérées
            foreach($tab as $index2=>$recette){     //on parcourt les recettes
                $TabNonVoulu[]=$recette;            //on ajoute les recettes dans un tableau
            }
        }
        foreach($TabNonVoulu as $index=>$recette){ //on parcourt les recettes
            if (array_search($recette, $TabCocktail)) { //si la recette est dans le tableau des recettes voulues
                array_splice($TabCocktail, array_search($recette, $TabCocktail),1); //on supprime la recette du tableau des recettes voulues
            }
        }
    
    $TabCocktail = array_unique($TabCocktail);          //on supprime les doublons
    $S = count($TabAlimentNonDesire);                   //on initialise le nombre de satisfaction
    $SC = null; 
    foreach ($TabCocktail as $key => $value) {          //on parcourt les recettes voulues
        foreach($TabAlimentVoulu as $index=>$aliment){  //on parcourt les aliments voulus
            if($aliment!="Aliment"){                    //si l'aliment n'est pas "Aliment"
                $SC = Recup_Sous_cat($aliment);         //on récupère les sous catégories de l'aliment
            }
                if (in_array($aliment, $Recettes[$value][array_keys($Recettes[$value])[3]])) { //si l'aliment est dans la recette
                    $S++; //on incrémente le nombre de satisfaction
                }else{ 
                    if (!empty($SC)) { //si on a des sous catégories
                        foreach($SC as $index2=>$sous_cat){ //on parcourt les sous catégories
                            if (in_array($sous_cat, $Recettes[$value][array_keys($Recettes[$value])[3]])) { //si la sous catégorie est dans la recette
                                $S++; //on incrémente le nombre de satisfaction
                            }
                            
                    }}

                }
                $SC = null;                                             //on réinitialise les sous catégories
            }
        
            if(!empty($tmp[$S]))                                        //si le nombre de satisfaction est déjà dans le tableau
            {
                $tmp[$S][]=  $value;                                    //on ajoute la recette dans le tableau
            }else
            {
                $tmp[$S]= array(0 => $value);                           //sinon on crée un tableau avec la recette
            }
    $S = count($TabAlimentNonDesire);                                   //on réinitialise le nombre de satisfaction
    }
    }
    if (empty($TabAlimentNonDesire)) {                                  //si on a pas d'aliments non désirés
        foreach ($TabAlimentVoulu as $index => $recherche) {            //on parcourt les aliments voulus
            if (empty($tmp)) {                                          //si le tableau est vide
                $tmp = Tourner_Recettes($recherche);                    //on récupère les recettes qui contiennent l'aliment voulu
            }
            else
            {
                $tmp = array_merge($tmp, Tourner_Recettes($recherche)); //sinon on ajoute les recettes qui contiennent l'aliment voulu dans le tableau
            }
        }
        sort($tmp);                                                     //on trie le tableau
        foreach($tmp as $index => $cocktail){                           //on parcourt les recettes
            Afficher_Recette_Synt($cocktail,1);                         //on affiche les recettes
        }
    }
    else //si on a des aliments non désirés
    {
        $T = $tmp[max(array_keys($tmp))];                                           //on récupère les recettes qui ont le plus de satisfaction
        do {
            foreach($T as $index => $cocktail){                                     //on parcourt les recettes
                Afficher_Recette_Synt($cocktail,max(array_keys($tmp))/($Satis));    //on affiche les recettes
                unset($tmp[max(array_keys($tmp))][$index]);                         //on supprime la recette du tableau
                if (empty($tmp[max(array_keys($tmp))])) {                           //si le tableau est vide
                    unset($tmp[max(array_keys($tmp))]);                             //on supprime le tableau
                    if (!empty($tmp)) {                                             //si le tableau n'est pas vide
                    $T = $tmp[max(array_keys($tmp))];                               //on récupère les recettes qui ont le plus de satisfaction
                    } 
                }
            }
        } while (!empty($tmp)); //tant que le tableau n'est pas vide
    }
}
?>