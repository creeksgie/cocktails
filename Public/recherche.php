<?php
$TabAlimentVoulu = array();
$TabAlimentNonDesire = array();
$TabInconnu = array();
$TabCocktail = null;
$TabMotsComposer=null;
$List_Recherche_Tmp= $_POST['ingredient'];
$RecherchePossible = true;

if(substr_count($List_Recherche_Tmp, '"')%2==0)
{
   $RecherchePossible = rechercheDansTab($TabAlimentVoulu,$TabAlimentNonDesire,$TabInconnu, $List_Recherche_Tmp);
}


?>
<nav>

</nav>
<main>
    <article>
        <span>
        <?php
        //$x = $_POST['ingredient'];
        if($RecherchePossible){
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
        foreach ($TabAlimentVoulu as $index => $recherche) {
            $afficher[] = Tourner_Recettes($recherche);
        }

        sort($afficher);                                                                        //on trie le tableau des cocktails à afficher
        echo "<br>";
        foreach ($afficher as $index_a => $cocktails) {                                         //on affiche la recettes synthétique pour chaque cocktails présent dans le tableau
            foreach($cocktails as $index_c => $cocktail){
                Afficher_Recette_Synt($cocktail);
            }
        }
        
        }
        else
        {
            echo "Erreur de syntaxe";
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