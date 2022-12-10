<?php
    session_destroy();                  //On détruit la session
    header('Location: ./index.php');    //On redirige vers la page d'accueil
?>