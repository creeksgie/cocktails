<?php 
session_start();
$indice = null;
if (isset($_GET['indice'])) {
    if (isset($_SESSION['like'])) {
        $indice = $_SESSION['like'];
    }
    if ($indice != null && in_array($_GET['indice'], $indice)) {
        array_splice($indice, array_search($_GET['indice'], $indice),1);
    }else
    {
        $indice[] = $_GET['indice'];
    }
    $_SESSION['like'] = $indice;
}
var_dump($indice);
?>  