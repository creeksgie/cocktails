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
         <span>
            Zone de connection
         </span>
      </div>
   </header>
   <?php
   if (isset($_POST['ingredient'])) {
      require("recherche.php");
   } else {
   ?>
      <nav>
         <?php
         if (isset($_GET['page']) && $_GET['page'] == "Like") {
         } else {
            require("navigation.php");
         }
         /*if(isset($_SESSION['user']))
      {
          if(!isset($_GET['page'])) $_GET['page']='index';
          if(in_array($_GET['page'],array('')))
          {
              include($_GET['page'].".php");
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
               require("cocktails.php");
            }
         }
         ?>

      </main>
   <?php
   }
   ?>
   <footer>
      yo
   </footer>
</body>

</html>