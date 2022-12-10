<article>
<?php
 $Login = $_SESSION['user']['login'];
 include('user\\'.$Login.'.php');    
 if (isset($_POST['submit'])) { // Si le formulaire a été envoyé
    $valide = true; // On considère que le formulaire est valide
    ?>
    <span>
    <?php
    if (isset($_POST['login']) == $user['login']) { // Si le login est rempli
        $valide = false; // On considère que le formulaire n'est pas valide
        ?>
        Vous avez surement essayer de changer votre Login <br>
        <?php
    }

    if (isset($_POST['mdp']) && !empty($_POST['mdp'])) { //le mot de passe est rempli 
       $user['mdp'] = sha1($_POST['mdp']); // On hash le mot de passe
    }
    if (isset($_POST['nom']) && !empty($_POST['prenom'])) { //le nom est rempli
        if(!preg_match("/^(([A-Za-z\x{00C0}-\x{00FF}])+(((|'|-) *)[A-Za-z[\x{00C0}-\x{00FF}]+)*)$/u",$_POST['nom'])) { // On vérifie que le nom est valide
            $valide = false; // On considère que le formulaire n'est pas valide
            ?>
            Votre nom n'est pas valide <br>
            <?php
        }
        else                        // Le nom est valide
        {
            $nom = $_POST['nom'];   // On affecte le nom à la variable $nom
            $user['nom'] = $nom;    // On affecte le nom à la variable $nom dans le tableau $user
        }
    }
    if (isset($_POST['prenom']) && !empty($_POST['prenom'])) { //le prenom est rempli
        if(!preg_match("/^(([A-Za-z\x{00C0}-\x{00FF}])+(((|'|-) *)[A-Za-z[\x{00C0}-\x{00FF}]+)*)$/u",$_POST['prenom'])) { // On vérifie que le prenom est valide
            $valide = false;// On considère que le formulaire n'est pas valide
            ?>
            Votre prenom n'est pas valide <br>
            <?php
        }
        else{ // Le prenom est valide
            $prenom = $_POST['prenom']; // On affecte le prenom à la variable $prenom
            $user['prenom'] = $prenom;  // On affecte le prenom à la variable $prenom dans le tableau $user
        }
    }

    if(isset($_POST['sexe'])) 			// la variable sexe est positionnée
    { 
        $Sexe=$_POST['sexe'];			// affectation de la variable $Sexe
        if(($Sexe=='f')||($Sexe=='h')) $user['sexe'] = $Sexe;   // On affecte le sexe à la variable $sexe dans le tableau $user
        else{ // Le sexe n'est pas valide
            $valide = false; // On considère que le formulaire n'est pas valide
            ?>
            Votre Sexe n'est pas valide <br> 
            <?php
        } 
    }
    if(isset($_POST['naissance'])) 			// la variable date de naissance est positionnée
    { $Naissance=trim($_POST['naissance']); // suppression des espaces devant et derrière 
     if($Naissance=="");
     else { list($Annee,$Mois,$Jour)=explode('-',$Naissance); // on découpe la date de naissance en 3 variables
          if(checkdate($Mois,$Jour,$Annee))  // on vérifie que la date est valide
          {
             $date = new DateTime(); // On récupère la date du jour
             $date_18 = $date->sub(new DateInterval('P18Y')); // On soustrait 18 ans à la date du jour
             $Naissance = new DateTime($_POST['naissance']); // On récupère la date de naissance
             if( $Naissance <= $date_18) // On vérifie que la date de naissance est inférieur à la date du jour - 18 ans
             {
                $user['naissance'] = $_POST['naissance']; // On affecte la date de naissance à la variable $naissance dans le tableau $user
             }
             else{ // La date de naissance n'est pas valide
                $valide = false; // On considère que le formulaire n'est pas valide
                ?>
                Votre date de naissance n'est pas valide, vous devez avoir plus de 18 ans <br>
                </span>
                <?php
             }
          }   
          }
    }
    if ($valide === true) { // Si le formulaire est valide
        ?>
        </span>
        <?php
        if (isset($userLike)) { // Si le tableau $userLike existe
            $fp = fopen('user\\'.$Login.'.php', 'w');  // On ouvre le fichier user\login.php
            fwrite($fp, "<?php \$user= ".var_export($user, true)."; \$userLike= ".var_export($userLike, true).";  ?>"); // On écrit dans le fichier
            fclose($fp); // On ferme le fichier
        }else{ // Le tableau $userLike n'existe pas
            $fp = fopen('user\\'.$Login.'.php', 'w'); // On ouvre le fichier user\login.php
            fwrite($fp, "<?php \$user= ".var_export($user, true)."?>"); // On écrit dans le fichier
            fclose($fp); // On ferme le fichier
        }
    } 
    $_SESSION['user'] = $user; // On affecte le tableau $user à la variable $_SESSION['user']
    
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
            <div>
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
            </div>
            <br/>
                
            Date de naissance : 
            <input type="date" name="naissance"  value="<?php if(isset($user['naissance'])) echo $user['naissance']; ?>"/><br /> 	
            <br />
            <input type="submit" name="submit" value="Valider" />   
        </form>
    </div>

</article>


