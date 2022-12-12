<?php
session_start();
if (isset($_POST['iLogin']) && isset($_POST['imdp']) && file_exists('user\\'.$_POST['iLogin'].'.php')) {
   $Login = $_POST['iLogin'];
   include('user\\'.$Login.'.php');
   if (sha1($_POST['imdp']) == $user['mdp']) {
      $_SESSION['user'] = $user;
  } else {
      ?>
      <script>alert("Mot de passe éronné");</script>
      <?php
  }
}

?>
<!DOCTYPE HTML>
<html lang="fr">

<head>
   <meta charset='utf-8'>
   <link rel="stylesheet" href="stylesheet.css">
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
      <div id="head-nav">
         <a href="?page=Aliment">Navigation</a>
      </div>
      <div id="head-recettes">
         <a href="?page=Like">Recettes <img class="svg" src="..\svg\coeurplein.svg" alt=""> </a>
      </div>
      <div id="search">
         <form action="./" class="hide-submit" method="POST">
            <input name="ingredient" type="text" required="required" />
            <label>
               <button><img class="svg" src="..\svg\loupe.svg" alt=""></button>
            </label>
         </form>
      </div>
      <?php
      if (!isset($_SESSION['user'])) {
      ?>
      <div id="login">
         <form action="./" method="POST">
            <div class="login">
               <p>Login &nbsp;</p>
               <input name="iLogin" type="text" required="required" />
            </div>
            <div class="login">
               <p>Mot de passe &nbsp;</p>
               <input name="imdp" type="password" required="required" />
            </div> 
            <label>
               <button>Connexion</button>
            </label>
         </form>
         <a href="?page=Inscription">S'inscrire</a>
      </div>
      <?php
         }
         else {
            ?>
      <div id="connecter">
            <div id="id"> 
               <span>
               <?php echo $_SESSION['user']['login'] ?>
               </span>
            </div>
            <div id="profil"> 
               <a href="?page=Profil">Profil</a>
            </div>
            <div id="deco"> 
               <a href="?page=Deconnection">Deconnection</a>
            </div>
         <?php
         }
         ?>
      </div>
   </header>
   <?php
   if (isset($_POST['ingredient'])) {
      require("recherche.php");
   } else {
   ?>
      <nav>
         <?php
         if (isset($_GET['page']) && (($_GET['page'] == "Like") || ($_GET['page'] == "Inscription") || ($_GET['page'] == "Profil"))) {
         } else {
            require("navigation.php");
         }
         ?>
      </nav>
      <main>
         <?php
         if (isset($_GET['Recettes'])) {
            require("recettesDetaille.php");
         } else {
            if (isset($_GET['page']) && $_GET['page'] == "Like") {
               require("afficherLike.php");
            } else if (isset($_GET['page']) && $_GET['page'] == "Inscription") {
               require("inscription.php");
            }elseif (isset($_GET['page']) && $_GET['page'] == "Deconnection") {
               require("deconnection.php");
            }elseif (isset($_GET['page']) && $_GET['page'] == "Profil") {
               require("profil.php");
            }else {
               require("cocktails.php");
            } 
         }
         ?>

      </main>
   <?php
   }
   ?>
   <footer>
      <p>Projet Programmation Web 2022 : PIVETEAU Théo, ZULIANI Cedric, LETULÉ Luc</p>
   </footer>
</body>
   <script src="..\FonctionJS.js"></script>
</html>