<?php
$TabAlimentVoulu = null;
$TabAlimentNonDesire = null;
$TabInconnu= null;
$TabCocktail = null;

$List_Recherche = explode(" ", $_POST['ingredient']);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
foreach($List_Recherche as $index => $recherche){
    if(preg_match("/\+?[A-Z]{1}[a-z]+/",$recherche)){
        $TabAlimentVoulu[] = $recherche;
        echo "salut mon pote c'est moi !!!";
    }elseif(preg_match("/-[A-Z]{1}[a-z]+/",$recherche)){
        $TabAlimentNonDesire[] = $recherche;
    }else{
        $TabInconnu[] = $recherche;
    }
}

?>
<nav>

</nav>
<main>
<span>
<?php
    //$x = $_POST['ingredient'];
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
    //match les s dans $x 
    /*$regex = '/s/';
    $matches = array();
    preg_match_all($regex, $x, $matches);
    var_dump($matches);
    echo "<br>";
    //affiche le nombre de s dans $x
    var_dump($_SESSION['like']);*/
?>
</span>
</main>
