<?php 
if (isset($_SESSION['user'])) { //Si je suis connecter
    $Login = $_SESSION['user']['login'];
    include('user\\'.$Login.'.php');
    if (isset($userLike)) { //Si j'ai des recettes liker
        if (isset($_SESSION['like'])) { //Si j'ai des recettes liker en session
            foreach($userLike as $key => $value) { //Pour chaque recette liker
                if (!in_array($value, $_SESSION['like'])) { //Si la recette liker n'est pas dans la session
                    $_SESSION['like'][] = $value;   //Ajout de la recette liker dans la session
                }
            }
            $fp = fopen('user\\'.$Login.'.php', 'w');  //On ouvre le fichier user\login.php
            fwrite($fp, "<?php \$user= ".var_export($_SESSION['user'], true)."; \$userLike= ".var_export($_SESSION['like'], true).";  ?>"); //On écrit dans le fichier
            fclose($fp); //On ferme le fichier
        }else //Si je n'ai pas de recette liker en session
        {
            $_SESSION['like'] = $userLike; //On met les recettes liker dans la session
        }
    }
    if (!isset($userLike) && isset($_SESSION['like'])) { //Si je n'ai pas de recette liker et que j'en ai en session
        $fp = fopen('user\\'.$Login.'.php', 'w'); //On les enregistre dans le fichier
        fwrite($fp, "<?php \$user= ".var_export($_SESSION['user'], true)."; \$userLike= ".var_export($_SESSION['like'], true).";  ?>"); //On les enregistre dans le fichier
        fclose($fp); //On ferme le fichier
    }
}

?>

<article class="like" id="like">
    <?php
    if (isset($_SESSION['like'])) { //Si j'ai des recettes liker
        $indice = $_SESSION['like']; //On les met dans un tableau
        sort($indice); //On les trie
        foreach ($indice as $index_a => $cocktails) { //Pour chaque recette liker
            Afficher_Recette_synt($cocktails); //On affiche la recette
        }
    }
    ?>
</article>