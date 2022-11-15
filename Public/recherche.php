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
    if(preg_match("/^\+?[A-Z]{1}[a-z]+/",$recherche)){
        if(preg_match("/^\+/", $recherche))
            $recherche=substr($recherche,1);
        if(array_key_exists($recherche,$Hierarchie))
            $TabAlimentVoulu[] = $recherche;
        else
            $TabInconnu[] = $recherche;
    }elseif(preg_match("/^-[A-Z]{1}[a-z]+/",$recherche)){
        $recherche=substr($recherche,1);
        if(array_key_exists($recherche,$Hierarchie))
            $TabAlimentNonDesire[] = $recherche;
        else
            $TabInconnu[] = $recherche;
    }else{
        $TabInconnu[] = $recherche;
    }
}
/*dans le sujet le prof mettais pas des '', je vais check 
Par exemple : "Jus de fruits" +Sel -Whisky dans le sujet du prof, donc du coup faut que tu explode d'abord grace au "" puis avec les espace sur le reste 
ça va pas me detruire mon mots ?
bah si t'explose d'abord avec " ça va te resortir jus de fruits dans la première case et sel -whisky dans la deuxième case puis tu peut explose la dexième case avec un " " 
du coup j'explode dabord comme ça : explode("",...) puis explode(" ",...)
si tu met "" ça va jamais marcher, faut juste un " et faut echaper le " avec un \ genre : explode("\"",...)
atm je ne peut plus avancer, il me faut forcement la connexion fonctionnelle a merde
ah si je peut afficher les recettes liké mais ça va pas me prendre 15 ans quoi je comprends 
alors j'ai test d'explode ça me donne ça

<?php
$var="\"Jus de FruiTs\" Fruits";
$List_recherche=explode("\"",$var);
var_dump($List_recherche);
?>
resultas : array(3) { [0]=> string(0) "" [1]=> string(13) "Jus de FruiTs" [2]=> string(7) " Fruits" }

faut surement supprimer le premier element de la recherche soit " et du coup t'auras pas la première case vide jsp ça me parait bizarre
après ya peut être d'autre solution mais atm c'est la seule que j'ai à te proposer, je peut chercher plus stv 
ptetre avec preg_split
ouais possible jvais chercher une sol si t'as moyen vite fait aussi yes je check aussi 
j'y ai reflechi mais si on remplace "Jus de Fruits" par "Jus=de=Fruits" avant l'explode ça regle le prob
oui mais faut repasser les = en " " après ouais mais c'est plus facile ouais surement, en plus faut toujours que ça fonctionne sans les ""
*/
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
    */
?>
</span>
</main>
