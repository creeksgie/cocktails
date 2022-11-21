<?php
$TabAlimentVoulu = array();
$TabAlimentNonDesire = array();
$TabInconnu = array();
$TabCocktail = null;
$TabMotsComposer=null;
$List_Recherche_Tmp= $_POST['ingredient'];
$RecherchePossible = true;


echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

if(substr_count($List_Recherche_Tmp, '"')%2==0)
{
    $Cmpt=substr_count($List_Recherche_Tmp, '"')/2;
    preg_match_all('/(\+|-)?"([^"]+)"/', $List_Recherche_Tmp, $TabMotsComposer);
    $List_Recherche_Tmp = preg_replace('/( (\+|-)?"([^"]+)"|(\+|-)?"([^"]+)")/', "", $List_Recherche_Tmp);
    
    for($i =0; $i<$Cmpt; $i++){
        
        $MotsComposer=str_replace('"', "", $TabMotsComposer[0][$i]);
        echo $MotsComposer;
        if(preg_match('/^\+/',$MotsComposer)){
            $MotsComposer = preg_replace('/^\+/', "", $MotsComposer);
            if (array_key_exists($MotsComposer, $Hierarchie))
                array_push($TabAlimentVoulu, $MotsComposer);
            else
                array_push($TabInconnu, $MotsComposer);
        }
        else if(preg_match('/^[A-Z]/',$MotsComposer)){
            if (array_key_exists($MotsComposer, $Hierarchie))
                array_push($TabAlimentVoulu, $MotsComposer);
            else
                array_push($TabInconnu, $MotsComposer);
        }
        
        else if (preg_match('/^\-/',$TabMotsComposer[0][$i])){
            $MotsComposer = preg_replace('/^\-/', "", $MotsComposer);
            if (array_key_exists($MotsComposer, $Hierarchie))
                array_push($TabAlimentNonDesire, $MotsComposer);
            else
                array_push($TabInconnu, $MotsComposer);
        }
        else{
            array_push($TabInconnu, $MotsComposer);
        }
    }

    
    //var_dump(trim($TabMotsComposer[0], "\""));
    if($List_Recherche_Tmp != "")
    {
        $List_Recherche = explode(" ", $List_Recherche_Tmp);
        foreach ($List_Recherche as $index => $recherche) {
            if (preg_match("/^\+?[A-Z]{1}[a-z]+/", $recherche)) {
                if (preg_match("/^\+/", $recherche))
                    $recherche = substr($recherche, 1);
                if (array_key_exists($recherche, $Hierarchie))
                    $TabAlimentVoulu[] = $recherche;
                else
                    $TabInconnu[] = $recherche;
            } elseif (preg_match("/^-[A-Z]{1}[a-z]+/", $recherche)) {
                $recherche = substr($recherche, 1);
                if (array_key_exists($recherche, $Hierarchie))
                    $TabAlimentNonDesire[] = $recherche;
                else
                    $TabInconnu[] = $recherche;
            } else {
                $TabInconnu[] = $recherche;
            }
        }
    }
    else
    {
        $List_Recherche = null;
    }
}
else
{
    $RecherchePossible = false;
}


?>
<nav>

</nav>
<main>
    <span>
        <?php
        //$x = $_POST['ingredient'];
        if($RecherchePossible){
            echo "TabMotComposer : ";
        var_dump($TabMotsComposer[0]);
        echo "<br>";
        echo " liste : ";
        var_dump($List_Recherche_Tmp);
        echo "<br>";
        echo "Recherche : ";
        var_dump($List_Recherche);
        echo "<br>";
        echo "Aliment Voulu : ";
        var_dump($TabAlimentVoulu);
        echo "<br>";
        echo "Aliment Non Voulu : ";
        var_dump($TabAlimentNonDesire);
        echo "<br>";
        echo "Inconnu : ";
        var_dump($TabInconnu);
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
    </span>
</main>