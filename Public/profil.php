<article>
<?php
 $Login = $_SESSION['user']['login'];
 include('user\\'.$Login.'.php');   
 if (isset($_POST['submit'])) {
    $valide = true;
    if (isset($_POST['login']) == $user['login']) {
        $valide = false;
    }

    if (isset($_POST['mdp']) && !empty($_POST['mdp'])) {
       $user['mdp'] = password_hash($_POST['mdp'],PASSWORD_DEFAULT);
    }
    if (isset($_POST['nom']) && !empty($_POST['prenom'])) {
        $user['nom'] = $_POST['nom'];
    }
    if (isset($_POST['prenom']) && !empty($_POST['prenom'])) {
        $user['prenom'] = $_POST['prenom'];
    }

    if(isset($_POST['sexe'])) 			// la variable sexe est positionnée
    { 
        $Sexe=$_POST['sexe'];			// affectation de la variable $Sexe
        if(($Sexe=='f')||($Sexe=='h'))
        {
            echo "ok";
            $user['sexe'] = $Sexe;
        }
        else
        {
            $valide = false;
        }
    }
    if(isset($_POST['naissance'])) 			// la variable date de naissance est positionnée
    { $Naissance=trim($_POST['naissance']); // suppression des espaces devant et derrière 
     if($Naissance=="");
     else { list($Annee,$Mois,$Jour)=explode('-',$Naissance);
          if(checkdate($Mois,$Jour,$Annee)) 
          {
             $date = new DateTime();
             $date_18 = $date->sub(new DateInterval('P18Y'));
             $Naissance = new DateTime($_POST['naissance']);
             if( $Naissance <= $date_18)
             {
                $user['naissance'] = $_POST['naissance'];
             }
             else{
                $valide = false;
             }
          }   
          }
    }
    if ($valide === true) {
        if (isset($userLike)) {
            $fp = fopen('user\\'.$Login.'.php', 'w'); 
            fwrite($fp, "<?php \$user= ".var_export($user, true)."; \$userLike= ".var_export($userLike, true).";  ?>");
            fclose($fp);
        }else{
            $fp = fopen('user\\'.$Login.'.php', 'w');
            fwrite($fp, "<?php \$user= ".var_export($user, true)."?>");
            fclose($fp);
        }
        echo"Modification effectuer";
    }
    $_SESSION['user'] = $user;
    
 }
?>
<div id="inscription">
        <form method="post" action=# >
            Login * :
            <input name="login" type="text" disabled ="disabled" value="<?php echo $user['login'] ?>"/><br /> 
            Mot de passe * : 
            <input name="mdp" type="password"/><br />  
            Nom :    
            <input type="text" name="nom" value="<?php 
            if(isset($user['nom'])) 				// la variable nom est positionnée
                {$Nom=trim($user['nom']);			// suppression des espaces devant et derrière 
                if(strlen($Nom)>1) echo $Nom;  
                }
            ?>"/><br />     
            Prénom : 
            <input type="text" name="prenom" value="<?php 
            if(isset($user['prenom'])) 				// la variable nom est positionnée
                {$Prenom=trim($user['prenom']);			// suppression des espaces devant et derrière 
                if(strlen($Prenom)>1) echo $Prenom;  
                }
            ?>"/><br /> 
            Vous êtes :  
            <input type="radio" name="sexe" value="h"
            <?php 
            if(isset($user['sexe'])) 			// la variable sexe est positionnée
            { $Sexe=$user['sexe'];				// affectation de la variable $Sexe
              if ($Sexe=='h'){?> 
              checked = "checked" <?php }
            }?>/> un homme	
            <input type="radio" name="sexe" value="f"
            <?php
            if(isset($user['sexe'])) 			// la variable sexe est positionnée
            { $Sexe=$user['sexe'];				// affectation de la variable $Sexe
              if ($Sexe=='f') {?> 
              checked = "checked" <?php }
            }?>/> une femme
            <br />
                
            Date de naissance : 
            <input type="date" name="naissance"  value="<?php if(isset($user['naissance'])) echo $user['naissance']; ?>"/><br /> 	
            <br />
            <input type="submit" name="submit" value="Valider" />   
        </form>
    </div>

</article>


