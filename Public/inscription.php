<article>
    <?php
    if(isset($_POST['Login']) && isset($_POST['mdp']) && file_exists('user\\'.$_POST['Login'].'.php')) // Si le login existe déjà
    {
        $valide = false;
        ?>
        <span> Ce login est déjà pris </span>
        <?php
    
    }else if(isset($_POST['Login']) && isset($_POST['mdp'])) // Si le login n'existe pas
    {
        $valide = true;
        ?>
        <span>
        <?php
        if (!preg_match("/^([a-zA-Z0-9]+)$/",$_POST['Login'])) { // Si le login n'est pas valide
            $valide = false;
            ?>
            Votre login n'est pas valide, il ne peut pas contenir d'accent <br>
            <?php
        }
        else { // Si le login est valide
            $Login = $_POST['Login'];  // affectation de la variable $Login
            $mdp = sha1($_POST['mdp']); // affectation de la variable $mdp
            $user = array('login' => $Login , 'mdp' => $mdp); // Création du tableau $user
        }
            
        
        
        if (isset($_POST['nom']) && !empty($_POST['nom'])) { // Si le nom est rempli
            if(!preg_match("/^(([A-Za-z\x{00C0}-\x{00FF}])+(((|'|-) *)[A-Za-z[\x{00C0}-\x{00FF}]+)*)$/u",$_POST['nom'])) { // Si le nom n'est pas valide
                $valide = false;
                ?>
                Votre nom n'est pas valide <br>
                <?php
            }
            else // Si le nom est valide
            {
                $nom = $_POST['nom']; // affectation de la variable $nom
                $user['nom'] = $nom; // Ajout de la variable $nom dans le tableau $user
            }
        }
        if (isset($_POST['prenom']) && !empty($_POST['prenom'])) { // Si le prenom est rempli
            if(!preg_match("/^(([A-Za-z\x{00C0}-\x{00FF}])+(((|'|-) *)[A-Za-z[\x{00C0}-\x{00FF}]+)*)$/u",$_POST['prenom'])) { // Si le prenom n'est pas valide
                $valide = false;
                ?>
                Votre prenom n'est pas valide <br>
                <?php
            }
            else{ // Si le prenom est valide
                $prenom = $_POST['prenom']; // affectation de la variable $prenom
                $user['prenom'] = $prenom; // Ajout de la variable $prenom dans le tableau $user
            }
        }
        
        if(isset($_POST['naissance'])) 			// la variable date de naissance est positionnée
        { $Naissance=trim($_POST['naissance']); // suppression des espaces devant et derrière 
        if($Naissance==""); 
        else { list($Annee,$Mois,$Jour)=explode('-',$Naissance); // découpage de la date de naissance en 3 variables
                if(checkdate($Mois,$Jour,$Annee))  // vérification de la validité de la date de naissance
                {
                $date = new DateTime(); // date du jour
                $date_18 = $date->sub(new DateInterval('P18Y')); // date du jour - 18 ans
                $Naissance = new DateTime($_POST['naissance']); // date de naissance
                if( $Naissance <= $date_18) // Si la date de naissance est inférieur à la date du jour - 18 ans
                {
                    $user['naissance'] = $_POST['naissance']; // Ajout de la variable $naissance dans le tableau $user
                }
                else{ // Si la date de naissance est supérieur à la date du jour - 18 ans
                    $valide = false; 
                    ?>
                    Votre date de naissance n'est pas valide, vous devez avoir plus de 18 ans <br>
                    <?php
                }
                }   
                }
        }

        if(isset($_POST['sexe'])) 			// la variable sexe est positionnée
        { 
            $Sexe=$_POST['sexe'];			// affectation de la variable $Sexe
            if(($Sexe=='f')||($Sexe=='h')) $user['sexe'] = $Sexe;  // Ajout de la variable $Sexe dans le tableau $user
            else{ // Si le sexe n'est pas valide
                $valide = false;
                ?>
                <br> Votre Sexe n'est pas valide
                </span>
                <?php
            } 
        }
        if ($valide == true) { // Si toutes les conditions sont remplies
            ?>
            </span>
            <?php
            $fp = fopen('user\\'.$Login.'.php', 'w'); // Création du fichier user\login.php
            fwrite($fp, "<?php \$user= ".var_export($user, true)."?>"); // Ecriture des données dans le fichier
            fclose($fp); // Fermeture du fichier
            header('Location: ./'); // Redirection vers l'index
        }
        
    }
    ?>
    <div id="inscription">
        <form method="post" action="#" >
            Login * :
            <input name="Login" type="text" required="required" /><br /> 
            Mot de passe * : 
            <input name="mdp" type="password" required="required" /><br />  
            Nom :    
            <input type="text" name="nom" /><br />   
            Prénom : 
            <input type="text" name="prenom" /><br /> 
            Vous êtes :  
            <div>
                <input type="radio" name="sexe" value="h"/> un homme	
                <input type="radio" name="sexe" value="f"/> une femme
            </div>
            <br /> 
            Date de naissance : 
            <input type="date" name="naissance" /><br /> 	
            <br />
            <input type="submit" value="Valider" />   
        </form>
    </div>
</article>
