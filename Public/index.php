<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="fr">

<head>
   <meta charset='utf-8'>
   <link rel="stylesheet" href="a.css">
   <title>Cocktails</title>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <?php
   include("..\Donnees.inc.php");
   include("..\Fonction.php");
   ?>
   <link rel="icon" href="..\Photos\cocktail.png" />
</head>

<body style="
    margin-top: 0px; 
    margin-bottom: 0px;
    margin-left: 0px;
    margin-right: 0px;">
   <header>
      <div id="head-nav" class="head-section">
         <a href="?page=Aliment">Navigation</a>
      </div>
      <div id="head-recettes" class="head-section">
         <a href="?page=Like">Recettes <img class="svg" src="..\svg\coeurplein.svg" alt=""> </a>
      </div>
      <div id="search" class="head-section">
         <form action="./" class="hide-submit" method="POST">
            <input name="ingredient" type="text" required="required" />
            <label>
               <button><img class="svg" src="..\svg\loupe.svg" alt=""></button>
            </label>
         </form>
      </div>
      <div id="login" class="head-section">
          <a href="?page=Connexion">Zone de connection </a>
      </div>
   </header>
   <?php
   if (isset($_POST['ingredient'])) {
      require("recherche.php");
   } else {
   ?>
      <nav>
         <?php
         if (isset($_GET['page']) && (($_GET['page'] == "Like") || ($_GET['page'] == "Connexion"))) {
         } else {
            require("navigation.php");
         }
         /*if(isset($_SESSION['user']))
      {
          if(!isset($_GET['page']) && $_GET['page']== 'Connexion'){
          } else {
             require("connexion.php");
          }
      }
      else include('connexion.php');*/
         ?>
      </nav>
      <main>
         <?php
         if (isset($_GET['Recettes'])) {
            require("recettesDetaille.php");
         } else {
            if (isset($_GET['page']) && $_GET['page'] == "Like") {
               require("afficherLike.php");
            } else {
               if (isset($_GET['page']) && $_GET['page'] == "Connexion") {
                  require("connexion.php");
               }else {
                  require("cocktails.php");
               }
               
            }
         }
         ?>

      </main>
   <?php
   }
   ?>
   <footer>
      Projet Programmation Web 2022 : PIVETEAU Théo, ZULIANI Cedric, LETULE Luc
   </footer>
</body>
   <script src="..\FonctionJS.js"></script>
</html>