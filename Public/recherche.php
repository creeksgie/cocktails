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
             $Satis = count($TabAlimentVoulu);
            if ((empty($TabAlimentVoulu) || !empty($TabAlimentNonDesire)) && !in_array("Aliment", $TabAlimentVoulu)) {
                $TabAlimentVoulu[] = 'Aliment';
                $Satis = count($TabAlimentVoulu) + count($TabAlimentNonDesire) -1;
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
            
            $TabCocktail = array_unique($TabCocktail);
            $S = count($TabAlimentNonDesire);
            $SC = null;
            foreach ($TabCocktail as $key => $value) {
                foreach($TabAlimentVoulu as $index=>$aliment){
                    if($aliment!="Aliment"){
                        $SC = Recup_Sous_cat($aliment);
                    }
                    //faire une fonction qui récup les sous catégorie des aliments car ya pas que l'aliment courant qui satisfait la demande, pour lait "lait de coco" satisfait aussi 
                        if (in_array($aliment, $Recettes[$value][array_keys($Recettes[$value])[3]])) {
                            $S++;
                        }else{
                            if (!empty($SC)) {
                                foreach($SC as $index2=>$sous_cat){
                                    if (in_array($sous_cat, $Recettes[$value][array_keys($Recettes[$value])[3]])) {
                                        $S++;
                                    }
                                    
                            }}

                        }
                        $SC = null;
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
            }
            if (empty($TabAlimentNonDesire)) {
                foreach ($TabAlimentVoulu as $index => $recherche) {
                    if (empty($tmp)) {
                        $tmp = Tourner_Recettes($recherche);
                    }
                    else
                    {
                        $tmp = array_merge($tmp, Tourner_Recettes($recherche));
                    }
                }
                sort($tmp);
                foreach($tmp as $index => $cocktail){
                    Afficher_Recette_Synt($cocktail,1);
                }
            }
            else
            {
                $T = $tmp[max(array_keys($tmp))];
                do {
                    foreach($T as $index => $cocktail){
                        Afficher_Recette_Synt($cocktail,max(array_keys($tmp))/($Satis));
                        unset($tmp[max(array_keys($tmp))][$index]);
                        if (empty($tmp[max(array_keys($tmp))])) {
                          unset($tmp[max(array_keys($tmp))]);
                          if (!empty($tmp)) {
                            $T = $tmp[max(array_keys($tmp))]; 
                          }
                        }
                    }
                } while (!empty($tmp));
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