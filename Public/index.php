<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="fr">

<head>
   <meta charset='utf-8'>
   <link rel="stylesheet" href="a.css">
   <title>Cocktails</title>
   <?php include("..\Donnees.inc.php"); ?>
</head>

<body style="
    margin-top: 0px; 
    margin-bottom: 0px;
    margin-left: 0px;
    margin-right: 0px;">
   <header>
      <div id="head-nav" class="head-section">
         <a href="?page=Aliment" ;>Navigation</a>
      </div>
      <div id="head-recettes" class="head-section">
         <a href="#">Recettes <img class="svg" src="..\svg\coeurplein.svg" alt=""> </a>
      </div>
      <div id="search" class="head-section">
         <span>
            <form action="./" class="hide-submit" method="POST" >
               <input name="ingredient" type="text" />
               <label>
                  <button><img class="svg" src="..\svg\loupe.svg" alt=""></button>
               </label>
            </form>
         </span>
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
   }else{
   ?>
   <nav>
      <?php
       require("navigation.php"); 
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
      } 
      else {
         require("cocktails.php");
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