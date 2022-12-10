<?php
$TabAlimentVoulu = array();                         //Tableau des aliments voulu
$TabAlimentNonDesire = array();                     //Tableau des aliments non désiré
$TabInconnu = array();                              //Tableau des aliments inconnu
$TabCocktail = null;                                //Tableau des cocktails
$TabMotsComposer=null;                              //Tableau des mots composés
$List_Recherche_Tmp= $_POST['ingredient'];          //Liste des aliments recherché
$RecherchePossible=false;                           //Booléen pour savoir si la recherche est possible
$NbQuote=true;                                      //Booléen pour savoir si le nombre de quote est pair

if(preg_match('/^ +/', $List_Recherche_Tmp)){       //Si la liste commence par un espace
    preg_replace('/^ +/', '', $List_Recherche_Tmp); //On supprime les espaces
}
if(substr_count($List_Recherche_Tmp, '"')%2==0){    //Si le nombre de quote est pair
    $RecherchePossible = Recherche_Dans_Tab($TabAlimentVoulu,$TabAlimentNonDesire,$TabInconnu, $List_Recherche_Tmp); //On recherche dans le tableau
}
else{ 
    $NbQuote=false;                                 //Sinon on met le booléen à false
}



?>
<nav>
    <article>
        <span>
        <?php
            if(!$NbQuote){ //Si le nombre de quote est impair
                echo "Problème de syntaxe dans votre requête : nombre impaire de double-quotes"; //On affiche un message d'erreur
            }
            else{                                                       //Sinon on affiche les résultats 
                if(!empty($TabAlimentVoulu))                            //Si le tableau n'est pas vide
                {
                    ?>
                    <p>Aliment voulu :</p>
                    <?php
                    echo implode(", ", $TabAlimentVoulu)."<br>";        //On affiche les aliments voulu
                }
                if(!empty($TabAlimentNonDesire))                        //Si le tableau n'est pas vide
                {
                    ?>
                    <p>Aliment non désiré :</p>
                    <?php
                    echo implode(", ", $TabAlimentNonDesire)."<br>";    //On affiche les aliments non désiré
                }
                if(!empty($TabInconnu))                                 //Si le tableau n'est pas vide
                {
                    ?>
                    <p>Aliment inconnu :</p>
                    <?php
                    echo implode(", ", $TabInconnu)."<br>";             //On affiche les aliments inconnu
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
        if(empty($TabAlimentVoulu) && empty($TabAlimentNonDesire)){     //Si les tableaux sont vide
            $RecherchePossible=false;                                   //On met le booléen à false
        }
        if($RecherchePossible && $NbQuote){                             //Si la recherche est possible et que le nombre de quote est pair
            ?>
            </span>
            <?php
            Afficher_Recherche($TabAlimentVoulu, $TabAlimentNonDesire); //On affiche les résultats
        }
        else
        {
            echo "Problème dans votre requête: Recherche impossible";   //Sinon on affiche un message d'erreur
            ?></span><?php
        }
        ?>
    </article>
</main>