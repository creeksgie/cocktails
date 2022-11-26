<?php
session_start();

if(isset($_POST['Login']) && isset($_POST['mdp']) && file_exists('user\\'.$_POST['Login'].'.php'))
{
   echo 'Login et mot de passe corrects';
   header("location: ./index.php?page=Inscription&use=1");
}else if(isset($_POST['Login']) && isset($_POST['mdp']))
{
      $Login = $_POST['Login'];
      $mdp = $_POST['mdp'];
      $users = array('login' => $Login , 'mdp' => $mdp);
      if (!isset($_POST['nom'])) {
         $nom = $_POST['nom'];
         $users['nom'] = $nom;
      }
      if (!isset($_POST['prenom'])) {
         $prenom = $_POST['prenom'];
         $users['prenom'] = $prenom;
      }
      $fp = fopen($Login.'.php', 'w');
      fwrite($fp, "<?php \$user= ".var_export($users, true)."?>");
      fclose($fp);
}
if (isset($_POST['iLogin']) && isset($_POST['imdp']) && file_exists('user\\'.$_POST['iLogin'].'.php')) {
   $Login = $_POST['iLogin'];
   include('user\\'.$Login.'.php');
   echo "fichier trouvé";
   $_SESSION['user'] = $user;
   //var_dump($_SESSION['user']);
}

?>
<!DOCTYPE HTML>
<html lang="fr">

<head>
   <meta charset='utf-8'>
   <link rel="stylesheet" href="b.css">
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
      <?php
      if (!isset($_SESSION['user'])) {
      ?>
      <div id="login" class="head-section">
         
            <form action="./" class="hide-submit" method="POST">
            <div>
               <p>Login &nbsp;</p>
               <input name="iLogin" type="text" required="required" />
            </div>
            <div>
               <p>Mot de passe &nbsp;</p>
               <input name="imdp" type="password" required="required" />
            </div> 
            <label>
               <button>Connection</button>
            </label>
         </form>
         <a href="?page=Inscription">S'inscrire</a>
      </div>
      <?php
         }
         else {
            ?>
            <div id="id" class="head-section"> 
               <span>
               <?php echo $_SESSION['user']['login'] ?>
               </span>
            </div>
            <div id="profil" class="head-section"> 
               <a href="?page=Profil">Profil</a>
            </div>
            <div id="deco" class="head-section"> 
               <a href="?page=Deconnection">Deconnection</a>
            </div>
         <?php
         }
         ?>
   </header>
   <?php
   if (isset($_POST['ingredient'])) {
      require("recherche.php");
   } else {
   ?>
      <nav>
         <?php
         if (isset($_GET['page']) && (($_GET['page'] == "Like") || ($_GET['page'] == "Inscription"))) {
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
               if (isset($_GET['page']) && $_GET['page'] == "Inscription") {
                  require("inscription.php");
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
      <p>Projet Programmation Web 2022 : PIVETEAU Théo, ZULIANI Cedric, LETULÉ Luc</p>
   </footer>
</body>
   <script src="..\FonctionJS.js"></script>
</html>