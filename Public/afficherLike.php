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
            $fp = fopen('user\\'.$Login.'.php', 'w'); 
            fwrite($fp, "<?php \$user= ".var_export($_SESSION['user'], true)."; \$userLike= ".var_export($_SESSION['like'], true).";  ?>");
            fclose($fp);
        }else //Si je n'ai pas de recette liker en session
        {
            $_SESSION['like'] = $userLike;
        }
    }
    if (!isset($userLike) && isset($_SESSION['like'])) { //Si je n'ai pas de recette liker et que j'en ai en session
        $fp = fopen('user\\'.$Login.'.php', 'w');
        fwrite($fp, "<?php \$user= ".var_export($_SESSION['user'], true)."; \$userLike= ".var_export($_SESSION['like'], true).";  ?>");
        fclose($fp);
    }
}

?>

<article class="like" id="like">
    <?php
    if (isset($_SESSION['like'])) {
        $indice = $_SESSION['like'];
        sort($indice);
        foreach ($indice as $index_a => $cocktails) {
            Afficher_Recette_synt($cocktails,$Recettes[$cocktails]);
        }
    }
    ?>
</article>