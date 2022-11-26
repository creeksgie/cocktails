<?php
$TabAlimentVoulu = array();
$TabAlimentNonDesire = array();
$TabInconnu = array();
$TabCocktail = null;
$TabMotsComposer=null;
$List_Recherche_Tmp= $_POST['ingredient'];
$RecherchePossible=false;
$NbQuote=true;

if(preg_match('/^ +/', $List_Recherche_Tmp)){
    preg_replace('/^ +/', '', $List_Recherche_Tmp);
}
if(substr_count($List_Recherche_Tmp, '"')%2==0){
    $RecherchePossible = rechercheDansTab($TabAlimentVoulu,$TabAlimentNonDesire,$TabInconnu, $List_Recherche_Tmp);
}
else{
    $NbQuote=false;
}



?>
<nav>
    <article>
        <span>
        <?php
            if(!$NbQuote){
                echo "Problème de syntaxe dans votre requête : nombre impaire de double-quotes";
            }
            else{
                if(!empty($TabAlimentVoulu))
                {
                    ?>
                    <p>Aliment voulu :</p>
                    <?php
                    echo implode(", ", $TabAlimentVoulu)."<br>"; 
                }
                if(!empty($TabAlimentNonDesire))
                {
                    ?>
                    <p>Aliment non désiré :</p>
                    <?php
                    echo implode(", ", $TabAlimentNonDesire)."<br>";
                }
                if(!empty($TabInconnu))
                {
                    ?>
                    <p>Aliment inconnu :</p>
                    <?php
                    echo implode(", ", $TabInconnu)."<br>";
                }
                
            }
        ?>
        </span>
    </article>
</nav>
<main>
    <article>
        <span>
        <?php
        //$x = $_POST['ingredient'];
        if(empty($TabAlimentVoulu) && empty($TabAlimentNonDesire)){
            $RecherchePossible=false;
        }
        if($RecherchePossible && $NbQuote){
            ?>
            </span>
            <?php
            
            if ((empty($TabAlimentVoulu) || !empty($TabAlimentNonDesire)) && !in_array("Aliment", $TabAlimentVoulu)) {
                $TabAlimentVoulu[] = 'Aliment';
            }
        
            foreach ($TabAlimentVoulu as $index => $recherche) {
                $afficher[] = Tourner_Recettes($recherche);
            }
            foreach($afficher as $index=>$tab){
                foreach($tab as $index2=>$recette){
                    $TabCocktail[]=$recette;
                }
            }
            $TabCocktail = array_unique($TabCocktail);
            sort($TabCocktail);
            if (!empty($TabAlimentNonDesire)) {
                $afficher = null;
                foreach ($TabAlimentNonDesire as $index => $recherche) {
                    $afficher[] = Tourner_Recettes($recherche);
                }
                foreach($afficher as $index=>$tab){
                    foreach($tab as $index2=>$recette){
                        $TabNonVoulu[]=$recette;
                    }
                }
                foreach($TabNonVoulu as $index=>$recette){
                    if (array_search($recette, $TabCocktail)) {
                        array_splice($TabCocktail, array_search($recette, $TabCocktail),1);
                    }
                }
            }
            $TabCocktail = array_unique($TabCocktail);
            $S = count($TabAlimentNonDesire);
            $SC = null;
            //echo count($TabCocktail)." recettes trouvées";
            foreach ($TabCocktail as $key => $value) {
                foreach($TabAlimentVoulu as $index=>$aliment){
                    if($aliment!="Aliment"){
                        $SC = Recup_Sous_cat($aliment);
                    }
                    //faire une fonction qui récup les sous catégorie des aliments car ya pas que l'aliment courant qui satisfait la demande, pour lait "lait de coco" satisfait aussi 
                        if (in_array($aliment, $Recettes[$value][array_keys($Recettes[$value])[3]])) {
                            $S++;
                        }elseif (!empty($SC)) {
                            foreach($SC as $index2=>$sous_cat){
                                if (in_array($sous_cat, $Recettes[$value][array_keys($Recettes[$value])[3]])) {
                                    $S++;
                                }
                            }
                        }
                        else 
                        {
                            $S--; 
                            if ($S < 0) {
                               $S = 0;
                            }
                        }
                    }
                    if(!empty($tmp[$S]))
                    {
                        $tmp[$S][]=  $value;
                    }else
                    {
                        $tmp[$S]= array(0 => $value);
                    }
            $S = count($TabAlimentNonDesire);
            }
            for ($i = max(array_keys($tmp)); $i >= 0 ; $i--) { 
                
                if (array_key_exists($i,$tmp)) {
                    if ($i == max(array_keys($tmp))) {
                        $Tab = $tmp[max(array_keys($tmp))];
                    }
                    else {
                        array_push($Tab, $tmp[$i]);
                    }
                }
            }
           //var_dump($Tab);
            foreach ($Tab as $index_a => $cocktails) {                                         //on affiche la recettes synthétique pour chaque cocktails présent dans le tableau
                if (is_array($cocktails)) {
                    foreach($cocktails as $index_b => $cocktail){
                        Afficher_Recette_Synt($cocktail);
                    }
                }
                else {
                    Afficher_Recette_Synt($cocktails);
                }
                    
            }
        }
        else
        {
            echo "Problème dans votre requête: Recherche impossible";
            ?></span><?php
        }
        //match les s dans $x 
        /*$regex = '/s/';
    $matches = array();
    preg_match_all($regex, $x, $matches);
    var_dump($matches);
    echo "<br>";
    //affiche le nombre de s dans $x
    */
        ?>
    </article>
</main>