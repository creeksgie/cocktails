<!DOCTYPE HTML>
<html lang="fr">
 <head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="nomachanger.css">
    <?php  include("..\Donnees.inc.php"); ?>
 </head>
 <body>
   <header>
      <button>Navigation</button>
      <button>Recettes <img class="svg" src="..\svg\coeurplein.svg" alt=""> </button>
      <span id ="login" >
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
   </main>
   <footer>
      salut
   </footer>
 </body>
</html>