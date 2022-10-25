<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="fr">

<head>
   <meta charset='utf-8'>
   <link rel="stylesheet" href="amod.css">
   <title>Cocktails</title>
   <?php include("..\Donnees.inc.php"); ?>
</head>

<body style="
    margin-top: 0px;
    margin-bottom: 0px;
    margin-left: 0px;
    margin-right: 0px;">
   <header>
      <button onclick=window.location.href="?page=Aliment" ;>Navigation</button>
      <button>Recettes <img class="svg" src="..\svg\coeurplein.svg" alt=""> </button>
      <span id="login">
         Zone de connection
      </span>
      <span id="search">
         Recherche : <input id="searchbar" type="text" placeholder="">
         <button><img class="svg" src="..\svg\loupe.svg" alt=""></button>
      </span>
   </header>
   <nav>
      <?php require("navigation.php"); ?>
   </nav>
   <main>
      <?php
      if (isset($_GET['Recettes'])) {
         require("recettesDetaille.php");
      } else {
         require("cocktails.php");
      }
      ?>

   </main>
   <footer>
      salut
   </footer>
</body>

</html>