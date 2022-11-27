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
    $userLike = $_SESSION['like'];
    if (isset($_GET['indice'])) {
        if (isset($userLike)) {
            $indice = $userLike;
        }
        if ($indice != null && in_array($_GET['indice'], $indice)) {
            array_splice($indice, array_search($_GET['indice'], $indice),1);
            if (count($indice) == 0) {
                $indice = null;
            }
        }else
        {
            $indice[] = $_GET['indice'];
        }
        $_SESSION['like'] = $indice;
        $fp = fopen('user\\'.$Login.'.php', 'w'); 
        fwrite($fp, "<?php \$user= ".var_export($_SESSION['user'], true)."; \$userLike= ".var_export($_SESSION['like'], true).";  ?>");
        fclose($fp);
    }
}else
{
    if (isset($_GET['indice'])) {
        if (isset($_SESSION['like'])) {
            $indice = $_SESSION['like'];
        }
        if ($indice != null && in_array($_GET['indice'], $indice)) {
            array_splice($indice, array_search($_GET['indice'], $indice),1);
            if (count($indice) == 0) {
                $indice = null;
            }
        }else
        {
            $indice[] = $_GET['indice'];
        }
        $_SESSION['like'] = $indice;
    }
}
?>