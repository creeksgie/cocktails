<?php
$TabAlimentVoulu = array();
$TabAlimentNonDesire = array();
$TabInconnu = array();
$TabCocktail = null;
$TabMotsComposer=null;
$List_Recherche_Tmp= $_POST['ingredient'];
$RecherchePossible=false;
$NbQuote=true;

if(!preg_match('/^ +/', $List_Recherche_Tmp)){
    if(substr_count($List_Recherche_Tmp, '"')%2==0)
    {
        $RecherchePossible = rechercheDansTab($TabAlimentVoulu,$TabAlimentNonDesire,$TabInconnu, $List_Recherche_Tmp);
    }
    else{
        $NbQuote=false;
    }
}



?>
<nav>
    <span>
    <?php
        if(!$NbQuote){
            echo "Problème de syntaxe dans votre requête : nombre impaire de double-quotes";
        }
        else{
            if(!empty($TabAlimentVoulu))
                echo "Aliment voulu : ".implode(", ", $TabAlimentVoulu)."<br>"; 
            if(!empty($TabAlimentNonDesire))
                echo "Aliment non désiré : ".implode(", ", $TabAlimentNonDesire)."<br>";
            if(!empty($TabInconnu))
                echo "Aliment inconnu : ".implode(", ", $TabInconnu)."<br>";
        }
    ?>
    </span>
</nav>
<main>
    <article>
        <span>
        <?php
        //$x = $_POST['ingredient'];
        if($RecherchePossible && $NbQuote){
        echo "<br>";
        echo " liste : ";
        var_dump($List_Recherche_Tmp);
        echo "<br>";
        echo "Aliment Voulu : ";
        var_dump($TabAlimentVoulu);
        echo "<br>";
        echo "Aliment Non Voulu : ";
        var_dump($TabAlimentNonDesire);
        echo "<br>";
        echo "Inconnu : ";
        var_dump($TabInconnu);
        echo "<br>";
        ?>
        </span>
        <?php
        
        if (empty($TabAlimentVoulu)) {
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
                unset($TabCocktail[array_search($recette, $TabCocktail)]);
            }
        }
        sort($TabCocktail);                                                                        //on trie le tableau des cocktails à afficher
        foreach ($TabCocktail as $index_a => $cocktails) {                                         //on affiche la recettes synthétique pour chaque cocktails présent dans le tableau

                Afficher_Recette_Synt($cocktails);
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