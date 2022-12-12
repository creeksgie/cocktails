<?php 
session_start();
$indice = null;
if (isset($_SESSION['user'])) { //Si je suis connecter
    $Login = $_SESSION['user']['login'];
    include('user\\'.$Login.'.php');
    if (isset($_SESSION['like'])) { //Si j'ai des recettes liker en session
        foreach($userLike as $key => $value) { //Pour chaque recette liker
            if (!in_array($value, $_SESSION['like'])) { //Si la recette liker n'est pas dans la session
                $_SESSION['like'][] = $value;   //Ajout de la recette liker dans la session
            }
        }
    }
    $userLike = $_SESSION['like'];  //On met les recettes liker dans la session
    if (isset($_GET['indice'])) {   //Si on a cliquer sur un bouton like
        if (isset($userLike)) {     //Si j'ai des recettes liker
            $indice = $userLike;    //On les met dans un tableau
        }
        if ($indice != null && in_array($_GET['indice'], $indice)) {            //Si la recette liker est dans le tableau
            array_splice($indice, array_search($_GET['indice'], $indice),1);    //On la supprime
            if (count($indice) == 0) {                                          //Si le tableau est vide
                $indice = null;                                                 //On le met a null
            }
        }else
        {
            $indice[] = $_GET['indice'];                                        //Sinon on ajoute la recette liker dans le tableau
        }
        $_SESSION['like'] = $indice;                                            //On met le tableau dans la session
        $fp = fopen('user\\'.$Login.'.php', 'w');                               //On ouvre le fichier user\login.php
        fwrite($fp, "<?php \$user= ".var_export($_SESSION['user'], true)."; \$userLike= ".var_export($_SESSION['like'], true).";  ?>"); //On écrit dans le fichier
        fclose($fp);                                                           //On ferme le fichier
    }
}else
{
    if (isset($_GET['indice'])) {           //Si on a cliquer sur un bouton like
        if (isset($_SESSION['like'])) {     //Si j'ai des recettes liker en session
            $indice = $_SESSION['like'];    //On les met dans un tableau
        }
        if ($indice != null && in_array($_GET['indice'], $indice)) {            //Si la recette liker est dans le tableau
            array_splice($indice, array_search($_GET['indice'], $indice),1);    //On la supprime
            if (count($indice) == 0) {                                          //Si le tableau est vide
                $indice = null;                                                 //On le met a null
            }
        }else
        {
            $indice[] = $_GET['indice'];                                        //Sinon on ajoute la recette liker dans le tableau
        }
        $_SESSION['like'] = $indice;                                            //On met le tableau dans la session
    }
}

?>